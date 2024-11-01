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
    <title>Proyectos - Jefe de Carrera</title>
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
                <h1 id="anteproyecto">Gestión de Proyectos</h1>

                <!-- Barra de búsqueda -->
                <form method="GET" class="form-inline mb-3">
                    <input class="form-control mr-sm-2" type="search" name="search"
                           placeholder="Buscar por ID, Nombre de proyecto, Status, Integrante, Asesor" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>

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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener el valor de búsqueda, si se proporcionó
                            $search = isset($_GET['search']) ? $_GET['search'] : '';

                            // Consulta para obtener todos los proyectos según la carrera del jefe
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
                                WHERE a.Carrera = ? AND (
                                      p.ID_Proyecto LIKE '%$search%' OR
                                      p.Nombre_Proyecto LIKE '%$search%' OR
                                      p.Status LIKE '%$search%' OR
                                      CONCAT(i1.Nombres, ' ', i1.Apellido_Paterno, ' ', i1.Apellido_Materno) LIKE '%$search%' OR
                                      CONCAT(i2.Nombres, ' ', i2.Apellido_Paterno, ' ', i2.Apellido_Materno) LIKE '%$search%' OR
                                      CONCAT(i3.Nombres, ' ', i3.Apellido_Paterno, ' ', i3.Apellido_Materno) LIKE '%$search%' OR
                                      CONCAT(a.Nombres, ' ', a.Apellido_Paterno, ' ', a.Apellido_Materno) LIKE '%$search%'
                                )
                                ORDER BY p.ID_Proyecto ASC";

                            $stmt = $connection->prepare($query);
                            $stmt->bind_param("s", $carrera_jefe);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Verificar si se encontraron proyectos
                            if ($result && $result->num_rows > 0) {
                                // Mostrar los proyectos filtrados
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='project-id'>" . htmlspecialchars($row['ID_Proyecto'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Nombre_Proyecto'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Status'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Integrante1'] ?? 'No asignado') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Integrante2'] ?? 'No asignado') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Integrante3'] ?? 'No asignado') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Nombre_Asesor'] ?? 'No asignado') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No existe ningún proyecto para esta carrera.</td></tr>";
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
