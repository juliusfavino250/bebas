<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Icon SVG Profile di Pojok Kiri Atas -->
                <a href="{{ route('profile.show') }}" class="flex items-center gap-2 p-2 rounded-lg text-slate-700 hover:bg-slate-100 transition" title="Lihat Profil">
                    <!-- SVG User Icon (Bukan Emoji) -->
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                </a>
            </div>

            <!-- Menu Lain / Logout di Pojok Kanan -->
            <div class="flex items-center">
                <!-- Tambahkan item navbar kanan sesuai kebutuhan -->
            </div>
        </div>
    </div>
</nav>