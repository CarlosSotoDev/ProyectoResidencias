<?php
include('../../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del asesor
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $carrera = $_POST['carrera'];
    $proyecto = !empty($_POST['proyecto']) ? $_POST['proyecto'] : NULL;

    // Datos del usuario
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password']; // Contraseña en texto plano, se encriptará en la base de datos mediante el trigger
    $rol = 2; // Rol por defecto para asesores

    // Iniciar una transacción para asegurar la consistencia
    $connection->begin_transaction();

    try {
        // Verificar el ID del asesor, asegurarse de que el ID del asesor sea mayor o igual a 100
        $resultLastID = $connection->query("SELECT MAX(ID_Asesor) AS last_id FROM asesor");
        $rowLastID = $resultLastID->fetch_assoc();
        $nextID = isset($rowLastID['last_id']) ? max($rowLastID['last_id'] + 1, 100) : 100;

        // Insertar en la tabla asesor
        $sqlAsesor = "INSERT INTO asesor (ID_Asesor, Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Proyecto_Asignado, Rol, ID_Usuario) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAsesor = $connection->prepare($sqlAsesor);
        $stmtAsesor->bind_param("isssiiii", $nextID, $nombres, $apellido_paterno, $apellido_materno, $carrera, $proyecto, $rol, $nextID);
        $stmtAsesor->execute();

        // Insertar en la tabla usuario con id_usuario igual a id_asesor
        $sqlUsuario = "INSERT INTO usuario (id_usuario, Nombre_Usuario, Contraseña, Rol) VALUES (?, ?, ?, ?)";
        $stmtUsuario = $connection->prepare($sqlUsuario);
        $stmtUsuario->bind_param("issi", $nextID, $nombre_usuario, $contrasena, $rol);
        $stmtUsuario->execute();

        // Si el asesor tiene un proyecto asignado, actualizar el proyecto con el ID del asesor
        if (!empty($proyecto)) {
            $sqlUpdateProyecto = "UPDATE proyecto SET Asesor = ? WHERE ID_Proyecto = ?";
            $stmtProyecto = $connection->prepare($sqlUpdateProyecto);
            $stmtProyecto->bind_param("ii", $nextID, $proyecto);
            $stmtProyecto->execute();
        }

        // Confirmar la transacción
        $connection->commit();
        header("Location: dashboardAdminAsesor.php?message=Asesor y usuario creados correctamente");

    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $connection->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Cerrar las declaraciones
    $stmtAsesor->close();
    $stmtUsuario->close();
    if (isset($stmtProyecto)) {
        $stmtProyecto->close();
    }
}
?>
