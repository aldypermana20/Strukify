<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kesalahan Server - Strukify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white font-sans antialiased min-h-screen flex items-center justify-center">
    <div class="text-center px-4 max-w-lg mx-auto">
        <div class="text-rose-500 font-bold text-9xl mb-4 font-display">500</div>
        <h1 class="text-3xl font-bold mb-4">Terjadi Kesalahan Server</h1>
        <p class="text-gray-400 mb-8">Wah, sepertinya server kami sedang mengalami sedikit gangguan. Tim kami telah diberitahu dan sedang berusaha memperbaikinya.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl font-semibold text-sm transition-all">
            Coba Kembali ke Beranda
        </a>
    </div>
</body>
</html>
