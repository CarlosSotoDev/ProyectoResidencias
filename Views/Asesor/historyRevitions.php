<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];
$upload_message = '';

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

// Consulta para obtener los detalles del proyecto según el ID
$query = "SELECT p.*, p.Status, p.Archivo_Docx, p.Nombre_Proyecto FROM proyecto p WHERE p.ID_Proyecto = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$proyecto = $result->fetch_assoc();

// Mensajes de éxito o error al cambiar la contraseña
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
    <!-- Modal Cambio Contraseña -->
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <main role="main" class="container-fluid bg-light p-2 my-1 border border-success custom-margin">
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

            <!-- Columna derecha: Historial de Revisiones -->
            <div class="col-md-6">
                <div class="bg-light p-3 text-center">
                    <h2 class="text-center">Historial de Revisiones</h2>
                    <!-- Botón para agregar nueva revisión (abre modal) -->
                    <button type="button" class="btn btn-success mb-1 text-center" data-toggle="modal" data-target="#revisionModal">
                        Generar nueva Revision
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
                                    <!-- Formulario para agregar revisión -->
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

                    <!-- Tabla de revisiones -->
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr class="text-center">
                                    <th>Número de Revisión</th>
                                    <th>Comentario</th>
                                    <th>Fecha Revision</th>
                                    <th>Fecha Próxima Revision</th>
                                </tr>
                            </thead>
                            <tbody id="revisiones-tbody" class="text-center">
                                <?php
                                $fecha_actual = date('Y-m-d');

                                // Obtener el ID_Conexion basado en el ID_Proyecto
                                $queryConexion = "SELECT ID_Conexion FROM conproyectorevisiones WHERE ID_Proyecto = ?";
                                $stmtConexion = $connection->prepare($queryConexion);
                                $stmtConexion->bind_param("i", $project_id);
                                $stmtConexion->execute();
                                $resultConexion = $stmtConexion->get_result();

                                if ($resultConexion->num_rows > 0) {
                                    $conexion = $resultConexion->fetch_assoc();
                                    $id_conexion = $conexion['ID_Conexion'];

                                    $queryRevisiones = "
                                        SELECT ROW_NUMBER() OVER (ORDER BY Fecha_Revision ASC) as Revision_Numero, Comentario, Fecha_Revision, Fecha_Proxima_Revision
                                        FROM revisiones
                                        WHERE ID_Conexion = ?";

                                    $stmtRevisiones = $connection->prepare($queryRevisiones);
                                    $stmtRevisiones->bind_param("i", $id_conexion);
                                    $stmtRevisiones->execute();
                                    $resultRevisiones = $stmtRevisiones->get_result();

                                    if ($resultRevisiones->num_rows > 0) {
                                        while ($revision = $resultRevisiones->fetch_assoc()) {
                                            $fecha_proxima_revision = $revision['Fecha_Proxima_Revision'];
                                            $clase_fecha = '';

                                            if ($fecha_proxima_revision < $fecha_actual) {
                                                $clase_fecha = 'text-danger'; // Fecha pasada: rojo
                                            } elseif ($fecha_proxima_revision == $fecha_actual) {
                                                $clase_fecha = 'text-success'; // Fecha actual: verde
                                            } else {
                                                $clase_fecha = 'text-warning'; // Fecha futura: amarillo
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
                                } else {
                                    echo "<tr><td colspan='4'>No se encontró una conexión para este proyecto.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal para mostrar comentario completo -->
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
    $(document).ready(function() {
        $("#revisionForm").submit(function(e) {
            e.preventDefault();
            var comentario = $("#comentario").val();
            var fecha_proxima_revision = $("#fecha_proxima_revision").val();
            var id_proyecto = $("#id_proyecto").val();

            $.ajax({
                url: 'insert_revision.php',
                method: 'POST',
                data: { comentario: comentario, fecha_proxima_revision: fecha_proxima_revision, id_proyecto: id_proyecto },
                success: function(response) {
                    $("#comentario").val('');
                    $("#fecha_proxima_revision").val('');
                    $('#revisionModal').modal('hide');
                    $("#revisiones-tbody").html(response);
                }
            });
        });

        $(document).on('click', '.ver-comentario', function() {
            var comentario = $(this).data('comentario');
            $("#comentario-completo").text(comentario);
            $("#verComentarioModal").modal('show');
        });
    });
    </script>
</body>
</html>
