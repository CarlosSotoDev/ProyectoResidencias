<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];

// Consulta para obtener el proyecto del alumno
$query = "SELECT p.ID_Proyecto, p.Nombre_Proyecto
          FROM proyecto p
          WHERE p.Integrante_1 = ? OR p.Integrante_2 = ? OR p.Integrante_3 = ? LIMIT 1";
$stmt = $connection->prepare($query);
$stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificamos si hay un proyecto asignado
if ($result && $result->num_rows > 0) {
    $proyecto = $result->fetch_assoc();
    $_SESSION['id_proyecto'] = $proyecto['ID_Proyecto']; // Guardamos el ID del proyecto en la sesión
    $nombre_proyecto = $proyecto['Nombre_Proyecto'];
} else {
    $_SESSION['id_proyecto'] = null; // No hay proyecto asignado
    $nombre_proyecto = "No hay proyecto asignado";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestion de Alumnos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css">
</head>
<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAlumno.php'); ?>

    <main role="main" class="container bg-light p-2 mx-auto my-1">
        <!-- Dashboard Bienvenida -->
        <?php require('../../includes/welcomeDashboard.php'); ?>

        <!-- Sección para mostrar proyecto -->
        
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
