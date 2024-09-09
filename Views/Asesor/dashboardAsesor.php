<?php
include('../../includes/config.php');
checkLogin();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Asesor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Barra superior -->
    <nav class="navbar navbar-dark bg-success">
        <span class="navbar-brand mb-0 h1">Panel de Administración</span>
        <div class="d-flex align-items-center">
            <span class="navbar-text mr-3">
                <?php echo $_SESSION['username']; ?>
            </span>
            <a href="../public/logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <nav class="col-md-2 d-none d-md-block bg-success sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <!-- Enlace "Alumnos" con redirección directa -->
                            <a class="nav-link text-white text-center" href="../Asesor/addStudent.php" id="btn-alumnos">
                                Alumnos
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- Enlace "Proyectos" con manejo por jQuery -->
                            <a class="nav-link text-white text-center" href="../Asesor/addProject.php" id="btn-proyectos">
                                Proyectos
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main role="main" class="col-sm-9 ml-sm-auto col-lg-10 px-4">
                <!-- Mensaje de Bienvenida -->
                <div id="welcome-message" class="d-flex justify-content-center align-items-center flex-column min-vh-100">
                    <h1 class="text-center">Bienvenido <span class="navbar-text mr-3">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                    </h1>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Script para alternar entre paneles usando jQuery -->
    <script>
        $(document).ready(function () {
            // Aquí quitamos el preventDefault para permitir la redirección en el enlace "Alumnos"
            // El botón "Proyectos" sigue usando preventDefault para mostrar el contenido dinámico
            $('#btn-proyectos').on('click', function (event) {
                event.preventDefault(); // Prevenir el comportamiento por defecto del enlace "Proyectos"
                $('#welcome-message').hide();
                $('#crud-proyectos').show();
            });
        });
    </script>

</body>

</html>
