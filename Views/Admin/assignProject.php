<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alumno_id = $_POST['alumno_id'];
    $proyecto_id = $_POST['proyecto_id'];

    // Validar que ambos valores no estén vacíos
    if (!empty($alumno_id) && !empty($proyecto_id)) {
        // Iniciar transacción
        $connection->begin_transaction();

        try {
            // 1. Actualizar el proyecto asignado al alumno
            $queryUpdateAlumno = "UPDATE alumno SET Proyecto = ?, Asesor = (SELECT Asesor FROM proyecto WHERE ID_Proyecto = ?) WHERE ID_Alumno = ?";
            $stmt = $connection->prepare($queryUpdateAlumno);
            $stmt->bind_param('iii', $proyecto_id, $proyecto_id, $alumno_id);
            $stmt->execute();

            // 2. Verificar si el proyecto tiene espacio para más integrantes
            $queryCheckIntegrantes = "SELECT Integrante_1, Integrante_2, Integrante_3 FROM proyecto WHERE ID_Proyecto = ?";
            $stmtCheck = $connection->prepare($queryCheckIntegrantes);
            $stmtCheck->bind_param('i', $proyecto_id);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();
            $row = $resultCheck->fetch_assoc();

            // 3. Asignar al alumno en uno de los campos de integrantes disponibles
            if (empty($row['Integrante_1'])) {
                $queryUpdateProyecto = "UPDATE proyecto SET Integrante_1 = ? WHERE ID_Proyecto = ?";
            } elseif (empty($row['Integrante_2'])) {
                $queryUpdateProyecto = "UPDATE proyecto SET Integrante_2 = ? WHERE ID_Proyecto = ?";
            } elseif (empty($row['Integrante_3'])) {
                $queryUpdateProyecto = "UPDATE proyecto SET Integrante_3 = ? WHERE ID_Proyecto = ?";
            } else {
                throw new Exception("El proyecto ya tiene 3 integrantes.");
            }

            $stmtUpdateProyecto = $connection->prepare($queryUpdateProyecto);
            $stmtUpdateProyecto->bind_param('ii', $alumno_id, $proyecto_id);
            $stmtUpdateProyecto->execute();

            // Si todo está bien, confirmamos la transacción
            $connection->commit();
            $_SESSION['success_message'] = "Proyecto y asesor asignados correctamente.";
        } catch (Exception $e) {
            // En caso de error, deshacer la transacción
            $connection->rollback();
            $_SESSION['error_message'] = "Error: " . $e->getMessage();
        }

        // Cerrar las conexiones
        $stmt->close();
        $stmtCheck->close();
        $stmtUpdateProyecto->close();
    } else {
        $_SESSION['error_message'] = "Debe seleccionar un alumno y un proyecto.";
    }

    // Redirigir a la página de alumnos
    header('Location: dashboardAdminAlumnos.php');
    exit();
}
?>
