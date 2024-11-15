<?php
include('../../includes/config.php');

if (isset($_GET['id_notificacion']) && isset($_GET['id_proyecto'])) {
    $id_notificacion = $_GET['id_notificacion'];
    $id_proyecto = $_GET['id_proyecto'];

    // Marcar la notificación como leída
    $query = "UPDATE notificaciones SET Leida = 1 WHERE ID_Notificacion = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id_notificacion);
    $stmt->execute();

    // Almacenar el ID del proyecto en la sesión y verificar
    $_SESSION['id_proyecto'] = $id_proyecto;
    if (!isset($_SESSION['id_proyecto'])) {
        echo "Error: el ID del proyecto no se almacenó en la sesión.";
        exit();
    }

    // Redirigir al historial de revisiones del proyecto
    header("Location: ../Student/historyRevitions.php?id_proyecto=" . $id_proyecto);
    exit();
} else {
    echo "ID de notificación o de proyecto no válido.";
}
?>
