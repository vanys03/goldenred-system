<!-- Modal Crear Cliente -->
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-labelledby="modalCrearClienteLabel" aria-hidden="true"
  translate="no">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('clientes.store') }}" method="POST">
        @csrf

        {{-- ENCABEZADO --}}
        <div class="modal-header bg-gradient-dark border-bottom border-primary">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalCrearClienteLabel">
            <i class="material-icons me-2 text-white">person_add</i> Crear Nuevo Cliente
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
            style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body">
          <div class="row">
            {{-- Nombre --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Nombre</label>
              <input type="text" name="nombre" class="form-control border" placeholder="Ej. Ana Martínez" required>
            </div>

            {{-- Teléfono 1 --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Teléfono 1</label>
              <input type="text" name="telefono1" class="form-control border" placeholder="Ej. 5551234567">
            </div>

            {{-- Teléfono 2 --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Teléfono 2</label>
              <input type="text" name="telefono2" class="form-control border" placeholder="Opcional">
            </div>

            {{-- Fecha contrato (automática) --}}
            <input type="hidden" name="fecha_contrato" value="{{ now()->toDateString() }}">

            {{-- Día de cobro --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Día de cobro</label>
              <input type="number" name="dia_cobro" class="form-control border" min="1" max="31" placeholder="Ej. 15"
                required>
            </div>

            {{-- Paquete --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Paquete</label>
              <select name="paquete_id" class="form-select border" required>
                <option value="">-- Selecciona un paquete --</option>
                @foreach($paquetes as $paquete)
          <option value="{{ $paquete->id }}">
            {{ $paquete->nombre }} - ${{ number_format($paquete->precio, 2) }}
          </option>
        @endforeach
              </select>

            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Torre</label>
              <input type="text" name="torre" class="form-control border" value="{{ $cliente->torre }}">
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Panel</label>
              <input type="text" name="panel" class="form-control border" value="{{ $cliente->panel }}">
            </div>


            {{-- Dirección MAC --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Dirección MAC</label>
              <input type="text" name="Mac" class="form-control border" placeholder="Ej. A1:B2:C3:D4:E5:F6">
            </div>

            {{-- IP --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Dirección IP</label>
              <input type="text" name="IP" class="form-control border" placeholder="Ej. 192.168.1.1">
            </div>

            {{-- Dirección --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Dirección</label>
              <input type="text" name="direccion" class="form-control border"
                placeholder="Ej. Calle 123, Colonia Centro">
            </div>

            {{-- Coordenadas --}}
            <div class="col-md-4 mb-3">
              <label class="form-label fw-bold text-dark">Coordenadas</label>
              <input type="text" name="coordenadas" class="form-control border" placeholder="Ej. 19.4326,-99.1332">
            </div>

            {{-- Referencias --}}
            <div class="col-md-12 mb-3">
              <label class="form-label fw-bold text-dark">Referencias</label>
              <textarea name="referencias" class="form-control border" rows="2"
                placeholder="Casa azul frente a la tienda."></textarea>
            </div>
          </div>
        </div>


        {{-- PIE DE MODAL --}}
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