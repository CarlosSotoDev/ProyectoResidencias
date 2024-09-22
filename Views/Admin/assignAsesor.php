<?php
include('../../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asesor_id = $_POST['asesor_id'];
    $proyecto_id = $_POST['proyecto_id'];

    // Iniciar transacción
    $connection->begin_transaction();

    try {
        // Asignar el asesor existente al proyecto
        $sqlUpdateProyecto = "UPDATE proyecto SET Asesor = ? WHERE ID_Proyecto = ?";
        $stmtProyecto = $connection->prepare($sqlUpdateProyecto);
        $stmtProyecto->bind_param("ii", $asesor_id, $proyecto_id);
        $stmtProyecto->execute();

        // Confirmar la transacción
        $connection->commit();
        header("Location: dashboardAdminAsesor.php?success=Asesor asignado correctamente");
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $connection->rollback();
        echo "Error al asignar el asesor: " . $e->getMessage();
    }

    // Cerrar la declaración
    $stmtProyecto->close();
}
?>
