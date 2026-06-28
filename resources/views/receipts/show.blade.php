<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Riwayat Struk', 'url' => route('receipts.index')],
            ['label' => 'Detail Struk'],
        ]" />
        <div class="flex items-center gap-4">
            <a href="{{ route('receipts.index') }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-200 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold font-display text-slate-800">
                Detail Struk
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Receipt Info -->
                <div class="md:col-span-1 space-y-6">
                    <div class="glass-light rounded-2xl p-6">
                        <h3 class="text-sm font-semibold text-slate-500 mb-4 uppercase tracking-wider">Informasi Toko</h3>
                        <div class="mb-4">
                            <p class="text-xs text-slate-400 mb-1">Nama Toko</p>
                            <p class="font-medium text-slate-800">{{ $receipt->store_name ?: 'Tidak diketahui' }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-slate-400 mb-1">Alamat</p>
                            <p class="font-medium text-slate-800 text-sm break-words">{{ $receipt->address ?: 'Tidak ada alamat' }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-slate-400 mb-1">Tanggal</p>
                            <p class="font-medium text-slate-800">{{ $receipt->receipt_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-primary-600">Rp {{ number_format($receipt->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="glass-light rounded-2xl p-6 flex flex-col gap-3">
                        @if($receipt->status === 'review_needed' || $receipt->status === 'review')
                            <form action="{{ route('receipts.confirm', $receipt) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full px-4 py-2.5 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 rounded-xl text-sm font-medium transition-colors border border-emerald-500/20">
                                    Simpan Struk
                                </button>
                            </form>
                        @else
                            <a href="{{ route('receipts.export-single.pdf', $receipt) }}" target="_blank" class="w-full text-center px-4 py-2.5 bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-400 border border-cyan-500/20 rounded-xl text-sm font-medium transition-colors flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                Cetak PDF
                            </a>
                        @endif
                        <a href="{{ route('receipts.edit', $receipt) }}" class="w-full text-center px-4 py-2.5 bg-slate-100 hover:bg-white/20 text-slate-800 rounded-xl text-sm font-medium transition-colors">
                            Edit Struk
                        </a>
                        <form id="delete-receipt-form-show" action="{{ route('receipts.destroy', $receipt) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                type="button"
                                onclick="showConfirmDelete(document.getElementById('delete-receipt-form-show'), 'Struk ini akan dihapus permanen dan tidak dapat dikembalikan.')"
                                class="w-full px-4 py-2.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 rounded-xl text-sm font-medium transition-colors border border-rose-500/20"
                            >
                                Hapus Struk
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Items List -->
                <div class="md:col-span-2">
                    <div class="glass-light rounded-2xl p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Daftar Barang</h3>
                            @if($receipt->items->count() > 0)
                                <span class="text-xs text-slate-400 bg-slate-50 px-2.5 py-1 rounded-full border border-slate-200">{{ $receipt->items->count() }} item</span>
                            @endif
                        </div>

                        @if($receipt->items->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-slate-200">
                                            <th class="text-left text-xs font-semibold text-slate-400 uppercase tracking-wider pb-3 pr-4">Nama Barang</th>
                                            <th class="text-center text-xs font-semibold text-slate-400 uppercase tracking-wider pb-3 px-4 w-16">Qty</th>
                                            <th class="text-right text-xs font-semibold text-slate-400 uppercase tracking-wider pb-3 pl-4">Harga (Net)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @foreach($receipt->items as $item)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="py-3 pr-4 text-slate-800 font-medium">{{ $item->item_name }}</td>
                                                <td class="py-3 px-4 text-center text-slate-500">{{ $item->quantity }}</td>
                                                <td class="py-3 pl-4 text-right text-primary-600 font-semibold tabular-nums">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="border-t border-white/20">
                                            <td colspan="2" class="pt-4 text-xs text-slate-400 font-semibold uppercase tracking-wider">Total dari Barang</td>
                                            <td class="pt-4 text-right text-slate-800 font-bold tabular-nums">
                                                Rp {{ number_format($receipt->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @elseif($receipt->status === 'processing')
                            <div class="py-10 flex flex-col items-center justify-center text-center">
                                <svg class="w-8 h-8 text-primary-600 animate-spin mb-3" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                </svg>
                                <p class="text-sm text-slate-500 font-medium">AI sedang memproses struk...</p>
                                <p class="text-xs text-gray-600 mt-1">Daftar barang akan muncul setelah selesai.</p>
                            </div>
                        @else
                            <div class="py-10 flex flex-col items-center justify-center text-center border border-dashed border-slate-200 rounded-xl bg-slate-50">
                                <svg class="w-8 h-8 text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm text-slate-400">Tidak ada barang terdeteksi.</p>
                                <p class="text-xs text-gray-600 mt-1">Struk lama mungkin belum memiliki data barang.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

