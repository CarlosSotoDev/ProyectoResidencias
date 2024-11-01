<?php
include('../../includes/config.php');
checkLogin(); // Verify user authentication

// Get user ID from URL or session
if (isset($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id']; // Get user ID from URL
} else {
    $usuario_id = $_SESSION['user_id']; // Use session ID if no URL ID
}

// Query to get student's project
$query = "SELECT p.ID_Proyecto, p.Nombre_Proyecto
          FROM proyecto p
          WHERE p.Integrante_1 = ? OR p.Integrante_2 = ? OR p.Integrante_3 = ? LIMIT 1";
$stmt = $connection->prepare($query);
$stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if a project is assigned
if ($result && $result->num_rows > 0) {
    $proyecto = $result->fetch_assoc();
    $_SESSION['id_proyecto'] = $proyecto['ID_Proyecto']; // Save project ID in session
    $nombre_proyecto = $proyecto['Nombre_Proyecto'];
} else {
    $_SESSION['id_proyecto'] = null; // No assigned project
    $nombre_proyecto = "No hay proyecto asignado";
}

// Success or error messages for password changes
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Alumnos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>docs.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAlumno.php'); ?>
    <!-- Modal Change Password -->
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <main role="main" class="container bg-white p-2 mx-auto my-1">
        <!-- Dashboard Welcome -->
        <?php require('../../includes/welcomeDashboard.php'); ?>

        <!-- Project Section -->
        <h2>Proyecto Asignado</h2>
        <p><strong>Nombre del Proyecto:</strong> <?php echo htmlspecialchars($nombre_proyecto); ?></p>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
