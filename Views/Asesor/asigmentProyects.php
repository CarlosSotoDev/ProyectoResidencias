<?php
session_start(); // Iniciar la sesión
include('../../includes/config.php'); // Conexión a la base de datos
checkLogin(); // Verificar si el usuario ha iniciado sesión

// Verificar si el ID del asesor está en la sesión
if (!isset($_SESSION['asesor_id'])) {
    echo "Error: No se encontró el ID del asesor en la sesión.";
    exit;
}

// Obtener el ID del asesor desde la sesión
$asesor_id = $_SESSION['asesor_id'];

// Verificar si hay un término de búsqueda
$search_query = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%%';

// Obtener la página actual desde la URL (si no se proporciona, por defecto es la página 1)
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$results_per_page = 10; // Número de resultados por página
$start_from = ($page - 1) * $results_per_page; // Calcular el offset

// Modificar la consulta SQL para incluir el LIMIT y OFFSET
$query = "
    SELECT p.ID_Proyecto, p.Nombre_Proyecto, p.Status
    FROM proyecto p
    WHERE p.Asesor = ? 
    AND (p.Nombre_Proyecto LIKE ? OR p.ID_Proyecto LIKE ?)
    ORDER BY p.ID_Proyecto ASC
    LIMIT ?, ?"; // Limitar los resultados

// Preparar la consulta
$stmt = $connection->prepare($query);
if ($stmt === false) {
    die('Error al preparar la consulta: ' . $connection->error);
}

// Añadimos el término de búsqueda, el límite y el offset
$stmt->bind_param('issii', $asesor_id, $search_query, $search_query, $start_from, $results_per_page);
$stmt->execute();
$result = $stmt->get_result(); // Obtener resultados

// Obtener el número total de proyectos asignados al asesor para paginación
$total_query = "
    SELECT COUNT(*) AS total
    FROM proyecto p
    WHERE p.Asesor = ? 
    AND (p.Nombre_Proyecto LIKE ? OR p.ID_Proyecto LIKE ?)";

// Preparar la consulta
$stmt_total = $connection->prepare($total_query);
$stmt_total->bind_param('iss', $asesor_id, $search_query, $search_query);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total_row = $result_total->fetch_assoc();
$total_projects = $total_row['total'];

// Calcular el número total de páginas
$total_pages = ceil($total_projects / $results_per_page);

// Mensajes de éxito o error al cambiar la contraseña
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Proyectos Asignados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>

    <!-- Modal Cambio Contraseña -->
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Contenido principal -->
            <main role="main" class="container bg-light p-2 mx-auto my-1">
                <h2>Gestión de Proyectos Asignados</h2>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                        placeholder="Buscar por nombre o ID de proyecto" aria-label="Buscar"
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr class="text-center">
                                <th>ID Proyecto</th>
                                <th>Nombre del Proyecto</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            // Mostrar proyectos asignados
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id_proyecto = $row['ID_Proyecto'];

                                    // Verificar si el proyecto ya está en conproyectorevisiones
                                    $checkQuery = "SELECT * FROM conproyectorevisiones WHERE ID_Proyecto = ?";
                                    $stmtCheck = $connection->prepare($checkQuery);
                                    $stmtCheck->bind_param('i', $id_proyecto);
                                    $stmtCheck->execute();
                                    $resultCheck = $stmtCheck->get_result();

                                    // Si no existe, lo insertamos
                                    if ($resultCheck->num_rows == 0) {
                                        // Insertar con ID_Conexion igual al ID_Proyecto
                                        $insertQuery = "INSERT INTO conproyectorevisiones (ID_Proyecto, ID_Conexion) VALUES (?, ?)";
                                        $stmtInsert = $connection->prepare($insertQuery);
                                        $stmtInsert->bind_param('ii', $id_proyecto, $id_proyecto); // Ambos valores iguales
                                        $stmtInsert->execute();
                                    }

                                    // Mostrar el enlace al proyecto
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Proyecto']) . "</td>";
                                    echo "<td><a href='historyRevitions.php?id_proyecto=" . htmlspecialchars($row['ID_Proyecto']) . "'>" . htmlspecialchars($row['Nombre_Proyecto']) . "</a></td>";
                                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No hay proyectos asignados.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <?php
                $search_query_encoded = isset($_GET['search']) ? urlencode($_GET['search']) : ''; // Encodificar si existe
                if ($total_pages > 1) {
                    echo '<nav aria-label="Page navigation">';
                    echo '<ul class="pagination justify-content-center">';

                    // Botón "Anterior"
                    if ($page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="asigmentProyects.php?page=' . ($page - 1) . '&search=' . $search_query_encoded . '">Anterior</a></li>';
                    } else {
                        echo '<li class="page-item disabled"><span class="page-link">Anterior</span></li>';
                    }

                    // Mostrar enlaces de paginación
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="asigmentProyects.php?page=' . $i . '&search=' . $search_query_encoded . '">' . $i . '</a></li>';
                        }
                    }

                    // Botón "Siguiente"
                    if ($page < $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="asigmentProyects.php?page=' . ($page + 1) . '&search=' . $search_query_encoded . '">Siguiente</a></li>';
                    } else {
                        echo '<li class="page-item disabled"><span class="page-link">Siguiente</span></li>';
                    }

                    echo '</ul>';
                    echo '</nav>';
                }
                ?>



            </main>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>