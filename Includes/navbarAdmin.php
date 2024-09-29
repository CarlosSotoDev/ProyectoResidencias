<!-- Barra superior -->
<nav class="navbar navbar-dark bg-success">
    <span class="navbar-brand mb-0 h1">Panel de Administración</span>
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
                <a class="dropdown-item" href="#">Perfil</a>
                <a class="dropdown-item" href="../public/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</nav>