<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Riwayat Struk', 'url' => route('receipts.index')],
            ['label' => 'Edit Struk'],
        ]" />
        <div class="flex items-center gap-4">
            <a href="{{ route('receipts.show', $receipt) }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-200 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold font-display text-slate-800">
                Edit Struk
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-light rounded-2xl p-8">
                <form action="{{ route('receipts.update', $receipt) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="px-4 py-3 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl">
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="store_name" class="block text-sm font-medium text-slate-600 mb-1.5">Nama Toko / Perusahaan</label>
                        <input type="text" name="store_name" id="store_name" value="{{ old('store_name', $receipt->store_name) }}" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm"
                            placeholder="Contoh: Indomaret, SPBU Pertamina">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-slate-600 mb-1.5">Alamat Toko</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm"
                            placeholder="Masukkan alamat lengkap toko... (opsional)">{{ old('address', $receipt->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="receipt_date" class="block text-sm font-medium text-slate-600 mb-1.5">Tanggal</label>
                            <input type="date" name="receipt_date" id="receipt_date" value="{{ old('receipt_date', $receipt->receipt_date ? $receipt->receipt_date->format('Y-m-d') : date('Y-m-d')) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-gray-500 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm [color-scheme:dark]">
                        </div>

                        <div>
                            <label for="total" class="block text-sm font-medium text-slate-600 mb-1.5">Total Pengeluaran (Rp)</label>
                            <input type="number" name="total" id="total" value="{{ old('total', $receipt->total) }}" required min="0" step="1"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-primary-600 font-bold focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-all text-sm"
                                placeholder="Masukkan nominal total belanja...">
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3">
                        <a href="{{ route('receipts.show', $receipt) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-white/20 text-slate-800 rounded-xl text-sm font-semibold transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 gradient-primary rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
