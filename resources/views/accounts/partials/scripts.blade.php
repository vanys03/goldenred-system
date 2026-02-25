@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const emailItems = document.querySelectorAll('.js-email-select');
    const profilesPanel = document.querySelector('.profiles-panel-elegant');

    function getProfileStatusClass(profile) {
        if (profile.status === 'available') return 'status-green';
        if (profile.status === 'assigned' && profile.assigned_since) {
            const fechaAsignacion = new Date(profile.assigned_since);
            const hoy = new Date();
            const fechaLimite = new Date(fechaAsignacion);
            fechaLimite.setMonth(fechaLimite.getMonth() + 1);
            return hoy >= fechaLimite ? 'status-purple' : 'status-red';
        }
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
                        html += `
                            <div class="action-buttons-grid-elegant four-profiles-grid"
                                style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:15px;">
                        `;

                        data.profiles.forEach(profile => {
                            const statusClass = getProfileStatusClass(profile);

                            let expiradoMsg = '';
                            if (statusClass === 'status-purple' && profile.status === 'assigned') {
                                expiradoMsg = `<small class="d-block text-danger">Expirado</small>`;
                            }

                            html += `
                                <div class="profile-group" style="display:flex; flex-direction:column;">
                                    <button
                                        class="btn btn-sm btn-light elegant-action-button profile-card-elegant ${statusClass}"
                                        style="border-bottom-left-radius:0; border-bottom-right-radius:0; margin-bottom:0;"
                                        onclick="${!profile.notes ? "alert('Necesitas agregar un PIN antes de continuar')" : ''}"
                                        ${profile.notes
                                            ? (profile.status === 'available'
                                                ? `data-bs-toggle="modal" data-bs-target="#assignProfileModal" data-profile-id="${profile.id}"`
                                                : profile.status === 'assigned'
                                                    ? `data-bs-toggle="modal" data-bs-target="#unassignProfileModal" data-profile-id="${profile.id}"`
                                                    : '')
                                            : ''}>

                                        <strong style="display:block; font-size:1.1em;">${profile.name}</strong>

                                        ${profile.status === 'assigned'
                                            ? `<span class="pin-indicator">Ocupado por: ${profile.current_holder}</span>`
                                            : 'Sin asignar'}

                                        ${profile.telefono
                                            ? `<small class="d-block text-muted">${profile.telefono}</small>`
                                            : ''}

                                        ${profile.assigned_since
                                            ? (() => {
                                                const fechaAsignacion = new Date(profile.assigned_since);
                                                const hoy = new Date();
                                                const fechaLimite = new Date(fechaAsignacion);
                                                fechaLimite.setMonth(fechaLimite.getMonth() + 1);
                                                const msPorDia = 1000 * 60 * 60 * 24;
                                                const diasRestantes = Math.ceil((fechaLimite - hoy) / msPorDia);
                                                return diasRestantes > 0
                                                    ? `<small class="d-block text-muted">Faltan ${diasRestantes} día${diasRestantes > 1 ? 's' : ''}</small>`
                                                    : `<small class="d-block text-danger">Expirado</small>`;
                                            })()
                                            : ''}

                                        ${profile.notes
                                            ? `<small class="d-block text-muted">PIN: ${profile.notes}</small>`
                                            : ''}

                                        ${expiradoMsg}
                                    </button>

                                    ${profile.status === 'available' ? `
                                        <button class="btn btn-sm"
                                            style="background-color:#ffb347; color:#000; font-weight:bold;
                                                   border-top-left-radius:0; border-top-right-radius:0;
                                                   border:none; padding:5px 0;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addPinModal"
                                            data-profile-id="${profile.id}"
                                            data-current-pin="${profile.notes ?? ''}">
                                            ${profile.notes ? 'Editar PIN' : 'Agregar PIN'}
                                        </button>
                                    ` : ''}
                                </div>
                            `;
                        });

                        html += `</div>`;
                    }

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

    const assignProfileModal = document.getElementById('assignProfileModal');
    assignProfileModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        const profileId = button.getAttribute('data-profile-id');
        document.getElementById('profileIdInput').value = profileId;
        document.getElementById('assignProfileForm').action = `/profiles/${profileId}/assign`;
    });

    const unassignProfileModal = document.getElementById('unassignProfileModal');
    unassignProfileModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        if (!button) return;
        const profileId = button.getAttribute('data-profile-id');
        document.getElementById('unassignProfileIdInput').value = profileId;
        document.getElementById('unassignProfileForm').action = `/profiles/${profileId}/unassign`;
    });
});
const addPinModal = document.getElementById('addPinModal');

addPinModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    const profileId = button.getAttribute('data-profile-id');
    const currentPin = button.getAttribute('data-current-pin');

    document.getElementById('pinProfileId').value = profileId;
    document.querySelector('#addPinForm input[name="notes"]').value = currentPin ?? '';

    document.getElementById('addPinForm').action =
        `/profiles/${profileId}/pin`;
});

</script>
@endpush
