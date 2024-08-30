<?php
session_start();
session_unset();
session_destroy();

// Desactivar el caché del navegador
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');

// Redirigir a la página de login
header('Location: ../public/login.php');
exit;
?>
