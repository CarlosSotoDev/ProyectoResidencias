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
                <h1 id="anteproyecto">Gestion de Usuarios</h1>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                        placeholder="Buscar por nombre o rol" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre de Usuario</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Verifica si se ha enviado una búsqueda
                            $searchQuery = "";
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = mysqli_real_escape_string($connection, $_GET['search']);
                                $searchQuery = "AND (Nombre_Usuario LIKE '%$search%' OR Rol LIKE '%$search%')";
                            }

                            // Consulta con orden ascendente por ID_Usuario
                            $query = "SELECT ID_Usuario, Nombre_Usuario, Rol FROM usuario WHERE Rol != 4 $searchQuery ORDER BY ID_Usuario ASC";
                            $result = $connection->query($query);

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID_Usuario']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Nombre_Usuario']) . "</td>";
                                echo "<td>" . htmlspecialchars(getRoleName($row['Rol'])) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Scripts de Bootstrap -->
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>