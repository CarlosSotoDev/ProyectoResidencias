<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] != 3) {
    header('Location: ../public/login.php');
    exit;
}

// Desactivar el caché del navegador
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');

// Aquí continúa el resto de tu código para la página protegida
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido al Dashboard del Administrador</h1>
        <p>Usuario: <?php echo $_SESSION['username']; ?></p>

        <!-- Botón para cerrar sesión -->
        <a href="../public/logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
