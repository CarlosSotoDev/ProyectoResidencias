<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_proyecto = mysqli_real_escape_string($connection, $_POST['nombre_proyecto']);
    $status = 'Pendiente'; // El status por defecto

    $query = "INSERT INTO proyecto (Nombre_Proyecto, Status) VALUES ('$nombre_proyecto', '$status')";

    if ($connection->query($query) === TRUE) {
        header("Location: dashboardAdminProyectos.php?success=1");
    } else {
        echo "Error: " . $connection->error;
    }
}

$connection->close();
