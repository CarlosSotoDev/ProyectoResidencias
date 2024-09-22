<?php
include('../../includes/config.php');
checkLogin();

// Verificar si el ID del asesor está en la sesión
if (isset($_SESSION['asesor_id'])) {
    echo "<div class='alert alert-success'>ID del Asesor en la sesión: " . $_SESSION['asesor_id'] . "</div>";
} else {
    echo "<div class='alert alert-danger'>No se encontró el ID del asesor en la sesión.</div>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Asesor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>

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
