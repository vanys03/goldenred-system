<x-confirm-modal
    id="modalEliminarRol{{ $role->id }}"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar el rol {{ $role->name }}?"
    icon="delete"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-exit"
    cancelClass="btn-cancel"
    :onConfirm="'document.getElementById(\'formEliminarRol' . $role->id . '\').submit();'"
/>

<form id="formEliminarRol{{ $role->id }}" action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>