<?php
include('../../includes/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // En lugar de eliminar el usuario, lo marcamos como inactivo
    $sql = "UPDATE usuario SET Rol = 4 WHERE ID_Usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: dashboardAdmin.php?message=Usuario desactivado correctamente");
    } else {
        echo "Error al desactivar el usuario: " . $stmt->error;
    }

    $stmt->close();
}
?>
