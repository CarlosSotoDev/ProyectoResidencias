<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Jefes de Carrera</title>
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
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardAdminJefes.php">Jefes de Carrera</a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1 id="anteproyecto">Gestion de Jefes de Carrera</h1>

                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por ID, Nombre, Apellidos, Carrera" aria-label="Buscar" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addJefeModal">
                    Agregar Jefe de Carrera
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID Jefe</th>
                                <th>Nombres</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Carrera</th>
                                <th>Nombre de Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener el valor de búsqueda, si existe
                            $search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

                            // Consulta para obtener los jefes de carrera, con lógica de búsqueda
                            $query = "
                                SELECT administrador.ID_Administrador, administrador.Nombres, administrador.Apellido_Paterno, administrador.Apellido_Materno, 
                                       carrera.Nombre_Carrera, usuario.Nombre_Usuario
                                FROM administrador
                                LEFT JOIN carrera ON administrador.Carrera = carrera.ID_Carrera
                                LEFT JOIN usuario ON administrador.ID_Usuario = usuario.ID_Usuario
                                WHERE administrador.Rol = 5
                            ";

                            // Si se ingresó un término de búsqueda, agregar condiciones para buscar en todos los campos
                            if ($search) {
                                $query .= " AND (
                                    administrador.ID_Administrador LIKE '%$search%' OR 
                                    administrador.Nombres LIKE '%$search%' OR 
                                    administrador.Apellido_Paterno LIKE '%$search%' OR 
                                    administrador.Apellido_Materno LIKE '%$search%' OR 
                                    carrera.Nombre_Carrera LIKE '%$search%' OR 
                                    usuario.Nombre_Usuario LIKE '%$search%'
                                )";
                            }

                            $query .= " ORDER BY administrador.ID_Administrador ASC";
                            $result = $connection->query($query);

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Administrador'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombres'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Paterno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Materno'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Carrera'] ?? 'Sin Carrera') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Usuario'] ?? 'Sin Usuario') . "</td>";
                                echo "<td><button type='button' class='btn btn-primary btn-sm edit-btn' data-toggle='modal' data-target='#editJefeModal'>Editar</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal para agregar jefe de carrera -->
                <div class="modal fade" id="addJefeModal" tabindex="-1" role="dialog" aria-labelledby="addJefeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addJefeModalLabel">Agregar Jefe de Carrera</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="addJefe.php" method="POST">
                                    <div class="form-group">
                                        <label for="addNombreJefe">Nombres</label>
                                        <input type="text" class="form-control" name="nombres" id="addNombreJefe" required>
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
                                            $queryCarrera = "SELECT * FROM carrera";
                                            $resultCarrera = $connection->query($queryCarrera);
                                            while ($carrera = $resultCarrera->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($carrera['ID_Carrera']) . "'>" . htmlspecialchars($carrera['Nombre_Carrera']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="addUsuario">Nombre de Usuario</label>
                                        <input type="text" class="form-control" name="username" id="addUsuario" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="addContrasena">Contraseña</label>
                                        <input type="text" class="form-control" name="password" id="addContrasena" readonly required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Agregar Jefe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar jefe de carrera -->
                <div class="modal fade" id="editJefeModal" tabindex="-1" role="dialog" aria-labelledby="editJefeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editJefeModalLabel">Editar Jefe de Carrera</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="editJefe.php" method="POST">
                                    <input type="hidden" name="id_jefe" id="editJefeId">
                                    <div class="form-group">
                                        <label for="editNombreJefe">Nombres</label>
                                        <input type="text" class="form-control" name="nombres" id="editNombreJefe" required>
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
                                            $queryCarrera = "SELECT * FROM carrera";
                                            $resultCarrera = $connection->query($queryCarrera);
                                            while ($carrera = $resultCarrera->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($carrera['ID_Carrera']) . "'>" . htmlspecialchars($carrera['Nombre_Carrera']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editUsuario">Nombre de Usuario</label>
                                        <input type="text" class="form-control" name="username" id="editUsuario" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editContrasena">Contraseña</label>
                                        <input type="password" class="form-control" name="password" id="editContrasena">
                                        <small class="form-text text-muted">Deja el campo vacío si no quieres cambiar la contraseña.</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function generarUsuarioYContrasena() {
                        const nombres = document.getElementById('addNombreJefe').value.trim();
                        const apellidoPaterno = document.getElementById('addApellidoPaterno').value.trim();
                        const apellidoMaterno = document.getElementById('addApellidoMaterno').value.trim();

                        if (nombres && apellidoPaterno && apellidoMaterno) {
                            const nombreUsuario = (nombres.charAt(0) + apellidoPaterno + apellidoMaterno.charAt(0)).toUpperCase();
                            document.getElementById('addUsuario').value = nombreUsuario;
                        }

                        const contrasenaAleatoria = Math.floor(100000 + Math.random() * 900000);
                        document.getElementById('addContrasena').value = contrasenaAleatoria;
                    }

                    document.getElementById('addNombreJefe').addEventListener('input', generarUsuarioYContrasena);
                    document.getElementById('addApellidoPaterno').addEventListener('input', generarUsuarioYContrasena);
                    document.getElementById('addApellidoMaterno').addEventListener('input', generarUsuarioYContrasena);

                    // Funcionalidad para el botón de "Editar"
                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            var row = this.closest('tr');
                            var jefeId = row.cells[0].innerText;
                            var nombres = row.cells[1].innerText;
                            var apellidoPaterno = row.cells[2].innerText;
                            var apellidoMaterno = row.cells[3].innerText;
                            var carrera = row.cells[4].innerText;
                            var username = row.cells[5].innerText;

                            document.getElementById('editJefeId').value = jefeId;
                            document.getElementById('editNombreJefe').value = nombres;
                            document.getElementById('editApellidoPaterno').value = apellidoPaterno;
                            document.getElementById('editApellidoMaterno').value = apellidoMaterno;
                            document.getElementById('editCarrera').value = carrera;
                            document.getElementById('editUsuario').value = username;
                            document.getElementById('editContrasena').value = ''; // Deja el campo vacío para que el usuario lo rellene si lo desea
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
