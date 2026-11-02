<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard HRD / Perusahaan Mitra
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Cek Data Perusahaan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($company)
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded">Perusahaan Terdaftar</span>
                            <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $company->name }}</h3>
                            <p class="text-sm text-slate-500 mt-1">📍 {{ $company->address }} ({{ $company->location }})</p>
                            <p class="text-sm text-slate-600 mt-3">{{ $company->description }}</p>
                        </div>
                        <a href="{{ route('companies.edit', $company->id) }}" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                            Edit Profil Perusahaan
                        </a>
                    </div>
                @else
                    <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded text-sm space-y-2">
                        <p class="font-bold">Data Perusahaan Belum Dibuat!</p>
                        <p>Silakan daftarkan informasi perusahaan Anda terlebih dahulu agar guru dapat melihat dan mengirimkan pengajuan kerja sama.</p>
                        <a href="{{ route('companies.create') }}" class="inline-block mt-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold px-4 py-2 rounded-lg transition text-xs">
                            + Buat Data Perusahaan Sekarang
                        </a>
                    </div>
                @endif
            </div>

            <!-- Menu Cepat / Navigasi Request Guru -->
            @if($company)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 text-lg">📩 Pengajuan / Request Guru</h4>
                            <p class="text-xs text-slate-500 mt-1">Kelola permohonan kerja sama dan penempatan siswa PKL dari guru pembimbing.</p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('hrd.requests.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition">
                                Lihat Daftar Request Masuk →
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>