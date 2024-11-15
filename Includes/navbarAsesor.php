<?php
// navbarAsesor.php
include_once('../../includes/config.php'); // Usamos include_once para evitar conflictos

// Obtener el ID del asesor y almacenarlo en la sesión si no está configurado
if (!isset($_SESSION['asesor_id'])) {
    $query = "SELECT ID_Asesor FROM asesor WHERE ID_Usuario = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($asesor_id);
    $stmt->fetch();
    $stmt->close();

    if ($asesor_id) {
        $_SESSION['asesor_id'] = $asesor_id;
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <a class="navbar-brand mx-5" href="../Asesor/dashboardAsesor.php">
        <img src="<?php echo IMG_PATH; ?>TESCO_TRANSPARENTE.webp" alt="Logo" style="width: 120px;">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="../Asesor/asigmentProyects.php" class="nav-link">Ver Proyectos</a>
            </li>
        </ul>

        <div class="d-flex align-items-center">
            <!-- Icono de notificaciones -->
            <div class="dropdown">
                <?php
                $query = "SELECT ID_Notificacion, Mensaje, Fecha_Notificacion, ID_Proyecto 
                          FROM notificaciones 
                          WHERE ID_Usuario = ? AND Leida = 0 ORDER BY Fecha_Notificacion DESC LIMIT 5";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $unread_count = $result->num_rows;
                ?>
                <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <?php if ($unread_count > 0): ?>
                        <span class="badge badge-danger"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                    <?php if ($unread_count > 0): ?>
                        <?php while ($notification = $result->fetch_assoc()): ?>
                            <a href="../Asesor/mark_notification_read.php?id_notificacion=<?php echo $notification['ID_Notificacion']; ?>&id_proyecto=<?php echo $notification['ID_Proyecto']; ?>" 
                               class="dropdown-item">
                                <?php echo $notification['Mensaje']; ?>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <span class="dropdown-item">No tienes notificaciones nuevas.</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="dropdown ml-3">
                <span class="navbar-text mr-3">
                    <?php echo $_SESSION['username']; ?>
                </span>
                <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fas fa-user text-white ml-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal">Cambiar
                        Contraseña</a>
                    <a class="dropdown-item" href="../public/logout.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</nav>
