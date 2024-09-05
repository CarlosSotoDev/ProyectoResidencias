<?php
include('../../includes/config.php');

// Verificar si se ha pasado el ID del usuario
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los datos del usuario
    $sql = "SELECT ID_Usuario, Nombre_Usuario, Rol FROM usuario WHERE ID_Usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Enviar los datos del usuario en formato JSON
    echo json_encode($user);
}
?>
