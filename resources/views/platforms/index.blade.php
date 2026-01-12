<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='platforms' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Plataformas" />
        <!-- End Navbar -->
        <div class="card m-4">
            <div class="d-flex platform-grid">
                @foreach($platforms as $platform)
                    <div class="platform-card position-relative">
                        <button type="button" class="delete-platform-btn material-icons" title="Eliminar plataforma"
                            data-bs-toggle="modal" data-bs-target="#modalEliminarPlatform{{ $platform->id }}">
                            delete_forever
                        </button>

                        <a href="{{ route('platforms.accounts', $platform) }}" class="card-link">
                            <div class="card-body text-center d-flex align-items-center justify-content-center flex-column">
                                <i class="material-icons text-lg mb-2">laptop_mac</i>
                                <h5 class="mb-0">{{ $platform->name }}</h5>
                                <small>{{ $platform->accounts_count }} cuentas</small>
                            </div>
                        </a>
                    </div>
                    @include('platforms.partials.modal-delete', ['platform' => $platform])
                @endforeach

                <a href="#" class="platform-card card-link add-new" id="openAddPlatformModal">
                    <div class="card-body text-center d-flex align-items-center justify-content-center flex-column">
                        <i class="material-icons text-lg mb-2">add</i>
                        <h5 class="mb-0">Agregar plataforma</h5>
                    </div>
                </a>
            </div>
            <div id="addPlatformModal" class="modal-elegant-overlay">
                <div class="modal-elegant-content">

                    <button type="button" class="close-button-elegant material-icons" id="closeModalButton">
                        close
                    </button>
                    <div class="modal-elegant-body">
                        <form action="{{ route('platforms.store') }}" method="POST">
                            @csrf
                            <div class="form-group-elegant">
                                <label for="platformName" class="form-label-elegant">Nombre</label>
                                <input type="text" class="form-control-elegant" id="platformName" name="name"
                                    placeholder="Nombre de la plataforma" required>
                            </div>
                            <button type="submit"
                                class="btn btn-success btn-block mt-4 elegant-submit-button">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('platforms.partials.style')
        @include('platforms.partials.scripts')
        <div class="card m-4">
            <div class="table-responsive p-3">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Perfiles Ocupados</h5>
                </div>

                <table id="tabla-perfiles" class="table align-items-center mb-0 w-100">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Plataforma</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Cuenta</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Perfil</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Cliente</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Teléfono</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Asignado desde
                            </th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Pin</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                </table>
            </div>
        </div>
        <div id="iframeReimpresionContainer" style="display:none;"></div>
        
        



    </main>
    
</x-layout>
<script>
$(document).ready(function() {
    $('#tabla-perfiles').DataTable({
        processing: false,
        serverSide: false,
        ajax: '{{ route("platforms.occupied-profiles.data") }}',
        pageLength: 10,
        deferRender: true,
        columns: [
            { data: 'platform_name', className: 'text-center' },
            { data: 'account_email', className: 'text-center' },
            { data: 'profile_name', className: 'text-center' },
            { data: 'current_holder', className: 'text-center' },
            { data: 'telefono', className: 'text-center' },
            { data: 'assigned_since', className: 'text-center' },
            { data: 'notes', className: 'text-center' }, 
            { data: 'acciones', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
        }
    });
});

</script>
