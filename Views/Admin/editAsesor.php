<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']); // Carrera seleccionada
    $rol = mysqli_real_escape_string($connection, $_POST['rol']);
    $id_usuario = mysqli_real_escape_string($connection, $_POST['id_usuario']);
    $proyecto_asignado = mysqli_real_escape_string($connection, $_POST['proyecto_asignado']);

    // Insertar el nuevo asesor en la tabla asesor
    $insert_asesor = "INSERT INTO asesor (Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Rol, ID_Usuario) 
                      VALUES ('$nombres', '$apellido_paterno', '$apellido_materno', '$carrera', '$rol', '$id_usuario')";
    
    if ($connection->query($insert_asesor) === TRUE) {
        $id_asesor = $connection->insert_id; // Obtener el ID del asesor recién agregado

        // Actualizar la tabla proyecto para asignar el asesor al proyecto
        $update_proyecto = "UPDATE proyecto SET Asesor = '$id_asesor' WHERE ID_Proyecto = '$proyecto_asignado'";
        if ($connection->query($update_proyecto) === TRUE) {
            // Redirigir al dashboard si la inserción y actualización fueron exitosas
            header("Location: dashboardAdminAsesor.php?success=1");
            exit();
        } else {
            echo "Error al actualizar el proyecto: " . $connection->error;
        }
    } else {
        echo "Error al agregar el asesor: " . $connection->error;
    }
}

$connection->close();
?>
