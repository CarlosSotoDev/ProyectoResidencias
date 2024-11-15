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
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardAdminJefes.php">Jefes de Carrera</a>
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
                            $recordsPerPage = 7; // Limite de registros por página
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                            $offset = ($page - 1) * $recordsPerPage; // Desplazamiento para la consulta

                            // Verifica si se ha enviado una búsqueda
                            $searchQuery = "";
                            $search = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connection, $_GET['search']);
                                $searchQuery = "AND (alumno.Nombres LIKE '%$search%' OR alumno.Apellido_Paterno LIKE '%$search%' OR alumno.Apellido_Materno LIKE '%$search%' OR alumno.ID_Alumno LIKE '%$search%' OR asesor.Nombres LIKE '%$search%' OR proyecto.Nombre_Proyecto LIKE '%$search%')";
                            }

                            // Consulta para contar el total de registros para la paginación
                            $totalQuery = "
                                SELECT COUNT(*) as total
                                FROM alumno 
                                LEFT JOIN proyecto ON alumno.Proyecto = proyecto.ID_Proyecto 
                                LEFT JOIN asesor ON alumno.Asesor = asesor.ID_Asesor 
                                LEFT JOIN carrera ON alumno.Carrera = carrera.ID_Carrera
                                LEFT JOIN usuario ON alumno.ID_Usuario = usuario.ID_Usuario
                                WHERE 1=1 $searchQuery";
                            $totalResult = $connection->query($totalQuery);
                            $totalRows = $totalResult->fetch_assoc()['total'];
                            $totalPages = ceil($totalRows / $recordsPerPage);

                            // Consulta para obtener los alumnos con paginación
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
                                ORDER BY alumno.ID_Alumno ASC
                                LIMIT $recordsPerPage OFFSET $offset";
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

                <!-- Paginación -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page - 1; ?>&search=<?= htmlspecialchars($search); ?>">Anterior</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>&search=<?= htmlspecialchars($search); ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page + 1; ?>&search=<?= htmlspecialchars($search); ?>">Siguiente</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <!-- Resto de tu código de modales y scripts adicionales -->
                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            </div>
        </div>
    </div>
</body>

</html>
