<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];
$upload_message = '';
$result = null; // Inicializar la variable $result para evitar errores

// Procesar la subida de archivo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documento'])) {
    $allowed_extensions = ['doc', 'docx'];
    $file = $_FILES['documento'];
    $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $file_name_original = pathinfo($file['name'], PATHINFO_FILENAME); // Obtener el nombre original sin extensión

    if (in_array($file_ext, $allowed_extensions)) {
        // Ruta de almacenamiento absoluta
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/ProyectoResidencias/uploads/documents/'; // Asegurarse de que la ruta sea absoluta y correcta

        // Verificar si la carpeta existe, si no, crearla
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Obtener el ID del proyecto desde el formulario
        $project_id = $_POST['project_id'];

        // Recuperar el nombre del archivo antiguo desde la base de datos
        $query = "SELECT Archivo_Docx FROM proyecto WHERE ID_Proyecto = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $project_id);
        $stmt->execute();
        $stmt->bind_result($archivo_anterior);
        $stmt->fetch();
        $stmt->close();

        // Si existe un archivo previo, eliminarlo de la carpeta
        if ($archivo_anterior && file_exists($upload_dir . $archivo_anterior)) {
            unlink($upload_dir . $archivo_anterior); // Eliminar el archivo
        }

        // Evitar duplicación de archivos añadiendo timestamp si ya existe
        $file_name = str_replace(' ', '_', $file_name_original) . '.' . $file_ext; // Reemplazar espacios con guiones bajos
        $file_path = $upload_dir . $file_name;

        if (file_exists($file_path)) {
            // Si el archivo ya existe, agregar un sufijo con un timestamp para evitar sobreescritura
            $file_name = str_replace(' ', '_', $file_name_original) . '_' . time() . '.' . $file_ext;
            $file_path = $upload_dir . $file_name;
        }

        // Mover el archivo al servidor
        if (move_uploaded_file($file['tmp_name'], $file_path)) {
            // Guardar el archivo en la base de datos con el nombre original o modificado si ya existía
            $query = "UPDATE proyecto SET Archivo_Docx = ?, Status = 'En Revisión' WHERE ID_Proyecto = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("si", $file_name, $project_id);
            if ($stmt->execute()) {
                $upload_message = "El archivo se subió correctamente.";

                // Redirigir para evitar reenvío de formulario al recargar la página
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
$project_id = isset($_GET['id_proyecto']) ? $_GET['id_proyecto'] : null;

if (!$project_id) {
    echo "No se ha seleccionado ningún proyecto.";
    exit();
}

$query = "SELECT p.*, p.Status, p.Archivo_Docx FROM proyecto p WHERE p.ID_Proyecto = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
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

    <!-- Main content -->
    <main role="main" class="container-fluid bg-light p-2 my-1 border border-success custom-margin">
        <h2>Historial de Revisiones</h2>

        <div class="row align-items-center justify-content-center mt-5">
            <!-- Columna izquierda: Datos del proyecto asignado -->
            <div class="col-md-6 border-right border-2 border-success">
                <div class="bg-light p-3">
                    <h2 class="text-center">Proyecto</h2>

                    <!-- Mostrar mensaje de éxito -->
                    <?php if ($upload_message): ?>
                        <div id="uploadMessage" class="upload-message">
                            <?php echo $upload_message; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($result && $result->num_rows > 0): 
                        $proyecto = $result->fetch_assoc();
                    ?>
                        <p class="h2 text-center">
                            <strong><?php echo htmlspecialchars($proyecto['Nombre_Proyecto'] ?? 'No disponible'); ?></strong>
                        </p>
                        <p class="h4 text-center">Subir Documento:</p>
                        <!-- Formulario para subir documento -->
                        <form method="post" enctype="multipart/form-data">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <label for="documento">Seleccionar Documento (.docx):</label>
                                <input type="file" name="documento" id="documento" class="form-control" accept=".doc, .docx" required style="width: 50%;">
                                <!-- Campo oculto para enviar el ID del proyecto -->
                                <input type="hidden" name="project_id" value="<?php echo $proyecto['ID_Proyecto']; ?>">
                                <button type="submit" class="btn btn-success mt-3 mx-auto">Subir Documento</button>
                            </div>
                        </form>

                        <!-- Mostrar el documento si ya ha sido subido -->
                        <?php if (!empty($proyecto['Archivo_Docx'])): ?>
                            <p class="mt-3">Documento Actual:
                                <a href="../../uploads/documents/<?php echo rawurlencode($proyecto['Archivo_Docx']); ?>" target="_blank" class="document-link">Ver Documento</a>
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
                            // Obtener el ID_Conexion basado en el ID_Proyecto
                            $queryConexion = "SELECT ID_Conexion FROM conproyectorevisiones WHERE ID_Proyecto = ?";
                            $stmtConexion = $connection->prepare($queryConexion);
                            $stmtConexion->bind_param("i", $project_id);
                            $stmtConexion->execute();
                            $resultConexion = $stmtConexion->get_result();

                            if ($resultConexion->num_rows > 0) {
                                $conexion = $resultConexion->fetch_assoc();
                                $id_conexion = $conexion['ID_Conexion'];

                                // Obtener el historial de revisiones para este ID_Conexion
                                $queryRevisiones = "
                                    SELECT Revision_Numero, Comentario, Fecha_Revision, Fecha_Proxima_Revision
                                    FROM revisiones
                                    WHERE ID_Conexion = ?";

                                $stmtRevisiones = $connection->prepare($queryRevisiones);
                                $stmtRevisiones->bind_param("i", $id_conexion);
                                $stmtRevisiones->execute();
                                $resultRevisiones = $stmtRevisiones->get_result();

                                if ($resultRevisiones->num_rows > 0) {
                                    $revision_numero = 1; // Iniciar contador de revisiones
                                    while ($revision = $resultRevisiones->fetch_assoc()) {
                                        // Definir la clase CSS según la fecha
                                        $fecha_proxima_revision = $revision['Fecha_Proxima_Revision'];
                                        $fecha_actual = date('Y-m-d');
                                        $clase_fecha = '';

                                        if ($fecha_proxima_revision < $fecha_actual) {
                                            $clase_fecha = 'text-danger'; // Fecha pasada: rojo
                                        } elseif ($fecha_proxima_revision == $fecha_actual) {
                                            $clase_fecha = 'text-success'; // Fecha actual: verde
                                        } else {
                                            $clase_fecha = 'text-warning'; // Fecha futura: amarillo
                                        }

                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($revision_numero) . "</td>";
                                        echo "<td><button class='btn btn-info ver-comentario' data-comentario='" . htmlspecialchars($revision['Comentario']) . "'>Ver Comentario</button></td>";
                                        echo "<td>" . htmlspecialchars($revision['Fecha_Revision']) . "</td>";
                                        echo "<td class='" . $clase_fecha . "'>" . htmlspecialchars($revision['Fecha_Proxima_Revision']) . "</td>";
                                        echo "</tr>";

                                        $revision_numero++; // Incrementar el número de revisión
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var message = document.getElementById('uploadMessage');
            if (message) {
                message.style.display = 'block';  // Mostrar el mensaje
                setTimeout(function () {
                    message.style.display = 'none'; // Ocultar después de 3 segundos
                }, 3000); 
            }

            // Manejar el evento de clic en los botones "Ver Comentario"
            $(document).on('click', '.ver-comentario', function() {
                var comentario = $(this).data('comentario');
                if (comentario) {
                    $("#comentario-completo").text(comentario); // Colocar el comentario en el modal
                    $("#verComentarioModal").modal('show'); // Mostrar el modal
                } else {
                    alert('No hay comentario disponible.'); // Mensaje de error si no hay comentario
                }
            });
        });
    </script>
</body>
</html>
