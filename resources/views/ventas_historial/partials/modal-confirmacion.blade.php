<div class="modal fade" id="modalDetalleVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-gradient-primary text-white rounded-top-4">
                <h5 class="modal-title text-white">
                    <i class="material-icons me-2">receipt_long</i> Detalle de Venta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body py-4 px-4">
                <div class="mb-3">
                    <h6 class="text-muted">Resumen de la Venta</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><strong>Cliente:</strong> <span id="detalle_cliente"></span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Paquete:</strong> <span id="detalle_paquete"></span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Meses:</strong> <span id="detalle_meses"></span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Descuento:</strong> <span id="detalle_descuento"></span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Recargo Domicilio:</strong> <span id="detalle_recargo_domicilio"></span></li>
                        <li class="list-group-item d-flex justify-content-between"><strong>Recargo </strong><span id="detalle_recargo_atraso"></span></li>
                    </ul>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between fs-5">
                        <strong>Total:</strong> <span class="text-success fw-bold" id="detalle_total"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="material-icons me-1">cancel</i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" id="btnReimprimirTicket">
                    <i class="material-icons me-1">print</i> Reimprimir Ticket
                </button>
            </div>
        </div>
    </div>
</div>
