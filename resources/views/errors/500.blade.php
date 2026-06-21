<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terjadi Kesalahan - Strukify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4 max-w-lg mx-auto">
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center">
            <svg class="w-10 h-10 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>
        <div class="text-amber-500 font-bold text-8xl mb-4 font-display">500</div>
        <h1 class="text-3xl font-bold mb-4">Terjadi Kesalahan Server</h1>
        <p class="text-gray-400 mb-8">Maaf, terjadi kesalahan di server kami. Tim teknis telah diberitahu. Silakan coba lagi dalam beberapa saat.</p>
        <div class="flex items-center justify-center gap-3">
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 gradient-primary rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
                Kembali ke Beranda
            </a>
            <button onclick="location.reload()" class="inline-block px-6 py-3 bg-white/5 border border-white/10 rounded-xl font-semibold text-sm hover:bg-white/10 transition-all">
                Coba Lagi
            </button>
        </div>
    </div>
</body>
</html>
