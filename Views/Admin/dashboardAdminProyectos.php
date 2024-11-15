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

                <!-- Botones de acciones -->
                <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addProjectModal">Agregar Proyecto</button>
                <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#unlinkModal">Desvincular Asesor</button>
                <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#selectProjectModal">Desvincular Integrante</button>

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
                            $recordsPerPage = 7; // Limite de registros por página
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                            $offset = ($page - 1) * $recordsPerPage; // Desplazamiento para la consulta

                            // Obtener el valor de búsqueda, si se proporcionó
                            $search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

                            // Consulta para contar el total de registros (necesario para la paginación)
                            $totalQuery = "
                                SELECT COUNT(*) as total
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
                                   OR CONCAT(a.Nombres, ' ', a.Apellido_Paterno, ' ', a.Apellido_Materno) LIKE '%$search%'";
                            
                            $totalResult = $connection->query($totalQuery);
                            $totalRows = $totalResult->fetch_assoc()['total'];
                            $totalPages = ceil($totalRows / $recordsPerPage);

                            // Consulta para obtener los proyectos con paginación
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
                                ORDER BY p.ID_Proyecto ASC
                                LIMIT $recordsPerPage OFFSET $offset";
                            
                            $result = $connection->query($query);

                            // Mostrar los campos de la tabla
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='project-id'>" . htmlspecialchars($row['ID_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Proyecto'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Integrante1'] ?? 'No asignado') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Integrante2'] ?? 'No asignado') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Integrante3'] ?? 'No asignado') . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Asesor'] ?? 'No asignado') . "</td>";
                                echo "<td><button type='button' class='btn btn-primary btn-sm edit-btn'>Editar</button></td>";
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

                <!-- Modales y scripts de Bootstrap -->
                <!-- Resto de tu código -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
