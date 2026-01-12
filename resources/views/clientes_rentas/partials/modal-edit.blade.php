<!-- Modal Editar Cliente de Rentas -->
<div class="modal fade" id="modalEditarCliente{{ $cliente->id }}" tabindex="-1"
  aria-labelledby="modalEditarClienteLabel{{ $cliente->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('clientes-rentas.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- ENCABEZADO -->
        <div class="modal-header bg-gradient-dark border-bottom border-warning">
          <h5 class="modal-title fw-bold text-white d-flex align-items-center"
            id="modalEditarClienteLabel{{ $cliente->id }}">
            <i class="material-icons me-2 text-white">edit</i> Editar Cliente: {{ $cliente->nombre }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
            style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Nombre</label>
              <div class="position-relative">
                <input type="text" name="nombre" class="form-control ps-5" value="{{ $cliente->nombre }}" required>
                <i
                  class="material-icons position-absolute top-50 start-0 translate-middle-y ms-3 text-secondary">badge</i>
              </div>

            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Teléfono</label>
              <div class="input-group border rounded">
                <span class="input-group-text bg-light"><i class="material-icons text-secondary">call</i></span>
                <input type="text" name="telefono1" class="form-control border-0" value="{{ $cliente->telefono1 }}"
                  required>
              </div>
            </div>

            <div class="col-12">
              <label class="form-label fw-bold text-dark">Dirección</label>
              <div class="input-group border rounded">
                <span class="input-group-text bg-light"><i class="material-icons text-secondary">location_on</i></span>
                <textarea name="direccion" class="form-control border-0" rows="3"
                  style="resize: none;">{{ $cliente->direccion }}</textarea>
              </div>
            </div>


            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Día de pago</label>
              <div class="input-group border rounded">
                <span class="input-group-text bg-light"><i class="material-icons text-secondary">event</i></span>
                <input type="number" name="dia_pago" class="form-control border-0" value="{{ $cliente->dia_pago }}"
                  min="1" max="31">
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold text-dark">Precio</label>
              <div class="input-group border rounded">
                <span class="input-group-text bg-light"><i class="material-icons text-secondary">attach_money</i></span>
                <input type="number" step="0.01" name="precio" class="form-control border-0"
                  value="{{ $cliente->precio }}">
              </div>
            </div>
          </div>
        </div>

        <!-- PIE -->
        <div class="modal-footer border-0">
          <button type="submit" class="btn btn-warning">
            <i class="material-icons align-middle">save</i> Actualizar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>