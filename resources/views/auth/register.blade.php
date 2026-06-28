<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold font-display text-surface-900 mb-2">Daftar Akun Baru 🚀</h2>
        <p class="text-sm text-surface-500">Bergabunglah dengan kami! Masukkan detail Anda untuk membuat akun.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <label for="name" class="block text-sm font-bold text-surface-700 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full px-4 py-3 bg-[#f5f8f8] border border-surface-200 rounded-xl text-surface-900 placeholder-surface-400 focus:border-[#109479] focus:ring-1 focus:ring-[#109479] focus:outline-none transition-all text-sm"
                placeholder="Budi Santoso">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-bold text-surface-700 mb-1.5">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full px-4 py-3 bg-[#f5f8f8] border border-surface-200 rounded-xl text-surface-900 placeholder-surface-400 focus:border-[#109479] focus:ring-1 focus:ring-[#109479] focus:outline-none transition-all text-sm"
                placeholder="budi@budi.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="block text-sm font-bold text-surface-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full px-4 py-3 bg-[#f5f8f8] border border-surface-200 rounded-xl text-surface-900 placeholder-surface-400 focus:border-[#109479] focus:ring-1 focus:ring-[#109479] focus:outline-none transition-all text-sm"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-8">
            <label for="password_confirmation" class="block text-sm font-bold text-surface-700 mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full px-4 py-3 bg-[#f5f8f8] border border-surface-200 rounded-xl text-surface-900 placeholder-surface-400 focus:border-[#109479] focus:ring-1 focus:ring-[#109479] focus:outline-none transition-all text-sm"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full px-6 py-3.5 bg-[#109479] text-white rounded-xl font-bold text-sm hover:bg-[#0c7862] transition-colors shadow-sm uppercase tracking-wide">
            Daftar Sekarang
        </button>

        <p class="text-center text-sm text-surface-500 mt-8">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#109479] font-bold hover:text-[#0c7862] transition-colors">Masuk disini</a>
        </p>
    </form>
</x-guest-layout>
