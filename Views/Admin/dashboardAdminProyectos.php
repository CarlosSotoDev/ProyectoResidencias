<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Proyectos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>
<body>
    <!-- Barra superior -->
    <nav class="navbar navbar-dark bg-success">
        <span class="navbar-brand mb-0 h1">Panel de Administración</span>
        <div class="d-flex align-items-center">
            <span class="navbar-text mr-3">
                <?php echo $_SESSION['username']; ?>
            </span>
            <a href="../public/logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <nav class="col-md-2 d-none d-md-block bg-success sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="#">
                                Proyectos
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2>Gestión de Proyectos</h2>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por nombre de proyecto" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <!-- Botón para agregar proyecto (abre modal) -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addProjectModal">
                    Agregar Proyecto
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID Proyecto</th>
                                <th>Nombre del Proyecto</th>
                                <th>Status</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Verifica si se ha enviado una búsqueda
                            $searchQuery = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connection, $_GET['search']);
                                $searchQuery = "AND (Nombre_Proyecto LIKE '%$search%')";
                            }

                            $query = "SELECT * FROM proyecto WHERE 1=1 $searchQuery ORDER BY ID_Proyecto ASC";
                            $result = $connection->query($query);

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status'] ?? '') . "</td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editProjectModal' 
                                        data-id='" . htmlspecialchars($row['ID_Proyecto']) . "' 
                                        data-nombre='" . htmlspecialchars($row['Nombre_Proyecto']) . "'>Editar</button>";
                                echo "<a href='deleteProject.php?id=" . htmlspecialchars($row['ID_Proyecto']) . "' class='btn btn-danger btn-sm'>Eliminar</a>";
                                echo "</td>";
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
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" name="nombre_proyecto" id="addNombreProyecto" required>
                        </div>
                        <input type="hidden" name="status" value="Pendiente"> <!-- Status predeterminado -->
                        <button type="submit" class="btn btn-primary">Agregar Proyecto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar proyecto -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel">Editar Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editProject.php" method="POST">
                        <input type="hidden" name="id_proyecto" id="editProjectId"> <!-- Campo oculto para el ID del proyecto -->
                        <div class="form-group">
                            <label for="editNombreProyecto">Nombre del Proyecto</label>
                            <input type="text" class="form-control" name="nombre_proyecto" id="editNombreProyecto" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace para abrir el modal con los datos del proyecto -->
    <script>
        $('#editProjectModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activa el modal
            var id = button.data('id'); // Extraer el ID del proyecto del atributo data-id
            var nombre = button.data('nombre'); // Extraer el nombre del proyecto del atributo data-nombre

            var modal = $(this);
            modal.find('#editProjectId').val(id); // Asignar el ID del proyecto al campo oculto
            modal.find('#editNombreProyecto').val(nombre); // Asignar el nombre del proyecto al input
        });
    </script>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>