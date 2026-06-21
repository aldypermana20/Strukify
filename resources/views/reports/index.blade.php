<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Laporan Keuangan'],
        ]" />
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-primary-500/30 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-500/10 flex items-center justify-center border border-primary-500/20">
                                <svg class="w-5 h-5 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total</p>
                        </div>
                        <h3 class="text-2xl font-bold text-white font-display">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center border border-emerald-500/20">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Transaksi</p>
                        </div>
                        <h3 class="text-2xl font-bold text-white font-display">{{ $receipts->count() }} <span class="text-lg text-gray-400 font-normal">struk</span></h3>
                    </div>
                </div>

                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-cyan-500/30 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center border border-cyan-500/20">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M3 20.25h18M3.75 4.5h16.5"/></svg>
                            </div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Rata-rata</p>
                        </div>
                        <h3 class="text-2xl font-bold text-white font-display">Rp {{ number_format($avgPerTransaction, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-amber-500/30 transition-colors">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>
                            </div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">vs Periode Lalu</p>
                        </div>
                        @if($percentChange !== null)
                            <h3 class="text-2xl font-bold font-display {{ $percentChange >= 0 ? 'text-rose-400' : 'text-emerald-400' }}">
                                {{ $percentChange >= 0 ? '+' : '' }}{{ $percentChange }}%
                            </h3>
                        @else
                            <h3 class="text-2xl font-bold text-gray-500 font-display">—</h3>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Trend Chart -->
            <div class="glass rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-white">Tren Pengeluaran</h3>
                    <span class="text-xs text-gray-400">{{ $period === 'year' ? 'Per Bulan' : 'Per Hari' }}</span>
                </div>
                @if(count($trendData) > 0 && array_sum($trendData) > 0)
                    <div class="h-[300px] relative">
                        <canvas id="trendChart"></canvas>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center text-center p-8 h-[300px]">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center mb-3">
                            <svg class="w-7 h-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">Belum ada data tren untuk periode ini.</p>
                    </div>
                @endif
            </div>

            <!-- Table Preview -->
            <div class="glass rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-300 uppercase tracking-wider">Detail Transaksi</h3>
                    <span class="text-xs text-gray-400">{{ $receipts->count() }} struk ditemukan</span>
                </div>
                
                @if($receipts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-black/20 text-gray-400 text-xs uppercase tracking-wider border-b border-white/5">
                                    <th class="px-6 py-3 font-medium">Tanggal</th>
                                    <th class="px-6 py-3 font-medium">Toko</th>
                                    <th class="px-6 py-3 font-medium">Alamat</th>
                                    <th class="px-6 py-3 font-medium text-right">Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @foreach($receipts as $receipt)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $receipt->receipt_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 font-medium text-white">{{ $receipt->store_name ?: 'Tidak diketahui' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs text-gray-400 truncate max-w-xs" title="{{ $receipt->address }}">
                                                {{ $receipt->address ?: 'Tidak ada alamat' }}
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

    @if(count($trendData) > 0 && array_sum($trendData) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.color = '#9ca3af';
            Chart.defaults.font.family = "'Inter', sans-serif";

            // Trend Line Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const gradient = trendCtx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(0, 191, 165, 0.3)');
            gradient.addColorStop(1, 'rgba(0, 191, 165, 0.0)');

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [{
                        label: 'Pengeluaran',
                        data: @json($trendData),
                        borderColor: '#00bfa5',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#00bfa5',
                        pointBorderColor: '#111827',
                        pointBorderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.95)',
                            titleColor: '#fff', bodyColor: '#fff',
                            padding: 12, borderColor: 'rgba(255,255,255,0.1)',
                            borderWidth: 1, cornerRadius: 8,
                            callbacks: {
                                label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
                            }
                        }
                    },
                    scales: {
                        x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { maxTicksLimit: 10 } },
                        y: {
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: { callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>
