<!-- Toast Notification Component -->
<div x-data="toastNotification()" x-init="init()" class="fixed top-5 right-5 z-[100] space-y-3" style="pointer-events: none;">
    <!-- Success Toast -->
    <template x-if="successMessage">
        <div x-show="showSuccess"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="flex items-center gap-3 px-5 py-4 bg-surface-800/95 backdrop-blur-xl border border-emerald-500/20 rounded-2xl shadow-2xl shadow-emerald-500/10 max-w-sm"
             style="pointer-events: auto;">
            <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-white flex-1" x-text="successMessage"></p>
            <button @click="showSuccess = false" class="text-gray-400 hover:text-white transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>

    <!-- Error Toast -->
    <template x-if="errorMessage">
        <div x-show="showError"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="flex items-center gap-3 px-5 py-4 bg-surface-800/95 backdrop-blur-xl border border-rose-500/20 rounded-2xl shadow-2xl shadow-rose-500/10 max-w-sm"
             style="pointer-events: auto;">
            <div class="w-9 h-9 rounded-xl bg-rose-500/10 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-white flex-1" x-text="errorMessage"></p>
            <button @click="showError = false" class="text-gray-400 hover:text-white transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toastNotification() {
    return {
        showSuccess: false,
        showError: false,
        successMessage: @json(session('success')),
        errorMessage: @json($errors->first()),
        init() {
            if (this.successMessage) {
                this.showSuccess = true;
                setTimeout(() => { this.showSuccess = false; }, 4000);
            }
            if (this.errorMessage) {
                this.showError = true;
                setTimeout(() => { this.showError = false; }, 5000);
            }
        }
    }
}
</script>
