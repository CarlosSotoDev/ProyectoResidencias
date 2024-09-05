<?php
include('../../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password'];
    $rol = $_POST['role'];

    // Encriptar la contraseña con SHA256 (usa el disparador en la BD)
    $sql = "INSERT INTO usuario (Nombre_Usuario, Contraseña, Rol) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $nombre_usuario, $contrasena, $rol);

    if ($stmt->execute()) {
        header("Location: dashboardAdmin.php?message=Usuario creado correctamente");
    } else {
        echo "Error al crear el usuario: " . $stmt->error;
    }

    $stmt->close();
}
?>
