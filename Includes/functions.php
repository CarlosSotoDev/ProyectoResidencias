<?php

// Función para redirigir a una página específica
function redirect($url) {
    header("Location: $url");
    exit;
}

// Función para sanitizar entradas
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

?>
