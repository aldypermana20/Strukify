<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('receipts.index') }}" class="p-2 text-gray-400 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold font-display text-white">
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
                    <div class="glass rounded-2xl p-6">
                        <h3 class="text-sm font-semibold text-gray-400 mb-4 uppercase tracking-wider">Informasi Toko</h3>
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-1">Nama Toko</p>
                            <p class="font-medium text-white">{{ $receipt->store_name ?: 'Tidak diketahui' }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                            <p class="font-medium text-white">{{ $receipt->receipt_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-primary-400">Rp {{ number_format($receipt->total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="glass rounded-2xl p-6 flex flex-col gap-3">
                        <a href="{{ route('receipts.edit', $receipt) }}" class="w-full text-center px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-sm font-medium transition-colors">
                            Edit Struk
                        </a>
                        <form action="{{ route('receipts.destroy', $receipt) }}" method="POST" onsubmit="return confirm('Hapus struk ini permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 rounded-xl text-sm font-medium transition-colors border border-rose-500/20">
                                Hapus Struk
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Receipt Items -->
                <div class="md:col-span-2">
                    <div class="glass rounded-2xl p-6">
                        <h3 class="text-sm font-semibold text-gray-400 mb-6 uppercase tracking-wider">Daftar Barang ({{ $receipt->items->count() }})</h3>
                        
                        <div class="space-y-4">
                            @foreach($receipt->items as $item)
                                <div class="flex items-start justify-between p-4 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-{{ $item->category ? $item->category->color : 'gray' }}-500/10 flex items-center justify-center text-lg shrink-0">
                                            {{ $item->category ? $item->category->icon : '🏷️' }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-white mb-1">{{ $item->item_name }}</p>
                                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                                <span>{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-600"></span>
                                                <span class="text-{{ $item->category ? $item->category->color : 'gray' }}-400">{{ $item->category ? $item->category->name : 'Tanpa Kategori' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="font-semibold text-white">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
