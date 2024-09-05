<?php
// Evitar redeclaración de funciones como redirect si ya existen
if (!function_exists('redirect')) {
    // Redireccionar a una URL
    function redirect($url) {
        header("Location: $url");
        exit;
    }
}

// Otras funciones aquí...

// Función para obtener el nombre del rol en función del ID del rol
function getRoleName($roleId) {
    switch ($roleId) {
        case 1:
            return 'Alumno';
        case 2:
            return 'Asesor';
        case 3:
            return 'Administrador';
        case 4:
            return 'Inactivo';
        default:
            return 'Desconocido';
    }
}
?>
