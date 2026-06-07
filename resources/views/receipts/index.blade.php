<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold font-display text-white">
                Riwayat Struk
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('receipts.export.pdf') }}" target="_blank" class="px-4 py-2 bg-white/5 border border-white/10 rounded-xl font-medium text-sm text-white hover:bg-white/10 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download PDF
                </a>
                <a href="{{ route('receipts.create') }}" class="px-4 py-2 gradient-primary rounded-xl font-medium text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Manual
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-6 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="glass rounded-2xl overflow-hidden">
                @if($receipts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white/5 text-gray-400 text-sm border-b border-white/5">
                                    <th class="px-6 py-4 font-medium">Tanggal</th>
                                    <th class="px-6 py-4 font-medium">Toko</th>
                                    <th class="px-6 py-4 font-medium">Total</th>
                                    <th class="px-6 py-4 font-medium">Status</th>
                                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @foreach($receipts as $receipt)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4">{{ $receipt->receipt_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 font-medium text-white">{{ $receipt->store_name ?: 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4 font-medium text-primary-400">Rp {{ number_format($receipt->total, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            @if($receipt->status === 'saved')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Disimpan
                                                </span>
                                            @elseif($receipt->status === 'processing')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Memproses AI
                                                </span>
                                            @elseif($receipt->status === 'review_needed' || $receipt->status === 'review')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Perlu Review
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-500/10 text-rose-400 border border-rose-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> {{ ucfirst($receipt->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                @if($receipt->status === 'review_needed' || $receipt->status === 'review')
                                                    <a href="{{ route('receipts.show', $receipt) }}" class="px-3 py-1.5 bg-primary-500/10 text-primary-400 hover:bg-primary-500 hover:text-white border border-primary-500/20 rounded-lg text-xs font-semibold transition-all shadow-lg flex items-center gap-1.5" title="Simpan Struk">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                        Simpan Struk
                                                    </a>
                                                @else
                                                    <a href="{{ route('receipts.edit', $receipt) }}" class="px-3 py-1.5 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium border border-transparent hover:border-white/10" title="Edit Struk">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                                        Edit Struk
                                                    </a>
                                                @endif
                                                <form action="{{ route('receipts.destroy', $receipt) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus struk ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium border border-transparent hover:border-rose-500/20" title="Hapus Struk">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                                        Hapus Struk
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-white/5 bg-white/5">
                        {{ $receipts->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-white/5 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">Belum ada riwayat</h3>
                        <p class="text-sm text-gray-400 mb-6">Anda belum mencatat pengeluaran apapun.</p>
                        <a href="{{ route('receipts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            Catat Pengeluaran Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
