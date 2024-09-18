<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']);
    $proyecto = mysqli_real_escape_string($connection, $_POST['proyecto']);
    $asesor = mysqli_real_escape_string($connection, $_POST['asesor']);

    // Validar cuántos integrantes tiene el proyecto
    $queryIntegrantes = "SELECT Integrante_1, Integrante_2, Integrante_3 FROM proyecto WHERE ID_Proyecto = '$proyecto'";
    $resultIntegrantes = $connection->query($queryIntegrantes);
    $rowIntegrantes = $resultIntegrantes->fetch_assoc();

    // Validar si hay espacio para más integrantes
    if (!empty($rowIntegrantes['Integrante_1']) && !empty($rowIntegrantes['Integrante_2']) && !empty($rowIntegrantes['Integrante_3'])) {
        // Si los tres campos de Integrante están llenos, no se puede agregar más
        header("Location: dashboardAdminAlumnos.php?error=El proyecto ya tiene 3 integrantes asignados.");
        exit();
    }

    // Insertar el nuevo alumno
    $queryInsertAlumno = "INSERT INTO alumno (Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Proyecto, Asesor) 
                          VALUES ('$nombres', '$apellido_paterno', '$apellido_materno', '$carrera', '$proyecto', '$asesor')";

    if ($connection->query($queryInsertAlumno) === TRUE) {
        $id_alumno = $connection->insert_id; // Obtener el ID del nuevo alumno insertado

        // Asignar al alumno como integrante en el proyecto
        if (empty($rowIntegrantes['Integrante_1'])) {
            // Si Integrante_1 está vacío, asignar el alumno como Integrante_1
            $queryUpdateProyecto = "UPDATE proyecto SET Integrante_1 = '$id_alumno' WHERE ID_Proyecto = '$proyecto'";
        } elseif (empty($rowIntegrantes['Integrante_2'])) {
            // Si Integrante_2 está vacío, asignar el alumno como Integrante_2
            $queryUpdateProyecto = "UPDATE proyecto SET Integrante_2 = '$id_alumno' WHERE ID_Proyecto = '$proyecto'";
        } else {
            // Si Integrante_3 está vacío, asignar el alumno como Integrante_3
            $queryUpdateProyecto = "UPDATE proyecto SET Integrante_3 = '$id_alumno' WHERE ID_Proyecto = '$proyecto'";
        }

        // Ejecutar la actualización del proyecto
        if ($connection->query($queryUpdateProyecto) === TRUE) {
            header("Location: dashboardAdminAlumnos.php?success=Alumno agregado correctamente y asignado al proyecto.");
        } else {
            echo "Error al asignar el alumno al proyecto: " . $connection->error;
        }
    } else {
        echo "Error al agregar el alumno: " . $connection->error;
    }
}
?>
