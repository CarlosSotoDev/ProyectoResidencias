<?php
include('../../includes/config.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Asegúrate de iniciar la sesión
}

// Verificar si el usuario ya está logueado
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if (isset($_SESSION['rol'])) {
        // Redirigir al dashboard según el rol
        if ($_SESSION['rol'] == 3) {
            header('Location: ../admin/dashboardAdmin.php');
        } else if ($_SESSION['rol'] == 2) {
            header('Location: ../Asesor/dashboardAsesor.php');
        } else if ($_SESSION['rol'] == 1) {
            header('Location: ../Student/dashboardStudent.php');
        } else if ($_SESSION['rol'] == 5) {
            header('Location: ../Jefe/dashboardJefe.php');
        }else {
            // Rol no reconocido, redirigir a una página de error o login
            header('Location: login.php');
        }
    } else {
        // Si no hay rol definido
        header('Location: login.php');
    }
    exit;
}

// Control de cache y errores de autenticación
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');

$error_message = "";

// Verificar si hay un error de autenticación
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
    <?php include('../../includes/navbarLogin.php'); ?>
    

    <div class="container flex-grow-1 d-flex justify-content-center align-items-center">
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
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Ingresa tu usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Ingresa tu contraseña" required>
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
        window.onpageshow = function (event) {
            if (event.persisted || window.performance && window.performance.navigation.type == 2) {
                window.location.reload();
            }
        };
    </script>
</body>

</html>
