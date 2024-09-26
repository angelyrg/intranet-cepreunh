<div class="modal fade show" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-scrollable {{ $modalSize }}" role="document">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary text-white">
                <h4 class="modal-title text-white">{{ $modalNombre }}</h4>
                <button type="button" class="btn-close btn-close-white border" wire:click="closeModal" aria-label="Close"></button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
