<div x-data="{ sidebarOpen: false }" @open-sidebar.window="sidebarOpen = true">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40 sm:hidden" 
         @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col transition-all duration-300 ease-in-out sm:translate-x-0 sm:static sm:h-screen shadow-sm">
        
        <!-- Logo Header -->
        <div class="h-20 flex items-center px-6 border-b border-slate-200 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 w-full">
                <div class="w-10 h-10 rounded-xl bg-[#109479] flex items-center justify-center shadow-md shadow-[#109479]/20">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z" /></svg>
                </div>
                <span class="text-2xl font-bold font-display tracking-tight text-slate-800">Struk<span class="text-[#109479]">ify</span></span>
            </a>
            <!-- Close Button Mobile -->
            <button @click="sidebarOpen = false" class="sm:hidden p-2 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Primary Action: Scan AI -->
        <div class="p-6 shrink-0">
            <a href="{{ route('scan.index') }}" 
               class="group relative flex w-full items-center justify-center gap-2 px-4 py-3.5 rounded-xl text-sm font-bold text-white overflow-hidden transition-all hover:scale-[1.02] bg-[#109479] hover:bg-[#0c7862] shadow-lg shadow-[#109479]/25">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9a3.75 3.75 0 100 7.5A3.75 3.75 0 0012 9z" /><path fill-rule="evenodd" d="M9.344 3.071a49.52 49.52 0 015.312 0c.967.052 1.83.585 2.332 1.39l.821 1.317c.24.383.645.643 1.11.71.386.054.77.113 1.152.177 1.432.239 2.429 1.493 2.429 2.909V18a3 3 0 01-3 3h-15a3 3 0 01-3-3V9.574c0-1.416.997-2.67 2.429-2.909.382-.064.766-.123 1.151-.178a1.56 1.56 0 001.11-.71l.822-1.315a2.942 2.942 0 012.332-1.39zM6.75 12.75a5.25 5.25 0 1110.5 0 5.25 5.25 0 01-10.5 0zm12-1.5a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" /></svg>
                <span class="tracking-wide uppercase">Scan Struk AI</span>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto overflow-x-hidden">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-[#e6f4f1] text-[#109479] border border-[#109479]/20' : 'text-slate-500 hover:text-[#109479] hover:bg-[#e6f4f1]/50' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Dashboard
            </a>
            
            <a href="{{ route('receipts.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('receipts.*') && !request()->routeIs('scan.*') && !request()->routeIs('receipts.export.*') ? 'bg-[#e6f4f1] text-[#109479] border border-[#109479]/20' : 'text-slate-500 hover:text-[#109479] hover:bg-[#e6f4f1]/50' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Riwayat Struk
            </a>
            
            <a href="{{ route('reports.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('reports.*') ? 'bg-[#e6f4f1] text-[#109479] border border-[#109479]/20' : 'text-slate-500 hover:text-[#109479] hover:bg-[#e6f4f1]/50' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan
            </a>
        </nav>

        <!-- User Profile & Settings -->
        <div class="p-4 border-t border-slate-200 shrink-0">
            <div class="flex items-center gap-3 p-3 rounded-xl bg-[#f8faf9] border border-slate-200 relative group">
                <div class="w-10 h-10 rounded-lg bg-[#109479] flex items-center justify-center text-sm font-bold text-white shadow-md shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                
                <div class="flex items-center gap-1 shrink-0">
                    <x-dropdown align="top-right" width="48">
                        <x-slot name="trigger">
                            <button class="p-1.5 rounded-lg text-slate-400 hover:text-[#109479] hover:bg-slate-100 transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="!text-slate-600 hover:!text-[#109479] hover:!bg-[#e6f4f1]">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="!text-red-500 hover:!text-red-600 hover:!bg-red-50">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </aside>

</div>

