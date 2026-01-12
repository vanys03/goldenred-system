<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        @if(session('success'))
            <div id="liveToastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="liveToastError" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastSuccess = document.getElementById('liveToastSuccess');
        if (toastSuccess) {
            const toast = new bootstrap.Toast(toastSuccess);
            toast.show();
        }

        const toastError = document.getElementById('liveToastError');
        if (toastError) {
            const toast = new bootstrap.Toast(toastError);
            toast.show();
        }
    });
</script>
