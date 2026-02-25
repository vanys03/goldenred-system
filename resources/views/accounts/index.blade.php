<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='platforms' />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Cuentas" />

        <div class="card m-4 mt-5 p-4 elegant-shadow">

            <div class="emails-profile-layout-elegant">

                <div class="emails-list-container-elegant">
                    <a href="#" class="email-item-elegant add-new-email" data-bs-toggle="modal"
                        data-bs-target="#addNewEmailModal">
                        <i class="material-icons me-2">add_circle_outline</i>
                        Agregar nuevo correo
                    </a>

                    @foreach($accounts as $account)
                        <div class="email-item-elegant js-email-select d-flex justify-content-between align-items-center"
                            id="account-{{ $account->id }}">

                            <div class="me-2">
                                {{ $account->email }}
                                <small class="text-muted">({{ $account->platform->name }})</small>
                            </div>

                            <form action="{{ route('accounts.destroy', $account) }}" method="POST"
                                class="d-inline flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <!-- Botón eliminar -->
                                <button type="button" class="btn btn-link text-danger p-0 mx-1" title="Eliminar"
                                    data-bs-toggle="modal" data-bs-target="#modalEliminarAccount{{ $account->id }}">
                                    <span class="material-icons">delete_forever</span>
                                </button>


                            </form>
                        </div>

                        <!-- Incluir modal -->
                        @include('accounts.partials.modal-delete-account', ['account' => $account])
                    @endforeach
                </div>
                @include('accounts.partials.modal-add-account')

                <div class="profiles-panel-elegant">


                </div>

            </div>
        </div>
        @include('accounts.partials.style')
        <!-- Modal Asignar Perfil -->
        <div class="modal fade" id="assignProfileModal" tabindex="-1" role="dialog"
            aria-labelledby="assignProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-elegant">

                    <!-- Header -->
                    <div class="modal-header modal-header-elegant">
                        <h5 class="modal-title modal-title-elegant" id="assignProfileModalLabel">
                            <i class="material-icons me-2 text-success">person_add</i>
                            Asignar Perfil
                        </h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <form id="assignProfileForm" method="POST">
                            @csrf
                            <!-- Campo oculto para el ID del perfil -->
                            <input type="hidden" name="profile_id" id="profileIdInput">

                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Nombre del Cliente</label>
                                <input type="text" class="form-control" name="current_holder" required>
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono del cliente</label>
                                <input type="text" name="telefono" id="telefono" class="form-control"
                                    placeholder="Ej. 222-123-4567">
                            </div>


                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Fecha de Asignación</label>
                                <input type="date" class="form-control" name="assigned_since" required>
                            </div>


                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="assignProfileForm"
                            class="btn btn-success elegant-password-button w-50">
                            Asignar Perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Desocupar Perfil -->
        <div class="modal fade" id="unassignProfileModal" tabindex="-1" role="dialog"
            aria-labelledby="unassignProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-elegant">

                    <!-- Header -->
                    <div class="modal-header modal-header-elegant">
                        <h5 class="modal-title modal-title-elegant" id="unassignProfileModalLabel">
                            <i class="material-icons me-2 text-danger">person_remove</i>
                            Desocupar Perfil
                        </h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="unassignProfileForm" method="POST">
                            @csrf
                            <!-- Campo oculto para el ID del perfil -->
                            <input type="hidden" name="profile_id" id="unassignProfileIdInput">

                            <p class="text-center">¿Seguro que deseas desocupar este perfil?</p>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="unassignProfileForm"
                            class="btn btn-danger elegant-password-button w-50">
                            Desocupar Perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @include('accounts.partials.scripts')
        @include('accounts.partials.modal-change-password')
        @include('accounts.partials.modal-add-pin')
    </main>
       
    @if(session('assignment_to_print'))
        <iframe 
            src="{{ route('ticket.perfil', session('assignment_to_print')) }}" 
            style="width:0; height:0; border:0; display:none;">
        </iframe>

        @php(session()->forget('assignment_to_print'))
    @endif

</x-layout>

