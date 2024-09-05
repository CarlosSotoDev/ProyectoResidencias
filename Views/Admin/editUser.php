<?php
include('../../includes/config.php');

if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['role'])) {
    $id = $_POST['id'];
    $nombre_usuario = $_POST['username'];
    $rol = $_POST['role'];

    // Si se proporciona una nueva contraseña, se actualiza con encriptación (usando el trigger de la base de datos).
    if (!empty($_POST['password'])) {
        $contrasena = $_POST['password'];
        $sql = "UPDATE usuario SET Nombre_Usuario = ?, Contraseña = ?, Rol = ? WHERE ID_Usuario = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssii", $nombre_usuario, $contrasena, $rol, $id);
    } else {
        // Si no se cambia la contraseña, solo se actualiza el nombre y el rol.
        $sql = "UPDATE usuario SET Nombre_Usuario = ?, Rol = ? WHERE ID_Usuario = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sii", $nombre_usuario, $rol, $id);
    }

    if ($stmt->execute()) {
        header("Location: dashboardAdmin.php?message=Usuario actualizado correctamente");
    } else {
        echo "Error al actualizar el usuario: " . $stmt->error;
    }

    $stmt->close();
}
?>
