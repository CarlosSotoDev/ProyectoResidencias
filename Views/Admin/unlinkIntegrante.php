<?php
include('../../includes/config.php');
checkLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_proyecto = $_POST['id_proyecto'];
    $integrante = $_POST['integrante'];

    // Primero, obtener el ID del alumno que va a ser desvinculado
    $queryGetAlumno = "SELECT $integrante FROM proyecto WHERE ID_Proyecto = ?";
    $stmtGetAlumno = $connection->prepare($queryGetAlumno);
    $stmtGetAlumno->bind_param('i', $id_proyecto);
    $stmtGetAlumno->execute();
    $resultGetAlumno = $stmtGetAlumno->get_result();
    $row = $resultGetAlumno->fetch_assoc();
    $id_alumno = $row[$integrante];

    // Actualizar el campo del integrante en la tabla proyecto a NULL
    $queryUnlinkIntegrante = "UPDATE proyecto SET $integrante = NULL WHERE ID_Proyecto = ?";
    $stmtUnlink = $connection->prepare($queryUnlinkIntegrante);
    $stmtUnlink->bind_param('i', $id_proyecto);
    
    if ($stmtUnlink->execute()) {
        // Si se desvinculó correctamente, también actualizar el campo Proyecto en la tabla alumno
        if ($id_alumno) {
            $alumnoQuery = "UPDATE alumno SET Proyecto = NULL WHERE ID_Alumno = ?";
            $alumnoStmt = $connection->prepare($alumnoQuery);
            $alumnoStmt->bind_param('i', $id_alumno);
            $alumnoStmt->execute();
            $alumnoStmt->close();
        }
        $_SESSION['success_message'] = "Integrante desvinculado correctamente.";
    } else {
        $_SESSION['error_message'] = "Error al desvincular el integrante.";
    }
    
    $stmtUnlink->close();
    header('Location: dashboardAdminProyectos.php');
    exit();
}
?>
