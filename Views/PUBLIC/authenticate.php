<?php
include('../../includes/config.php');  // Asegúrate de que la ruta a config.php sea correcta.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT ID_Usuario, Nombre_Usuario, Contraseña, Rol FROM usuario WHERE Nombre_Usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña usando password_verify()
        if (password_verify($contrasena, $user['Contraseña'])) {
            // Contraseña correcta, iniciar sesión
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['Nombre_Usuario'];
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['rol'] = $user['Rol'];

            // Redirigir al dashboard correspondiente según el rol
            if ($_SESSION['rol'] == 3) {
                header("Location: ../admin/dashboardAdmin.php");
                exit;
            } else {
                // Redirigir a otra página si el usuario no es administrador
                header("Location: ../public/dashboard.php");  // Modifica esto según el rol del usuario
                exit;
            }
        } else {
            // Contraseña incorrecta
            header("Location: login.php?error=incorrect_password");
            exit;
        }
    } else {
        // Usuario no encontrado
        header("Location: login.php?error=user_not_found");
        exit;
    }
}
?>
