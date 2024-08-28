<?php
include('includes/config.php');  // Asegúrate de que la ruta a config.php sea correcta.

$nombre_usuario = 'admin';  // Cambia 'admin' por el usuario real
$nueva_contrasena = 'admin';  // La nueva contraseña en texto plano

// Crear un hash de la nueva contraseña
$hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);

// Actualizar la contraseña en la base de datos
$sql = "UPDATE usuario SET Contraseña = ? WHERE Nombre_Usuario = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ss", $hash, $nombre_usuario);

if ($stmt->execute()) {
    echo "Contraseña actualizada correctamente.";
} else {
    echo "Error al actualizar la contraseña.";
}
?>
