<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Strukify — Aplikasi Pencatat Pengeluaran Pintar & Scanner Struk Otomatis. Scan struk belanja, kelola pengeluaran dengan AI.">
    <title>Strukify — Smart Expense Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-900 text-white font-sans antialiased overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/20 group-hover:shadow-primary-500/40 transition-shadow">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-xl font-bold font-display tracking-tight">Struk<span class="gradient-text">ify</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm text-gray-400 hover:text-white transition-colors">Fitur</a>
                <a href="#how-it-works" class="text-sm text-gray-400 hover:text-white transition-colors">Cara Kerja</a>
                <a href="#stats" class="text-sm text-gray-400 hover:text-white transition-colors">Statistik</a>
            </div>

            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-medium gradient-primary rounded-xl hover:opacity-90 transition-opacity shadow-lg shadow-primary-500/25">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-medium text-gray-300 hover:text-white transition-colors">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-medium gradient-primary rounded-xl hover:opacity-90 transition-opacity shadow-lg shadow-primary-500/25">Daftar Gratis</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-hero min-h-screen flex items-center relative pt-20">
        <!-- Ambient orbs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-float-delayed"></div>

        <div class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <div class="animate-slide-up stagger-1">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-medium bg-primary-500/10 text-primary-400 border border-primary-500/20 mb-6">
                        <span class="w-2 h-2 rounded-full bg-primary-400 animate-pulse"></span>
                        AI-Powered Receipt Scanner
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold font-display leading-tight mb-6 animate-slide-up stagger-2">
                    Catat Pengeluaran<br>
                    <span class="gradient-text">Cukup Foto Struk</span>
                </h1>

                <p class="text-lg text-gray-400 leading-relaxed mb-8 max-w-lg animate-slide-up stagger-3">
                    Strukify menggunakan AI untuk memindai struk belanja Anda secara otomatis, mengelompokkan pengeluaran, dan memberikan insight cerdas untuk keuangan yang lebih sehat.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 animate-slide-up stagger-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-8 py-3.5 text-base font-semibold gradient-primary rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary-500/25 hover:shadow-primary-500/40 text-center">
                            Mulai Gratis →
                        </a>
                    @endif
                    <a href="#how-it-works" class="px-8 py-3.5 text-base font-semibold glass rounded-xl hover:bg-white/10 transition-all text-center">
                        Lihat Demo
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-10 animate-slide-up stagger-5">
                    <div>
                        <div class="text-2xl font-bold gradient-text">99%</div>
                        <div class="text-xs text-gray-500">Akurasi OCR</div>
                    </div>
                    <div class="w-px h-10 bg-surface-600"></div>
                    <div>
                        <div class="text-2xl font-bold gradient-text">&lt;3s</div>
                        <div class="text-xs text-gray-500">Proses Scan</div>
                    </div>
                    <div class="w-px h-10 bg-surface-600"></div>
                    <div>
                        <div class="text-2xl font-bold gradient-text">100%</div>
                        <div class="text-xs text-gray-500">Gratis</div>
                    </div>
                </div>
            </div>

            <!-- Hero Visual -->
            <div class="relative animate-slide-up stagger-4">
                <div class="relative glass rounded-3xl p-6 shadow-2xl">
                    <!-- Receipt mockup -->
                    <div class="bg-white rounded-2xl p-6 text-gray-800 shadow-inner">
                        <div class="text-center mb-4">
                            <div class="text-sm font-bold text-gray-900">SUPERMARKET SEJAHTERA</div>
                            <div class="text-xs text-gray-500">Jl. Merdeka No. 123, Jakarta</div>
                            <div class="text-xs text-gray-400 mt-1">20/04/2026 19:45</div>
                        </div>
                        <div class="border-t border-dashed border-gray-300 my-3"></div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between"><span>Beras 5kg</span><span class="font-medium">Rp 75.000</span></div>
                            <div class="flex justify-between"><span>Minyak Goreng 2L</span><span class="font-medium">Rp 32.000</span></div>
                            <div class="flex justify-between"><span>Telur 1kg</span><span class="font-medium">Rp 28.000</span></div>
                            <div class="flex justify-between"><span>Sabun Cuci</span><span class="font-medium">Rp 15.000</span></div>
                        </div>
                        <div class="border-t border-dashed border-gray-300 my-3"></div>
                        <div class="flex justify-between font-bold text-base">
                            <span>TOTAL</span><span class="text-primary-600">Rp 150.000</span>
                        </div>
                    </div>
                    <!-- Scanning overlay effect -->
                    <div class="absolute inset-6 rounded-2xl overflow-hidden pointer-events-none">
                        <div class="absolute inset-0 bg-gradient-to-b from-primary-400/20 via-transparent to-transparent animate-pulse" style="animation-duration: 3s;"></div>
                    </div>
                    <!-- AI badge -->
                    <div class="absolute -top-3 -right-3 px-3 py-1.5 gradient-primary rounded-full text-xs font-bold shadow-lg shadow-primary-500/30 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.547a1 1 0 01.64 1.894l-1.04.355L18 8.5a1 1 0 01-1 1h-1.05l-.946 2.838 1.042.355a1 1 0 11-.64 1.894l-1.599-.547L10 15.623l-3.954-1.583-1.599.547a1 1 0 01-.64-1.894l1.042-.355L3.903 9.5H3a1 1 0 110-2l1.847-.893-1.04-.355a1 1 0 11.64-1.894l1.599.547L10 3.323V3a1 1 0 011-1z"/></svg>
                        AI Scan
                    </div>
                </div>
                <!-- Floating category badges -->
                <div class="absolute -left-4 top-1/4 px-3 py-1.5 bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-full text-xs font-medium animate-float shadow-lg">🍚 Makanan</div>
                <div class="absolute -right-4 top-1/2 px-3 py-1.5 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-full text-xs font-medium animate-float-delayed shadow-lg">🧴 Kebutuhan Rumah</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-surface-800 relative">
        <div class="absolute inset-0 bg-gradient-to-b from-surface-900 to-surface-800"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider">Fitur Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold font-display mt-3 mb-4">Semua yang Anda Butuhkan</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Dari scan struk hingga analisis pengeluaran, Strukify menyediakan alat lengkap untuk mengelola keuangan Anda.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl gradient-primary flex items-center justify-center mb-4 group-hover:shadow-lg group-hover:shadow-primary-500/30 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Scan Struk Otomatis</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Cukup foto struk belanja Anda. AI kami akan membaca dan mengekstrak semua data secara otomatis.</p>
                </div>
                <!-- Feature 2 -->
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mb-4 group-hover:shadow-lg group-hover:shadow-violet-500/30 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Kategorisasi Cerdas</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">NLP mengelompokkan barang ke kategori: Makanan, Elektronik, Pakaian, dan lainnya secara pintar.</p>
                </div>
                <!-- Feature 3 -->
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mb-4 group-hover:shadow-lg group-hover:shadow-amber-500/30 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Review & Edit</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Tinjau hasil scan, perbaiki typo, ubah kategori, atau tambah barang yang terlewat sebelum menyimpan.</p>
                </div>
                <!-- Feature 4 -->
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center mb-4 group-hover:shadow-lg group-hover:shadow-cyan-500/30 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Dashboard Analitik</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Visualisasi pengeluaran per kategori, tren bulanan, dan insight cerdas dalam satu dashboard.</p>
                </div>
                <!-- Feature 5 -->
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center mb-4 group-hover:shadow-lg group-hover:shadow-rose-500/30 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Riwayat Lengkap</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Akses semua struk lama Anda kapan saja. Filter berdasarkan tanggal, toko, atau kategori belanja.</p>
                </div>
                <!-- Feature 6 -->
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-lime-500 to-green-600 flex items-center justify-center mb-4 group-hover:shadow-lg group-hover:shadow-lime-500/30 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Export Data</h3>
                    <p class="text-sm text-gray-400 leading-relaxed">Download laporan pengeluaran dalam format CSV. Cocok untuk pelaporan dan analisis lebih lanjut.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-24 bg-surface-900 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-primary-400 text-sm font-semibold uppercase tracking-wider">Cara Kerja</span>
                <h2 class="text-3xl md:text-4xl font-bold font-display mt-3 mb-4">Semudah 1-2-3</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Proses scan struk hanya membutuhkan 3 langkah sederhana.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-20 h-20 mx-auto rounded-2xl gradient-primary flex items-center justify-center mb-6 group-hover:animate-pulse-glow transition-all text-3xl font-bold">1</div>
                    <h3 class="text-xl font-semibold mb-3">Foto Struk</h3>
                    <p class="text-gray-400 text-sm">Upload gambar struk belanja Anda dari kamera atau galeri.</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mb-6 group-hover:animate-pulse-glow transition-all text-3xl font-bold">2</div>
                    <h3 class="text-xl font-semibold mb-3">AI Memproses</h3>
                    <p class="text-gray-400 text-sm">OCR membaca teks, NLP mengkategorikan setiap item secara otomatis.</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mb-6 group-hover:animate-pulse-glow transition-all text-3xl font-bold">3</div>
                    <h3 class="text-xl font-semibold mb-3">Review & Simpan</h3>
                    <p class="text-gray-400 text-sm">Periksa hasil, edit jika perlu, lalu simpan ke riwayat pengeluaran Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="stats" class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 gradient-hero"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl md:text-5xl font-bold font-display mb-6">Mulai Kontrol<br><span class="gradient-text">Keuangan Anda Sekarang</span></h2>
            <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto">Bergabung dengan Strukify dan ubah struk belanja Anda menjadi insight keuangan yang berharga.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-block px-10 py-4 text-lg font-semibold gradient-primary rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary-500/25 hover:shadow-primary-500/40">
                    Daftar Gratis Sekarang →
                </a>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 bg-surface-900 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg gradient-primary flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="text-sm font-semibold font-display">Strukify</span>
            </div>
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} Strukify. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navbar background on scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('glass', 'shadow-lg');
            } else {
                navbar.classList.remove('glass', 'shadow-lg');
            }
        });
    </script>
</body>
</html>
