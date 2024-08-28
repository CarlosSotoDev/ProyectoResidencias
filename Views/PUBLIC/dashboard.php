<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Usuario</title>
</head>
<body>
    <h1>Bienvenido al Dashboard del Usuario</h1>
    <p>Usuario: <?php echo $_SESSION['username']; ?></p>
    <!-- Contenido del dashboard para otros usuarios -->
</body>
</html>
