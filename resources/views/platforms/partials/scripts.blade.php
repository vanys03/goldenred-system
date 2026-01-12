@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addPlatformCard = document.querySelector('.platform-card.add-new');
            const addPlatformModal = document.getElementById('addPlatformModal');
            // Referencia al nuevo botón de cierre (la 'X')
            const closeModalButton = document.getElementById('closeModalButton');

            // Función para mostrar la modal
            function showModal(event) {
                event.preventDefault(); // Previene la navegación si el botón es un <a>
                addPlatformModal.classList.add('show');
                document.getElementById('platformName').focus();
            }

            // Función para ocultar la modal
            function hideModal() {
                addPlatformModal.classList.remove('show');
            }

            // 1. Evento para abrir la modal
            if (addPlatformCard) {
                addPlatformCard.addEventListener('click', showModal);
            }

            // 2. Evento para cerrar la modal con el botón 'x'
            if (closeModalButton) {
                closeModalButton.addEventListener('click', hideModal);
            }

            // 3. Evento para cerrar la modal al hacer clic fuera de ella (overlay)
            addPlatformModal.addEventListener('click', function (event) {
                if (event.target === addPlatformModal) { // Si el clic es directamente en el overlay
                    hideModal();
                }
            });

            // 4. Cerrar con la tecla ESC
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && addPlatformModal.classList.contains('show')) {
                    hideModal();
                }
            });

            // 5. Confirmación para la eliminación de plataformas
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    if (!confirm('¿Estás seguro de que quieres eliminar esta plataforma? Se eliminarán todas las cuentas asociadas.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
    <script>
            function reimprimirPerfil(profileId) {
                const container = document.getElementById('iframeReimpresionContainer');
                container.innerHTML = `
        <iframe 
            src="/ticket/perfil/${profileId}" 
            style="width:0; height:0; border:0;" 
            onload="this.contentWindow.focus(); this.contentWindow.print();">
        </iframe>
    `;
            }
        </script>
@endpush