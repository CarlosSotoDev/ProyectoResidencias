<?php
include('../../config.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT ID_Usuario, Nombre_Usuario, Contraseña, Rol FROM Usuario WHERE Nombre_Usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($contrasena, $user['Contraseña'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['Nombre_Usuario'];
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['rol'] = $user['Rol'];

            // Redirigir al dashboard del Administrador si el rol es 3
            if ($_SESSION['rol'] == 3) {
                header("Location: ../Admin/dashboardAdmin.php");
                exit;
            } else {
                // Redirigir a otra página o mostrar un mensaje si no es administrador
                echo "No tienes acceso al panel de administrador.";
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
