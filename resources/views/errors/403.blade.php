<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak - Strukify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4 max-w-lg mx-auto">
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center">
            <svg class="w-10 h-10 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
            </svg>
        </div>
        <div class="text-rose-500 font-bold text-8xl mb-4 font-display">403</div>
        <h1 class="text-3xl font-bold mb-4">Akses Ditolak</h1>
        <p class="text-gray-400 mb-8">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Pastikan Anda sudah login dengan akun yang benar.</p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 gradient-primary rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                Kembali ke Beranda
            </a>
            <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-3 bg-white/5 border border-white/10 rounded-xl font-semibold text-sm hover:bg-white/10 transition-all">
                Ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
