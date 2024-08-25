<?php
include('../../config.php'); // Asegúrate de que session_start() esté en config.php si es necesario
include('../../includes/header.php');
?>

<nav class="navbar navbar-light bg-white">
        <a class="navbar-brand mx-5" href="<?php echo BASE_URL; ?>">
            <img src="<?php echo IMG_PATH; ?>TESCO.webp" alt="Logo" style="width: 120px;">
        </a>
    </nav>
<div class="container mt-5 flex-grow-1 d-flex justify-content-center align-items-center login-container">
    <div style="width: 100%; max-width: 600px;">
        
        <h2 class="text-center">Iniciar Sesión</h2>
        
        <!-- Mostrar mensajes de error -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php
                if ($_GET['error'] == 'incorrect_password') {
                    echo "Contraseña incorrecta.";
                } elseif ($_GET['error'] == 'user_not_found') {
                    echo "Usuario no encontrado.";
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
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

<?php
include('../../includes/footer.php');
?>
