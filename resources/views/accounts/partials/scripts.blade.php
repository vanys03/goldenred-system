@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailItems = document.querySelectorAll('.js-email-select');
            const profilesPanel = document.querySelector('.profiles-panel-elegant');

            // Función para aplicar color según estado y fecha
            function getProfileStatusClass(profile) {
                // Disponible → verde
                if (profile.status === 'available') return 'status-green';

                // Asignado → verificamos fecha
                if (profile.status === 'assigned' && profile.assigned_since) {
                    const fechaAsignacion = new Date(profile.assigned_since);
                    const hoy = new Date();

                    // Crear fecha límite sumando un mes exacto
                    const fechaLimite = new Date(fechaAsignacion);
                    fechaLimite.setMonth(fechaLimite.getMonth() + 1);

                    // Si ya pasó un mes → morado
                    if (hoy >= fechaLimite) {
                        return 'status-purple';
                    }

                    // Si aún no pasa un mes → rojo
                    return 'status-red';
                }

                // Bloqueado explícitamente en BD → morado
                if (profile.status === 'blocked') return 'status-purple';

                return 'status-default';
            }

            emailItems.forEach(item => {
                item.addEventListener('click', function () {
                    emailItems.forEach(i => i.classList.remove('active-email-elegant'));
                    this.classList.add('active-email-elegant');

                    const accountId = this.id.replace('account-', '');
                    fetch(`/accounts/${accountId}/profiles`)
                        .then(response => response.json())
                        .then(data => {
                            let html = `<h5 class="text-center panel-title-elegant">Perfiles de ${data.email}</h5>`;

                            if (data.profiles.length === 0) {
                                html += `<p class="text-muted text-center">No hay perfiles asociados a esta cuenta.</p>`;
                            } else {
                                html += `<div class="action-buttons-grid-elegant four-profiles-grid">`;
                                data.profiles.forEach(profile => {
                                    const statusClass = getProfileStatusClass(profile);

                                    // Verificamos si está expirado
                                    let expiradoMsg = '';
                                    if (statusClass === 'status-purple' && profile.status === 'assigned') {
                                        expiradoMsg = `<small class="d-block text-danger">Expirado</small>`;
                                    }

                                    html += `
                                        <button class="btn btn-sm btn-light elegant-action-button profile-card-elegant ${statusClass}"
                                        ${profile.status === 'available' ?
                                            `data-bs-toggle="modal" data-bs-target="#assignProfileModal" data-profile-id="${profile.id}"` :
                                            profile.status === 'assigned' ?
                                                `data-bs-toggle="modal" data-bs-target="#unassignProfileModal" data-profile-id="${profile.id}"` : ''}>
                                        ${profile.name}
                                        ${profile.status === 'assigned'
                                            ? `<span class="pin-indicator">Ocupado por: ${profile.current_holder}</span>`
                                            : ''}
                                            ${profile.telefono
                                            ? `<small class="d-block text-muted">Teléfono: ${profile.telefono}</small>`
                                            : ''}

                                        ${profile.assigned_since
    ? (() => {
        const fechaAsignacion = new Date(profile.assigned_since);
        const hoy = new Date();
        const fechaLimite = new Date(fechaAsignacion);
        fechaLimite.setMonth(fechaLimite.getMonth() + 1);

        const msPorDia = 1000 * 60 * 60 * 24;
        const diasRestantes = Math.ceil((fechaLimite - hoy) / msPorDia);

        if (diasRestantes > 0) {
            return `<small class="d-block text-muted">Faltan ${diasRestantes} día${diasRestantes > 1 ? 's' : ''} para expirar</small>`;
        } else {
            return `<small class="d-block text-danger">Expirado</small>`;
        }
    })()
    : ''}


                                        ${profile.notes
                                            ? `<small class="d-block text-muted">PIN: ${profile.notes}</small>`
                                            : ''}

                                        ${expiradoMsg}
                                        </button>
                                    `;
                                });
                                html += `</div>`;
                            }

                            // Contraseña de la cuenta
                            html += `
                                <div class="password-section-elegant mt-4">
                                    <h6 class="password-title">Contraseña de la Cuenta</h6>
                                    <div class="password-display-box">
                                        <span class="password-text">${data.password_plain}</span>
                                    </div>
                                    <button class="btn btn-sm w-100 mt-2 elegant-password-button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#changePasswordModal"
                                        data-account-id="${data.id}">
                                        Cambiar Contraseña
                                    </button>
                                </div>
                            `;

                            profilesPanel.innerHTML = html;
                        })
                        .catch(error => console.error('Error cargando perfiles:', error));
                });
            });

            // Capturar evento de apertura del modal y pasar el profile_id
            const assignProfileModal = document.getElementById('assignProfileModal');
            assignProfileModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const profileId = button.getAttribute('data-profile-id');
                document.getElementById('profileIdInput').value = profileId;

                // Actualizar acción del formulario dinámicamente
                const form = document.getElementById('assignProfileForm');
                form.action = `/profiles/${profileId}/assign`;
            });

            // Capturar evento de apertura del modal de desocupar
            const unassignProfileModal = document.getElementById('unassignProfileModal');
            unassignProfileModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const profileId = button.getAttribute('data-profile-id');
                document.getElementById('unassignProfileIdInput').value = profileId;

                // Actualizar acción del formulario dinámicamente
                const form = document.getElementById('unassignProfileForm');
                form.action = `/profiles/${profileId}/unassign`;
            });
        });
    </script>
@endpush