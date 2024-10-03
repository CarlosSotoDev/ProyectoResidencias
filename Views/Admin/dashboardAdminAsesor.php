<?php 
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Asesores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Barra superior -->
    <?php require('../../includes/navbarAdmin.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <nav class="col-md-2 d-none d-md-block bg-success sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdmin.php">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdminProyectos.php">Proyectos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdminAsesor.php">Asesor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-center" href="dashboardAdminAlumnos.php">Alumnos</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <h2>Gestión de Asesores</h2>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar por ID, Nombre, Apellidos, Carrera o Proyectos" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <!-- Botón para agregar asesor -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addAsesorModal">
                    Agregar Asesor
                </button>

                <!-- Botón para agregar asesor EXISTENTE -->
                <button type="button" class="btn btn-info mb-3 ml-2" data-toggle="modal" data-target="#assignExistingAsesorModal">
                    Agregar Asesor existente
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID Asesor</th>
                                <th>Nombres</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Carrera</th>
                                <th>Proyectos Asignados</th>
                                <th>Nombre de Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta para obtener los asesores y sus proyectos asignados
                            $query = "
                                SELECT asesor.ID_Asesor, asesor.Nombres, asesor.Apellido_Paterno, asesor.Apellido_Materno, 
                                       carrera.Nombre_Carrera, 
                                       GROUP_CONCAT(proyecto.Nombre_Proyecto SEPARATOR ', ') AS Proyectos,
                                       usuario.Nombre_Usuario
                                FROM asesor
                                LEFT JOIN carrera ON asesor.Carrera = carrera.ID_Carrera
                                LEFT JOIN proyecto ON asesor.ID_Asesor = proyecto.Asesor
                                LEFT JOIN usuario ON asesor.ID_Usuario = usuario.ID_Usuario
                                GROUP BY asesor.ID_Asesor
                                ORDER BY asesor.ID_Asesor ASC";
                            $result = $connection->query($query);

                            // Mostrar los asesores
                            while ($row = $result->fetch_assoc()) {
                                // Verificación y separación de proyectos
                                if (!empty($row['Proyectos']) && is_string($row['Proyectos'])) {
                                    $proyectos = explode(", ", $row['Proyectos']);
                                } else {
                                    $proyectos = []; // Si está vacío, inicializamos como un arreglo vacío
                                }

                                echo "<tr>";
                                echo "<td class='asesor-id'>" . htmlspecialchars($row['ID_Asesor']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombres']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Paterno']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Apellido_Materno']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Carrera'] ?? 'Sin Carrera') . "</td>";

                                // Si el asesor tiene más de un proyecto asignado, mostrar un menú desplegable
                                if (count($proyectos) > 1) {
                                    echo "<td>
                                          <select class='form-control'>
                                              <option value=''>Seleccionar Proyecto</option>";
                                    foreach ($proyectos as $proyecto) {
                                        echo "<option value='" . htmlspecialchars($proyecto) . "'>" . htmlspecialchars($proyecto) . "</option>";
                                    }
                                    echo "</select></td>";
                                } else {
                                    echo "<td>" . htmlspecialchars($proyectos[0] ?? 'Sin Proyecto') . "</td>";
                                }

                                echo "<td>" . htmlspecialchars($row['Nombre_Usuario']) . "</td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary btn-sm edit-btn'>Editar</button>";
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

    <!-- Modal para agregar asesor -->
    <div class="modal fade" id="addAsesorModal" tabindex="-1" role="dialog" aria-labelledby="addAsesorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAsesorModalLabel">Agregar Asesor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="addAsesor.php" method="POST">
                        <div class="form-group">
                            <label for="addNombreAsesor">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="addNombreAsesor" required>
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
                            <label for="addProyecto">Proyecto</label>
                            <select class="form-control" name="proyecto" id="addProyecto">
                                <option value="">Sin Proyecto</option>
                                <?php
                                // Obtener los proyectos sin asesor asignado
                                $queryProyecto = "SELECT * FROM proyecto WHERE Asesor IS NULL";
                                $resultProyecto = $connection->query($queryProyecto);
                                while ($proyecto = $resultProyecto->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($proyecto['ID_Proyecto']) . "'>" . htmlspecialchars($proyecto['Nombre_Proyecto']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addUsuario">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="username" id="addUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="addContrasena">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="addContrasena" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Asesor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para asignar asesor existente -->
    <div class="modal fade" id="assignExistingAsesorModal" tabindex="-1" role="dialog" aria-labelledby="assignExistingAsesorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignExistingAsesorModalLabel">Asignar Asesor Existente</h5>
                    <button  type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="assignAsesor.php" method="POST" id="assignAsesorForm">
                        <div class="form-group">
                            <label for="selectExistingAsesor">Seleccionar Asesor</label>
                            <select class="form-control" name="asesor_id" id="selectExistingAsesor" required>
                                <option value="">Seleccione un Asesor</option>
                                <?php
                                // Obtener los asesores existentes
                                $queryAsesores = "SELECT ID_Asesor, CONCAT(Nombres, ' ', Apellido_Paterno, ' ', Apellido_Materno) AS Nombre_Asesor FROM asesor";
                                $resultAsesores = $connection->query($queryAsesores);
                                while ($asesor = $resultAsesores->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($asesor['ID_Asesor']) . "'>" . htmlspecialchars($asesor['Nombre_Asesor']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selectProject">Seleccionar Proyecto</label>
                            <select class="form-control" name="proyecto_id" id="selectProject" required>
                                <option value="">Seleccione un Proyecto</option>
                                <?php
                                // Obtener los proyectos disponibles
                                $queryProyectos = "SELECT ID_Proyecto, Nombre_Proyecto FROM proyecto WHERE Asesor IS NULL";
                                $resultProyectos = $connection->query($queryProyectos);
                                while ($proyecto = $resultProyectos->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($proyecto['ID_Proyecto']) . "'>" . htmlspecialchars($proyecto['Nombre_Proyecto']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Asignar Asesor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar asesor -->
    <div class="modal fade" id="editAsesorModal" tabindex="-1" role="dialog" aria-labelledby="editAsesorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAsesorModalLabel">Editar Asesor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editAsesor.php" method="POST">
                        <input type="hidden" name="id_asesor" id="editAsesorId">
                        <div class="form-group">
                            <label for="editNombreAsesor">Nombres</label>
                            <input type="text" class="form-control" name="nombres" id="editNombreAsesor" required>
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

    <!-- Script para pre-llenar el modal de edición con los datos del asesor -->
    <script>
        // Escuchar el evento de clic en los botones "Editar"
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                var row = this.closest('tr');
                
                var asesorId = row.querySelector('.asesor-id').innerText;
                var nombres = row.cells[1].innerText;
                var apellidoPaterno = row.cells[2].innerText;
                var apellidoMaterno = row.cells[3].innerText;
                var carrera = row.cells[4].innerText;
                var username = row.cells[6].innerText;

                document.getElementById('editAsesorId').value = asesorId;
                document.getElementById('editNombreAsesor').value = nombres;
                document.getElementById('editApellidoPaterno').value = apellidoPaterno;
                document.getElementById('editApellidoMaterno').value = apellidoMaterno;
                document.getElementById('editCarrera').value = carrera;
                document.getElementById('editUsuario').value = username;
                document.getElementById('editContrasena').value = ''; // Deja vacío para que el usuario la rellene si lo desea

                $('#editAsesorModal').modal('show');
            });
        });
    </script>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
