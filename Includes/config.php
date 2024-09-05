<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sistema_residencias');

// Establecer conexión a la base de datos
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Verificar conexión
if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configuración de URL base
define('BASE_URL', 'http://localhost/ProyectoResidencias/');

// Definir rutas de recursos
define('CSS_PATH', BASE_URL . 'assets/css/');
define('JS_PATH', BASE_URL . 'assets/js/');
define('IMG_PATH', BASE_URL . 'assets/img/');

// Mostrar errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Función para verificar si el usuario está autenticado y activo
function checkLogin() {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header('Location: ../public/login.php');
        exit;
    }

    // Verificar si el usuario tiene el rol 4 (Inactivo)
    if ($_SESSION['rol'] == 4) {
        session_destroy();
        header('Location: ../public/login.php?error=disabled');
        exit;
    }
}

// Incluir funciones comunes
include_once(__DIR__ . '/functions.php'); // Usar include_once para evitar múltiples inclusiones
?>
