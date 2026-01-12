<!-- Modal Editar Rol -->
<div class="modal fade" id="modalEditarRol{{ $role->id }}" tabindex="-1" aria-labelledby="modalEditarRolLabel{{ $role->id }}" aria-hidden="true" translate="no">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header bg-gradient-dark border-bottom border-warning">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalEditarRolLabel{{ $role->id }}">
            <i class="material-icons me-2 text-white">edit</i> Editar Rol: {{ $role->name }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
        </div>

        <div class="modal-body text-start">
          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Nombre del Rol</label>
            <div class="input-group">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">badge</i></span>
              <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
            </div>
          </div>

          <label class="form-label fw-bold text-dark">Asignar Permisos</label>

          <x-permission-section title="Dashboard" :range="[1, 1]" :role="$role" />
          <x-permission-section title="Roles" :range="[2, 5]" :role="$role" />
          <x-permission-section title="Usuarios" :range="[6, 9]" :role="$role" />
          <x-permission-section title="Clientes" :range="[10, 13]" :role="$role" />
          <x-permission-section title="Paquetes" :range="[14, 17]" :role="$role" />
          <x-permission-section title="Ventas" :range="[18, 21]" :role="$role" />
          <x-permission-section title="Actividades/Accesos" :range="[22, 22]" :role="$role" />

        </div>

        <div class="modal-footer">
          @can('Editar roles')
          <button type="submit" class="btn btn-warning">
            <i class="material-icons align-middle">save</i> Actualizar
          </button>
          @endcan
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
