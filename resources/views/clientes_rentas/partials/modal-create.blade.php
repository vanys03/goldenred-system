<!-- Modal Crear Cliente de Rentas -->
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-labelledby="modalCrearClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('clientes-rentas.store') }}" method="POST">
        @csrf

        <!-- ENCABEZADO -->
        <div class="modal-header bg-gradient-dark border-bottom border-warning">
          <h5 class="modal-title fw-bold text-white d-flex align-items-center" id="modalCrearClienteLabel">
            <i class="material-icons me-2 text-white">person_add</i> Nuevo Cliente de Rentas
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Nombre</label>
              <div class="position-relative">
                <input type="text" name="nombre" class="form-control ps-5 border border-secondary rounded text-dark" placeholder="Nombre completo" required>
                <i class="material-icons position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary">badge</i>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Teléfono</label>
              <div class="position-relative">
                <input type="text" name="telefono1" class="form-control ps-5 border border-secondary rounded text-dark" placeholder="Teléfono principal" required>
                <i class="material-icons position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary">call</i>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold text-dark">Dirección</label>
              <div class="position-relative">
                <textarea name="direccion" class="form-control ps-5 border border-secondary rounded text-dark" rows="3" placeholder="Dirección completa" style="resize: none;"></textarea>
                <i class="material-icons position-absolute top-0 start-0 ms-3 mt-2 text-secondary">location_on</i>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Día de pago</label>
              <div class="position-relative">
                <input type="number" name="dia_pago" class="form-control ps-5 border border-secondary rounded text-dark" min="1" max="31" placeholder="Ej. 5">
                <i class="material-icons position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary">event</i>
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Precio</label>
              <div class="position-relative">
                <input type="number" step="0.01" name="precio" class="form-control ps-5 border border-secondary rounded text-dark" placeholder="Ej. 300.00">
                <i class="material-icons position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary">attach_money</i>
              </div>
            </div>
          </div>
        </div>

        <!-- PIE -->
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-success">
            <i class="material-icons align-middle">save</i> Guardar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
