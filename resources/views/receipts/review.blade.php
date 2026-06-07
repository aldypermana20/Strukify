<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold font-display text-white">
            Review Hasil Scan
        </h2>
    </x-slot>

    <div class="py-8" x-data="reviewForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('receipts.store') }}" method="POST">
                @csrf
                <input type="hidden" name="image_path" value="{{ $imagePath }}">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Receipt Image Preview -->
                    <div class="lg:col-span-4">
                        <div class="glass rounded-2xl p-4 sticky top-24">
                            <h3 class="text-sm font-semibold text-gray-400 mb-4 uppercase tracking-wider">Foto Struk</h3>
                            <div class="rounded-xl overflow-hidden border border-white/10 bg-white/5">
                                <img src="{{ Storage::url($imagePath) }}" alt="Struk" class="w-full h-auto">
                            </div>
                            
                            <div class="mt-6 p-4 bg-primary-500/10 border border-primary-500/20 rounded-xl">
                                <h4 class="text-sm font-semibold text-primary-400 mb-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    AI Selesai Memproses
                                </h4>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    Silakan periksa kembali data di samping. Anda dapat mengedit nama barang, menyesuaikan kategori, atau memperbaiki harga jika ada kesalahan OCR.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Form -->
                    <div class="lg:col-span-8 space-y-6">
                        <!-- General Info -->
                        <div class="glass rounded-2xl p-6">
                            <h3 class="text-sm font-semibold text-gray-400 mb-4 uppercase tracking-wider">Informasi Umum</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Nama Toko</label>
                                    <input type="text" name="store_name" value="{{ old('store_name', $aiData['store_name']) }}" required
                                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:border-primary-500 focus:ring-1 focus:outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Tanggal Struk</label>
                                    @php
                                        // Try to format date, fallback to today if invalid
                                        $parsedDate = date('Y-m-d');
                                        if (!empty($aiData['receipt_date'])) {
                                            try {
                                                // Handle various id formats or let it fallback
                                                $dateObj = \Carbon\Carbon::parse(str_replace('/', '-', $aiData['receipt_date']));
                                                $parsedDate = $dateObj->format('Y-m-d');
                                            } catch (\Exception $e) {}
                                        }
                                    @endphp
                                    <input type="date" name="receipt_date" value="{{ old('receipt_date', $parsedDate) }}" required
                                        class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white focus:border-primary-500 focus:ring-1 focus:outline-none text-sm [color-scheme:dark]">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Total Pengeluaran (Rp)</label>
                                    <input type="number" name="total" value="{{ old('total', $aiData['total']) }}" required min="0" step="1" x-model="total" readonly
                                        class="w-full px-4 py-2.5 bg-black/20 border border-white/10 rounded-xl text-primary-400 font-bold text-lg focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Items List -->
                        <div class="glass rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Daftar Barang yang Terdeteksi</h3>
                                <button type="button" @click="addItem" class="text-sm font-medium text-primary-400 hover:text-primary-300 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Manual
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(item, index) in items" :key="item.key">
                                    <div class="p-4 rounded-xl bg-white/5 border border-white/10 relative hover:border-white/20 transition-colors">
                                        <button type="button" @click="removeItem(index)" class="absolute top-3 right-3 text-gray-500 hover:text-rose-400 p-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>

                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                            <div class="sm:col-span-5">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Nama Barang</label>
                                                <input type="text" x-model="item.name" :name="'items['+index+'][item_name]'" required
                                                    class="w-full px-3 py-2 bg-surface-900 border border-white/10 rounded-lg text-white text-sm focus:border-primary-500 focus:ring-1 focus:outline-none">
                                            </div>
                                            
                                            <div class="sm:col-span-4">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Kategori (Auto)</label>
                                                <select x-model="item.categoryId" :name="'items['+index+'][category_id]'" required
                                                    class="w-full px-3 py-2 bg-surface-900 border border-white/10 rounded-lg text-white text-sm focus:border-primary-500 focus:ring-1 focus:outline-none">
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Harga (Rp)</label>
                                                <input type="number" x-model.number="item.price" :name="'items['+index+'][price]'" required min="0" step="1" @input="calculateTotal"
                                                    class="w-full px-3 py-2 bg-surface-900 border border-white/10 rounded-lg text-white text-sm focus:border-primary-500 focus:ring-1 focus:outline-none">
                                            </div>

                                            <input type="hidden" x-model.number="item.qty" :name="'items['+index+'][quantity]'">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Submit Action -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-3.5 gradient-primary rounded-xl font-semibold text-base hover:opacity-90 shadow-lg shadow-primary-500/25 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Simpan Pengeluaran
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function reviewForm() {
            // Load extracted items from AI
            const extractedItems = @json($aiData['items']);
            
            let initialItems = [];
            if (extractedItems && extractedItems.length > 0) {
                initialItems = extractedItems.map((item, index) => ({
                    key: Date.now() + index,
                    name: item.item_name || '',
                    categoryId: item.category_id || 7, // default to Lainnya
                    price: parseFloat(item.price) || 0,
                    qty: parseInt(item.quantity) || 1
                }));
            } else {
                // Empty state if AI found nothing
                initialItems = [{ key: Date.now(), name: '', categoryId: 7, price: 0, qty: 1 }];
            }

            return {
                items: initialItems,
                total: {{ floatval($aiData['total']) }},
                
                addItem() {
                    this.items.push({
                        key: Date.now(),
                        name: '',
                        categoryId: 7,
                        price: 0,
                        qty: 1
                    });
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                    this.calculateTotal();
                },
                
                calculateTotal() {
                    this.total = this.items.reduce((sum, item) => sum + ((item.price || 0) * (item.qty || 1)), 0);
                },

                init() {
                    // Recalculate total if AI total was 0 or incorrect compared to items
                    let calcTotal = this.items.reduce((sum, item) => sum + ((item.price || 0) * (item.qty || 1)), 0);
                    if (this.total === 0 && calcTotal > 0) {
                        this.total = calcTotal;
                    }
                }
            }
        }
    </script>
</x-app-layout>
