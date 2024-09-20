<?php
include('../../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Eliminar el cifrado en el código ya que la base de datos lo realiza con un trigger
    // $contrasena_encriptada = hash('sha256', $contrasena);  // Esta línea ya no es necesaria

    // Buscar el usuario en la base de datos
    $sql = "SELECT ID_Usuario, Nombre_Usuario, Contraseña, Rol FROM usuario WHERE Nombre_Usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar si el usuario tiene el rol 4 (Inactivo)
        if ($user['Rol'] == 4) {
            header("Location: login.php?error=disabled");
            exit;
        }

        // Comparar la contraseña ingresada con la almacenada en la base de datos
        // Ya no necesitamos cifrarla en el código, ya que la base de datos la cifra con el trigger
        if (hash('sha256', $contrasena) === $user['Contraseña']) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['Nombre_Usuario'];
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['rol'] = $user['Rol'];

            // Redirigir al dashboard correspondiente según el rol
            if ($_SESSION['rol'] == 3) {
                header("Location: ../admin/dashboardAdmin.php");
                exit;
            } else if ($_SESSION['rol'] == 2) {
                header("Location: ../Asesor/dashboardAsesor.php");
                exit;
            } else if ($_SESSION['rol'] == 1) {
                header("Location: ../Student/dashboardStudent.php");
                exit;
            } else {
                header("Location: login.php");
                exit;
            }
        } else {
            header("Location: login.php?error=incorrect_password");
            exit;
        }
    } else {
        header("Location: login.php?error=user_not_found");
        exit;
    }
}
?>
