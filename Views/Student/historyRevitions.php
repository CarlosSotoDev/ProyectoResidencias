<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];
$upload_message = '';

// Obtener el ID del proyecto desde la URL, la sesión, o asociarlo directamente con el usuario si es necesario
$project_id = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : (isset($_SESSION['id_proyecto']) ? $_SESSION['id_proyecto'] : null);

if (!$project_id) {
    // Si no hay ID en la sesión ni en la URL, intenta buscar el proyecto del usuario
    $query = "SELECT p.ID_Proyecto FROM proyecto p 
              JOIN alumno a ON (p.Integrante_1 = a.ID_Alumno OR p.Integrante_2 = a.ID_Alumno OR p.Integrante_3 = a.ID_Alumno)
              WHERE a.ID_Alumno = ? LIMIT 1";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($project_id);
    $stmt->fetch();
    $stmt->close();

    if ($project_id) {
        $_SESSION['id_proyecto'] = $project_id;
    } else {
        echo "No se ha seleccionado ningún proyecto.";
        exit();
    }
}

// Procesar la subida de archivo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documento'])) {
    $allowed_extensions = ['doc', 'docx'];
    $file = $_FILES['documento'];
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name_original = pathinfo($file['name'], PATHINFO_FILENAME);

    if (in_array($file_ext, $allowed_extensions)) {
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/ProyectoResidencias/uploads/documents/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $query = "SELECT Archivo_Docx FROM proyecto WHERE ID_Proyecto = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        $stmt->bind_result($archivo_anterior);
        $stmt->fetch();
        $stmt->close();

        if ($archivo_anterior && file_exists($upload_dir . $archivo_anterior)) {
            unlink($upload_dir . $archivo_anterior);
        }

        $file_name = str_replace(' ', '_', $file_name_original) . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;

        if (file_exists($file_path)) {
            $file_name = str_replace(' ', '_', $file_name_original) . '_' . time() . '.' . $file_ext;
            $file_path = $upload_dir . $file_name;
        }

        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            $query = "UPDATE proyecto SET Archivo_Docx = ?, Status = 'En Revisión' WHERE ID_Proyecto = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("si", $file_name, $project_id);
            if ($stmt->execute()) {
                // Enviar notificación al asesor
                $mensaje = "Un nuevo documento ha sido subido para el proyecto.";
                $query_notif = "INSERT INTO notificaciones (ID_Usuario, Mensaje, ID_Proyecto) 
                                SELECT Asesor, ?, ? FROM proyecto WHERE ID_Proyecto = ?";
                $stmt_notif = $connection->prepare($query_notif);
                $stmt_notif->bind_param("sii", $mensaje, $project_id, $project_id);
                $stmt_notif->execute();

                $upload_message = "El archivo se subió correctamente.";
                header("Location: historyRevitions.php?id_proyecto=" . $project_id);
                exit();
            } else {
                $upload_message = "Error al guardar el archivo en la base de datos.";
            }
        } else {
            $upload_message = "Error al mover el archivo.";
        }
    } else {
        $upload_message = "Solo se permiten archivos .doc y .docx.";
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
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>dashboard.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAlumno.php'); ?>
    <!-- Modal Cambio Contraseña -->
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <main role="main" class="container-fluid bg-light p-2 my-1 border border-success custom-margin">
        <h2>Historial de Revisiones</h2>

        <div class="row align-items-center justify-content-center mt-5">
            <!-- Columna izquierda: Datos del proyecto asignado -->
            <div class="col-md-6 border-right border-2 border-success">
                <div class="bg-light p-3">
                    <h2 class="text-center">Proyecto</h2>

                    <?php if (!empty($proyecto)): ?>
                        <p class="h2 text-center">
                            <strong><?php echo htmlspecialchars($proyecto['Nombre_Proyecto'] ?? 'No disponible'); ?></strong>
                        </p>
                        <p class="h4 text-center">Subir Documento:</p>
                        <form method="post" enctype="multipart/form-data">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <label for="documento">Seleccionar Documento (.docx):</label>
                                <input type="file" name="documento" id="documento" class="form-control" accept=".doc, .docx" required style="width: 50%;">
                                <input type="hidden" name="project_id" value="<?php echo $proyecto['ID_Proyecto']; ?>">
                                <button type="submit" class="btn btn-success mt-3 mx-auto">Subir Documento</button>
                            </div>
                        </form>

                        <?php if (!empty($proyecto['Archivo_Docx'])): ?>
                            <p class="mt-3">Documento Actual:
                                <a href="/ProyectoResidencias/uploads/documents/<?php echo rawurlencode($proyecto['Archivo_Docx']); ?>" target="_blank" class="document-link">Ver Documento</a>
                            </p>
                        <?php endif; ?>

                        <p class="text-center h4"><strong>Status del Proyecto:</strong><br>
                            <?php echo htmlspecialchars($proyecto['Status'] ?? 'No disponible'); ?>
                        </p>
                    <?php else: ?>
                        <p>No hay detalles disponibles para este proyecto.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Columna derecha: Historial de Revisiones -->
            <div class="col-md-6">
                <div class="bg-light p-3">
                    <h2 class="text-center">Historial de Revisiones</h2>
                    <table class="table table-striped table-sm text-center">
                        <thead>
                            <tr>
                                <th>Numero de Revision</th>
                                <th>Comentario</th>
                                <th>Fecha de Revisión</th>
                                <th>Fecha Próxima Revisión</th>
                            </tr>
                        </thead>
                        <tbody id="revisiones-tbody">
                            <?php
                            $queryConexion = "SELECT ID_Conexion FROM conproyectorevisiones WHERE ID_Proyecto = ?";
                            $stmtConexion = $connection->prepare($queryConexion);
                            $stmtConexion->bind_param("i", $project_id);
                            $stmtConexion->execute();
                            $resultConexion = $stmtConexion->get_result();

                            if ($resultConexion->num_rows > 0) {
                                $conexion = $resultConexion->fetch_assoc();
                                $id_conexion = $conexion['ID_Conexion'];

                                $queryRevisiones = "
                                    SELECT ROW_NUMBER() OVER (ORDER BY Fecha_Revision ASC) AS Revision_Numero, 
                                           Comentario, 
                                           Fecha_Revision, 
                                           Fecha_Proxima_Revision
                                    FROM revisiones
                                    WHERE ID_Conexion = ?";

                                $stmtRevisiones = $connection->prepare($queryRevisiones);
                                $stmtRevisiones->bind_param("i", $id_conexion);
                                $stmtRevisiones->execute();
                                $resultRevisiones = $stmtRevisiones->get_result();

                                if ($resultRevisiones->num_rows > 0) {
                                    while ($revision = $resultRevisiones->fetch_assoc()) {
                                        $fecha_proxima_revision = $revision['Fecha_Proxima_Revision'];
                                        $fecha_actual = date('Y-m-d');
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
                            } else {
                                echo "<tr><td colspan='4'>No se encontró una conexión para este proyecto.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
                <div class="modal-body" id="comentario-completo">
                    <!-- Aquí se cargará el comentario completo -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var message = document.getElementById('uploadMessage');
            if (message) {
                message.style.display = 'block';
                setTimeout(function () {
                    message.style.display = 'none';
                }, 3000);
            }

            $(document).on('click', '.ver-comentario', function () {
                var comentario = $(this).data('comentario');
                $("#comentario-completo").text(comentario);
                $("#verComentarioModal").modal('show');
            });
        });
    </script>
</body>
</html>
