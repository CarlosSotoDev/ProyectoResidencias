<?php
include('../../includes/config.php');

if (isset($_GET['proyecto_id'])) {
    $proyecto_id = mysqli_real_escape_string($connection, $_GET['proyecto_id']);

    // Consulta para obtener el asesor del proyecto
    $query = "SELECT CONCAT(asesor.Nombres, ' ', asesor.Apellido_Paterno, ' ', asesor.Apellido_Materno) AS Nombre_Asesor
              FROM proyecto
              LEFT JOIN asesor ON proyecto.Asesor = asesor.ID_Asesor
              WHERE proyecto.ID_Proyecto = '$proyecto_id'";
    
    $result = $connection->query($query);
    
    if ($row = $result->fetch_assoc()) {
        echo $row['Nombre_Asesor'] ?? 'No asignado';
    } else {
        echo 'No asignado';
    }
}
?>
