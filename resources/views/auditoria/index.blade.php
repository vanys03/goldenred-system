<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='auditoria' />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Auditoría del Sistema" />

        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Auditoria</h5>
                </div>

                  {{-- Loader --}}
                  <div id="loader-auditoria" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>


                @if ($logs->isNotEmpty())
                    <table id="tabla-auditoria" class="table align-items-center mb-0 w-100">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Fecha</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Usuario</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Acción</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="text-xs">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-xs">{{ $log->causer?->name ?? 'Sistema' }}</td>

                                    @php
                                        $modelo = match (class_basename($log->subject_type)) {
                                            'Cliente' => 'cliente',
                                            'Equipo' => 'equipo',
                                            'User' => 'usuario',
                                            'Paquete' => 'paquete',
                                            'Venta' => 'venta',
                                            default => strtolower(class_basename($log->subject_type)),
                                        };

                                        $props = $log->properties->toArray();

                                        $nombre = $props['attributes']['nombre']
                                            ?? $props['attributes']['name']
                                            ?? $props['cliente_nombre']
                                            ?? null;

                                        $acciones = [
                                            'created' => 'creó',
                                            'updated' => 'editó',
                                            'deleted' => 'eliminó',
                                        ];

                                        $accion = $acciones[$log->description] ?? $log->description;

                                        $detalle = "Se {$accion} el {$modelo}";

                                        if ($modelo === 'venta' && $props['cliente_nombre'] ?? false) {
                                            $detalle .= " para el cliente {$props['cliente_nombre']}";
                                        } elseif ($nombre) {
                                            $detalle .= ": «{$nombre}»";
                                        } elseif ($log->subject_id) {
                                            $detalle .= " (ID: {$log->subject_id})";
                                        }
                                    @endphp

                                    <td class="text-xs text-primary">{{ ucfirst($accion) }}</td>
                                    <td class="text-xs">{{ ucfirst($detalle) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-xs py-4">No hay registros de auditoría recientes.</div>
                @endif
            </div>
        </div>
    </main>
    @include('auditoria.partials.scripts')

</x-layout>
