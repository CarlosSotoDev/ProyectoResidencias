<?php
include('../../includes/config.php');
checkLogin();

// Verificar si el ID_Asesor ya está almacenado en la sesión
if (!isset($_SESSION['asesor_id'])) {
    // Consulta para obtener el ID_Asesor basado en el ID_Usuario
    $query = "SELECT ID_Asesor FROM asesor WHERE ID_Usuario = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($asesor_id);
    $stmt->fetch();
    $stmt->close();

    // Guardar el ID_Asesor en la sesión si se encontró
    if ($asesor_id) {
        $_SESSION['asesor_id'] = $asesor_id;
        echo "<script>console.log('ID del Asesor almacenado en la sesión: " . $_SESSION['asesor_id'] . "');</script>";
    } else {
        echo "<script>console.log('Error: No se encontró el ID del asesor en la base de datos.');</script>";
    }
} else {
    echo "<script>console.log('ID del Asesor en sesión: " . $_SESSION['asesor_id'] . "');</script>";
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
    <title>Dashboard Asesor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>

    <!-- Modal Cambio Contraseña -->
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <main role="main" class="container bg-light p-2 mx-auto my-1">
        <!-- Dashboard Bienvenida -->
        <?php require('../../includes/welcomeDashboard.php'); ?>
    </main>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
