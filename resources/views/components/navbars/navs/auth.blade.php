@props(['titlePage'])

<nav class="navbar navbar-main navbar-expand-lg bg-white my-3 px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true" translate="no">

    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Páginas</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $titlePage }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $titlePage }}</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="font-medium text-sm text-gray-800 d-none d-md-block">
                    <strong>{{ Auth::user()->name }}</strong>
                </div>
            </div>

            <!-- Formulario logout oculto -->
            <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                @csrf
            </form>

            <ul class="navbar-nav justify-content-end align-items-center">
                <li class="nav-item d-flex align-items-center">
                    <!-- Botón que abre el modal -->
                    <a href="javascript:;" 
                        class="nav-link text-body font-weight-bold px-0"
                        data-bs-toggle="modal"
                        data-bs-target="#modalConfirmLogout">

                        <!-- Ícono Material Icons -->
                        <span class="material-icons-round me-sm-1" style="vertical-align: middle;">
                            logout
                        </span>

                        <!-- Texto solo en xs y sm -->
                        <span class="d-inline d-md-none">Salir</span>

                        <!-- Texto u oculto en md+ -->
                        <span class="d-none d-md-inline">Salir</span>
                    </a>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Modal de Confirmación de Logout -->
<x-confirm-modal
    id="modalConfirmLogout"
    title="Confirmar salida"
    title2="¿Estás seguro que deseas cerrar sesión?"
    message="Esta acción te desconectará inmediatamente del sistema."
    icon="logout"
    confirmText="Sí, salir"
    cancelText="Cancelar"
    onConfirm="document.getElementById('logout-form').submit();"
/>