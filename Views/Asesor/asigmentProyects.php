<?php
session_start(); // Inicia la sesión

include('../../includes/config.php'); // Conexión a la base de datos
checkLogin(); // Función que verifica si el usuario ha iniciado sesión

// Verificar si el ID del asesor está en la sesión
if (!isset($_SESSION['asesor_id'])) {
    // Si no se encuentra el ID del asesor en la sesión, redirigir o mostrar un mensaje de error
    echo "Error: No se encontró el ID del asesor en la sesión.";
    exit; // Detener la ejecución si no se encuentra el ID del asesor
}

// Obtener el ID del asesor de la sesión
$asesor_id = $_SESSION['asesor_id'];

// Consulta para obtener los proyectos asignados al asesor que ha iniciado sesión
$query = "
    SELECT p.ID_Proyecto, p.Nombre_Proyecto, p.Status
    FROM proyecto p
    WHERE p.Asesor = ?
    ORDER BY p.ID_Proyecto ASC";

// Preparar la consulta para evitar inyecciones SQL
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $asesor_id); // 'i' indica que el parámetro es un entero
$stmt->execute();
$result = $stmt->get_result(); // Obtener los resultados de la consulta

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Proyectos Asignados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
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
                        placeholder="Buscar por nombre de proyecto" aria-label="Buscar">
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
                            // Mostrar los proyectos asignados al asesor
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Proyecto']) . "</td>";
                                
                                // Crear el enlace alrededor del nombre del proyecto
                                echo "<td><a href='../Asesor/proyects.php?id=" . htmlspecialchars($row['ID_Proyecto']) . "'>" . htmlspecialchars($row['Nombre_Proyecto']) . "</a></td>";
                                
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                echo "<td>";
                                echo "</tr>";
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
