<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold font-display text-slate-800">
            Dashboard
        </h2>
    </x-slot>

    <!-- Include ApexCharts from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white rounded-2xl p-8 mb-8 relative overflow-hidden border border-[#109479]/10 shadow-sm">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-[#109479]/5 blur-3xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-[#109479] flex items-center justify-center text-2xl font-bold text-white shadow-lg shadow-[#109479]/20">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold font-display mb-1 text-slate-800">Halo, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-slate-500">Pantau pengeluaranmu bulan ini dengan AI yang cerdas.</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
                            <select name="period" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-slate-200 rounded-xl text-slate-700 text-sm focus:outline-none focus:border-[#109479]">
                                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="year" {{ $period === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            </select>
                        </form>
                        <a href="{{ route('scan.index') }}" class="px-6 py-3 bg-[#109479] hover:bg-[#0c7862] text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-[#109479]/25 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Scan Struk Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-3 gap-6 mb-8">
                <!-- Total Pengeluaran -->
                <div class="bg-white rounded-2xl p-6 relative overflow-hidden group hover:border-amber-400/50 transition-colors min-w-0 border border-slate-100 shadow-sm">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center border border-amber-200/50 shrink-0">
                            <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V5.988c0-.754-.726-1.294-1.453-1.096A60.07 60.07 0 012.25 6.993v11.757z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5h.008v.008h-.008v-.008zm-7.25-1.5a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>
                        </div>
                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full uppercase tracking-wider truncate ml-2 border border-amber-200/50">{{ $period === 'today' ? 'Hari Ini' : ($period === 'year' ? 'Tahun Ini' : 'Bulan Ini') }}</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold font-display text-slate-800 relative z-10 mb-1 truncate">
                        Rp {{ number_format($totalSpending, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-slate-500 relative z-10 truncate">Total Pengeluaran</div>
                </div>

                <!-- Total Struk -->
                <div class="bg-white rounded-2xl p-6 relative overflow-hidden group hover:border-[#109479]/30 transition-colors min-w-0 border border-slate-100 shadow-sm">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#109479]/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center border border-[#109479]/20 shrink-0">
                            <svg class="w-6 h-6 text-[#109479]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        </div>
                        <span class="text-xs font-medium text-[#109479] bg-[#e6f4f1] px-2.5 py-1 rounded-full uppercase tracking-wider truncate ml-2 border border-[#109479]/20">{{ $period === 'today' ? 'Hari Ini' : ($period === 'year' ? 'Tahun Ini' : 'Bulan Ini') }}</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold font-display text-slate-800 relative z-10 mb-1 truncate">
                        {{ $totalReceipts }} <span class="text-lg font-normal text-slate-400">struk</span>
                    </div>
                    <div class="text-sm text-slate-500 relative z-10 truncate">Struk Tersimpan</div>
                </div>

                <!-- Kategori Terbesar -->
                <div class="bg-white rounded-2xl p-6 relative overflow-hidden group hover:border-emerald-400/30 transition-colors min-w-0 border border-slate-100 shadow-sm">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center border border-emerald-200/50 shrink-0">
                            <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                        </div>
                        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-wider truncate ml-2 border border-emerald-200/50">{{ $period === 'today' ? 'Hari Ini' : ($period === 'year' ? 'Tahun Ini' : 'Bulan Ini') }}</span>
                    </div>
                    <div class="text-2xl sm:text-3xl font-bold font-display text-slate-800 relative z-10 mb-1 truncate">
                        {{ $topCategoryName }}
                    </div>
                    <div class="text-sm text-slate-500 relative z-10 truncate">Pengeluaran Terbesar</div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 2xl:grid-cols-3 gap-8 mb-8">
                <!-- Trend Chart Area -->
                <div class="2xl:col-span-2 bg-white rounded-2xl p-6 flex flex-col min-w-0 border border-slate-100 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Analisis Kategori</h3>
                        </div>
                        <div class="text-sm text-slate-400">Distribusi Pengeluaran</div>
                    </div>
                    
                    @if(count($categoryData) > 0 && array_sum($categoryData) > 0)
                        <div class="flex-1 w-full h-[300px] relative">
                            <div id="categoryChart" class="w-full h-full -ml-3 flex items-center justify-center"></div>
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-8 h-[300px]">
                            <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75z"/></svg>
                            </div>
                            <h4 class="text-slate-700 font-medium mb-1">Belum Ada Data Tren</h4>
                            <p class="text-sm text-slate-400 max-w-xs">Grafik tren akan muncul setelah Anda menyimpan struk.</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl p-6 min-w-0 border border-slate-100 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-800">Aktivitas Terakhir</h3>
                        <a href="{{ route('receipts.index') }}" class="text-sm text-[#109479] hover:text-[#0c7862] font-medium transition-colors">Lihat Semua</a>
                    </div>

                    @if($recentReceipts->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentReceipts as $receipt)
                                <a href="{{ route('receipts.show', $receipt) }}" class="block group">
                                    <div class="p-4 rounded-xl bg-slate-50/50 border border-slate-100 group-hover:bg-[#e6f4f1]/50 group-hover:border-[#109479]/20 transition-all flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-slate-400 group-hover:text-[#109479] transition-colors border border-slate-200">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-800 text-sm mb-0.5 truncate max-w-[120px]">{{ $receipt->store_name ?: 'Toko Tidak Diketahui' }}</p>
                                                <p class="text-xs text-slate-400">{{ $receipt->receipt_date->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-sm text-slate-800 mb-0.5">Rp {{ number_format($receipt->total, 0, ',', '.') }}</p>
                                            @if($receipt->status === 'saved')
                                                <span class="inline-block text-[10px] font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200/50">Disimpan</span>
                                            @else
                                                <span class="inline-block text-[10px] font-medium text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200/50">Pending</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-6 bg-slate-50 rounded-xl border border-slate-100">
                            <p class="text-sm text-slate-400 mb-4">Belum ada struk yang disimpan.</p>
                            <a href="{{ route('scan.index') }}" class="px-4 py-2 bg-[#109479] hover:bg-[#0c7862] text-white rounded-xl text-sm font-medium transition-colors">
                                Mulai Scan
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    let categoryChart = null;

    document.addEventListener('DOMContentLoaded', function() {
        const textColor = '#64748b';

        // Donut Chart for Categories
        @if(count($categoryData) > 0 && array_sum($categoryData) > 0)
        const options = {
            series: @json($categoryData),
            labels: @json($categoryLabels),
            chart: {
                type: 'donut',
                height: 320,
                animations: { enabled: false },
                background: 'transparent'
            },
            colors: ['#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ef4444', '#14b8a6', '#f97316', '#64748b'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: { show: false }
                    }
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: false },
            legend: {
                position: 'right',
                offsetY: 0,
                height: 250,
                labels: { colors: textColor, useSeriesColors: false }
            },
            theme: { mode: 'light' },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return "Rp " + new Intl.NumberFormat('id-ID').format(val) } }
            }
        };

        categoryChart = new ApexCharts(document.querySelector("#categoryChart"), options);
        categoryChart.render();
        @endif
    });
    </script>

</x-app-layout>
