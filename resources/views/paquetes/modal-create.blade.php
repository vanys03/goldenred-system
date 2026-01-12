<!-- Modal Crear Paquete -->
<div class="modal fade" id="modalCrearPaquete" tabindex="-1" aria-labelledby="modalCrearPaqueteLabel"
    aria-hidden="true" translate="no">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('paquetes.store') }}" method="POST">
                @csrf

                {{-- ENCABEZADO --}}
                <div class="modal-header bg-gradient-dark border-bottom border-primary">
                    <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalCrearPaqueteLabel">
                        <i class="material-icons me-2 text-white">inventory_2</i> Crear Nuevo Paquete
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
                        style="filter: invert(1);"></button>
                </div>

                {{-- CUERPO --}}
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Nombre del paquete</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text bg-light"><i class="material-icons text-secondary">label</i></span>
                            <input type="text" name="nombre" class="form-control border-0" placeholder="Ej. Básico, Premium" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Precio</label>
                        <div class="input-group border rounded">
                            <span class="input-group-text bg-light"><i class="material-icons text-secondary">attach_money</i></span>
                            <input type="number" name="precio" class="form-control border-0" placeholder="Ej. 299.99" min="0" step="0.01" required>
                        </div>
                    </div>
                </div>

                {{-- PIE --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Paquete</button>
                </div>
            </form>
        </div>
    </div>
</div>
