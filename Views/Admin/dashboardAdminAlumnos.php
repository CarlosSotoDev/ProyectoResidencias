<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Alumnos</title>
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
                            <a class="nav-link text-white text-center" href="dashboardAdmin.php">
                                Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdminProyectos.php">
                                Proyectos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdminAsesor.php">
                                Asesor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdminAlumnos.php">
                                Alumnos
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
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por nombre de alumno" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <!-- Botón para agregar alumno -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addAlumnoModal">
                    Agregar Alumno
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Carrera</th>
                                <th>Proyecto</th>
                                <th>Asesor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Verifica si se ha enviado una búsqueda
                            $searchQuery = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connection, $_GET['search']);
                                $searchQuery = "AND (alumno.Nombres LIKE '%$search%' OR alumno.Apellido_Paterno LIKE '%$search%' OR alumno.Apellido_Materno LIKE '%$search%' OR alumno.Id_Alumno LIKE '%$search%' OR asesor.Nombres LIKE '%$search%' OR proyecto.Nombre_Proyecto LIKE '%$search%')";
                            }

                            // Consulta para obtener los datos de los alumnos con los nombres de carrera, proyecto, asesor, id_usuario, y rol
                            $query = "
                                SELECT alumno.*, proyecto.Nombre_Proyecto, 
                                       CONCAT(asesor.Nombres, ' ', asesor.Apellido_Paterno, ' ', asesor.Apellido_Materno) AS Nombre_Asesor, 
                                       carrera.Nombre_Carrera, usuario.id_usuario, usuario.rol 
                                FROM alumno 
                                LEFT JOIN proyecto ON alumno.Proyecto = proyecto.ID_Proyecto 
                                LEFT JOIN asesor ON alumno.Asesor = asesor.ID_Asesor 
                                LEFT JOIN carrera ON alumno.Carrera = carrera.ID_Carrera
                                LEFT JOIN usuario ON alumno.ID_Usuario = usuario.id_usuario
                                WHERE 1=1 $searchQuery 
                                ORDER BY alumno.ID_Alumno ASC";
                            $result = $connection->query($query);

                            // Mostrar los resultados en la tabla
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Alumno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombres'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Paterno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Materno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Carrera'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Asesor'] ?? '') . "</td>";
                                //echo "<td>" . htmlspecialchars($row['id_usuario'] ?? '') . "</td>";
                               // echo "<td>" . htmlspecialchars($row['rol'] ?? '') . "</td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editAlumnoModal' 
                                        data-id='" . htmlspecialchars($row['ID_Alumno'] ?? '') . "' 
                                        data-nombre='" . htmlspecialchars($row['Nombres'] ?? '') . "' 
                                        data-apellido_paterno='" . htmlspecialchars($row['Apellido_Paterno'] ?? '') . "' 
                                        data-apellido_materno='" . htmlspecialchars($row['Apellido_Materno'] ?? '') . "' 
                                        data-carrera='" . htmlspecialchars($row['Carrera'] ?? '') . "' 
                                        data-proyecto='" . htmlspecialchars($row['Proyecto'] ?? '') . "' 
                                        data-asesor='" . htmlspecialchars($row['Asesor'] ?? '') . "'>Editar</button>";
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

    <!-- Modal para agregar alumno -->
    <div class="modal fade" id="addAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="addAlumnoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAlumnoModalLabel">Agregar Alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addAlumno.php" method="POST">
                        <div class="form-group">
                            <label for="addNombreAlumno">Nombre del Alumno</label>
                            <input type="text" class="form-control" name="nombres" id="addNombreAlumno" required>
                        </div>
                        <div class="form-group">
                            <label for="addApellidoPaterno">Apellido Paterno</label>
                            <input type="text" class="form-control" name="apellido_paterno" id="addApellidoPaterno" required>
                        </div>
                        <div class="form-group">
                            <label for="addApellidoMaterno">Apellido Materno</label>
                            <input type="text" class="form-control" name="apellido_materno" id="addApellidoMaterno" required>
                        </div>
                        <div class="form-group">
                            <label for="addCarrera">Carrera</label>
                            <select class="form-control" name="carrera" id="addCarrera" required>
                                <?php
                                // Obtener las carreras para el dropdown
                                $queryCarrera = "SELECT ID_Carrera, Nombre_Carrera FROM carrera";
                                $resultCarrera = $connection->query($queryCarrera);
                                while ($rowCarrera = $resultCarrera->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($rowCarrera['ID_Carrera']) . "'>" . htmlspecialchars($rowCarrera['Nombre_Carrera']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addProyecto">Proyecto</label>
                            <select class="form-control" name="proyecto" id="addProyecto" required>
                                <?php
                                // Obtener los proyectos para el dropdown
                                $queryProyecto = "SELECT ID_Proyecto, Nombre_Proyecto FROM proyecto";
                                $resultProyecto = $connection->query($queryProyecto);
                                while ($rowProyecto = $resultProyecto->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($rowProyecto['ID_Proyecto']) . "'>" . htmlspecialchars($rowProyecto['Nombre_Proyecto']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addAsesor">Asesor</label>
                            <select class="form-control" name="asesor" id="addAsesor" required>
                                <?php
                                // Obtener los asesores para el dropdown
                                $queryAsesor = "SELECT ID_Asesor, CONCAT(Nombres, ' ', Apellido_Paterno, ' ', Apellido_Materno) AS Nombre_Asesor FROM asesor";
                                $resultAsesor = $connection->query($queryAsesor);
                                while ($rowAsesor = $resultAsesor->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($rowAsesor['ID_Asesor']) . "'>" . htmlspecialchars($rowAsesor['Nombre_Asesor']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Campos de usuario -->
                        <div class="form-group">
                            <label for="addUsuarioAlumno">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="username" id="addUsuarioAlumno" required>
                        </div>
                        <div class="form-group">
                            <label for="addContrasenaAlumno">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="addContrasenaAlumno" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Alumno</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar alumno -->
    <div class="modal fade" id="editAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="editAlumnoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlumnoModalLabel">Editar Alumno</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editAlumno.php" method="POST">
                        <input type="hidden" name="id_alumno" id="editAlumnoId">
                        <div class="form-group">
                            <label for="editNombreAlumno">Nombre del Alumno</label>
                            <input type="text" class="form-control" name="nombres" id="editNombreAlumno" required>
                        </div>
                        <div class="form-group">
                            <label for="editApellidoPaterno">Apellido Paterno</label>
                            <input type="text" class="form-control" name="apellido_paterno" id="editApellidoPaterno" required>
                        </div>
                        <div class="form-group">
                            <label for="editApellidoMaterno">Apellido Materno</label>
                            <input type="text" class="form-control" name="apellido_materno" id="editApellidoMaterno" required>
                        </div>
                        <div class="form-group">
                            <label for="editCarrera">Carrera</label>
                            <select class="form-control" name="carrera" id="editCarrera" required>
                                <!-- Las opciones de carrera se cargarán dinámicamente desde el servidor -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editProyecto">Proyecto</label>
                            <select class="form-control" name="proyecto" id="editProyecto" required>
                                <!-- Las opciones de proyecto se cargarán dinámicamente desde el servidor -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editAsesor">Asesor</label>
                            <select class="form-control" name="asesor" id="editAsesor" required>
                                <!-- Las opciones de asesor se cargarán dinámicamente desde el servidor -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace para abrir el modal de edición con los datos del alumno -->
    <script>
        $('#editAlumnoModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activa el modal
            var id = button.data('id'); // Extraer el ID del alumno del atributo data-id
            var nombre = button.data('nombre'); // Extraer el nombre del alumno del atributo data-nombre
            var apellido_paterno = button.data('apellido_paterno');
            var apellido_materno = button.data('apellido_materno');
            var carrera = button.data('carrera');
            var proyecto = button.data('proyecto');
            var asesor = button.data('asesor');

            var modal = $(this);
            modal.find('#editAlumnoId').val(id); // Asignar el ID del alumno al campo oculto
            modal.find('#editNombreAlumno').val(nombre);
            modal.find('#editApellidoPaterno').val(apellido_paterno);
            modal.find('#editApellidoMaterno').val(apellido_materno);
            modal.find('#editCarrera').val(carrera);
            modal.find('#editProyecto').val(proyecto);
            modal.find('#editAsesor').val(asesor);
        });
    </script>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>