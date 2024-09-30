<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <a class="navbar-brand mx-5" href="../Student/dashboardStudent.php">
        <img src="<?php echo IMG_PATH; ?>TESCO_TRANSPARENTE.webp" alt="Logo" style="width: 120px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?php if (isset($_SESSION['id_proyecto']) && $_SESSION['id_proyecto']): ?>
                    <a href="../Student/proyects.php?id_proyecto=<?php echo $_SESSION['id_proyecto']; ?>" class="nav-link">
                        Ir al Proyecto
                    </a>
                <?php else: ?>
                    <p class="nav-link">No tienes ningún proyecto asignado.</p>
                <?php endif; ?>
            </li>

            <!-- Dropdown de Documentación -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Documentación
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Anteproyecto.php">Anteproyecto</a>
                    <a class="dropdown-item" href="Documentacion.php">Documentación Proyecto</a>
                    <a class="dropdown-item" href="APA7.php">APA 7</a>
                </div>
            </li>
        </ul>

        <div class="d-flex align-items-center">
            <!-- Dropdown de usuario sin flecha -->
            <div class="dropdown">
                <span class="navbar-text mr-3">
                    <?php echo $_SESSION['username']; ?>
                </span>
                <!-- Se elimina la clase dropdown-toggle -->
                <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fas fa-user text-white ml-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <!-- Botón para abrir el modal de cambio de contraseña -->
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">Cambiar
                        Contraseña</a>
                    <a class="dropdown-item" href="../public/logout.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</nav>