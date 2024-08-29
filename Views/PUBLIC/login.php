<?php
include('../../includes/config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if ($_SESSION['rol'] == 3) {
        header('Location: ../admin/dashboardAdmin.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['username'];
    $contraseña = $_POST['password'];
    $contraseña_encriptada = hash('sha256', $contraseña);

    $sql = "SELECT ID_Usuario, Nombre_Usuario, Rol FROM Usuario WHERE Nombre_Usuario = ? AND Contraseña = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $nombre_usuario, $contraseña_encriptada);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $id_usuario, $nombre_usuario_db, $rol);
        mysqli_stmt_fetch($stmt);

        $_SESSION['loggedin'] = true;
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['nombre_usuario'] = $nombre_usuario_db;
        $_SESSION['rol'] = $rol;

        // Generar y almacenar un token de sesión
        $_SESSION['session_token'] = bin2hex(random_bytes(32));

        if ($rol == 3) {
            header('Location: ../admin/dashboardAdmin.php');
        } else {
            header('Location: dashboard.php');
        }
        exit;
    } else {
        $error_message = "Nombre de usuario o contraseña incorrectos.";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>styles.css">
</head>
<body>
    <div class="container mt-5 flex-grow-1 d-flex justify-content-center align-items-center login-container">
        <div style="width: 100%; max-width: 600px;">
            <h2 class="text-center">Iniciar Sesión</h2>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingresa tu usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                </div>
                <button type="submit" class="btn btn-success btn-block">Acceder</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        window.onpageshow = function(event) {
            if (event.persisted || window.performance && window.performance.navigation.type == 2) {
                window.location.reload();
            }
        };
    </script>
</body>
</html>
