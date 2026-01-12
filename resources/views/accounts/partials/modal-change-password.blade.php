<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-elegant">
            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title modal-title-elegant" id="changePasswordModalLabel">
                    <i class="material-icons me-2 text-primary">vpn_key</i>
                    Cambiar Contraseña Principal
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Formulario dinámico -->
                <form id="changePasswordForm" method="POST">
                    @csrf
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="newPassword" required>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" name="newPassword_confirmation" required>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="changePasswordForm"
                    class="btn btn-info elegant-password-button w-50">
                    Actualizar Contraseña
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('changePasswordModal')
    .addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget; // botón que abrió la modal
        const accountId = button.getAttribute('data-account-id');
        const form = document.getElementById('changePasswordForm');

        console.log("ABRIENDO MODAL — ID:", accountId);

        if (accountId) {
            form.action = `/accounts/${accountId}/change-password`;
        }
    });
</script>

