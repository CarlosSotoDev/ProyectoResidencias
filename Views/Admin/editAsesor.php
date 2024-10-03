<?php
include('../../includes/config.php');
checkLogin();

// Comprobamos que se han enviado los datos necesarios
if (isset($_POST['id_asesor'], $_POST['nombres'], $_POST['apellido_paterno'], $_POST['apellido_materno'], $_POST['carrera'], $_POST['username'])) {

    // Escapar los valores recibidos para prevenir inyección SQL
    $id_asesor = mysqli_real_escape_string($connection, $_POST['id_asesor']);
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = isset($_POST['password']) && !empty($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;

    // Actualizamos el asesor con los nuevos datos
    $query = "
        UPDATE asesor 
        SET Nombres = '$nombres', Apellido_Paterno = '$apellido_paterno', Apellido_Materno = '$apellido_materno', Carrera = '$carrera'
        WHERE ID_Asesor = '$id_asesor'
    ";

    if ($connection->query($query) === TRUE) {
        // Actualizamos el usuario si se han cambiado los datos
        $userQuery = "UPDATE usuario SET Nombre_Usuario = '$username'";

        // Solo actualizar la contraseña si se ha enviado
        if ($password) {
            $hashedPassword = hash('sha256', $password); // Encriptar contraseña
            $userQuery .= ", Contraseña = '$hashedPassword'";
        }

        $userQuery .= " WHERE ID_Usuario = (SELECT ID_Usuario FROM asesor WHERE ID_Asesor = '$id_asesor')";

        // Ejecutar la consulta de actualización del usuario
        $connection->query($userQuery);

        header('Location: dashboardAdminAsesor.php?success=1');
    } else {
        echo "Error al actualizar el asesor: " . $connection->error;
    }

} else {
    echo "Faltan datos obligatorios para realizar la actualización.";
}
?>
