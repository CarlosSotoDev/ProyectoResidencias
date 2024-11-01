<?php
include('../../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del jefe de carrera
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $carrera = $_POST['carrera'];

    // Datos del usuario
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password']; // Contraseña en texto plano, se encriptará en la base de datos mediante el trigger
    $rol = 5; // Rol por defecto para jefes de carrera

    // Iniciar una transacción para asegurar la consistencia
    $connection->begin_transaction();

    try {
        // Verificar el ID del jefe, asegurarse de que el ID sea mayor o igual a 3000
        $resultLastID = $connection->query("SELECT MAX(ID_Administrador) AS last_id FROM administrador");
        $rowLastID = $resultLastID->fetch_assoc();
        $nextID = isset($rowLastID['last_id']) ? max($rowLastID['last_id'] + 1, 3000) : 3000;

        // Insertar en la tabla administrador
        $sqlJefe = "INSERT INTO administrador (ID_Administrador, Nombres, Apellido_Paterno, Apellido_Materno, Carrera, Rol, ID_Usuario) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtJefe = $connection->prepare($sqlJefe);
        $stmtJefe->bind_param("isssiii", $nextID, $nombres, $apellido_paterno, $apellido_materno, $carrera, $rol, $nextID);
        $stmtJefe->execute();

        // Insertar en la tabla usuario con id_usuario igual a id_administrador
        $sqlUsuario = "INSERT INTO usuario (ID_Usuario, Nombre_Usuario, Contraseña, Rol) VALUES (?, ?, ?, ?)";
        $stmtUsuario = $connection->prepare($sqlUsuario);
        $stmtUsuario->bind_param("issi", $nextID, $nombre_usuario, $contrasena, $rol);
        $stmtUsuario->execute();

        // Confirmar la transacción
        $connection->commit();
        header("Location: dashboardAdminJefes.php?message=Jefe de carrera y usuario creados correctamente");

    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $connection->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Cerrar las declaraciones
    $stmtJefe->close();
    $stmtUsuario->close();
}
?>
