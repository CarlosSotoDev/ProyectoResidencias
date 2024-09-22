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
        header("Location: dashboardAdminAlumnos.php?error=El proyecto ya tiene 3 integrantes asignados.");
        exit();
    }

    // Iniciar una transacción para asegurarnos de que todo se inserte correctamente
    $connection->begin_transaction();

    try {
        // Verificar si el ID del alumno es menor que 300
        $resultLastID = $connection->query("SELECT MAX(ID_Alumno) AS last_id FROM alumno");
        $rowLastID = $resultLastID->fetch_assoc();
        $nextID = isset($rowLastID['last_id']) ? max($rowLastID['last_id'] + 1, 300) : 300;

        // Insertar el nuevo usuario en la tabla usuario, sin SHA2 ya que el trigger lo hará
        $queryInsertUsuario = "INSERT INTO usuario (ID_Usuario, Nombre_Usuario, Contraseña, Rol) VALUES (?, ?, ?, ?)";
        $stmtUsuario = $connection->prepare($queryInsertUsuario);
        $stmtUsuario->bind_param("issi", $nextID, $nombre_usuario, $contrasena, $rol);
        $stmtUsuario->execute();

        // Insertar el nuevo alumno en la tabla alumno, usando el ID_Usuario como ID_Alumno y asignando el rol
        $queryInsertAlumno = "INSERT INTO alumno (ID_Alumno, Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Proyecto, Asesor, ID_Usuario, Rol) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAlumno = $connection->prepare($queryInsertAlumno);
        $stmtAlumno->bind_param("isssiiiii", $nextID, $nombres, $apellido_paterno, $apellido_materno, $carrera, $proyecto, $asesor, $nextID, $rol);
        $stmtAlumno->execute();

        // Asignar al alumno como integrante en el proyecto
        if (empty($rowIntegrantes['Integrante_1'])) {
            $queryUpdateProyecto = "UPDATE proyecto SET Integrante_1 = ? WHERE ID_Proyecto = ?";
        } elseif (empty($rowIntegrantes['Integrante_2'])) {
            $queryUpdateProyecto = "UPDATE proyecto SET Integrante_2 = ? WHERE ID_Proyecto = ?";
        } else {
            $queryUpdateProyecto = "UPDATE proyecto SET Integrante_3 = ? WHERE ID_Proyecto = ?";
        }
        $stmtProyecto = $connection->prepare($queryUpdateProyecto);
        $stmtProyecto->bind_param("ii", $nextID, $proyecto);
        $stmtProyecto->execute();

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
    $stmtProyecto->close();
}
?>
