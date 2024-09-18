<?php
include('../../includes/config.php');
checkLogin();

if (isset($_GET['id'])) {
    $id_alumno = mysqli_real_escape_string($connection, $_GET['id']);

    // Eliminar el alumno
    $query = "DELETE FROM alumno WHERE ID_Alumno = '$id_alumno'";

    if ($connection->query($query) === TRUE) {
        header("Location: dashboardAdminAlumnos.php?success=Alumno eliminado correctamente.");
    } else {
        echo "Error al eliminar el alumno: " . $connection->error;
    }
}
?>
