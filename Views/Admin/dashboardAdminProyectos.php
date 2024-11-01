<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>docs.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAdmin.php'); ?>
    <!-- Modal Cambio Contraseña -->

    <!-- Página de contenido -->
    <div class="container-fluid page-dashboard bg-white">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-2 sidebar bg-success d-flex flex-column align-items-center p-3">
                <!-- Aquí va el contenido de la barra lateral -->
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

            <!-- Contenido principal -->
            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1 id="anteproyecto">Gestion de Proyectos</h1>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                        placeholder="Buscar por ID, Nombre de proyecto, Status, Integrante, Asesor" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <!-- Botón para agregar proyecto (abre modal) -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addProjectModal">
                    Agregar Proyecto
                </button>

                <!-- Botón para desvincular asesor (abre modal) -->
                <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#unlinkModal">
                    Desvincular Asesor
                </button>

                <!-- Botón para desvincular integrante (abre modal) -->
                <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#selectProjectModal">
                    Desvincular Integrante
                </button>

                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID Proyecto</th>
                                <th>Nombre del Proyecto</th>
                                <th>Status</th>
                                <th>Integrante 1</th>
                                <th>Integrante 2</th>
                                <th>Integrante 3</th>
                                <th>Asesor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener el valor de búsqueda, si se proporcionó
                            $search = isset($_GET['search']) ? $_GET['search'] : '';

                            // Consulta para obtener todos los campos de la tabla proyecto con opción de búsqueda
                            $query = "
                                SELECT p.*, 
                                       CONCAT(a.Nombres, ' ', a.Apellido_Paterno, ' ', a.Apellido_Materno) AS Nombre_Asesor,
                                       CONCAT(i1.Nombres, ' ', i1.Apellido_Paterno, ' ', i1.Apellido_Materno) AS Integrante1,
                                       CONCAT(i2.Nombres, ' ', i2.Apellido_Paterno, ' ', i2.Apellido_Materno) AS Integrante2,
                                       CONCAT(i3.Nombres, ' ', i3.Apellido_Paterno, ' ', i3.Apellido_Materno) AS Integrante3
                                FROM proyecto p
                                LEFT JOIN asesor a ON p.Asesor = a.ID_Asesor
                                LEFT JOIN alumno i1 ON p.Integrante_1 = i1.ID_Alumno
                                LEFT JOIN alumno i2 ON p.Integrante_2 = i2.ID_Alumno
                                LEFT JOIN alumno i3 ON p.Integrante_3 = i3.ID_Alumno
                                WHERE p.ID_Proyecto LIKE '%$search%'
                                   OR p.Nombre_Proyecto LIKE '%$search%'
                                   OR p.Status LIKE '%$search%'
                                   OR CONCAT(i1.Nombres, ' ', i1.Apellido_Paterno, ' ', i1.Apellido_Materno) LIKE '%$search%'
                                   OR CONCAT(i2.Nombres, ' ', i2.Apellido_Paterno, ' ', i2.Apellido_Materno) LIKE '%$search%'
                                   OR CONCAT(i3.Nombres, ' ', i3.Apellido_Paterno, ' ', i3.Apellido_Materno) LIKE '%$search%'
                                   OR CONCAT(a.Nombres, ' ', a.Apellido_Paterno, ' ', a.Apellido_Materno) LIKE '%$search%'
                                ORDER BY p.ID_Proyecto ASC";

                            $result = $connection->query($query);

                            // Mostrar todos los campos de la tabla
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='project-id'>" . htmlspecialchars($row['ID_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Integrante1'] ?? 'No asignado') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Integrante2'] ?? 'No asignado') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Integrante3'] ?? 'No asignado') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Asesor'] ?? 'No asignado') . "</td>";
                                echo "<td>";
                                echo "<button type='button' class='btn btn-primary btn-sm edit-btn'>Editar</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal para agregar proyecto -->
                <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog"
                    aria-labelledby="addProjectModalLabel" aria-hidden="true">
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
                                        <input type="text" class="form-control" name="nombre_proyecto"
                                            id="addNombreProyecto" required>
                                    </div>
                                    <input type="hidden" name="status" value="Pendiente"> <!-- Status predeterminado -->
                                    <button type="submit" class="btn btn-primary">Agregar Proyecto</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para editar proyecto -->
                <div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog"
                    aria-labelledby="editProjectModalLabel" aria-hidden="true">
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
                                    <input type="hidden" name="id_proyecto" id="editProjectId">

                                    <!-- Campo de texto para nombre del proyecto -->
                                    <div class="form-group">
                                        <label for="editNombreProyecto">Nombre del Proyecto</label>
                                        <input type="text" class="form-control" name="nombre_proyecto"
                                            id="editNombreProyecto" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para desvincular asesor -->
                <div class="modal fade" id="unlinkModal" tabindex="-1" role="dialog" aria-labelledby="unlinkModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="unlinkModalLabel">Desvincular Asesor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="unlinkAsesor.php" method="POST">
                                    <div class="form-group">
                                        <label for="selectProyecto">Seleccionar Proyecto</label>
                                        <select class="form-control" id="selectProyecto" name="id_proyecto" required>
                                            <?php
                                            // Consulta para obtener los proyectos que tienen un asesor asignado
                                            $queryProyectosConAsesor = "
                                    SELECT p.ID_Proyecto, p.Nombre_Proyecto, 
                                           CONCAT(a.Nombres, ' ', a.Apellido_Paterno, ' ', a.Apellido_Materno) AS Nombre_Asesor
                                    FROM proyecto p
                                    INNER JOIN asesor a ON p.Asesor = a.ID_Asesor";
                                            $resultProyectos = $connection->query($queryProyectosConAsesor);
                                            while ($rowProyectos = $resultProyectos->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($rowProyectos['ID_Proyecto']) . "'>"
                                                    . htmlspecialchars($rowProyectos['Nombre_Proyecto']) . " - Asesor: "
                                                    . htmlspecialchars($rowProyectos['Nombre_Asesor']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger">Desvincular Asesor</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Primer Modal: Seleccionar proyecto para desvincular integrante -->
                <div class="modal fade" id="selectProjectModal" tabindex="-1" role="dialog"
                    aria-labelledby="selectProjectModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="selectProjectModalLabel">Seleccionar Proyecto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="selectProjectForm">
                                    <div class="form-group">
                                        <label for="selectProyectoIntegrante">Seleccionar Proyecto</label>
                                        <select class="form-control" id="selectProyectoIntegrante" name="id_proyecto"
                                            required>
                                            <?php
                                            // Consulta para obtener proyectos con uno o más integrantes
                                            $queryProyectosConIntegrantes = "
                                    SELECT p.ID_Proyecto, p.Nombre_Proyecto 
                                    FROM proyecto p
                                    WHERE p.Integrante_1 IS NOT NULL OR p.Integrante_2 IS NOT NULL OR p.Integrante_3 IS NOT NULL";
                                            $resultProyectosIntegrantes = $connection->query($queryProyectosConIntegrantes);
                                            while ($rowProyectosIntegrantes = $resultProyectosIntegrantes->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($rowProyectosIntegrantes['ID_Proyecto']) . "'>"
                                                    . htmlspecialchars($rowProyectosIntegrantes['Nombre_Proyecto']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="nextBtn">Siguiente</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Segundo Modal: Desvincular integrante -->
                <div class="modal fade" id="unlinkIntegranteModal" tabindex="-1" role="dialog"
                    aria-labelledby="unlinkIntegranteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="unlinkIntegranteModalLabel">Desvincular Integrante</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="unlinkIntegrante.php" method="POST">
                                    <input type="hidden" id="selectedProjectId" name="id_proyecto">
                                    <div class="form-group">
                                        <label for="selectIntegrante">Seleccionar Integrante a Desvincular</label>
                                        <select class="form-control" id="selectIntegrante" name="integrante" required>
                                            <!-- Este select se llenará dinámicamente al seleccionar el proyecto -->
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-warning">Desvincular Integrante</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enlace para abrir el modal con los datos del proyecto -->
                <script>
                    // Escuchar el evento de clic en los botones "Editar"
                    document.querySelectorAll('.edit-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            // Obtener la fila en la que se hizo clic
                            var row = this.closest('tr');

                            // Obtener el ID del proyecto desde la columna correspondiente
                            var projectId = row.querySelector('.project-id').innerText;

                            // Obtener el nombre del proyecto desde la columna correspondiente
                            var projectName = row.cells[1].innerText;

                            // Establecer los valores en el modal
                            document.getElementById('editProjectId').value = projectId;
                            document.getElementById('editNombreProyecto').value = projectName;

                            // Mostrar el modal
                            $('#editProjectModal').modal('show');
                        });
                    });
                </script>

                <!-- Script para manejar la lógica de los modales de desvinculación -->
                <script>
                    document.getElementById('nextBtn').addEventListener('click', function () {
                        var idProyecto = document.getElementById('selectProyectoIntegrante').value;

                        // Establecer el ID del proyecto seleccionado en el segundo modal
                        document.getElementById('selectedProjectId').value = idProyecto;

                        // Hacer una petición AJAX para obtener los integrantes del proyecto seleccionado
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'getIntegrantes.php?id_proyecto=' + idProyecto, true);
                        xhr.onload = function () {
                            if (this.status === 200) {
                                var integrantes = JSON.parse(this.responseText);
                                var selectIntegrante = document.getElementById('selectIntegrante');
                                selectIntegrante.innerHTML = ''; // Limpiar el select antes de agregar nuevas opciones

                                // Agregar cada integrante como opción
                                for (var i = 0; i < integrantes.length; i++) {
                                    var option = document.createElement('option');
                                    option.value = integrantes[i].id;
                                    option.text = integrantes[i].nombre;
                                    selectIntegrante.appendChild(option);
                                }

                                // Ocultar el primer modal y mostrar el segundo modal
                                $('#selectProjectModal').modal('hide');
                                $('#unlinkIntegranteModal').modal('show');
                            }
                        };
                        xhr.send();
                    });
                </script>

                <!-- Scripts de Bootstrap -->
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>