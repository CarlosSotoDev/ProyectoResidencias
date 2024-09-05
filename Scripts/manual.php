<?php
include('C:/wamp64/www/ProyectoResidencias/includes/config.php');

$id_usuario = 1; // El ID del usuario que deseas actualizar
$nueva_contraseña = '123';
$nueva_contraseña_encriptada = password_hash($nueva_contraseña, PASSWORD_BCRYPT);

$sql = "UPDATE usuario SET Contraseña = ? WHERE ID_Usuario = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("si", $nueva_contraseña_encriptada, $id_usuario);
$stmt->execute();

echo "Contraseña actualizada correctamente para el usuario con ID: $id_usuario";
?>
