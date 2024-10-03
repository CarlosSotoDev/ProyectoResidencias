<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_alumno = mysqli_real_escape_string($connection, $_POST['id_alumno']);
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = !empty($_POST['password']) ? mysqli_real_escape_string($connection, $_POST['password']) : null;

    // Actualizar los datos del alumno
    $query = "UPDATE alumno SET 
                Nombres = '$nombres',
                Apellido_Paterno = '$apellido_paterno',
                Apellido_Materno = '$apellido_materno',
                Carrera = '$carrera'
              WHERE ID_Alumno = '$id_alumno'";

    if ($connection->query($query) === TRUE) {
        // Actualizar el usuario
        $userQuery = "UPDATE usuario SET Nombre_Usuario = '$username'";
        if ($password) {
            $hashedPassword = hash('sha256', $password); // Encriptar la contraseña
            $userQuery .= ", Contraseña = '$hashedPassword'";
        }
        $userQuery .= " WHERE ID_Usuario = (SELECT ID_Usuario FROM alumno WHERE ID_Alumno = '$id_alumno')";
        
        if ($connection->query($userQuery) === TRUE) {
            header("Location: dashboardAdminAlumnos.php?success=Alumno actualizado correctamente.");
        } else {
            echo "Error al actualizar el usuario: " . $connection->error;
        }
    } else {
        echo "Error al actualizar el alumno: " . $connection->error;
    }
}
?>
