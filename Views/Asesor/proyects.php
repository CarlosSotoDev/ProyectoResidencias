<?php
include('../../includes/config.php');
checkLogin();

// Nueva consulta para obtener los datos del proyecto
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
    ORDER BY p.ID_Proyecto ASC";

// Ejecutar la consulta
$result = $connection->query($query);
$proyecto = $result->fetch_assoc();  // Obtener el primer resultado del proyecto (puedes ajustar esto según la lógica)
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>GESTION PROYECTOS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css"> <!-- Enlace al archivo CSS personalizado -->
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>

    <main role="main" class="container bg-light p-2 mx-auto my-1">
        <h2>Gestión de Proyectos</h2>

        <!-- Contenedor dividido en dos columnas -->
        <div class="row align-items-center justify-content-center mt-5">
            <!-- Columna izquierda: Datos del proyecto asignado -->
            <div class="col-md-6 border-right border-2 border-success">
                <div class="bg-light p-3">
                    <h2 class="text-center">Datos del Proyecto Asignado</h2>
                    <p class="h2">
                        Nombre del Proyecto:<br>
                        <strong><?php echo htmlspecialchars($proyecto['Nombre_Proyecto'] ?? 'No disponible'); ?></strong>
                    </p>
                    <p class="h4">Integrantes:</p>

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
                    <p><strong>Comentarios:</strong>
                        <?php echo htmlspecialchars($proyecto['Comentarios_Asesor'] ?? 'Sin comentarios'); ?></p>
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