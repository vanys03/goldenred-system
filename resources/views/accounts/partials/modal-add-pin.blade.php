<div class="modal fade" id="addPinModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-elegant">

            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title">
                    <i class="material-icons me-2 text-warning">pin</i>
                    Agregar / Editar PIN
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="addPinForm">
                @csrf
                @method('PATCH')

                <input type="hidden" name="profile_id" id="pinProfileId">

                <div class="modal-body">
                    <div class="input-group input-group-outline">
                        <label class="form-label">PIN del perfil</label>
                        <input
                            type="text"
                            name="notes"
                            class="form-control"
                            inputmode="numeric"
                            maxlength="6"
                            pattern="[0-9]{3,6}"
                            required
                        >
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning w-50">
                        Guardar PIN
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
