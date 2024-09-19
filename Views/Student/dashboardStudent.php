<?php
include('../../includes/config.php');
checkLogin();

// Consulta para obtener los datos del proyecto asignado
$query = "
    SELECT p.*, 
           CONCAT(a.Nombres, ' ', a.Apellido_Paterno, ' ', a.Apellido_Materno) AS Nombre_Asesor,
           CONCAT(i1.Nombres, ' ', i1.Apellido_Paterno, ' ', i1.Apellido_Materno) AS Integrante1,
           CONCAT(i2.Nombres, ' ', i2.Apellido_Paterno, ' ', i2.Apellido_Materno) AS Integrante2,
           CONCAT(i3.Nombres, ' ', i3.Apellido_Paterno, ' ', i3.Apellido_Materno) AS Integrante3
    FROM proyecto p
    LEFT JOIN asesor a ON p.Asesor = a.ID_Asesor
    LEFT JOIN alumno i1 ON p.Integrante_1 = i1.ID_Alumno
    LEFT JOIN alumno i2 ON p.Integrante_2 = i2.ID_Alumno
    LEFT JOIN alumno i3 ON p.Integrante_3 = i3.ID_Alumno
    WHERE p.ID_Proyecto = ?";  // Asegúrate de pasar el ID del proyecto adecuado
$stmt = $connection->prepare($query);
$stmt->bind_param('i', $idProyecto);  // Reemplaza $idProyecto con el ID del proyecto deseado
$stmt->execute();
$result = $stmt->get_result();
$proyecto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestion de Alumnos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAlumno.php'); ?>

    <main role="main" class="container bg-light p-2 mx-auto my-1">
        <!-- Mensaje de Bienvenida -->
        <div id="welcome-message" class="d-flex justify-content-center align-items-center flex-column min-vh-100">
            <h1 class="text-center">Bienvenido <span class="navbar-text mr-3">
                    <?php echo $_SESSION['username']; ?>
                </span>
            </h1>
        </div>

    </main>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>