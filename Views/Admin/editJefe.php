<?php
include('../../includes/config.php');
checkLogin();

// Comprobamos que se han enviado los datos necesarios
if (isset($_POST['id_jefe'], $_POST['nombres'], $_POST['apellido_paterno'], $_POST['apellido_materno'], $_POST['carrera'], $_POST['username'])) {

    // Escapar los valores recibidos para prevenir inyección SQL
    $id_jefe = mysqli_real_escape_string($connection, $_POST['id_jefe']);
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = isset($_POST['password']) && !empty($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;

    // Actualizamos los datos del jefe en la tabla administrador
    $query = "
        UPDATE administrador 
        SET Nombres = '$nombres', Apellido_Paterno = '$apellido_paterno', Apellido_Materno = '$apellido_materno', Carrera = '$carrera'
        WHERE ID_Administrador = '$id_jefe'
    ";

    if ($connection->query($query) === TRUE) {
        // Actualizamos el usuario si se han cambiado los datos
        $userQuery = "UPDATE usuario SET Nombre_Usuario = '$username'";

        // Solo actualizar la contraseña si se ha enviado
        if ($password) {
            // No encriptamos la contraseña, solo la actualizamos tal como se recibe
            $userQuery .= ", Contraseña = '$password'";
        }

        $userQuery .= " WHERE ID_Usuario = (SELECT ID_Usuario FROM administrador WHERE ID_Administrador = '$id_jefe')";

        // Ejecutar la consulta de actualización del usuario
        if ($connection->query($userQuery) === TRUE) {
            header('Location: dashboardAdminJefes.php?success=1');
        } else {
            echo "Error al actualizar el usuario: " . $connection->error;
        }
    } else {
        echo "Error al actualizar los datos del jefe de carrera: " . $connection->error;
    }
} else {
    echo "Faltan datos obligatorios para realizar la actualización.";
}
?>
