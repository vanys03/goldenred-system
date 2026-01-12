<!-- Modal Confirmación de Venta -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title text-white"><i class="material-icons me-2">receipt_long</i> Confirmar Venta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body py-4 px-4">
                <div class="mb-3">
                    <h6 class="text-muted">Resumen de la Venta</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Cliente:</strong></span>
                            <span id="resumen_cliente" class="fw-bold text-primary"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Paquete:</strong></span>
                            <span id="resumen_paquete"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Meses:</strong></span>
                            <span id="resumen_meses"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Descuento:</strong></span>
                            <span>$<span id="resumen_descuento"></span></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Tipo de pago:</strong></span>
                            <span id="resumen_tipo_pago"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Recargo Domicilio:</strong></span>
                            <span>$<span id="resumen_recargo_domicilio"></span></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><strong>Recargo Falta Pago:</strong></span>
                            <span>$<span id="resumen_recargo_falta_pago"></span></span>
                        </li>
                    </ul>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center fs-5">
                        <strong class="text-dark">Total:</strong>
                        <span class="fw-bold text-success">$<span id="resumen_total"></span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="material-icons me-1">cancel</i> Cancelar
                </button>
                <button type="button" id="btnEnviarFormulario" class="btn btn-success">
                    <i class="material-icons me-1">check_circle</i> Confirmar
                </button>
            </div>
        </div>
    </div>
</div>
