<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestion de Alumnos</title>
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
                            <!-- Enlace "Alumnos" con redirección directa -->
                            <a class="nav-link text-white text-center" href="../Asesor/addStudent.php" id="btn-alumnos">
                                Alumnos
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- Enlace "Proyectos" con manejo por jQuery -->
                            <a class="nav-link text-white text-center" href="../Asesor/addProject.php"
                                id="btn-proyectos">
                                Proyectos
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2>Gestión de Alumnos</h2>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por nombre o id"
                        aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <!-- Botón para agregar usuario (abre modal) -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addUserModal">
                    Agregar Alumno
                </button>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre(s) Alumno</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Proyecto</th>
                                <th>Calendario Revisiones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Verifica si se ha enviado una búsqueda
                            $searchQuery = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connection, $_GET['search']);
                                $searchQuery = "AND (Nombres LIKE '%$search%' OR Apellido_Paterno LIKE '%$search%' OR Apellido_Materno LIKE '%$search%' OR Proyecto LIKE '%$search%')";
                            }

                            // Query para obtener los alumnos
                            $query = "SELECT ID_Alumno, Nombres, Apellido_Paterno, Apellido_Materno, Proyecto, Calendario_Revisiones FROM alumno WHERE Rol != 4 $searchQuery";
                            $result = $connection->query($query);

                            // Mostrar los resultados en la tabla
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Alumno']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombres']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Paterno']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Materno']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Proyecto']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Calendario_Revisiones']) . "</td>";
                                echo "<td>";
                                // Botón de editar
                                echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editUserModal' 
                    data-id='" . $row['ID_Alumno'] . "' 
                    data-nombres='" . htmlspecialchars($row['Nombres']) . "' 
                    data-apellido_paterno='" . htmlspecialchars($row['Apellido_Paterno']) . "' 
                    data-apellido_materno='" . htmlspecialchars($row['Apellido_Materno']) . "'>Editar</button>";
                                // Botón de eliminar
                                echo "<a href='deleteUser.php?id=" . $row['ID_Alumno'] . "' class='btn btn-danger btn-sm'>Eliminar</a>";
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

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addUser.php" method="POST">
                        <div class="form-group">
                            <label for="addUsername">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="username" id="addUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="addRole">Rol</label>
                            <select class="form-control" name="role" id="addRole" required>
                                <option value="1">Alumno</option>
                                <option value="2">Asesor</option>
                                <option value="3">Administrador</option>
                                <option value="4">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addPassword">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="addPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editUser.php" method="POST">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label for="editUsername">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="username" id="editUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Rol</label>
                            <select class="form-control" name="role" id="editRole" required>
                                <option value="1">Alumno</option>
                                <option value="2">Asesor</option>
                                <option value="3">Administrador</option>
                                <option value="4">Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editPassword">Contraseña (dejar en blanco para no cambiarla)</label>
                            <input type="password" class="form-control" name="password" id="editPassword">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace para abrir el modal con los datos del usuario -->
    <script>
        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activa el modal
            var id = button.data('id'); // Extraer información de los atributos data-*
            var username = button.data('username');
            var role = button.data('role');

            var modal = $(this);
            modal.find('#editUserId').val(id);
            modal.find('#editUsername').val(username);
            modal.find('#editRole').val(role);
        });
    </script>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>