<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Strukify — Aplikasi Pencatat Pengeluaran Pintar & Scanner Struk Otomatis. Scan struk belanja, kelola pengeluaran dengan AI.">
    <title>Strukify — Aplikasi Pengarsipan Struk Cerdas</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0%25' stop-color='%23109479'/><stop offset='100%25' stop-color='%230c7862'/></linearGradient></defs><rect width='32' height='32' rx='8' fill='url(%23g)'/><path d='M10 8h4a2 2 0 012 2v0a2 2 0 01-2 2h-4M10 8v4M22 8h-4a2 2 0 00-2 2v0a2 2 0 002 2h4M22 8v4M10 12v12a2 2 0 002 2h8a2 2 0 002-2V12M13 17l2 2 4-4' fill='none' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-surface-900 custom-scrollbar bg-[#e6f4f1] selection:bg-[#109479]/30">

    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 w-full z-50 border-b border-[#109479]/10 transition-all duration-300 bg-white/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-[#109479] flex items-center justify-center shadow-lg shadow-[#109479]/20 group-hover:shadow-[#109479]/40 transition-shadow">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-xl font-bold font-display tracking-tight text-surface-900">Struk<span class="text-[#109479]">ify</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-medium text-surface-600 hover:text-[#109479] transition-colors">Fitur</a>
                <a href="#how-it-works" class="text-sm font-medium text-surface-600 hover:text-[#109479] transition-colors">Cara Kerja</a>
                <a href="#stats" class="text-sm font-medium text-surface-600 hover:text-[#109479] transition-colors">Mulai</a>
            </div>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-bold bg-[#109479] text-white rounded-xl hover:bg-[#0c7862] transition-colors shadow-lg shadow-[#109479]/25">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-bold text-[#109479] hover:text-[#0c7862] transition-colors">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold bg-[#109479] text-white rounded-xl hover:bg-[#0c7862] transition-colors shadow-lg shadow-[#109479]/25">Daftar Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="min-h-screen flex items-center relative overflow-hidden pt-20 bg-[#e6f4f1]">

        <div class="max-w-7xl mx-auto px-6 w-full h-full flex flex-col justify-center relative z-20 pointer-events-none">
            
            <!-- Huge Overlapping Typography on the Left -->
            <div class="absolute left-6 lg:left-12 top-1/2 -translate-y-1/2 z-30 hidden md:block">
                <h1 class="font-extrabold font-display tracking-tighter flex flex-col" style="font-size: clamp(2.5rem, 5vw, 5rem); line-height: 0.95;">
                    <span class="text-surface-900 drop-shadow-sm">Catat</span>
                    <span class="text-surface-900 drop-shadow-sm z-10">Pengeluaran</span>
                    <span class="text-surface-900 drop-shadow-sm z-20">Cukup Foto</span>
                    <span class="text-[#109479] drop-shadow-sm z-30" style="margin-top: -0.1em;">Struk</span>
                </h1>
                <div class="mt-8 pl-2">
                    <p class="text-surface-600 text-sm font-mono uppercase tracking-[0.2em] leading-relaxed mb-8">
                        Strukify App<br>AI Receipt Scanner
                    </p>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-between pl-6 pr-2 py-2 bg-[#109479] hover:bg-[#0c7862] transition-colors rounded-full shadow-lg shadow-[#109479]/30 w-[240px] group pointer-events-auto">
                            <span class="text-white font-semibold text-sm">Mulai Gratis Sekarang</span>
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white group-hover:bg-white/30 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Mobile Title (Visible only on small screens) -->
            <div class="md:hidden text-center mb-10 z-30 mt-[-200px] pointer-events-auto flex flex-col items-center">
                <h1 class="text-4xl font-extrabold font-display leading-tight mb-4 text-surface-900 drop-shadow-sm">
                    Catat Pengeluaran<br>
                    <span class="text-[#109479]">Cukup Foto Struk</span>
                </h1>
                <p class="text-surface-600 text-sm mb-8">AI Scanner Cerdas untuk Keuangan Sehat</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="flex items-center justify-between pl-6 pr-2 py-2 bg-[#109479] hover:bg-[#0c7862] transition-colors rounded-full shadow-lg shadow-[#109479]/30 w-[240px] group">
                        <span class="text-white font-semibold text-sm">Mulai Gratis Sekarang</span>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white group-hover:bg-white/30 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Right side elements: Abstract Receipt Decoration -->
            <div class="absolute top-1/2 right-12 -translate-y-1/2 w-[400px] h-[400px] z-0 hidden lg:flex items-center justify-center animate-fade-in stagger-5 pointer-events-none">
                <!-- Decorative Blobs/Background -->
                <div class="absolute w-[300px] h-[300px] bg-[#109479]/10 rounded-full blur-3xl"></div>
                <div class="absolute w-[200px] h-[200px] bg-[#109479]/20 rounded-full blur-2xl top-10 right-10"></div>
                
                <!-- Main Receipt Card -->
                <div class="relative bg-white p-6 rounded-2xl shadow-2xl shadow-[#109479]/20 border border-surface-100 w-64 transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <!-- Receipt Header -->
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-dashed border-surface-200">
                        <div class="w-10 h-10 bg-[#e6f4f1] rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#109479]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="text-right">
                            <div class="h-2 w-16 bg-surface-200 rounded-full mb-2"></div>
                            <div class="h-2 w-10 bg-surface-100 rounded-full ml-auto"></div>
                        </div>
                    </div>
                    
                    <!-- Receipt Items -->
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-3 items-center">
                                <div class="w-8 h-8 rounded-full bg-surface-100"></div>
                                <div>
                                    <div class="h-2 w-20 bg-surface-200 rounded-full mb-1.5"></div>
                                    <div class="h-1.5 w-12 bg-surface-100 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-2.5 w-12 bg-surface-200 rounded-full"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex gap-3 items-center">
                                <div class="w-8 h-8 rounded-full bg-[#e6f4f1]"></div>
                                <div>
                                    <div class="h-2 w-24 bg-[#109479]/40 rounded-full mb-1.5"></div>
                                    <div class="h-1.5 w-16 bg-surface-100 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-2.5 w-14 bg-[#109479]/60 rounded-full"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex gap-3 items-center">
                                <div class="w-8 h-8 rounded-full bg-surface-100"></div>
                                <div>
                                    <div class="h-2 w-16 bg-surface-200 rounded-full mb-1.5"></div>
                                    <div class="h-1.5 w-10 bg-surface-100 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-2.5 w-10 bg-surface-200 rounded-full"></div>
                        </div>
                    </div>

                    <!-- Receipt Total -->
                    <div class="pt-4 border-t border-dashed border-surface-200 flex justify-between items-end">
                        <div class="h-3 w-16 bg-surface-200 rounded-full"></div>
                        <div class="h-4 w-24 bg-[#109479] rounded-full"></div>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="absolute top-10 left-10 w-12 h-12 bg-white rounded-2xl shadow-xl shadow-[#109479]/10 flex items-center justify-center transform -rotate-12 animate-bounce" style="animation-duration: 3s;">
                    <span class="text-xl">✨</span>
                </div>
                <div class="absolute bottom-10 right-10 w-14 h-14 bg-[#109479] rounded-2xl shadow-xl shadow-[#109479]/30 flex items-center justify-center transform rotate-12 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Bottom pagination dots -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex items-center gap-3 z-20">
                <div class="w-2 h-2 rounded-full bg-[#109479]/30"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-[#109479]"></div>
                <div class="w-2 h-2 rounded-full bg-[#109479]/30"></div>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white relative">
        <div class="absolute inset-0 bg-gradient-to-b from-[#e6f4f1] to-white"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-[#109479] text-sm font-bold uppercase tracking-wider">Fitur Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold font-display mt-3 mb-4 text-surface-900">Semua yang Anda Butuhkan</h2>
                <p class="text-surface-600 max-w-2xl mx-auto">Dari scan struk hingga analisis pengeluaran, Strukify menyediakan alat lengkap untuk mengelola keuangan Anda.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-surface-200/50 border border-[#e6f4f1] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center mb-4 group-hover:bg-[#109479] transition-colors">
                        <svg class="w-6 h-6 text-[#109479] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 mb-2">Scan Struk Otomatis</h3>
                    <p class="text-sm text-surface-600 leading-relaxed">Cukup foto struk belanja Anda. AI kami akan membaca dan mengekstrak semua data secara otomatis.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-surface-200/50 border border-[#e6f4f1] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center mb-4 group-hover:bg-[#109479] transition-colors">
                        <svg class="w-6 h-6 text-[#109479] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 mb-2">Kategorisasi Cerdas</h3>
                    <p class="text-sm text-surface-600 leading-relaxed">NLP mengelompokkan barang ke kategori: Makanan, Elektronik, Pakaian, dan lainnya secara pintar.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-surface-200/50 border border-[#e6f4f1] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center mb-4 group-hover:bg-[#109479] transition-colors">
                        <svg class="w-6 h-6 text-[#109479] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 mb-2">Review & Edit</h3>
                    <p class="text-sm text-surface-600 leading-relaxed">Tinjau hasil scan, perbaiki typo, ubah kategori, atau tambah barang yang terlewat sebelum menyimpan.</p>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-surface-200/50 border border-[#e6f4f1] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center mb-4 group-hover:bg-[#109479] transition-colors">
                        <svg class="w-6 h-6 text-[#109479] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 mb-2">Dashboard Analitik</h3>
                    <p class="text-sm text-surface-600 leading-relaxed">Visualisasi pengeluaran per kategori, tren bulanan, dan insight cerdas dalam satu dashboard.</p>
                </div>
                <!-- Feature 5 -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-surface-200/50 border border-[#e6f4f1] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center mb-4 group-hover:bg-[#109479] transition-colors">
                        <svg class="w-6 h-6 text-[#109479] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 mb-2">Riwayat Lengkap</h3>
                    <p class="text-sm text-surface-600 leading-relaxed">Akses semua struk lama Anda kapan saja. Filter berdasarkan tanggal, toko, atau kategori belanja.</p>
                </div>
                <!-- Feature 6 -->
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-surface-200/50 border border-[#e6f4f1] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-[#e6f4f1] flex items-center justify-center mb-4 group-hover:bg-[#109479] transition-colors">
                        <svg class="w-6 h-6 text-[#109479] group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-surface-900 mb-2">Export Data</h3>
                    <p class="text-sm text-surface-600 leading-relaxed">Download laporan pengeluaran dalam format CSV. Cocok untuk pelaporan dan analisis lebih lanjut.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-24 bg-[#e6f4f1] relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-[#109479] text-sm font-bold uppercase tracking-wider">Cara Kerja</span>
                <h2 class="text-3xl md:text-4xl font-bold font-display mt-3 mb-4 text-surface-900">3 Langkah Sederhana</h2>
                <p class="text-surface-600 max-w-2xl mx-auto">Proses pencatatan struk yang cepat dan otomatis.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center group bg-white p-8 rounded-3xl shadow-lg border border-white hover:border-[#109479]/30 transition-colors">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-[#e6f4f1] text-[#109479] flex items-center justify-center mb-6 group-hover:bg-[#109479] group-hover:text-white transition-all text-3xl font-bold shadow-sm">1</div>
                    <h3 class="text-xl font-bold text-surface-900 mb-3">Foto Struk</h3>
                    <p class="text-surface-600 text-sm">Upload gambar struk belanja Anda dari kamera atau galeri smartphone.</p>
                </div>
                <div class="text-center group bg-white p-8 rounded-3xl shadow-lg border border-white hover:border-[#109479]/30 transition-colors">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-[#e6f4f1] text-[#109479] flex items-center justify-center mb-6 group-hover:bg-[#109479] group-hover:text-white transition-all text-3xl font-bold shadow-sm">2</div>
                    <h3 class="text-xl font-bold text-surface-900 mb-3">AI Memproses</h3>
                    <p class="text-surface-600 text-sm">Gemini AI membaca teks, dan NLP mengkategorikan setiap item secara cerdas.</p>
                </div>
                <div class="text-center group bg-white p-8 rounded-3xl shadow-lg border border-white hover:border-[#109479]/30 transition-colors">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-[#e6f4f1] text-[#109479] flex items-center justify-center mb-6 group-hover:bg-[#109479] group-hover:text-white transition-all text-3xl font-bold shadow-sm">3</div>
                    <h3 class="text-xl font-bold text-surface-900 mb-3">Review & Simpan</h3>
                    <p class="text-surface-600 text-sm">Periksa hasilnya, edit jika diperlukan, lalu simpan ke riwayat pengeluaran.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="stats" class="py-24 relative overflow-hidden bg-white">
        <div class="absolute inset-0 bg-[#e6f4f1]/50"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#109479]/10 rounded-full blur-3xl"></div>
        <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold font-display mb-6 text-surface-900">Mulai Kontrol<br><span class="text-[#109479]">Keuangan Anda Sekarang</span></h2>
            <p class="text-surface-600 text-lg mb-10 max-w-xl mx-auto">Bergabung dengan Strukify dan ubah struk belanja Anda menjadi insight keuangan yang berharga.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-block px-10 py-4 text-lg font-bold bg-[#109479] text-white rounded-xl hover:bg-[#0c7862] transition-all shadow-lg shadow-[#109479]/25 hover:-translate-y-1">
                    Daftar Gratis Sekarang →
                </a>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-[#109479] text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-white text-[#109479] flex items-center justify-center">
                            <span class="font-bold font-display text-sm">S</span>
                        </div>
                        <span class="text-lg font-bold font-display text-white">Strukify</span>
                    </div>
                    <p class="text-white/80 text-sm leading-relaxed">Aplikasi Pengarsipan Struk Cerdas berbasis AI untuk membantu Anda mencatat dan mendigitalisasi dokumen struk belanja dengan lebih mudah.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Navigasi</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-sm text-white/80 hover:text-white transition-colors">Fitur Unggulan</a></li>
                        <li><a href="#how-it-works" class="text-sm text-white/80 hover:text-white transition-colors">Cara Kerja</a></li>
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}" class="text-sm text-white/80 hover:text-white transition-colors">Masuk</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="text-sm text-white/80 hover:text-white transition-colors">Daftar Gratis</a></li>
                            @endif
                        @endif
                    </ul>
                </div>

                <!-- Tim Pengembang -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Tim Pengembang</h4>
                    <ul class="space-y-3">
                        <li class="text-sm text-white/80">Aldy Permana - 1237050003</li>
                        <li class="text-sm text-white/80">Andhika Pratama Kurniawan - 1237050117</li>
                        <li class="text-sm text-white/80">Annisa Rasha Azaliyya Wafeeqa - 1237050058</li>
                        <li class="text-sm text-white/80">Aura Ghifarani - 1237050145</li>
                        <li class="text-sm text-white/80">Fauzi Rizki Hermawan Saputra - 1237050115</li>
                    </ul>
                    <a href="https://github.com/aldypermana20/Strukify" target="_blank" class="inline-flex items-center gap-2 text-sm text-white hover:text-white/80 transition-colors mt-6 bg-white/10 px-4 py-2 rounded-lg font-bold">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        Lihat di GitHub
                    </a>
                </div>
            </div>

            <div class="pt-8 border-t border-white/20 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-white/60">&copy; {{ date('Y') }} Strukify. All rights reserved.</p>
                <p class="text-xs text-white/60">Dibuat Oleh Tim Strukify — UIN Sunan Gunung Djati Bandung</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-md');
                navbar.classList.remove('bg-white/80', 'border-[#109479]/10');
                navbar.classList.add('bg-white', 'border-b', 'border-gray-100');
            } else {
                navbar.classList.remove('shadow-md', 'bg-white', 'border-gray-100');
                navbar.classList.add('bg-white/80', 'border-[#109479]/10');
            }
        });
    </script>
</body>
</html>
