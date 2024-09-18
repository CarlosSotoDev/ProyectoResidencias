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
    $proyecto = mysqli_real_escape_string($connection, $_POST['proyecto']);
    $asesor = mysqli_real_escape_string($connection, $_POST['asesor']);

    // Actualizar los datos del alumno
    $query = "UPDATE alumno SET 
                Nombres = '$nombres',
                Apellido_Paterno = '$apellido_paterno',
                Apellido_Materno = '$apellido_materno',
                Carrera = '$carrera',
                Proyecto = '$proyecto',
                Asesor = '$asesor'
              WHERE ID_Alumno = '$id_alumno'";

    if ($connection->query($query) === TRUE) {
        header("Location: dashboardAdminAlumnos.php?success=Alumno actualizado correctamente.");
    } else {
        echo "Error al actualizar el alumno: " . $connection->error;
    }
}
?>
