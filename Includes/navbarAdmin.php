<!-- Barra superior -->
<nav class="navbar navbar-dark bg-success" style="z-index: 1000;">
    <!-- Contenedor de la imagen y el texto de la marca -->
    <div class="d-flex align-items-center" style="margin-left: 260px;"> <!-- Añadimos margen para evitar que choque con el sidebar -->
        <!-- Logo -->
        <img src="<?php echo IMG_PATH; ?>TESCO_TRANSPARENTE.webp" alt="Logo" style="width: 90px;" class="mr-3">
        <!-- Título del panel -->
        <span class="navbar-brand mb-0 h1">Panel de Administración</span>
    </div>

    <!-- Dropdown de usuario -->
    <div class="d-flex align-items-center">
        <div class="dropdown">
            <span class="navbar-text mr-3">
                <?php echo $_SESSION['username']; ?>
            </span>
            <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-user text-white ml-2"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Perfil</a>
                <a class="dropdown-item" href="../public/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>
