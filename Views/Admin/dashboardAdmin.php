<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] != 3 || !isset($_SESSION['session_token'])) {
    header('Location: ../public/login.php');
    exit;
}

// Desactivar el caché del navegador
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenido al Dashboard del Administrador</h1>
        <p>Usuario: <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></p>

        <!-- Botón para cerrar sesión -->
        <a href="../public/logout.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        // Verificar la sesión con AJAX
        function checkSession() {
            $.ajax({
                url: '../public/check_session.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (!response.session_active) {
                        window.location.href = '../public/login.php';
                    }
                },
                error: function() {
                    console.log('Error al verificar la sesión.');
                }
            });
        }

        // Verificar la sesión al cargar la página
        $(document).ready(function() {
            checkSession();

            // Verificar la sesión periódicamente (cada 5 minutos)
            setInterval(checkSession, 300000); // 300000 ms = 5 minutos
        });

        // Forzar la recarga si se navega hacia atrás
        window.onpageshow = function(event) {
            if (event.persisted || window.performance && window.performance.navigation.type == 2) {
                window.location.reload();
            }
        };
    </script>
</body>
</html>
