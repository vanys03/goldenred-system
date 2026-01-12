@props(['activePage'])

@php
    $permisosUsuarios = ['Ver usuarios', 'Ver roles', 'Ver actividades', 'Ver auditoria'];
    $tienePermiso = false;
    foreach ($permisosUsuarios as $permiso) {
        if (auth()->user()->can($permiso)) {
            $tienePermiso = true;
            break;
        }
    }
@endphp

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main" translate="no">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('alt-dashboard') }} ">
            <img src="{{ asset('assets') }}/img/golden.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">GOLDEN RED</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div id="sidenav-collapse-main">
        <ul class="navbar-nav">

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Páginas</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'alt-dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('alt-dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Inicio</span>
                </a>
            </li>

            @if($tienePermiso)
                <li class="nav-item">
                    <a class="nav-link text-white {{ in_array($activePage, ['usuarios', 'actividades', 'roles', 'auditoria']) ? 'active bg-gradient-primary' : '' }}"
                        data-bs-toggle="collapse" href="#usuariosSubmenu" role="button" aria-expanded="false"
                        aria-controls="usuariosSubmenu">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                    <div class="collapse {{ in_array($activePage, ['usuarios', 'actividades', 'roles', 'auditoria']) ? 'show' : '' }}"
                        id="usuariosSubmenu">
                        <ul class="nav ms-4 flex-column">
                            @can('Ver usuarios')
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ $activePage == 'usuarios' ? 'active' : '' }}"
                                        href="{{ route('usuarios.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons opacity-10 me-2">person</i>
                                            <span class="nav-link-text">Ver usuarios</span>
                                        </div>
                                    </a>
                                </li>
                            @endcan
                            @can('Ver roles')
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ $activePage == 'roles' ? 'active' : '' }}"
                                        href="{{ route('roles.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons opacity-10 me-2">admin_panel_settings</i>
                                            <span class="nav-link-text">Ver Roles</span>
                                        </div>
                                    </a>
                                </li>
                            @endcan
                            @can('Ver actividades')
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ $activePage == 'actividades' ? 'active' : '' }}"
                                        href="{{ route('actividades.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons opacity-10 me-2">history</i>
                                            <span class="nav-link-text">Ver accesos</span>
                                        </div>
                                    </a>
                                </li>
                            @endcan
                            @can('Ver auditoria')
                                <li class="nav-item">
                                    <a class="nav-link text-white {{ $activePage == 'auditoria' ? 'active' : '' }}"
                                        href="{{ route('auditoria.index') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="material-icons opacity-10 me-2">history</i>
                                            <span class="nav-link-text">Ver auditoria</span>
                                        </div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endif

            @can('Ver clientes')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'clientes' ? ' active bg-gradient-primary' : '' }}"
                        href="{{ route('clientes.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Clientes</span>
                    </a>
                </li>
            @endcan

            @can('Ver paquetes')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'paquetes' ? ' active bg-gradient-primary' : '' }}"
                        href="{{ route('paquetes.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Paquetes</span>
                    </a>
                </li>
            @endcan

            @can('Ver ventas')
                <li class="nav-item">
                    <a class="nav-link text-white {{ in_array($activePage, ['ventas', 'ventas_historial', 'ventas_corte']) ? 'active bg-gradient-primary' : '' }}"
                        data-bs-toggle="collapse" href="#ventasSubmenu" role="button" aria-expanded="false"
                        aria-controls="ventasSubmenu">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <span class="nav-link-text ms-1">Ventas</span>
                    </a>
                    <div class="collapse {{ in_array($activePage, ['ventas', 'ventas_historial', 'ventas_corte']) ? 'show' : '' }}"
                        id="ventasSubmenu">
                        <ul class="nav ms-4 flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'ventas' ? 'active' : '' }}"
                                    href="{{ route('ventas.index') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons opacity-10 me-2">add_shopping_cart</i>
                                        <span class="nav-link-text">Venta</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'ventas_historial' ? 'active' : '' }}"
                                    href="{{ route('ventas.historial') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons opacity-10 me-2">history</i>
                                        <span class="nav-link-text">Historial</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'ventas_corte' ? 'active' : '' }}"
                                    href="{{ route('ventas.corte') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="material-icons opacity-10 me-2">attach_money</i>
                                        <span class="nav-link-text">Corte</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'telefonos' ? ' active bg-gradient-primary' : '' }}"
                    href="{{ route('telefonos.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">phone</i> {{-- También puedes usar "call" --}}
                    </div>
                    <span class="nav-link-text ms-1">Teléfonos</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['platforms', 'platforms_historial']) ? 'active bg-gradient-primary' : '' }}"
                    data-bs-toggle="collapse" href="#platformsSubmenu" role="button" aria-expanded="false"
                    aria-controls="platformsSubmenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Plataforma</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['platforms', 'platforms_historial']) ? 'show' : '' }}"
                    id="platformsSubmenu">
                    <ul class="nav ms-4 flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'platforms' ? 'active' : '' }}"
                                href="{{ route('platforms.index') }}">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons opacity-10 me-2">list</i>
                                    <span class="nav-link-text">Plataformas</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'platforms_historial' ? 'active' : '' }}"
                                href="{{ route('plataformas_historial.index') }}">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons opacity-10 me-2">history</i>
                                    <span class="nav-link-text">Historial</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['rentas', 'rentas_historial', 'clientes_rentas']) ? 'active bg-gradient-primary' : '' }}"
                    data-bs-toggle="collapse" href="#rentasSubmenu" role="button" aria-expanded="false"
                    aria-controls="rentasSubmenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">key</i>
                    </div>
                    <span class="nav-link-text ms-1">Rentas</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['rentas', 'rentas_historial', 'clientes_rentas']) ? 'show' : '' }}"
                    id="rentasSubmenu">
                    <ul class="nav ms-4 flex-column">

                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'clientes_rentas' ? 'active' : '' }}"
                                href="{{ route('clientes-rentas.index') }}">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons opacity-10 me-2">people</i>
                                    <span class="nav-link-text">Clientes</span>
                                </div>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'rentas' ? 'active' : '' }}"
                                href="{{ route('rentas.index') }}">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons opacity-10 me-2">receipt_long</i>
                                    <span class="nav-link-text">Rentas</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'rentas_historial' ? 'active' : '' }}"
                                href="{{ route('rentas_historial.index') }}">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons opacity-10 me-2">history</i>
                                    <span class="nav-link-text">Historial</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>

</aside>