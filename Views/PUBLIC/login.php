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

$error_message = "";

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'disabled':
            $error_message = "Su cuenta ha sido deshabilitada.";
            break;
        case 'incorrect_password':
            $error_message = "Contraseña incorrecta.";
            break;
        case 'user_not_found':
            $error_message = "Nombre de usuario no encontrado.";
            break;
        default:
            $error_message = "Error desconocido.";
    }
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
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Inicio</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>">Volver al Inicio</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="card p-4" style="max-width: 500px; width: 100%;">
            <h2 class="text-center">Iniciar Sesión</h2>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form action="authenticate.php" method="POST">
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

    <!-- Footer -->
    <?php include('../../includes/footer.php'); ?>

    <!-- Bootstrap JS y dependencias -->
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
