<form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
  @csrf
  @method('PUT')

  <!-- ENCABEZADO -->
  <div class="modal-header bg-gradient-dark border-bottom border-warning" translate="no">
    <h5 class="modal-title fw-bold d-flex align-items-center text-white">
      <i class="material-icons me-2 text-white">edit</i> Editar Cliente: {{ $cliente->nombre }}
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
      style="filter: invert(1);"></button>
  </div>

  <!-- CUERPO -->
  <div class="modal-body text-start" translate="no">
    <div class="modal-body text-start">
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Nombre</label>
          <input type="text" name="nombre" class="form-control border" value="{{ $cliente->nombre }}" required>
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Teléfono 1</label>
          <input type="text" name="telefono1" class="form-control border" value="{{ $cliente->telefono1 }}">
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Teléfono 2</label>
          <input type="text" name="telefono2" class="form-control border" value="{{ $cliente->telefono2 }}">
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Fecha de contrato</label>
          <input type="date" name="fecha_contrato" class="form-control border"
            value="{{ $cliente->fecha_contrato->format('Y-m-d') }}" readonly>
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Día de cobro</label>
          <input type="number" name="dia_cobro" class="form-control border" min="1" max="31"
            value="{{ $cliente->dia_cobro }}" required>
        </div>
        
        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Tipo de Cliente</label>
          <select name="tipo" class="form-select border" required>
            <option value="A" {{ $cliente->tipo == 'A' ? 'selected' : '' }}>Tipo A</option>
            <option value="B" {{ $cliente->tipo == 'B' ? 'selected' : '' }}>Tipo B</option>
            <option value="C" {{ $cliente->tipo == 'C' ? 'selected' : '' }}>Tipo C</option>
          </select>
        </div>


        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Paquete</label>
          <select name="paquete_id" class="form-select border" required>
            <option value="">-- Selecciona un paquete --</option>
            @foreach($paquetes as $paquete)
              <option value="{{ $paquete->id }}" {{ $cliente->paquete_id == $paquete->id ? 'selected' : '' }}>
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


        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Dirección MAC</label>
          <input type="text" name="Mac" class="form-control border" value="{{ $cliente->Mac }}">
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Dirección IP</label>
          <input type="text" name="IP" class="form-control border" value="{{ $cliente->IP }}">
        </div>

        <!-- Zona -->
        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Zona</label>
          <input type="text" name="zona" class="form-control border" value="{{ $cliente->zona }}">
        </div>


        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Dirección</label>
          <textarea name="direccion" class="form-control border" rows="2">{{ $cliente->direccion }}</textarea>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold text-dark">Coordenadas</label>
          <input type="text" name="coordenadas" class="form-control border" value="{{ $cliente->coordenadas }}">
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label fw-bold text-dark">Referencias</label>
          <textarea name="referencias" class="form-control border" rows="2">{{ $cliente->referencias }}</textarea>
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label fw-bold text-dark">Estado</label>
          <select name="activo" class="form-select border">
            <option value="1" {{ $cliente->activo ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ !$cliente->activo ? 'selected' : '' }}>Inactivo</option>
          </select>
        </div>





      </div>
    </div>

    <!-- Apartado desplegable -->
    <details class="mb-3">
      <summary class="fw-bold text-dark">Información del equipo</summary>
      <div class="mt-3">
        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-dark">Marca Antena</label>
            <input type="text" name="equipo[marca_antena]" class="form-control border"
              value="{{ $cliente->equipos->first()->marca_antena ?? '' }}">
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-dark">Modelo Antena</label>
            <input type="text" name="equipo[modelo_antena]" class="form-control border"
              value="{{ $cliente->equipos->first()->modelo_antena ?? '' }}">
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-dark">Número de Serie Antena</label>
            <input type="text" name="equipo[numero_serie_antena]" class="form-control border"
              value="{{ $cliente->equipos->first()->numero_serie_antena ?? '' }}">
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-dark">Marca Router</label>
            <input type="text" name="equipo[marca_router]" class="form-control border"
              value="{{ $cliente->equipos->first()->marca_router ?? '' }}">
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-dark">Modelo Router</label>
            <input type="text" name="equipo[modelo_router]" class="form-control border"
              value="{{ $cliente->equipos->first()->modelo_router ?? '' }}">
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label fw-bold text-dark">Número de Serie Router</label>
            <input type="text" name="equipo[numero_serie_router]" class="form-control border"
              value="{{ $cliente->equipos->first()->numero_serie_router ?? '' }}">
          </div>
        </div>
      </div>
    </details>

  </div>
  <!-- PIE DE MODAL -->
  <div class="modal-footer border-0" translate="no">
    @can('Editar clientes')
      <button type="submit" class="btn btn-warning">
        <i class="material-icons align-middle">save</i> Actualizar
      </button>
    @endcan
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  </div>
</form>