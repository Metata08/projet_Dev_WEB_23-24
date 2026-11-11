<div class="toasts" aria-live="polite">
    @if (session('success'))
        <div class="toast toast-succes" role="status">
            <x-icon name="check-circle" />
            <span>{{ session('success') }}</span>
            <button type="button" class="toast-fermer" aria-label="Fermer"><x-icon name="x" /></button>
        </div>
    @endif
    @if (session('error'))
        <div class="toast toast-erreur" role="alert">
            <x-icon name="alert" />
            <span>{{ session('error') }}</span>
            <button type="button" class="toast-fermer" aria-label="Fermer"><x-icon name="x" /></button>
        </div>
    @endif
</div>
