<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard HRD
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-slate-800 mb-2">Dashboard HRD Perusahaan Mitra</h2>
                <p class="text-slate-600 mb-6">Selamat datang, <strong>{{ Auth::user()->name }}</strong>[cite: 2]!</p>
                
                @if(!$company)
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="text-lg font-semibold text-amber-900">Belum Ada Data Perusahaan</h3>
                            <p class="text-sm text-amber-700">Silakan daftarkan detail perusahaan Anda terlebih dahulu agar siswa dapat melihat informasi penempatan[cite: 2].</p>
                        </div>
                        <a href="{{ route('companies.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                            + Input Data Perusahaan
                        </a>
                    </div>
                @else
                    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="bg-indigo-200 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded uppercase">Profil Perusahaan</span>
                                <h3 class="text-xl font-bold text-indigo-950 mt-2">{{ $company->name }}</h3>
                                <p class="text-sm text-indigo-800 font-medium mt-1">Lokasi: {{ $company->location }}</p>
                            </div>
                            <a href="{{ route('companies.edit', $company->id) }}" class="bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-amber-700 transition">
                                Edit Perusahaan
                            </a>
                        </div>
                        <div class="mt-4 pt-4 border-t border-indigo-200 text-sm text-indigo-900 space-y-1">
                            <p><strong>Alamat Lengkap:</strong> {{ $company->address }}</p>
                            <p><strong>No Telepon:</strong> {{ $company->phone ?? '-' }}</p>
                            <p><strong>Bidang Usaha:</strong> {{ $company->description ?? '-' }}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>