<?php
include('../../includes/config.php');
checkLogin();

if (isset($_GET['id'])) {
    $id_asesor = mysqli_real_escape_string($connection, $_GET['id']);

    // Eliminar el asesor de la base de datos
    $query = "DELETE FROM asesor WHERE ID_Asesor = '$id_asesor'";

    if ($connection->query($query) === TRUE) {
        // Redirigir al dashboard si la eliminación fue exitosa
        header("Location: dashboardAdminAsesor.php?success=3");
        exit();
    } else {
        // Mostrar error si algo salió mal
        echo "Error al eliminar el asesor: " . $connection->error;
    }
}

$connection->close();
?>
