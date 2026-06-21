<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold font-display text-white">
            Dashboard
        </h2>
    </x-slot>

    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="glass rounded-2xl p-8 mb-8 relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-primary-500/10 blur-3xl"></div>
                <div class="absolute bottom-0 right-32 -mb-16 w-48 h-48 rounded-full bg-cyan-500/10 blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl gradient-primary flex items-center justify-center text-2xl font-bold shadow-lg shadow-primary-500/20">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold font-display mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-gray-400">Pantau pengeluaranmu bulan ini dengan AI yang cerdas.</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                            <select name="period" onchange="this.form.submit()" class="px-3 py-2 bg-white/10 border border-white/20 rounded-xl text-white text-sm focus:outline-none">
                                <option value="today" {{ $period === 'today' ? 'selected' : '' }} class="text-gray-900">Hari Ini</option>
                                <option value="month" {{ $period === 'month' ? 'selected' : '' }} class="text-gray-900">Bulan Ini</option>
                                <option value="year" {{ $period === 'year' ? 'selected' : '' }} class="text-gray-900">Tahun Ini</option>
                            </select>
                        </form>
                        <a href="{{ route('scan.index') }}" class="px-6 py-3 gradient-primary rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Scan Struk Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Pengeluaran -->
                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-amber-500/30 transition-colors">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                            <svg class="w-6 h-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-amber-400/80 bg-amber-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $period === 'today' ? 'Hari Ini' : ($period === 'year' ? 'Tahun Ini' : 'Bulan Ini') }}</span>
                    </div>
                    <div class="text-3xl font-bold font-display text-white relative z-10 mb-1">
                        Rp {{ number_format($totalSpending, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-400 relative z-10">Total Pengeluaran</div>
                </div>

                <!-- Total Struk -->
                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-primary-500/30 transition-colors">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-primary-500/10 flex items-center justify-center border border-primary-500/20">
                            <svg class="w-6 h-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <span class="text-xs font-medium text-primary-400/80 bg-primary-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $period === 'today' ? 'Hari Ini' : ($period === 'year' ? 'Tahun Ini' : 'Bulan Ini') }}</span>
                    </div>
                    <div class="text-3xl font-bold font-display text-white relative z-10 mb-1">
                        {{ $totalReceipts }} <span class="text-lg font-normal text-gray-500">struk</span>
                    </div>
                    <div class="text-sm text-gray-400 relative z-10">Struk Tersimpan</div>
                </div>

                <!-- Rata-rata Transaksi -->
                <div class="glass rounded-2xl p-6 relative overflow-hidden group hover:border-cyan-500/30 transition-colors">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center border border-cyan-500/20">
                            <svg class="w-6 h-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-cyan-400/80 bg-cyan-500/10 px-2.5 py-1 rounded-full uppercase tracking-wider">{{ $period === 'today' ? 'Hari Ini' : ($period === 'year' ? 'Tahun Ini' : 'Bulan Ini') }}</span>
                    </div>
                    <div class="text-3xl font-bold font-display text-white relative z-10 mb-1">
                        Rp {{ number_format($avgSpending, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-400 relative z-10">Rata-rata per Struk</div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Trend Chart Area -->
                <div class="lg:col-span-2 glass rounded-2xl p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-white">Tren Pengeluaran</h3>
                        <span class="text-xs text-gray-400">{{ $period === 'today' ? '7 Hari Terakhir' : ($period === 'year' ? 'Per Bulan' : 'Bulan Ini') }}</span>
                    </div>
                    
                    @if(count($trendData) > 0 && array_sum($trendData) > 0)
                        <div class="flex-1 w-full h-[300px] relative" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 500)">
                            <!-- Skeleton Loading -->
                            <div x-show="!loaded" class="absolute inset-0 flex items-end gap-2 px-8 pb-8">
                                @for($i = 0; $i < 12; $i++)
                                    <div class="flex-1 bg-white/5 rounded-t animate-pulse" style="height: {{ rand(20, 80) }}%"></div>
                                @endfor
                            </div>
                            <canvas id="trendChart" x-show="loaded" x-transition></canvas>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-8 h-[300px]">
                            <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                            </div>
                            <h4 class="text-white font-medium mb-1">Belum Ada Data Tren</h4>
                            <p class="text-sm text-gray-400 max-w-xs">Grafik tren akan muncul setelah Anda menyimpan struk.</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="glass rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-white">Aktivitas Terakhir</h3>
                        <a href="{{ route('receipts.index') }}" class="text-sm text-primary-400 hover:text-primary-300 font-medium transition-colors">Lihat Semua</a>
                    </div>

                    @if($recentReceipts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentReceipts as $receipt)
                                <a href="{{ route('receipts.show', $receipt) }}" class="block group">
                                    <div class="p-4 rounded-xl bg-white/5 border border-white/5 group-hover:bg-white/10 group-hover:border-white/10 transition-all flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-surface-900 flex items-center justify-center text-gray-400 group-hover:text-primary-400 transition-colors border border-white/5">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-white text-sm mb-0.5 truncate max-w-[120px]">{{ $receipt->store_name ?: 'Toko Tidak Diketahui' }}</p>
                                                <p class="text-xs text-gray-500">{{ $receipt->receipt_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-sm text-white mb-0.5">Rp {{ number_format($receipt->total, 0, ',', '.') }}</p>
                                            @if($receipt->status === 'saved')
                                                <span class="inline-block text-[10px] font-medium text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full">Disimpan</span>
                                            @else
                                                <span class="inline-block text-[10px] font-medium text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded-full">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center text-center p-6 h-48 border border-dashed border-white/10 rounded-xl">
                            <p class="text-sm text-gray-400 mb-4">Riwayat Anda masih kosong.</p>
                            <a href="{{ route('scan.index') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-sm font-medium transition-colors border border-white/5">
                                Mulai Scan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.font.family = "'Inter', sans-serif";

        // Trend Line Chart
        @if(count($trendData) > 0 && array_sum($trendData) > 0)
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const gradient = trendCtx.createLinearGradient(0, 0, 0, 300);
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
                    x: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { maxTicksLimit: 12 }
                    },
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: {
                            callback: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v)
                        }
                    }
                }
            }
        });
        @endif
    });
    </script>
</x-app-layout>
