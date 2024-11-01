<?php
include('../../includes/config.php');
checkLogin(); // Verifica si el usuario está autenticado

// Obtener el ID del usuario (jefe de carrera) desde la sesión o URL
if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id']; // Capturar el ID de usuario desde la URL
} else {
    $usuario_id = $_SESSION['user_id']; // Usar el ID del usuario desde la sesión si es necesario
}

// Consulta para obtener información relevante para el jefe de carrera
$query = "SELECT j.ID_Administrador, j.Nombres, j.Apellido_Paterno, j.Apellido_Materno, c.Nombre_Carrera
          FROM administrador j
          LEFT JOIN carrera c ON j.Carrera = c.ID_Carrera
          WHERE j.ID_Administrador = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificamos si se obtuvo la información del jefe
if ($result && $result->num_rows > 0) {
    $jefe = $result->fetch_assoc();
    $nombre_completo = $jefe['Nombres'] . ' ' . $jefe['Apellido_Paterno'] . ' ' . $jefe['Apellido_Materno'];
} else {
    $nombre_completo = "Jefe de carrera no encontrado";
}

// Mensajes de éxito o error al cambiar la contraseña
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Jefe de Carrera</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>docs.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarJefe.php'); ?> <!-- Barra de navegación específica para el jefe -->
    
    <main role="main" class="container bg-white p-2 mx-auto my-5 text-center">
        <!-- Bienvenida -->
        <h2 class="text-center">Bienvenido, <?php echo htmlspecialchars($nombre_completo); ?></h2>
        <p class="mt-3">Estamos aquí para ayudarte a gestionar tu carrera de forma eficiente.</p>

        <!-- Botón Ver Más -->
        <a href="dashboardJefeProyectos.php" class="btn btn-primary mt-4">Ver más</a>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
