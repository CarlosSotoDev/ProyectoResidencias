<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../public/login.php");
    exit;
}

// Verificar si el usuario tiene el rol adecuado (3 = Administrador)
if ($_SESSION['rol'] != 3) {
    echo "No tienes permiso para acceder a esta página.";
    exit;
}

include('../../includes/header.php');
?>

<div class="container mt-5">
    <h1>Bienvenido al Dashboard del Administrador</h1>
    <p>Aquí puedes administrar todo el sistema.</p>
    <!-- Agrega más contenido aquí -->
</div>

<?php
include('../../includes/footer.php');
?>

