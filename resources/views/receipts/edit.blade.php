<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('receipts.show', $receipt) }}" class="p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold font-display text-white">
                Edit Struk
            </h2>
        </div>
    </x-slot>

    <div class="py-8" x-data="receiptForm()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('receipts.update', $receipt) }}" method="POST">
                @csrf
                @method('PUT')

                @if($errors->any())
                    <div class="mb-6 px-4 py-3 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Receipt Info -->
                    <div class="md:col-span-1 space-y-6">
                        <div class="glass rounded-2xl p-6">
                            <h3 class="text-sm font-semibold text-gray-400 mb-4 uppercase tracking-wider">Informasi Umum</h3>
                            
                            <div class="mb-4">
                                <label for="store_name" class="block text-sm font-medium text-gray-300 mb-1.5">Nama Toko</label>
                                <input type="text" name="store_name" id="store_name" value="{{ old('store_name', $receipt->store_name) }}" required
                                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm">
                            </div>

                            <div class="mb-4">
                                <label for="receipt_date" class="block text-sm font-medium text-gray-300 mb-1.5">Tanggal</label>
                                <input type="date" name="receipt_date" id="receipt_date" value="{{ old('receipt_date', $receipt->receipt_date ? $receipt->receipt_date->format('Y-m-d') : '') }}" required
                                    class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm [color-scheme:dark]">
                            </div>

                            <div>
                                <label for="total" class="block text-sm font-medium text-gray-300 mb-1.5">Total Pengeluaran (Rp)</label>
                                <input type="number" name="total" id="total" value="{{ old('total', $receipt->total) }}" required min="0" step="1" x-model="total" readonly
                                    class="w-full px-4 py-2.5 bg-black/20 border border-white/10 rounded-xl text-primary-400 font-bold focus:outline-none transition-all text-sm">
                                <p class="text-xs text-gray-500 mt-1">Dihitung otomatis dari item</p>
                            </div>
                        </div>

                        <div class="glass rounded-2xl p-6">
                            <button type="submit" class="w-full px-4 py-3 gradient-primary rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                    <!-- Receipt Items -->
                    <div class="md:col-span-2">
                        <div class="glass rounded-2xl p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Daftar Barang</h3>
                                <button type="button" @click="addItem" class="text-sm font-medium text-primary-400 hover:text-primary-300 transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Item
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(item, index) in items" :key="item.key">
                                    <div class="p-4 rounded-xl bg-white/5 border border-white/5 relative">
                                        <button type="button" @click="removeItem(index)" class="absolute top-3 right-3 text-gray-500 hover:text-rose-400 transition-colors p-1" title="Hapus Item">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>

                                        <input type="hidden" :name="'items['+index+'][id]'" x-model="item.id" x-show="item.id">

                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                                            <div class="sm:col-span-6">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Nama Barang</label>
                                                <input type="text" x-model="item.name" :name="'items['+index+'][item_name]'" required
                                                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm">
                                            </div>
                                            
                                            <div class="sm:col-span-6">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Kategori</label>
                                                <select x-model="item.categoryId" :name="'items['+index+'][category_id]'" required
                                                    class="w-full px-3 py-2 bg-surface-800 border border-white/10 rounded-lg text-white focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="sm:col-span-4">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Harga Satuan (Rp)</label>
                                                <input type="number" x-model.number="item.price" :name="'items['+index+'][price]'" required min="0" step="1" @input="calculateTotal"
                                                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm">
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label class="block text-xs font-medium text-gray-400 mb-1">Qty</label>
                                                <input type="number" x-model.number="item.qty" :name="'items['+index+'][quantity]'" required min="1" step="1" @input="calculateTotal"
                                                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm">
                                            </div>

                                            <div class="sm:col-span-5 flex items-end">
                                                <div class="w-full px-3 py-2 bg-black/20 border border-white/5 rounded-lg text-primary-400 font-semibold text-sm text-right">
                                                    Sub: Rp <span x-text="formatMoney(item.price * item.qty)"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <div x-show="items.length === 0" class="text-center py-8 text-gray-500 text-sm">
                                    Belum ada item. Klik "Tambah Item" untuk memulai.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function receiptForm() {
            // Load existing items from Laravel to Alpine
            @php
                $mappedItems = $receipt->items->map(function($item) {
                    return [
                        'id' => $item->id,
                        'key' => 'item_' . $item->id,
                        'name' => $item->item_name,
                        'categoryId' => $item->category_id,
                        'price' => floatval($item->price),
                        'qty' => $item->quantity
                    ];
                })->toArray();
            @endphp
            const existingItems = @json($mappedItems);

            return {
                items: existingItems.length > 0 ? existingItems : [{ key: Date.now(), id: null, name: '', categoryId: '', price: 0, qty: 1 }],
                total: {{ $receipt->total ?? 0 }},
                
                addItem() {
                    this.items.push({
                        key: Date.now(),
                        id: null,
                        name: '',
                        categoryId: '',
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

                formatMoney(amount) {
                    return (amount || 0).toLocaleString('id-ID');
                },

                init() {
                    this.calculateTotal();
                }
            }
        }
    </script>
</x-app-layout>
