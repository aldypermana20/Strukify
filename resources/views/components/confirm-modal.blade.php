{{-- Beautiful Confirm Dialog Modal --}}
<div
    x-data="confirmModal()"
    x-on:confirm-delete.window="open($event.detail)"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[200] flex items-center justify-center px-4"
    style="display:none;"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="close()"
        class="absolute inset-0 bg-black/70 backdrop-blur-sm"
    ></div>

    {{-- Modal Card --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 translate-y-4"
        class="relative w-full max-w-sm rounded-2xl overflow-hidden shadow-2xl"
        style="background: linear-gradient(135deg, rgba(30,32,48,0.98) 0%, rgba(20,22,36,0.98) 100%); border: 1px solid rgba(239,68,68,0.2);"
    >
        {{-- Top glow accent --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-rose-500/50 to-transparent"></div>

        <div class="p-6">
            {{-- Icon --}}
            <div class="flex justify-center mb-5">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center relative"
                     style="background: linear-gradient(135deg, rgba(239,68,68,0.15), rgba(239,68,68,0.05)); border: 1px solid rgba(239,68,68,0.25);">
                    <div class="absolute inset-0 rounded-2xl animate-pulse" style="background: rgba(239,68,68,0.08);"></div>
                    <svg class="w-8 h-8 text-rose-400 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h3 class="text-center text-lg font-bold text-white mb-2">Hapus Struk?</h3>

            {{-- Message --}}
            <p class="text-center text-sm text-gray-400 mb-6" x-text="message"></p>

            {{-- Warning note --}}
            <div class="mb-6 px-3 py-2.5 rounded-xl flex items-center gap-2.5"
                 style="background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15);">
                <svg class="w-4 h-4 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-rose-300/80">Tindakan ini tidak dapat dibatalkan.</p>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button
                    type="button"
                    x-on:click="close()"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]"
                    style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #d1d5db;"
                    onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                    onmouseout="this.style.background='rgba(255,255,255,0.06)'"
                >
                    Batal
                </button>
                <button
                    type="button"
                    x-on:click="confirm()"
                    class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] relative overflow-hidden"
                    style="background: linear-gradient(135deg, #ef4444, #dc2626); border: 1px solid rgba(239,68,68,0.4); box-shadow: 0 4px 15px rgba(239,68,68,0.3);"
                >
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6"/>
                        </svg>
                        Ya, Hapus
                    </span>
                </button>
            </div>
        </div>

        {{-- Bottom glow accent --}}
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-rose-500/30 to-transparent"></div>
    </div>
</div>

<script>
function confirmModal() {
    return {
        show: false,
        message: 'Data yang dihapus tidak dapat dikembalikan.',
        formEl: null,

        open(detail) {
            this.message = detail.message || 'Data yang dihapus tidak dapat dikembalikan.';
            this.formEl = detail.form || null;
            this.show = true;
        },

        close() {
            this.show = false;
            this.formEl = null;
        },

        confirm() {
            if (this.formEl) {
                this.formEl.submit();
            }
            this.show = false;
        }
    }
}

// Global helper — call this from any delete button
function showConfirmDelete(form, message) {
    window.dispatchEvent(new CustomEvent('confirm-delete', {
        detail: { form, message }
    }));
}
</script>
