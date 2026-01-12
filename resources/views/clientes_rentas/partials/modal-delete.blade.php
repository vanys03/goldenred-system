<x-confirm-modal
    id="modalEliminarCliente{{ $cliente->id }}"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar al cliente {{ $cliente->nombre }}?"
    icon="delete_forever"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-danger"
    cancelClass="btn-secondary"
    :onConfirm="'document.getElementById(\'formEliminarCliente' . $cliente->id . '\').submit();'"
/>

<form id="formEliminarCliente{{ $cliente->id }}" action="{{ route('clientes-rentas.destroy', $cliente->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
