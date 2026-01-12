<!-- Modal Eliminar Venta -->
<div class="modal fade" id="modalEliminarVenta" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-5">
      
      <div class="modal-header custom-header rounded-top-3 d-flex align-items-center">
        <span class="material-icons-round custom-icon">delete_forever</span>
        <h5 class="modal-title text-white mb-0">Confirmar eliminación</h5>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body text-center">
        <p class="fs-5 fw-semibold mb-1">
          ¿Estás segura de que deseas eliminar la venta de <strong id="nombreClienteEliminar"></strong>?
        </p>
        <p class="text-secondary">Esta acción no se puede deshacer.</p>
      </div>

      <div class="modal-footer justify-content-center border-0 pb-4">
        <button type="button" class="btn btn-cancel px-4 py-2 rounded-pill me-3" data-bs-dismiss="modal">Cancelar</button>
        <form id="formEliminarVenta" method="POST" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-exit px-4 py-2 rounded-pill">Eliminar</button>
        </form>
      </div>

    </div>
  </div>
</div>
