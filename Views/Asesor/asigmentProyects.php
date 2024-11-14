<?php
// Incluir la configuración y la sesión si es necesario
include('../../includes/config.php');
include('../../includes/navbarAsesor.php'); // Llamada al navbar

checkLogin(); // Verificar inicio de sesión

// Verificar si el ID del asesor está en la sesión
if (!isset($_SESSION['asesor_id'])) {
    echo "Error: No se encontró el ID del asesor en la sesión.";
    exit;
}

// Obtener el ID del asesor desde la sesión
$asesor_id = $_SESSION['asesor_id'];

// Verificar si hay un término de búsqueda
$search_term = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%%';

// Consulta para obtener los proyectos asignados al asesor
$query = "
    SELECT p.ID_Proyecto, p.Nombre_Proyecto, p.Status
    FROM proyecto p
    WHERE p.Asesor = ? 
    AND (p.Nombre_Proyecto LIKE ? OR p.ID_Proyecto LIKE ?)
    ORDER BY p.ID_Proyecto ASC";

// Preparar la consulta
$stmt = $connection->prepare($query);
if ($stmt === false) {
    die('Error al preparar la consulta: ' . $connection->error);
}

// Añadimos el término de búsqueda para el ID_Proyecto (como string también)
$stmt->bind_param('iss', $asesor_id, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proyectos Asignados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/custom.css"> <!-- Ruta hacia tu CSS personalizado -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Ajuste de margen para evitar que el contenido sea cubierto por el navbar */
        .main-container {
            margin-top: 70px; /* Asegúrate de que coincide con la altura del navbar */
        }
    </style>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container main-container">
        <h2 class="text-center">Gestión de Proyectos Asignados</h2>

        <!-- Barra de búsqueda -->
        <form method="GET" class="form-inline mb-3 justify-content-center">
            <input class="form-control mr-sm-2" type="search" name="search"
                   placeholder="Buscar por nombre o ID de proyecto" aria-label="Buscar"
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>

        <!-- Tabla de proyectos -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>ID Proyecto</th>
                        <th>Nombre del Proyecto</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar proyectos asignados
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['ID_Proyecto']) . "</td>";
                            echo "<td><a href='proyects.php?id_proyecto=" . htmlspecialchars($row['ID_Proyecto']) . "'>" . htmlspecialchars($row['Nombre_Proyecto']) . "</a></td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['Status']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center text-danger'>No se encontraron proyectos en la consulta.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
