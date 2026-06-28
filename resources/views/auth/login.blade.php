<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold font-display text-surface-900 mb-2">Selamat Datang! 👋</h2>
        <p class="text-sm text-surface-500">Login sebagai pelanggan atau admin untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-bold text-surface-700 mb-1.5">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="w-full px-4 py-3 bg-[#f5f8f8] border border-surface-200 rounded-xl text-surface-900 placeholder-surface-400 focus:border-[#109479] focus:ring-1 focus:ring-[#109479] focus:outline-none transition-all text-sm"
                placeholder="budi@budi.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-sm font-bold text-surface-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-sm text-[#109479] hover:text-[#0c7862] font-medium transition-colors" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3 bg-[#f5f8f8] border border-surface-200 rounded-xl text-surface-900 placeholder-surface-400 focus:border-[#109479] focus:ring-1 focus:ring-[#109479] focus:outline-none transition-all text-sm"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center mb-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-surface-300 text-[#109479] focus:ring-[#109479] cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-surface-500 group-hover:text-surface-700 transition-colors">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="w-full px-6 py-3.5 bg-[#109479] text-white rounded-xl font-bold text-sm hover:bg-[#0c7862] transition-colors shadow-sm uppercase tracking-wide">
            Masuk Sekarang
        </button>

        <p class="text-center text-sm text-surface-500 mt-8">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#109479] font-bold hover:text-[#0c7862] transition-colors">Daftar disini</a>
        </p>
    </form>
</x-guest-layout>
