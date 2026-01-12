<!-- Modal Exportar Ventas -->
<div class="modal fade" id="modalExportarVentas" tabindex="-1" aria-labelledby="modalExportarVentasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('ventas.exportar') }}" method="GET" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExportarVentasLabel">Exportar Ventas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="fecha_inicio" class="form-label">Desde:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="fecha_fin" class="form-label">Hasta:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Atajo rápido:</label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="seleccionarHoy()">Hoy</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="seleccionarSemana()">Esta semana</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="seleccionarMes()">Este mes</button>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Exportar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>
