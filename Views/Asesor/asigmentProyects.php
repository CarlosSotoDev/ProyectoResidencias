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
$search_term = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%%';

// Consulta para obtener los proyectos asignados al asesor
$query = "
    SELECT p.ID_Proyecto, p.Nombre_Proyecto, p.Status
    FROM proyecto p
    WHERE p.Asesor = ? AND p.Nombre_Proyecto LIKE ?
    ORDER BY p.ID_Proyecto ASC";

// Preparar la consulta
$stmt = $connection->prepare($query);
$stmt->bind_param('is', $asesor_id, $search_term); // 'i' para entero y 's' para string
$stmt->execute();
$result = $stmt->get_result(); // Obtener resultados

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Proyectos Asignados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Contenido principal -->
            <main role="main" class="container bg-light p-2 mx-auto my-1">
                <h2>Gestión de Proyectos Asignados</h2>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                        placeholder="Buscar por nombre de proyecto" aria-label="Buscar"
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
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Proyecto']) . "</td>";
                                    // Enlace a la página proyects.php con el ID del proyecto
                                    echo "<td><a href='proyects.php?id_proyecto=" . htmlspecialchars($row['ID_Proyecto']) . "'>" . htmlspecialchars($row['Nombre_Proyecto']) . "</a></td>";
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
            </main>
        </div>
    </div>

    <!-- Modal para agregar proyecto -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Agregar Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addProject.php" method="POST">
                        <div class="form-group">
                            <label for="addNombreProyecto">Nombre del Proyecto</label>
                            <input type="text" class="form-control" name="nombre_proyecto" id="addNombreProyecto"
                                required>
                        </div>
                        <input type="hidden" name="status" value="Pendiente"> <!-- Status predeterminado -->
                        <button type="submit" class="btn btn-primary">Agregar Proyecto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>