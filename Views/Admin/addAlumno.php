<?php
include('../../includes/config.php');
checkLogin();

// Mostrar errores en caso de que algo falle
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']);
    $proyecto = mysqli_real_escape_string($connection, $_POST['proyecto']);
    $asesor = mysqli_real_escape_string($connection, $_POST['asesor']);

    // Datos para el usuario
    $nombre_usuario = mysqli_real_escape_string($connection, $_POST['username']);
    $contrasena = mysqli_real_escape_string($connection, $_POST['password']);
    $rol = 1; // Rol de alumno

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

    // Iniciar una transacción para asegurarnos de que todo se inserte correctamente
    $connection->begin_transaction();

    try {
        // Insertar el nuevo usuario en la tabla usuario, sin SHA2 ya que el trigger lo hará
        $queryInsertUsuario = "INSERT INTO usuario (Nombre_Usuario, Contraseña, Rol) VALUES (?, ?, ?)";
        $stmtUsuario = $connection->prepare($queryInsertUsuario);
        $stmtUsuario->bind_param("ssi", $nombre_usuario, $contrasena, $rol);
        $stmtUsuario->execute();
        $id_usuario = $connection->insert_id; // Obtener el ID del nuevo usuario insertado

        // Usar el ID del usuario como ID del alumno
        $id_alumno = $id_usuario;

        // Insertar el nuevo alumno en la tabla alumno, usando el ID_Usuario como ID_Alumno
        $queryInsertAlumno = "INSERT INTO alumno (ID_Alumno, Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Proyecto, Asesor, ID_Usuario) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAlumno = $connection->prepare($queryInsertAlumno);
        $stmtAlumno->bind_param("isssiiii", $id_alumno, $nombres, $apellido_paterno, $apellido_materno, $carrera, $proyecto, $asesor, $id_usuario);
        $stmtAlumno->execute();

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
        $connection->query($queryUpdateProyecto);

        // Confirmar la transacción
        $connection->commit();

        // Redirigir con mensaje de éxito
        header("Location: dashboardAdminAlumnos.php?success=Alumno agregado correctamente y asignado al proyecto.");

    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $connection->rollback();
        echo "Error al agregar el alumno: " . $e->getMessage();
    }

    // Cerrar las declaraciones
    $stmtUsuario->close();
    $stmtAlumno->close();
}
?>
