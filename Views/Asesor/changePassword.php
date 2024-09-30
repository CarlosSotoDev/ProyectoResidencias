<?php
// Ruta correcta al archivo config.php
include('../../includes/config.php');
checkLogin(); // Verificar si el usuario está autenticado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Asegúrate de que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $usuario_id = $_SESSION['user_id']; // ID del usuario desde la sesión
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar si la nueva contraseña y la confirmación coinciden
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Las nuevas contraseñas no coinciden.";
        header("Location: ../Asesor/dashboardAsesor.php");
        exit();
    }

    // Verificar la contraseña actual en la base de datos
    $query = "SELECT Contraseña FROM usuario WHERE ID_Usuario = ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        $_SESSION['error'] = "Error en la preparación de la consulta.";
        header("Location: ../Asesor/dashboardAsesor.php");
        exit();
    }
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password_db);
    $stmt->fetch();
    $stmt->close();

    // Hash de la contraseña actual ingresada por el usuario
    $hashed_input_password = hash('sha256', $current_password);

    // Verificar si la contraseña actual es correcta
    if ($hashed_input_password !== $hashed_password_db) {
        $_SESSION['error'] = "La contraseña actual es incorrecta.";
        header("Location: ../Asesor/dashboardAsesor.php");
        exit();
    }

    // Actualizar la contraseña en la base de datos
    // La contraseña se enviará en texto plano y el trigger se encargará de hashearla
    $update_query = "UPDATE usuario SET Contraseña = ? WHERE ID_Usuario = ?";
    $update_stmt = $connection->prepare($update_query);
    if (!$update_stmt) {
        $_SESSION['error'] = "Error en la preparación de la consulta de actualización.";
        header("Location: ../Asesor/dashboardAsesor.php");
        exit();
    }
    $update_stmt->bind_param("si", $new_password, $usuario_id);

    if ($update_stmt->execute()) {
        $_SESSION['success'] = "Contraseña actualizada con éxito.";
    } else {
        $_SESSION['error'] = "Hubo un error al actualizar la contraseña.";
    }
    $update_stmt->close();
    header("Location: ../Asesor/dashboardAsesor.php");
    exit();
}
?>