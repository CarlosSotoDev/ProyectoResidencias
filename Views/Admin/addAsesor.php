<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificación para asegurar que todas las claves esperadas en $_POST están definidas
    $nombres = isset($_POST['nombres']) ? mysqli_real_escape_string($connection, $_POST['nombres']) : null;
    $apellido_paterno = isset($_POST['apellido_paterno']) ? mysqli_real_escape_string($connection, $_POST['apellido_paterno']) : null;
    $apellido_materno = isset($_POST['apellido_materno']) ? mysqli_real_escape_string($connection, $_POST['apellido_materno']) : null;
    $carrera = isset($_POST['carrera']) ? mysqli_real_escape_string($connection, $_POST['carrera']) : null;
    $proyecto_asignado = isset($_POST['proyecto']) ? mysqli_real_escape_string($connection, $_POST['proyecto']) : null; // Valor por defecto null

    // Verificamos que las variables esenciales no estén vacías
    if ($nombres && $apellido_paterno && $apellido_materno && $carrera) {
        // Insertar asesor en la tabla asesor
        $query = "INSERT INTO asesor (Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Proyecto_Asignado) VALUES ('$nombres', '$apellido_paterno', '$apellido_materno', '$carrera', " . ($proyecto_asignado ? "'$proyecto_asignado'" : "NULL") . ")";

        if ($connection->query($query) === TRUE) {
            // Si se seleccionó un proyecto, actualizar la tabla proyecto con el asesor asignado
            if ($proyecto_asignado) {
                $id_asesor = $connection->insert_id; // Obtenemos el ID del asesor recién agregado
                $updateProyecto = "UPDATE proyecto SET Asesor = '$id_asesor' WHERE ID_Proyecto = '$proyecto_asignado'";

                if ($connection->query($updateProyecto) === TRUE) {
                    // Redirigir al dashboard si todo fue exitoso
                    header("Location: dashboardAdminAsesor.php?success=1");
                    exit();
                } else {
                    echo "Error al actualizar el proyecto: " . $connection->error;
                }
            } else {
                // Redirigir si no hay proyecto asignado pero se agregó el asesor
                header("Location: dashboardAdminAsesor.php?success=1");
                exit();
            }
        } else {
            echo "Error al agregar el asesor: " . $connection->error;
        }
    } else {
        echo "Faltan datos requeridos para agregar el asesor.";
    }
} else {
    echo "Método de solicitud no permitido.";
}

$connection->close();
?>
