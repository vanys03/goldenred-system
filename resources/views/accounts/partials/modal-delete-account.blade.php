<x-confirm-modal
    id="modalEliminarAccount{{ $account->id }}"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar la cuenta {{ $account->email }} de la plataforma {{ $account->platform->name }}?"
    icon="delete_forever"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-exit"
    cancelClass="btn-cancel"
    :onConfirm="'document.getElementById(\'formEliminarAccount' . $account->id . '\').submit();'"
/>

<form id="formEliminarAccount{{ $account->id }}" action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
