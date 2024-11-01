<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];

// Consulta para obtener la carrera del jefe de carrera desde la tabla "administrador"
$queryCarrera = "SELECT Carrera FROM administrador WHERE ID_Usuario = ? AND Rol = 5";
$stmtCarrera = $connection->prepare($queryCarrera);
$stmtCarrera->bind_param("i", $usuario_id);
$stmtCarrera->execute();
$resultCarrera = $stmtCarrera->get_result();

if ($resultCarrera && $resultCarrera->num_rows > 0) {
    $rowCarrera = $resultCarrera->fetch_assoc();
    $carrera_jefe = $rowCarrera['Carrera'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesores - Jefe de Carrera</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>docs.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarJefe.php'); ?>

    <div class="container-fluid page-dashboard bg-white">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-2 sidebar bg-success d-flex flex-column align-items-center p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardJefe.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardJefeAsesor.php">Asesores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardJefeAlumno.php">Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="dashboardJefeProyectos.php">Proyectos</a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1>Gestión de Asesores</h1>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                           placeholder="Buscar por nombre, apellidos o usuario" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>ID Asesor</th>
                                <th>Nombres</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Carrera</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener el valor de búsqueda, si se proporcionó
                            $search = isset($_GET['search']) ? $_GET['search'] : '';

                            // Consulta para obtener asesores filtrados por la carrera del jefe de carrera
                            $query = "
                                SELECT a.ID_Asesor, a.Nombres, a.Apellido_Paterno, a.Apellido_Materno, c.Nombre_Carrera, u.Nombre_Usuario
                                FROM asesor a
                                LEFT JOIN carrera c ON a.Carrera = c.ID_Carrera
                                LEFT JOIN usuario u ON a.ID_Usuario = u.ID_Usuario
                                WHERE a.Carrera = ? AND (
                                      a.Nombres LIKE '%$search%' OR
                                      a.Apellido_Paterno LIKE '%$search%' OR
                                      a.Apellido_Materno LIKE '%$search%' OR
                                      u.Nombre_Usuario LIKE '%$search%'
                                )
                                ORDER BY a.ID_Asesor ASC";

                            $stmt = $connection->prepare($query);
                            $stmt->bind_param("s", $carrera_jefe);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Verificar si se encontraron asesores
                            if ($result && $result->num_rows > 0) {
                                // Mostrar los asesores filtrados
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ID_Asesor']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Nombres']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Apellido_Paterno']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Apellido_Materno']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Nombre_Carrera']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Nombre_Usuario']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No existe ningún asesor para esta carrera.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
} else {
    echo "No se pudo encontrar la carrera del jefe de carrera.";
}
?>
