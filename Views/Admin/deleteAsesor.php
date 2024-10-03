<?php
include('../../includes/config.php');
checkLogin();

// Verificar si los datos obligatorios están presentes y no están vacíos
if (isset($_POST['id_asesor'], $_POST['nombres'], $_POST['apellido_paterno'], $_POST['apellido_materno'], $_POST['carrera'], $_POST['proyecto'], $_POST['username'], $_POST['password'])) {

    // Escapar valores para prevenir inyección SQL
    $id_asesor = mysqli_real_escape_string($connection, $_POST['id_asesor']);
    $nombres = mysqli_real_escape_string($connection, $_POST['nombres']);
    $apellido_paterno = mysqli_real_escape_string($connection, $_POST['apellido_paterno']);
    $apellido_materno = mysqli_real_escape_string($connection, $_POST['apellido_materno']);
    $carrera = mysqli_real_escape_string($connection, $_POST['carrera']);
    $proyecto_asignado = mysqli_real_escape_string($connection, $_POST['proyecto']);
    $previous_proyecto = mysqli_real_escape_string($connection, $_POST['previous_proyecto'] ?? ''); // Proyecto previamente asignado, opcional
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Verificar si se ha enviado el campo "rol" e "id_usuario" antes de utilizarlos, y si no están presentes, asignar valores por defecto
    $rol = isset($_POST['rol']) ? mysqli_real_escape_string($connection, $_POST['rol']) : null;
    $id_usuario = isset($_POST['id_usuario']) ? mysqli_real_escape_string($connection, $_POST['id_usuario']) : null;

    // Iniciar transacción
    $connection->begin_transaction();

    try {
        // Actualizar los datos del asesor
        $sql = "UPDATE asesor 
                SET Nombres = ?, Apellido_Paterno = ?, Apellido_Materno = ?, Carrera = ?, Proyecto_Asignado = ? 
                WHERE ID_Asesor = ?";

        $stmt = $connection->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssisi", $nombres, $apellido_paterno, $apellido_materno, $carrera, $proyecto_asignado, $id_asesor);
            $stmt->execute();
            $stmt->close();
        }

        // Actualizar el proyecto anterior para liberar al asesor si es necesario
        if (!empty($previous_proyecto)) {
            $sql_update_previous_project = "UPDATE proyecto SET Asesor = NULL WHERE ID_Proyecto = ?";
            $stmt_previous = $connection->prepare($sql_update_previous_project);
            if ($stmt_previous) {
                $stmt_previous->bind_param("i", $previous_proyecto);
                $stmt_previous->execute();
                $stmt_previous->close();
            }
        }

        // Actualizar los datos del usuario si hay un ID de usuario
        if ($id_usuario) {
            $sql_user = "UPDATE usuario SET Nombre_Usuario = ?, Contraseña = ? WHERE ID_Usuario = ?";
            $stmt_user = $connection->prepare($sql_user);
            if ($stmt_user) {
                // Encriptar la contraseña antes de guardarla
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt_user->bind_param("ssi", $username, $hashed_password, $id_usuario);
                $stmt_user->execute();
                $stmt_user->close();
            }
        }

        // Confirmar la transacción
        $connection->commit();

        // Redirigir con éxito
        header("Location: dashboardAdminAsesor.php?success=1");
        exit();

    } catch (Exception $e) {
        // Si ocurre un error, hacer rollback de la transacción
        $connection->rollback();
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Error: Datos incompletos para la actualización.";
}

$connection->close();
?>
