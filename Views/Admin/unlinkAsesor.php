<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_proyecto = $_POST['id_proyecto'];

    // Iniciar la transacción
    $connection->begin_transaction();

    try {
        // Actualizar el campo del asesor en el proyecto a NULL
        $queryUnlinkAsesor = "UPDATE proyecto SET Asesor = NULL WHERE ID_Proyecto = ?";
        $stmt = $connection->prepare($queryUnlinkAsesor);
        $stmt->bind_param('i', $id_proyecto);
        $stmt->execute();

        // Actualizar el campo del asesor en la tabla alumno para los alumnos que tienen asignado este proyecto
        $queryUpdateAlumno = "UPDATE alumno SET Asesor = NULL WHERE Proyecto = ?";
        $stmtAlumno = $connection->prepare($queryUpdateAlumno);
        $stmtAlumno->bind_param('i', $id_proyecto);
        $stmtAlumno->execute();

        // Confirmar la transacción
        $connection->commit();

        $_SESSION['success_message'] = "Asesor desvinculado correctamente y actualizado en los alumnos.";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $connection->rollback();
        $_SESSION['error_message'] = "Error al desvincular el asesor: " . $e->getMessage();
    }

    // Cerrar las declaraciones
    $stmt->close();
    $stmtAlumno->close();

    header('Location: dashboardAdminProyectos.php');
    exit();
}
?>
