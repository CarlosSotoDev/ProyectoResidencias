<?php
include('../../includes/config.php');
checkLogin();

// Verificar si se ha enviado el formulario y si se han proporcionado todos los datos necesarios
if (isset($_POST['id_proyecto']) && isset($_POST['nombre_proyecto'])) {
    $id_proyecto = $_POST['id_proyecto'];
    $nombre_proyecto = $_POST['nombre_proyecto'];

    // Verificar si los valores no están vacíos
    if (!empty($id_proyecto) && !empty($nombre_proyecto)) {
        // Preparar la consulta SQL para actualizar el nombre del proyecto
        $sql = "UPDATE proyecto SET Nombre_Proyecto = ? WHERE ID_Proyecto = ?";
        $stmt = $connection->prepare($sql);

        if ($stmt) {
            // Asociar los parámetros de la consulta
            $stmt->bind_param("si", $nombre_proyecto, $id_proyecto);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir al dashboard si la actualización fue exitosa
                header("Location: dashboardAdminProyectos.php?message=Proyecto actualizado correctamente");
                exit();
            } else {
                echo "Error al actualizar el proyecto: " . $stmt->error;
            }

            // Cerrar la declaración preparada
            $stmt->close();
        } else {
            echo "Error al preparar la consulta: " . $connection->error;
        }
    } else {
        echo "ID del proyecto o nombre del proyecto está vacío.";
    }
} else {
    echo "Error en los datos recibidos.";
}

// Cerrar la conexión a la base de datos
$connection->close();
?>
