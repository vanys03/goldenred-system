<x-confirm-modal
    id="modalEliminarRenta"
    title="Confirmar eliminación"
    message="¿Estás seguro de que deseas eliminar esta renta?"
    icon="delete_forever"
    confirmText="Eliminar"
    cancelText="Cancelar"
    confirmClass="btn-exit"
    cancelClass="btn-cancel"
    :onConfirm="'document.getElementById(\'formEliminarRenta\').submit();'"
/>

<form id="formEliminarRenta" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
