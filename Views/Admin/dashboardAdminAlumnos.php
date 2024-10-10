<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>docs.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAdmin.php'); ?>

    <div class="container-fluid page-dashboard bg-white">
        <div class="row">
            <div class="col-2 sidebar bg-success d-flex flex-column align-items-center p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardAdmin.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardAdminProyectos.php">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardAdminAsesor.php">Asesores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardAdminAlumnos.php">Alumnos</a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1 id="anteproyecto">Gestión de Alumno</h1>

                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                        placeholder="Buscar por nombre de alumno" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addAlumnoModal">
                    Agregar Alumno
                </button>

                <button type="button" class="btn btn-info mb-3 ml-2" data-toggle="modal"
                    data-target="#assignProjectModal">
                    Asignar Proyecto a Alumno
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Carrera</th>
                                <th>Proyecto</th>
                                <th>Asesor</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $searchQuery = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connection, $_GET['search']);
                                $searchQuery = "AND (alumno.Nombres LIKE '%$search%' OR alumno.Apellido_Paterno LIKE '%$search%' OR alumno.Apellido_Materno LIKE '%$search%' OR alumno.ID_Alumno LIKE '%$search%' OR asesor.Nombres LIKE '%$search%' OR proyecto.Nombre_Proyecto LIKE '%$search%')";
                            }

                            $query = "
                                SELECT alumno.*, proyecto.Nombre_Proyecto, 
                                       CONCAT(asesor.Nombres, ' ', asesor.Apellido_Paterno, ' ', asesor.Apellido_Materno) AS Nombre_Asesor, 
                                       carrera.Nombre_Carrera, usuario.Nombre_Usuario
                                FROM alumno 
                                LEFT JOIN proyecto ON alumno.Proyecto = proyecto.ID_Proyecto 
                                LEFT JOIN asesor ON alumno.Asesor = asesor.ID_Asesor 
                                LEFT JOIN carrera ON alumno.Carrera = carrera.ID_Carrera
                                LEFT JOIN usuario ON alumno.ID_Usuario = usuario.ID_Usuario
                                WHERE 1=1 $searchQuery 
                                ORDER BY alumno.ID_Alumno ASC";
                            $result = $connection->query($query);

                            while ($row = $result->fetch_assoc()) {
                                $proyecto = $row['Nombre_Proyecto'] ?? 'No asignado';
                                $asesor = $row['Nombre_Asesor'] ?? 'No asignado';
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Alumno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombres'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Paterno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Materno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Carrera'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($proyecto) . "</td>";
                                echo "<td>" . htmlspecialchars($asesor) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Usuario'] ?? '') . "</td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary btn-sm edit-btn' 
                                        data-id='" . htmlspecialchars($row['ID_Alumno'] ?? '') . "' 
                                        data-nombre='" . htmlspecialchars($row['Nombres'] ?? '') . "' 
                                        data-apellido_paterno='" . htmlspecialchars($row['Apellido_Paterno'] ?? '') . "' 
                                        data-apellido_materno='" . htmlspecialchars($row['Apellido_Materno'] ?? '') . "' 
                                        data-carrera='" . htmlspecialchars($row['Carrera'] ?? '') . "' 
                                        data-usuario='" . htmlspecialchars($row['Nombre_Usuario'] ?? '') . "'>Editar</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal para agregar alumno -->
                <div class="modal fade" id="addAlumnoModal" tabindex="-1" role="dialog"
                    aria-labelledby="addAlumnoModalLabel" aria-hidden="true">
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
                                        <select class="form-control" name="proyecto" id="addProyecto">
                                            <option value="">Sin Proyecto</option>
                                            <?php
                                            $queryProyecto = "SELECT ID_Proyecto, Nombre_Proyecto FROM proyecto WHERE (Integrante_1 IS NULL OR Integrante_2 IS NULL OR Integrante_3 IS NULL)";
                                            $resultProyecto = $connection->query($queryProyecto);
                                            while ($rowProyecto = $resultProyecto->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($rowProyecto['ID_Proyecto']) . "'>" . htmlspecialchars($rowProyecto['Nombre_Proyecto']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="addUsuarioAlumno">Nombre de Usuario</label>
                                        <input type="text" class="form-control" name="username" id="addUsuarioAlumno" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addContrasenaAlumno">Contraseña</label>
                                        <input type="text" class="form-control" name="password" id="addContrasenaAlumno" readonly required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Agregar Alumno</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar alumno -->
                <div class="modal fade" id="editAlumnoModal" tabindex="-1" role="dialog"
                    aria-labelledby="editAlumnoModalLabel" aria-hidden="true">
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
                                            <?php
                                            $queryCarrera = "SELECT ID_Carrera, Nombre_Carrera FROM carrera";
                                            $resultCarrera = $connection->query($queryCarrera);
                                            while ($rowCarrera = $resultCarrera->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($rowCarrera['ID_Carrera']) . "'>" . htmlspecialchars($rowCarrera['Nombre_Carrera']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editUsuarioAlumno">Nombre de Usuario</label>
                                        <input type="text" class="form-control" name="username" id="editUsuarioAlumno" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editContrasenaAlumno">Contraseña</label>
                                        <input type="password" class="form-control" name="password" id="editContrasenaAlumno">
                                        <small class="form-text text-muted">Deja en blanco para mantener la contraseña actual.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para asignar proyecto a un alumno existente -->
                <div class="modal fade" id="assignProjectModal" tabindex="-1" role="dialog"
                    aria-labelledby="assignProjectModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignProjectModalLabel">Asignar Proyecto a Alumno</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="assignProject.php" method="POST">
                                    <div class="form-group">
                                        <label for="selectAlumno">Seleccionar Alumno</label>
                                        <select class="form-control" name="alumno_id" id="selectAlumno" required>
                                            <option value="">Seleccione un alumno sin proyecto</option>
                                            <?php
                                            $queryAlumno = "SELECT ID_Alumno, CONCAT(Nombres, ' ', Apellido_Paterno, ' ', Apellido_Materno) AS Nombre_Alumno FROM alumno WHERE Proyecto IS NULL";
                                            $resultAlumno = $connection->query($queryAlumno);
                                            while ($alumno = $resultAlumno->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($alumno['ID_Alumno']) . "'>" . htmlspecialchars($alumno['Nombre_Alumno']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectProyecto">Seleccionar Proyecto</label>
                                        <select class="form-control" name="proyecto_id" id="selectProyecto" required>
                                            <option value="">Seleccione un proyecto con espacios disponibles</option>
                                            <?php
                                            $queryProyecto = "
                                    SELECT ID_Proyecto, Nombre_Proyecto 
                                    FROM proyecto 
                                    WHERE (Integrante_1 IS NULL OR Integrante_2 IS NULL OR Integrante_3 IS NULL)";
                                            $resultProyecto = $connection->query($queryProyecto);
                                            while ($proyecto = $resultProyecto->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($proyecto['ID_Proyecto']) . "'>" . htmlspecialchars($proyecto['Nombre_Proyecto']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Asignar Proyecto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Script para abrir el modal con los datos del alumno -->
                <script>
                    function generarUsuarioYContrasena() {
                        const nombres = document.getElementById('addNombreAlumno').value.trim();
                        const apellidoPaterno = document.getElementById('addApellidoPaterno').value.trim();
                        const apellidoMaterno = document.getElementById('addApellidoMaterno').value.trim();

                        if (nombres && apellidoPaterno && apellidoMaterno) {
                            const nombreUsuario = (nombres.charAt(0) + apellidoPaterno + apellidoMaterno.charAt(0)).toUpperCase();
                            document.getElementById('addUsuarioAlumno').value = nombreUsuario;
                        }

                        const contrasenaAleatoria = Math.floor(100000 + Math.random() * 900000);
                        document.getElementById('addContrasenaAlumno').value = contrasenaAleatoria;
                    }

                    document.getElementById('addNombreAlumno').addEventListener('input', generarUsuarioYContrasena);
                    document.getElementById('addApellidoPaterno').addEventListener('input', generarUsuarioYContrasena);
                    document.getElementById('addApellidoMaterno').addEventListener('input', generarUsuarioYContrasena);

                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            var row = this.closest('tr');
                            var idAlumno = row.querySelector('td').innerText;
                            var nombre = row.cells[1].innerText;
                            var apellidoPaterno = row.cells[2].innerText;
                            var apellidoMaterno = row.cells[3].innerText;
                            var carrera = row.cells[4].innerText;
                            var usuario = row.cells[7].innerText;

                            document.getElementById('editAlumnoId').value = idAlumno;
                            document.getElementById('editNombreAlumno').value = nombre;
                            document.getElementById('editApellidoPaterno').value = apellidoPaterno;
                            document.getElementById('editApellidoMaterno').value = apellidoMaterno;
                            document.getElementById('editCarrera').value = carrera;
                            document.getElementById('editUsuarioAlumno').value = usuario;
                            document.getElementById('editContrasenaAlumno').value = '';

                            $('#editAlumnoModal').modal('show');
                        });
                    });
                </script>

                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            </div>
        </div>
    </div>
</body>

</html>
