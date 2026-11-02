<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PKL Management - Sistem Informasi PKL Siswa</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen">
    <!-- Navbar Navigasi Atas -->
    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- SISI KIRI: Ikon Profil SVG & Nama Aplikasi -->
                <div class="flex items-center gap-4">
                    @auth
                        <!-- Tombol Profil (SVG di Pojok Kiri Atas) -->
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded-lg text-sm font-semibold transition shadow-sm" title="Lihat Profil Saya">
                            <!-- Icon SVG User (Bukan Emoji) -->
                            <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="hidden sm:inline">Profil</span>
                        </a>
                    @endauth

                    <div class="font-bold text-lg tracking-wide">
                        PKL Management
                    </div>
                </div>

                <!-- SISI KANAN: Tombol Logout -->
                <div>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-1.5 rounded text-sm font-semibold transition">
                                Keluar (Logout)
                            </button>
                        </form>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    <!-- Header Opsional -->
    @isset($header)
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Konten Utama Halaman -->
    <main>
        {{ $slot }}
    </main>
</body>
</html>