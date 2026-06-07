<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold font-display text-white">
                Laporan Keuangan
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('receipts.export.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="px-4 py-2 bg-rose-500/10 hover:bg-rose-500 hover:text-white border border-rose-500/20 text-rose-400 rounded-xl font-medium text-sm transition-all flex items-center gap-2 shadow-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print Laporan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filter Section -->
            <div class="glass rounded-2xl p-6">
                <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-400 mb-1">Periode Cepat</label>
                        <select name="period" onchange="this.form.submit()" class="w-full px-3 py-2 bg-surface-900 border border-white/10 rounded-lg text-white text-sm focus:border-primary-500 focus:ring-1 focus:outline-none">
                            <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="custom" {{ $period === 'custom' ? 'selected' : '' }}>Pilih Tanggal Manual</option>
                        </select>
                    </div>
                    
                    @if($period === 'custom')
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-400 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 bg-surface-900 border border-white/10 rounded-lg text-white text-sm focus:border-primary-500 focus:ring-1 focus:outline-none [color-scheme:dark]">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-400 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 bg-surface-900 border border-white/10 rounded-lg text-white text-sm focus:border-primary-500 focus:ring-1 focus:outline-none [color-scheme:dark]">
                    </div>
                    <div>
                        <button type="submit" class="w-full md:w-auto px-6 py-2 gradient-primary rounded-lg font-medium text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                            Terapkan Filter
                        </button>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Summary Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass rounded-2xl p-6 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-400 mb-1">Total Pengeluaran (Periode Terpilih)</p>
                        <h3 class="text-3xl font-bold text-white font-display">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="glass rounded-2xl p-6 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-400 mb-1">Total Transaksi</p>
                        <h3 class="text-3xl font-bold text-white font-display">{{ $receipts->count() }} <span class="text-lg text-gray-400 font-normal">struk</span></h3>
                    </div>
                </div>
            </div>

            <!-- Table Preview -->
            <div class="glass rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Preview Data Cetak</h3>
                </div>
                
                @if($receipts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-black/20 text-gray-400 text-xs uppercase tracking-wider border-b border-white/5">
                                    <th class="px-6 py-3 font-medium">Tanggal</th>
                                    <th class="px-6 py-3 font-medium">Toko</th>
                                    <th class="px-6 py-3 font-medium">Item & Kategori</th>
                                    <th class="px-6 py-3 font-medium text-right">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @foreach($receipts as $receipt)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $receipt->receipt_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 font-medium text-white">{{ $receipt->store_name ?: 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs text-gray-400">
                                                {{ $receipt->items->count() }} item tercatat
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-primary-400 text-right">{{ number_format($receipt->total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-white/5 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                        </div>
                        <h3 class="text-lg font-medium text-white mb-2">Tidak ada data</h3>
                        <p class="text-sm text-gray-400">Tidak ada pengeluaran pada periode tanggal yang dipilih.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
