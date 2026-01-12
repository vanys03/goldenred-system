<x-confirm-modal
    id="modalEliminarPlatform{{ $platform->id }}"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar la plataforma {{ $platform->name }}? Se eliminarán todas las cuentas asociadas."
    icon="delete_forever"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-exit"
    cancelClass="btn-cancel"
    :onConfirm="'document.getElementById(\'formEliminarPlatform' . $platform->id . '\').submit();'"
/>

<form id="formEliminarPlatform{{ $platform->id }}" action="{{ route('platforms.destroy', $platform->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
