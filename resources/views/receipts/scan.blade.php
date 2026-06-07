<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold font-display text-white">
            Scan Struk Belanja
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="glass rounded-2xl p-8" x-data="imageUploader()">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 mx-auto rounded-2xl gradient-primary flex items-center justify-center mb-4 shadow-lg shadow-primary-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold font-display mb-2">Upload Struk Anda</h3>
                    <p class="text-gray-400">AI kami akan membaca dan mengkategorikan pengeluaran secara otomatis.</p>
                </div>

                <form action="{{ route('scan.process') }}" method="POST" enctype="multipart/form-data" id="scanForm">
                    @csrf
                    
                    <div class="relative group cursor-pointer" 
                         @dragover.prevent="dragover = true" 
                         @dragleave.prevent="dragover = false" 
                         @drop.prevent="drop($event)"
                         @click="$refs.fileInput.click()">
                        
                        <input type="file" name="receipt_image" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileSelect">
                        
                        <div :class="{'border-primary-500 bg-primary-500/5': dragover, 'border-white/20 bg-white/5 group-hover:border-primary-500/50 group-hover:bg-white/10': !dragover}"
                             class="border-2 border-dashed rounded-2xl p-10 transition-all text-center">
                            
                            <template x-if="!imageUrl">
                                <div>
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                    <p class="text-sm font-medium text-white mb-1">Klik untuk upload atau drag and drop</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Maks. 10MB)</p>
                                </div>
                            </template>

                            <template x-if="imageUrl">
                                <div class="relative w-full max-w-sm mx-auto">
                                    <img :src="imageUrl" class="w-full h-auto rounded-lg shadow-lg border border-white/10">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <p class="text-sm font-medium text-white">Ganti Gambar</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <button type="submit" class="px-8 py-3.5 gradient-primary rounded-xl font-semibold text-base hover:opacity-90 transition-all shadow-lg shadow-primary-500/25 inline-flex items-center gap-2" :disabled="!imageUrl" :class="{'opacity-50 cursor-not-allowed': !imageUrl, 'is-loading': isSubmitting}" @click="isSubmitting = true">
                            <span x-show="!isSubmitting">Mulai Scan dengan AI</span>
                            <span x-show="isSubmitting" class="flex items-center gap-2">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memproses Gambar...
                            </span>
                        </button>
                    </div>
                </form>

            </div>
            
            <div class="mt-8 grid grid-cols-3 gap-6 text-center opacity-70">
                <div>
                    <div class="text-primary-400 font-bold mb-1">Pencahayaan</div>
                    <div class="text-xs text-gray-400">Pastikan struk terang dan jelas</div>
                </div>
                <div>
                    <div class="text-primary-400 font-bold mb-1">Rata</div>
                    <div class="text-xs text-gray-400">Ratakan lipatan pada struk</div>
                </div>
                <div>
                    <div class="text-primary-400 font-bold mb-1">Fokus</div>
                    <div class="text-xs text-gray-400">Hindari foto blur/goyang</div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function imageUploader() {
            return {
                dragover: false,
                imageUrl: null,
                isSubmitting: false,
                handleFileSelect(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.imageUrl = URL.createObjectURL(file);
                    }
                },
                drop(e) {
                    this.dragover = false;
                    const file = e.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        this.$refs.fileInput.files = e.dataTransfer.files;
                        this.imageUrl = URL.createObjectURL(file);
                    }
                }
            }
        }
    </script>
</x-app-layout>
