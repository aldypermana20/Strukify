<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Riwayat Struk'],
        ]" />
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold font-display text-slate-800">
                Riwayat Struk
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('receipts.export.pdf', request()->query()) }}" target="_blank" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium text-sm text-slate-800 hover:bg-slate-200 transition-all flex items-center gap-2">
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

            <!-- Search & Filter Bar -->
            <div class="glass-light rounded-2xl p-5 mb-6">
                <form action="{{ route('receipts.index') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari Toko</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama toko..." class="w-full pl-10 pr-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-800 text-sm focus:border-primary-500 focus:ring-1 focus:outline-none placeholder-gray-500">
                        </div>
                    </div>
                    <div class="w-full md:w-40">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-800 text-sm focus:border-primary-500 focus:ring-1 focus:outline-none">
                            <option value="" class="bg-slate-800 text-slate-800">Semua Status</option>
                            <option value="saved" {{ request('status') === 'saved' ? 'selected' : '' }} class="bg-slate-800 text-slate-800">Disimpan</option>
                            <option value="review_needed" {{ request('status') === 'review_needed' ? 'selected' : '' }} class="bg-slate-800 text-slate-800">Perlu Review</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }} class="bg-slate-800 text-slate-800">Memproses AI</option>
                        </select>
                    </div>
                    <div class="w-full md:w-40">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-800 text-sm focus:border-primary-500 focus:ring-1 focus:outline-none [color-scheme:dark]">
                    </div>
                    <div class="w-full md:w-40">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-800 text-sm focus:border-primary-500 focus:ring-1 focus:outline-none [color-scheme:dark]">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-5 py-2 gradient-primary rounded-lg font-medium text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            <a href="{{ route('receipts.index') }}" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 hover:bg-slate-200 transition-all">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            
            <div class="glass-light rounded-2xl overflow-hidden">
                @if($receipts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-sm border-b border-slate-200">
                                    <th class="px-6 py-4 font-medium">Tanggal</th>
                                    <th class="px-6 py-4 font-medium">Toko</th>
                                    <th class="px-6 py-4 font-medium">Total</th>
                                    <th class="px-6 py-4 font-medium">Status</th>
                                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @foreach($receipts as $receipt)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">{{ $receipt->receipt_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-800">{{ $receipt->store_name ?: 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4 font-medium text-primary-600">Rp {{ number_format($receipt->total, 0, ',', '.') }}</td>
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
                                                    <a href="{{ route('receipts.show', $receipt) }}" class="px-3 py-1.5 bg-primary-500/10 text-primary-600 hover:bg-primary-500 hover:text-slate-800 border border-primary-500/20 rounded-lg text-xs font-semibold transition-all shadow-lg flex items-center gap-1.5" title="Simpan Struk">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                        Simpan Struk
                                                    </a>
                                                @else
                                                    <a href="{{ route('receipts.export-single.pdf', $receipt) }}" target="_blank" class="px-3 py-1.5 text-emerald-400 hover:text-slate-800 hover:bg-emerald-500/20 rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium border border-transparent hover:border-emerald-500/20" title="Cetak Struk">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                        Cetak
                                                    </a>
                                                    <a href="{{ route('receipts.edit', $receipt) }}" class="px-3 py-1.5 text-slate-600 hover:text-slate-800 hover:bg-slate-200 rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium border border-transparent hover:border-slate-200" title="Edit Struk">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                                        Edit
                                                    </a>
                                                @endif
                                                <form id="delete-form-{{ $receipt->id }}" action="{{ route('receipts.destroy', $receipt) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="button"
                                                        onclick="showConfirmDelete(document.getElementById('delete-form-{{ $receipt->id }}'), 'Struk dari {{ $receipt->store_name ?: 'toko ini' }} akan dihapus permanen.')"
                                                        class="px-3 py-1.5 text-rose-400 hover:bg-rose-500/10 rounded-lg transition-all flex items-center gap-1.5 text-xs font-medium border border-transparent hover:border-rose-500/20"
                                                        title="Hapus Struk"
                                                    >
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
                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                        {{ $receipts->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            <h3 class="text-lg font-medium text-slate-800 mb-2">Tidak ada hasil</h3>
                            <p class="text-sm text-slate-500 mb-6">Tidak ditemukan struk yang sesuai dengan filter Anda.</p>
                            <a href="{{ route('receipts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-white/20 text-slate-800 rounded-xl text-sm font-medium transition-colors">
                                Reset Filter
                            </a>
                        @else
                            <h3 class="text-lg font-medium text-slate-800 mb-2">Belum ada riwayat</h3>
                            <p class="text-sm text-slate-500 mb-6">Anda belum mencatat pengeluaran apapun.</p>
                            <a href="{{ route('receipts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-white/20 text-slate-800 rounded-xl text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Catat Pengeluaran Pertama
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
