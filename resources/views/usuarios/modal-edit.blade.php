<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario{{ $user->id }}" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel{{ $user->id }}" aria-hidden="true" translate="no">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- ENCABEZADO -->
        <div class="modal-header bg-gradient-dark border-bottom border-warning">
          <h5 class="modal-title fw-bold d-flex align-items-center text-white" id="modalEditarUsuarioLabel{{ $user->id }}">
            <i class="material-icons me-2 text-white">edit</i> Editar Usuario: {{ $user->name }}
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
        </div>

        <!-- CUERPO -->
        <div class="modal-body text-start">
          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Nombre</label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">badge</i></span>
              <input type="text" name="name" class="form-control border-0" value="{{ $user->name }}" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Correo Electrónico</label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">email</i></span>
              <input type="email" name="email" class="form-control border-0" value="{{ $user->email }}" required>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-bold text-dark">Nueva Contraseña <small class="text-muted">(opcional)</small></label>
            <div class="input-group border rounded">
              <span class="input-group-text bg-light"><i class="material-icons text-secondary">lock</i></span>
              <input type="password" name="password" class="form-control border-0" placeholder="Dejar en blanco si no deseas cambiarla">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold text-dark">Asignar Rol</label>
            <div class="row">
              @foreach ($roles as $role)
              @if($role->name !== 'Superadmin')
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}"
                    {{ $user->roles->contains('name', $role->name) ? 'checked' : '' }} required>
                    <label class="form-check-label text-dark">{{ $role->name }}</label>
                  </div>
                </div>
                @endif
              @endforeach
            </div>
          </div>
        </div>

        <!-- PIE DE MODAL -->
        <div class="modal-footer border-0">
          @can('Editar usuarios')
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
