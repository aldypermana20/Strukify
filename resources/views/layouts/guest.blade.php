<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Strukify') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#e6f4f1] text-surface-900">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8">
        
        <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden min-h-[500px]">
            <!-- Left side (Form) -->
            <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center bg-white relative">
                <div class="w-full max-w-sm mx-auto">
                    <div class="flex justify-start mb-8">
                        <a href="/" class="flex items-center gap-2 group">
                            <div class="w-8 h-8 rounded-lg bg-[#109479] flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold font-display text-sm">S</span>
                            </div>
                            <span class="text-xl font-bold font-display tracking-tight text-[#109479]">Strukify</span>
                        </a>
                    </div>
                    
                    {{ $slot }}
                </div>
            </div>

            <!-- Right side (Illustration/Branding) -->
            <div class="w-full md:w-1/2 p-12 bg-[#109479] hidden md:flex flex-col items-center justify-center text-center">
                <div class="w-40 h-40 rounded-full bg-white/10 flex items-center justify-center mb-8 shadow-inner border border-white/20">
                    <div class="w-24 h-24 rounded-full border-4 border-white flex items-center justify-center relative">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-white font-display mb-4">Catat Pengeluaran Mudah & Cepat 💸</h3>
                <p class="text-white/80 text-sm leading-relaxed max-w-xs mx-auto">
                    Foto struk belanjamu kapan saja. Cek riwayat, analitik, dan kelola keuangan. Semua dalam satu aplikasi!
                </p>
            </div>
        </div>
    </div>
</body>
</html>
