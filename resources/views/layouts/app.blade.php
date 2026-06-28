<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Strukify') }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><defs><linearGradient id='g' x1='0' y1='0' x2='1' y2='1'><stop offset='0%25' stop-color='%23109479'/><stop offset='100%25' stop-color='%230c7862'/></linearGradient></defs><rect width='32' height='32' rx='8' fill='url(%23g)'/><path d='M10 8h4a2 2 0 012 2v0a2 2 0 01-2 2h-4M10 8v4M22 8h-4a2 2 0 00-2 2v0a2 2 0 002 2h4M22 8v4M10 12v12a2 2 0 002 2h8a2 2 0 002-2V12M13 17l2 2 4-4' fill='none' stroke='white' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-[#e6f4f1] relative transition-colors duration-300">
    <!-- Global Mesh Gradient Background -->
    <div class="fixed inset-0 z-[-2] bg-[#e6f4f1] overflow-hidden transition-colors duration-300">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-[#109479]/10 mix-blend-multiply filter blur-3xl opacity-70 animate-float"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-[#109479]/10 mix-blend-multiply filter blur-3xl opacity-60 animate-float-delayed"></div>
        <div class="absolute -bottom-40 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full bg-[#109479]/5 mix-blend-multiply filter blur-3xl opacity-70 animate-float"></div>
    </div>
    <!-- Soft Overlay -->
    <div class="fixed inset-0 z-[-1] bg-white/40 backdrop-blur-[100px] transition-colors duration-300"></div>

    <div class="flex h-screen overflow-hidden relative z-0">
    <!-- Sidebar Navigation -->
    @include('layouts.navigation')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white/70 backdrop-blur-xl border-b border-slate-200 sticky top-0 z-40 transition-colors duration-300">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center gap-4">
                    <!-- Hamburger (Mobile Only) -->
                    <button @click="window.dispatchEvent(new CustomEvent('open-sidebar'))" class="sm:hidden p-2 -ml-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-all">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div class="flex-1 w-full truncate">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden">
            <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Confirm Delete Modal -->
    <x-confirm-modal />
    </div>
</body>
</html>
