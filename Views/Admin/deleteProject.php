<?php
include('../../includes/config.php');
checkLogin();

if (isset($_GET['id'])) {
    $id_proyecto = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "DELETE FROM proyecto WHERE ID_Proyecto = '$id_proyecto'";

    if ($connection->query($query) === TRUE) {
        header("Location: dashboardAdminProyectos.php?success=3");
    } else {
        echo "Error: " . $connection->error;
    }
}

$connection->close();
