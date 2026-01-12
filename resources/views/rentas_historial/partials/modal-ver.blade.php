<!-- Modal Ver Renta (GLOBAL) -->
<div class="modal fade" id="modalVerRenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">

            <!-- ENCABEZADO -->
            <div class="modal-header bg-gradient-dark border-bottom border-warning">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center">
                    <i class="material-icons me-2 text-white">visibility</i>
                    Detalles de la Renta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    style="filter: invert(1);"></button>
            </div>

            <!-- CUERPO -->
            <div class="modal-body" id="contenido-ver-renta">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary"></div>
                </div>
            </div>

            <!-- PIE -->
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cerrar
                </button>

                <button type="button" class="btn btn-primary d-none" id="btnReimprimirTicket">
                    <i class="material-icons align-middle me-1">print</i>
                    Reimprimir Ticket
                </button>
            </div>

        </div>
    </div>
</div>
