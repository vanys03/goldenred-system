<div class="modal fade" id="addNewEmailModal" tabindex="-1" role="dialog" aria-labelledby="addNewEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-elegant">
            <div class="modal-header modal-header-elegant">
                <h5 class="modal-title modal-title-elegant" id="addNewEmailModalLabel">
                    <i class="material-icons me-2 text-info">mail_outline</i>
                    Agregar Nueva Cuenta de Correo
                </h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('accounts.store') }}" method="POST" id="addEmailForm">
                @csrf

                {{-- Si la vista tiene $platform, usamos hidden. Si no, mostramos select --}}
                @isset($platform)
                    <input type="hidden" name="platform_id" value="{{ $platform->id }}">
                @else
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Plataforma</label>
                        <select name="platform_id" class="form-control" required>
                            <option value="" disabled selected>Selecciona una plataforma</option>
                            @foreach($platforms as $platform)
                                <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endisset

                <div class="modal-body">
                    <div class="input-group input-group-outline my-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="notes">Alias (opcional)</label>
                        <input type="text" class="form-control" name="notes" id="notes" placeholder="Ej: Correo Personal">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success elegant-action-button w-50">
                        Guardar Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
