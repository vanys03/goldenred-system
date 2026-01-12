<div class="modal fade" id="modalCrearRol" tabindex="-1" aria-labelledby="modalCrearRolLabel" aria-hidden="true"
  translate="no">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        {{-- ENCABEZADO --}}
        <div class="modal-header bg-gradient-dark border-bottom border-primary">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalCrearRolLabel">
            <i class="material-icons me-2 text-white">admin_panel_settings</i> Crear Nuevo Rol
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"
            style="filter: invert(1);"></button>
        </div>

        <div class="modal-body">
          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Nombre del Rol</label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">badge</i></span>
              <input type="text" name="name" class="form-control" placeholder="Ej. Administrador" required>
            </div>
          </div>

          <label class="form-label fw-bold text-dark">Asignar Permisos</label>
          <x-permission-section title="Dashboard" :range="[1, 1]" />
          <x-permission-section title="Roles" :range="[2, 5]" />
          <x-permission-section title="Usuarios" :range="[6, 9]" />
          <x-permission-section title="Clientes" :range="[10, 13]" />
          <x-permission-section title="Paquetes" :range="[14, 17]" />
          <x-permission-section title="Ventas" :range="[18, 21]" />
          <x-permission-section title="Actividades/Accesos" :range="[22, 22]" />
          

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="material-icons align-middle">save</i> Guardar
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>