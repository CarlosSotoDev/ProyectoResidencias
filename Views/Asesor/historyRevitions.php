<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

// Obtener el ID del proyecto desde la URL, la sesión, o asociarlo directamente con el usuario si es necesario
$project_id = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : (isset($_SESSION['id_proyecto']) ? $_SESSION['id_proyecto'] : null);

if (!$project_id) {
    // Si no hay ID en la sesión ni en la URL, intenta buscar el proyecto asignado al asesor
    $query = "SELECT p.ID_Proyecto FROM proyecto p 
              JOIN asesor a ON p.Asesor = a.ID_Asesor
              WHERE a.ID_Usuario = ? LIMIT 1";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($project_id);
    $stmt->fetch();
    $stmt->close();

    // Guarda el ID de proyecto en la sesión si se encontró
    if ($project_id) {
        $_SESSION['id_proyecto'] = $project_id;
    } else {
        echo "No se ha seleccionado ningún proyecto.";
        exit();
    }
}

// Consulta para obtener los detalles del proyecto en la columna izquierda
$query = "SELECT p.*, p.Status, p.Archivo_Docx, p.Nombre_Proyecto FROM proyecto p WHERE p.ID_Proyecto = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$proyecto = $result->fetch_assoc();

// Configuración de paginación para la tabla de revisiones
$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $recordsPerPage;

$queryTotalRevisiones = "SELECT COUNT(*) as total 
                         FROM revisiones 
                         WHERE ID_Conexion = (
                            SELECT ID_Conexion 
                            FROM conproyectorevisiones 
                            WHERE ID_Proyecto = ?
                         )";
$stmtTotalRevisiones = $connection->prepare($queryTotalRevisiones);
$stmtTotalRevisiones->bind_param("i", $project_id);
$stmtTotalRevisiones->execute();
$resultTotalRevisiones = $stmtTotalRevisiones->get_result();
$totalRows = $resultTotalRevisiones->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $recordsPerPage);

$queryRevisiones = "
    SELECT ROW_NUMBER() OVER (ORDER BY Fecha_Revision ASC) as Revision_Numero, 
           Comentario, 
           Fecha_Revision, 
           Fecha_Proxima_Revision
    FROM revisiones
    WHERE ID_Conexion = (
        SELECT ID_Conexion 
        FROM conproyectorevisiones 
        WHERE ID_Proyecto = ?
    )
    ORDER BY Fecha_Revision ASC
    LIMIT $recordsPerPage OFFSET $offset";
$stmtRevisiones = $connection->prepare($queryRevisiones);
$stmtRevisiones->bind_param("i", $project_id);
$stmtRevisiones->execute();
$resultRevisiones = $stmtRevisiones->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Revisiones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAsesor.php'); ?>
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <main role="main" class="container-fluid bg-light p-4 mt-4 border border-success custom-margin">
        <h2>Historial de Revisiones</h2>

        <div class="row align-items-center justify-content-center mt-1">
            <!-- Columna izquierda: Datos del proyecto asignado -->
            <div class="col-md-6 border-right border-2 border-success">
                <div class="bg-light p-3">
                    <h2 class="text-center">Proyecto</h2>

                    <?php if (!empty($proyecto)): ?>
                        <p class="h2 text-center">
                            <strong><?php echo htmlspecialchars($proyecto['Nombre_Proyecto'] ?? 'No disponible'); ?></strong>
                        </p>
                        <p class="h4 text-center">DOCUMENTO:</p>
                        <?php if (!empty($proyecto['Archivo_Docx'])): ?>
                            <p class="text-center">
                                <a href="/ProyectoResidencias/uploads/documents/<?php echo htmlspecialchars($proyecto['Archivo_Docx']); ?>" target="_blank" class="btn btn-primary">Descargar Documento</a>
                            </p>
                        <?php else: ?>
                            <p class="text-center">No hay documento subido.</p>
                        <?php endif; ?>
                        <p class="text-center h4"><strong>Status del Proyecto:</strong><br>
                            <?php echo htmlspecialchars($proyecto['Status'] ?? 'No disponible'); ?></p>
                    <?php else: ?>
                        <p>No hay detalles disponibles para este proyecto.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Columna derecha: Historial de Revisiones con paginación -->
            <div class="col-md-6">
                <div class="bg-light p-3 text-center">
                    <h2 class="text-center">Historial de Revisiones</h2>
                    <button type="button" class="btn btn-success mb-1 text-center" data-toggle="modal" data-target="#revisionModal">
                        Generar nueva Revisión
                    </button>

                    <!-- Modal para agregar nueva revisión -->
                    <div class="modal fade" id="revisionModal" tabindex="-1" role="dialog" aria-labelledby="revisionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="revisionModalLabel">Nueva Revisión</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="revisionForm">
                                        <div class="form-group">
                                            <label for="comentario">Comentario</label>
                                            <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_proxima_revision">Fecha Próxima Revisión</label>
                                            <input type="date" class="form-control" id="fecha_proxima_revision" name="fecha_proxima_revision" required>
                                        </div>
                                        <input type="hidden" id="id_proyecto" name="id_proyecto" value="<?php echo $project_id; ?>">
                                        <button type="submit" class="btn btn-primary">Guardar Revisión</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>Número de Revisión</th>
                                    <th>Comentario</th>
                                    <th>Fecha Revisión</th>
                                    <th>Fecha Próxima Revisión</th>
                                </tr>
                            </thead>
                            <tbody id="revisiones-tbody" class="text-center">
                                <?php
                                $fecha_actual = date('Y-m-d');
                                if ($resultRevisiones->num_rows > 0) {
                                    while ($revision = $resultRevisiones->fetch_assoc()) {
                                        $fecha_proxima_revision = $revision['Fecha_Proxima_Revision'];
                                        $clase_fecha = '';

                                        if ($fecha_proxima_revision < $fecha_actual) {
                                            $clase_fecha = 'text-danger'; 
                                        } elseif ($fecha_proxima_revision == $fecha_actual) {
                                            $clase_fecha = 'text-success'; 
                                        } else {
                                            $clase_fecha = 'text-warning'; 
                                        }

                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($revision['Revision_Numero']) . "</td>";
                                        echo "<td><button class='btn btn-info ver-comentario' data-comentario='" . htmlspecialchars($revision['Comentario']) . "'>Ver Comentario</button></td>";
                                        echo "<td>" . htmlspecialchars($revision['Fecha_Revision']) . "</td>";
                                        echo "<td class='" . $clase_fecha . "'>" . htmlspecialchars($revision['Fecha_Proxima_Revision']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No hay revisiones para este proyecto.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page - 1; ?>&id_proyecto=<?= $project_id; ?>">Anterior</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $i; ?>&id_proyecto=<?= $project_id; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page + 1; ?>&id_proyecto=<?= $project_id; ?>">Siguiente</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="verComentarioModal" tabindex="-1" role="dialog" aria-labelledby="verComentarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verComentarioModalLabel">Comentario Completo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="comentario-completo"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.ver-comentario', function() {
            var comentario = $(this).data('comentario');
            $("#comentario-completo").text(comentario);
            $("#verComentarioModal").modal('show');
        });
    </script>
</body>
</html>
