<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="roles" />

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" translate="no">
        <x-navbars.navs.auth titlePage="Roles" />

        <div class="card m-4">
            <div class="table-responsive p-3">

                <div class="d-flex justify-content-between align-items-center px-3 pt-3">
                    <h5 class="mb-0">Lista de Roles</h5>
                    @can('Crear roles')
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearRol">
                            <span class="material-icons align-middle">add</span> Agregar Rol
                        </button>
                    @endcan
                </div>

                <table id="tabla-roles" class="table align-items-center mb-0 w-100 d-none">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder">Rol</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Permisos del rol</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $roles = collect($roles)->sortByDesc(fn($role) => strtolower($role->name) === 'superadmin' ? 1 : 0);
                        @endphp

                        @foreach($roles as $role)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-xs">{{ $role->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if(strtolower($role->name) === 'superadmin')
                                        <p class="text-xs mb-0 text-success">Acceso total</p>
                                    @else
                                        @php
                                            $permissions = $role->permissions->pluck('name');
                                            $first = $permissions->take(3)->join(', ');
                                            $more = $permissions->count() - 3;
                                        @endphp
                                        <p class="text-xs mb-0">
                                            {{ $first }}@if($more > 0) y {{ $more }} más...@endif
                                        </p>
                                    @endif
                                </td>
                                <td class="acciones-centro">
                                    @if(strtolower($role->name) !== 'superadmin')
                                        
                                            <button class="btn btn-link text-secondary p-0 mx-1" title="Editar"
                                                data-bs-toggle="modal" data-bs-target="#modalEditarRol{{ $role->id }}">
                                                <span class="material-icons">edit</span>
                                            </button>
                                            @include('roles.modal-edit', ['role' => $role, 'permissions' => $permissions])
                                        
                                        @can('Eliminar roles')
                                            <button type="button" class="btn btn-link text-danger p-0 mx-1" title="Eliminar"
                                                data-bs-toggle="modal" data-bs-target="#modalEliminarRol{{ $role->id }}">
                                                <span class="material-icons">delete_forever</span>
                                            </button>
                                            @include('roles.modal-delete', ['role' => $role])
                                        @endcan
                                    @else
                                        <span class="badge bg-success text-white text-xs">Protegido</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        @include('roles.modal-create')
        @include('components.alert-toast')
            @include('roles.partials.scripts')

    </main>

</x-layout>
