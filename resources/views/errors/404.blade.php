<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - Strukify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4 max-w-lg mx-auto">
        <div class="text-primary-500 font-bold text-9xl mb-4 font-display">404</div>
        <h1 class="text-3xl font-bold mb-4">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-400 mb-8">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan. Mari kembali ke tempat yang aman.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-3 gradient-primary rounded-xl font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary-500/25">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
