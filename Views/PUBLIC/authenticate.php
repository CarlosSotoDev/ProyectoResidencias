<?php
include('../../includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['username'];
    $contrasena = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT ID_Usuario, Nombre_Usuario, Contraseña, Rol FROM usuario WHERE Nombre_Usuario = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar si el usuario tiene el rol 4 (Inactivo)
        if ($user['Rol'] == 4) {
            header("Location: login.php?error=disabled");
            exit;
        }

        // Comparar la contraseña ingresada con la almacenada en la base de datos
        if (hash('sha256', $contrasena) === $user['Contraseña']) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['Nombre_Usuario'];
            $_SESSION['user_id'] = $user['ID_Usuario'];
            $_SESSION['rol'] = $user['Rol'];

            // Verificar si es un asesor (rol 2)
            if ($_SESSION['rol'] == 2) {
                // Consulta para obtener el ID del asesor y el nombre completo asociado al ID_Usuario
                $sqlAsesor = "SELECT ID_Asesor, CONCAT(Nombres, ' ', Apellido_Paterno, ' ', Apellido_Materno) AS Nombre_Completo 
                              FROM asesor 
                              WHERE ID_Usuario = ?";
                $stmtAsesor = $connection->prepare($sqlAsesor);
                $stmtAsesor->bind_param("i", $user['ID_Usuario']);
                $stmtAsesor->execute();
                $resultAsesor = $stmtAsesor->get_result();

                // Verificar si se obtuvo el ID_Asesor y el nombre completo
                if ($resultAsesor->num_rows > 0) {
                    $asesor = $resultAsesor->fetch_assoc();
                    $_SESSION['asesor_id'] = $asesor['ID_Asesor']; // Guardar el ID del asesor en la sesión
                    $_SESSION['nombre_completo'] = $asesor['Nombre_Completo']; // Guardar el nombre completo del asesor
                } else {
                    echo "Error: No se encontró el ID del asesor en la base de datos.";
                    exit;
                }

                header("Location: ../Asesor/dashboardAsesor.php");
                exit;
            }

            // Redirigir al dashboard correspondiente según el rol
            if ($_SESSION['rol'] == 3) {
                header("Location: ../admin/dashboardAdmin.php");
                exit;
            } else if ($_SESSION['rol'] == 1) {
                header("Location: ../Student/dashboardStudent.php");
                exit;
            } else {
                header("Location: login.php");
                exit;
            }
        } else {
            header("Location: login.php?error=incorrect_password");
            exit;
        }
    } else {
        header("Location: login.php?error=user_not_found");
        exit;
    }
}
?>
