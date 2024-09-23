<!-- Barra superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <a class="navbar-brand mx-5" href="../Asesor/dashboardAsesor.php">
            <img src="<?php echo IMG_PATH; ?>TESCO_TRANSPARENTE.webp" alt="Logo" style="width: 120px;">
        </a>    
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../Asesor/asigmentProyects.php">Proyecto</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <span class="navbar-text mr-3">
                    <?php echo $_SESSION['username']; ?>
                </span>
                <a href="../public/logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
            </div>
        </div>
    </nav>