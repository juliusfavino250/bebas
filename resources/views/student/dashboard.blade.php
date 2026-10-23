<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Siswa PKL</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Status Magang -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-lg shadow text-white">
                <h3 class="text-xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-sm text-blue-100 mt-1">Sistem Informasi PKL Terintegrasi SMK</p>
                
                <div class="mt-4 pt-4 border-t border-blue-500/50 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="block text-xs text-blue-200 uppercase font-semibold">NISN</span>
                        <span class="font-semibold">{{ $student->nisn ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-blue-200 uppercase font-semibold">Kelas</span>
                        <span class="font-semibold">{{ $student->class ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-blue-200 uppercase font-semibold">Perusahaan PKL</span>
                        <span class="font-semibold">{{ $placement->company->name ?? 'Belum Ditentukan' }}</span>
                    </div>
                </div>
            </div>

            <!-- Akses Cepat Menu -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('student.journals.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition border-l-4 border-blue-500 block">
                    <h4 class="font-bold text-gray-800 text-lg">Jurnal Harian Digital &rarr;</h4>
                    <p class="text-sm text-gray-500 mt-1">Isi logbook pekerjaan dan aktivitas magang harian kamu di sini.</p>
                </a>

                <a href="{{ route('student.documents') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition border-l-4 border-indigo-500 block">
                    <h4 class="font-bold text-gray-800 text-lg">Pusat Dokumen & Biodata &rarr;</h4>
                    <p class="text-sm text-gray-500 mt-1">Unduh surat tugas, sertifikat magang, atau ajukan perubahan biodata.</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>