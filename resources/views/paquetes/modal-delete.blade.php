<x-confirm-modal
    id="modalEliminarPaquete{{ $paquete->id }}"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar el paquete {{ $paquete->nombre }}?"
    icon="delete_forever"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-exit"
    cancelClass="btn-cancel"
    :onConfirm="'document.getElementById(\'formEliminarPaquete' . $paquete->id . '\').submit();'"
/>

<form id="formEliminarPaquete{{ $paquete->id }}" action="{{ route('paquetes.destroy', $paquete->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
