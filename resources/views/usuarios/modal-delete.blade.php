<x-confirm-modal
    id="modalEliminarUsuario{{ $user->id }}"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar al usuario {{ $user->name }}?"
    icon="delete_forever"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-exit"
    cancelClass="btn-cancel"
    :onConfirm="'document.getElementById(\'formEliminarUsuario' . $user->id . '\').submit();'"
/>

<form id="formEliminarUsuario{{ $user->id }}" action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
