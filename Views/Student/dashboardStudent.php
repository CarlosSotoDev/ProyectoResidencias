<?php
include('../../includes/config.php');
checkLogin();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestion de Alumnos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Navbar -->
    <?php
    require('../../includes/navbarAlumno.php');
    ?>

    <main role="main" class="container bg-light p-2 mx-auto my-1">
        <!-- DashboardBienvenida -->
        <?php require('../../includes/welcomeDashboard.php'); ?>


    </main>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>