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
                            $recordsPerPage = 8; // Limite de registros por página
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                            $offset = ($page - 1) * $recordsPerPage; // Desplazamiento para la consulta

                            // Obtener el valor de búsqueda, si existe
                            $search = isset($_GET['search']) ? mysqli_real_escape_string($connection, $_GET['search']) : '';

                            // Consulta para contar el total de registros para la paginación
                            $totalQuery = "
                                SELECT COUNT(*) as total
                                FROM administrador
                                LEFT JOIN carrera ON administrador.Carrera = carrera.ID_Carrera
                                LEFT JOIN usuario ON administrador.ID_Usuario = usuario.ID_Usuario
                                WHERE administrador.Rol = 5";
                            
                            // Añadir la lógica de búsqueda a la consulta de conteo
                            if ($search) {
                                $totalQuery .= " AND (
                                    administrador.ID_Administrador LIKE '%$search%' OR 
                                    administrador.Nombres LIKE '%$search%' OR 
                                    administrador.Apellido_Paterno LIKE '%$search%' OR 
                                    administrador.Apellido_Materno LIKE '%$search%' OR 
                                    carrera.Nombre_Carrera LIKE '%$search%' OR 
                                    usuario.Nombre_Usuario LIKE '%$search%'
                                )";
                            }
                            $totalResult = $connection->query($totalQuery);
                            $totalRows = $totalResult->fetch_assoc()['total'];
                            $totalPages = ceil($totalRows / $recordsPerPage);

                            // Consulta para obtener los jefes de carrera con paginación
                            $query = "
                                SELECT administrador.ID_Administrador, administrador.Nombres, administrador.Apellido_Paterno, administrador.Apellido_Materno, 
                                       carrera.Nombre_Carrera, usuario.Nombre_Usuario
                                FROM administrador
                                LEFT JOIN carrera ON administrador.Carrera = carrera.ID_Carrera
                                LEFT JOIN usuario ON administrador.ID_Usuario = usuario.ID_Usuario
                                WHERE administrador.Rol = 5";
                            
                            // Añadir la lógica de búsqueda a la consulta principal
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

                            $query .= " ORDER BY administrador.ID_Administrador ASC LIMIT $recordsPerPage OFFSET $offset";
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

                <!-- Modales y scripts adicionales -->
                <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
            </div>
        </div>
    </div>
</body>
</html>
