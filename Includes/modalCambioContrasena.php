<!-- Modal para cambiar la contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
        aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="../Asesor/changePassword.php" method="POST">
                        <div class="form-group">
                            <label for="current_password">Contraseña Actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>