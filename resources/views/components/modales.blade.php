@push('scripts')
<script>
    $(document).on('click', '.btn-modal', function () {
        const url = $(this).data('url');
        $('#contenido-modal').html('<div class="text-center p-4">Cargando...</div>');

        $.get(url, function (html) {
            $('#contenido-modal').html(html);
            const dialog = $('#modal-dialog-dinamico');

            if (url.includes('delete')) {
                dialog.removeClass('modal-lg').addClass('modal-dialog-centered').css('max-width', '500px');
            } else {
                dialog.removeClass('modal-dialog-centered').addClass('modal-lg').css('max-width', '');
            }

            $('#modalDinamico').modal('show');
        });
    });
</script>
@endpush
