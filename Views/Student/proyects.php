<?php
include('../../includes/config.php');
checkLogin();

// Obtener el ID_Usuario de la sesión
$usuario_id = $_SESSION['user_id']; // Verifica que 'user_id' esté siendo correctamente guardado en la sesión.
$rol = $_SESSION['rol']; // Verifica el rol del usuario, 1 = Alumno, 2 = Asesor

// Modificamos la consulta dependiendo del rol del usuario
if ($rol == 2) {
    // Si el usuario es Asesor, obtener los proyectos donde él es el asesor
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
        WHERE a.ID_Usuario = ? -- Aquí filtramos solo los proyectos del asesor actual
        ORDER BY p.ID_Proyecto ASC";

    // Preparar la consulta
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proyecto = $result->fetch_assoc();
} elseif ($rol == 1) {
    // Si el usuario es Alumno, obtener solo los proyectos en los que él es un integrante
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
        WHERE p.Integrante_1 = ? OR p.Integrante_2 = ? OR p.Integrante_3 = ? -- Filtrar por el alumno actual
        ORDER BY p.ID_Proyecto ASC";

    // Preparar la consulta
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proyecto = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestion de Proyectos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAlumno.php'); ?>

    <main role="main" class="container bg-light p-2 mx-auto my-1">
        <h2>Gestión de Proyectos</h2>

        <!-- Contenedor dividido en dos columnas -->
        <div class="row align-items-center justify-content-center mt-5">
            <!-- Columna izquierda: Datos del proyecto asignado -->
            <div class="col-md-6 border-right border-2 border-success">
                <div class="bg-light p-3">
                    <h2 class="text-center">Datos del Proyecto Asignado</h2>
                    <p class="h2 text-center">
                        Nombre del Proyecto:<br>
                        <strong><?php echo htmlspecialchars($proyecto['Nombre_Proyecto'] ?? 'No disponible'); ?></strong>
                    </p>
                    <p class="h4 text-center">Integrantes:</p>

                    <ul>
                        <li><?php echo htmlspecialchars($proyecto['Integrante1'] ?? 'No asignado'); ?></li>
                        <?php if (!empty($proyecto['Integrante2'])): ?>
                            <li><?php echo htmlspecialchars($proyecto['Integrante2']); ?></li>
                        <?php endif; ?>
                        <?php if (!empty($proyecto['Integrante3'])): ?>
                            <li><?php echo htmlspecialchars($proyecto['Integrante3']); ?></li>
                        <?php endif; ?>
                    </ul>
                    <p><strong>Status del Proyecto:</strong>
                        <?php echo htmlspecialchars($proyecto['Status'] ?? 'No disponible'); ?></p>
                </div>
            </div>

            <!-- Columna derecha: Datos y retroalimentación del asesor -->
            <div class="col-md-6">
                <div class="bg-light p-3">
                    <h2 class="text-center">Datos y Retroalimentación del Asesor</h2>
                    <p><strong>Asesor:</strong>
                        <?php echo htmlspecialchars($proyecto['Nombre_Asesor'] ?? 'No asignado'); ?></p>
                    <div class="text-center">
                        <a href="../Student/historyRevitions.php" class="btn btn-success mb-3">HISTORIAL DE
                            REVISIONES</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>