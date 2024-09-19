<!-- Barra superior -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
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
                    <a class="nav-link" href="../Student/proyects.php">Proyecto</a>
                </li>

                <!-- Dropdown de Documentación -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Documentación
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Anteproyecto</a> <!-- Primera opción del dropdown -->
                        <a class="dropdown-item" href="#">Informe Final</a> <!-- Segunda opción del dropdown -->
                        <a class="dropdown-item" href="#">Manual de Usuario</a> <!-- Tercera opción del dropdown -->
                    </div>
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