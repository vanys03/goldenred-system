@props([
    'id',
    'title' => '¿Estás seguro?',
    'title2' => '¿Estás seguro?',
    'message' => 'Esta acción no se puede deshacer.',
    'icon' => 'warning',
    'confirmText' => 'Confirmar',
    'cancelText' => 'Cancelar',
    'confirmClass' => 'btn-exit',
    'cancelClass' => 'btn-cancel',
    'onConfirm' => '', // JS o form submit
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true" translate="no">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal rounded-3 shadow-lg border-0">
      <div class="modal-header custom-header rounded-top-3 d-flex align-items-center">
        <span class="material-icons-round custom-icon">{{ $icon }}</span>
        <h5 class="modal-title text-white mb-0" id="{{ $id }}Label">{{ $title }}</h5>
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="fs-5 fw-semibold mb-1">{{ $title2 }}</p>
        <p class="text-secondary">{{ $message }}</p>
      </div>
      <div class="modal-footer justify-content-center border-0 pb-4">
        <button type="button" class="btn {{ $cancelClass }} px-4 py-2 rounded-pill me-3" data-bs-dismiss="modal">{{ $cancelText }}</button>
        <button type="button" class="btn {{ $confirmClass }} px-4 py-2 rounded-pill" onclick="{{ $onConfirm }}">{{ $confirmText }}</button>
      </div>
    </div>
  </div>
</div>
