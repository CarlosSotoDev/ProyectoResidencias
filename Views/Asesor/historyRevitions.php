<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];
$project_id = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : null;

// Asegurarse de que hay un ID de proyecto seleccionado
if ($project_id) {
    if ($rol == 2) {
        // Si el usuario es Asesor
        $query = "
            SELECT p.*, p.Status, p.Archivo_Docx
            FROM proyecto p
            WHERE p.Asesor = (SELECT ID_Asesor FROM asesor WHERE ID_Usuario = ?) 
            AND p.ID_Proyecto = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("ii", $usuario_id, $project_id);
        $stmt->execute();
        $result = $stmt->get_result();
    } elseif ($rol == 1) {
        // Si el usuario es Alumno
        $query = "
            SELECT p.*, p.Status, p.Archivo_Docx
            FROM proyecto p
            WHERE (p.Integrante_1 = ? OR p.Integrante_2 = ? OR p.Integrante_3 = ?) 
            AND p.ID_Proyecto = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $project_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }
} else {
    echo "No se ha seleccionado ningún proyecto.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de Revisiones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>

    <main role="main" class="container-fluid bg-light p-2 my-1 border border-success custom-margin">
        <h2>Historial de Revisiones</h2>

        <div class="row align-items-center justify-content-center mt-1">
            <!-- Columna izquierda: Datos del proyecto asignado -->
            <div class="col-md-6 border-right border-2 border-success">
                <div class="bg-light p-3">
                    <h2 class="text-center">Proyecto</h2>

                    <?php
                    if ($result && $result->num_rows > 0) {
                        $proyecto = $result->fetch_assoc();
                        ?>
                        <p class="h2 text-center">
                            <strong><?php echo htmlspecialchars($proyecto['Nombre_Proyecto'] ?? 'No disponible'); ?></strong>
                        </p>
                        <p class="h4 text-center">DOCUMENTO:</p>
                        <?php if (!empty($proyecto['Archivo_Docx'])): ?>
                            <p class="text-center">
                                <a href="../../uploads/documents/<?php echo htmlspecialchars($proyecto['Archivo_Docx']); ?>"
                                    target="_blank" class="btn btn-primary">Descargar Documento</a>
                            </p>
                        <?php else: ?>
                            <p class="text-center">No hay documento subido.</p>
                        <?php endif; ?>
                        <p class="text-center h4"><strong>Status del Proyecto:</strong><br>
                            <?php echo htmlspecialchars($proyecto['Status'] ?? 'No disponible'); ?></p>
                        <?php
                    } else {
                        echo "<p>No hay detalles disponibles para este proyecto.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Columna derecha: Historial de Revisiones -->
            <div class="col-md-6">
                <div class="bg-light p-3 text-center">
                    <h2 class="text-center">Historial de Revisiones</h2>
                    <!-- Botón para agregar proyecto (abre modal) -->
                    <button type="button" class="btn btn-success mb-1 text-center"">
                        Generar nueva Revision
                    </button>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>ID Revision</th>
                                    <th>Comentario</th>
                                    <th>Fecha Revision</th>
                                    <th>Fecha Proxima Revision</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <!-- Aquí iría el historial de revisiones, dependiendo de la implementación -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>