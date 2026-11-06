<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🎯 Cari & Ajukan Siswa PKL ke Perusahaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 text-emerald-800 rounded-lg text-sm font-semibold mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 bg-red-100 text-red-800 rounded-lg text-sm font-semibold mb-4">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Filter / Pencarian Siswa -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-sm font-bold text-slate-700 mb-4">🔍 Filter Data Siswa</h3>
                <form method="GET" action="{{ route('teacher.assign.create') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Cari Nama Siswa:</label>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Ketik nama siswa..." class="w-full text-xs rounded-lg border-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Asal Sekolah:</label>
                        <select name="school" class="w-full text-xs rounded-lg border-slate-300">
                            <option value="">-- Semua Sekolah --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school }}" {{ ($schoolFilter == $school) ? 'selected' : '' }}>
                                    {{ $school }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs py-2.5 rounded-lg transition shadow-sm">
                            Cari / Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Form Utama Pengajuan ke Perusahaan -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-sm font-bold text-slate-700 mb-4">📝 Form Pengajuan PKL</h3>
                <form action="{{ route('teacher.assign.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Pilih Perusahaan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Perusahaan Tujuan <span class="text-red-500">*</span></label>
                        <select name="company_id" required class="w-full text-sm rounded-lg border-slate-300">
                            <option value="">-- Pilih Perusahaan Mitra --</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }} (📍 {{ $company->address ?? 'Lokasi tidak tersedia' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Siswa (Menampilkan Nama, Kelas, dan Asal Sekolah) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Siswa <span class="text-red-500">*</span></label>
                        <select name="student_id" required class="w-full text-sm rounded-lg border-slate-300">
                            <option value="">-- Pilih Siswa --</option>
                            @forelse($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }} — Kelas: {{ $student->profile->class ?? 'Belum diisi' }} | Sekolah: {{ $student->profile->school ?? 'Belum diisi' }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada siswa ditemukan dengan filter tersebut.</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Pesan / Catatan -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pesan / Catatan Rekomendasi Guru <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="3" required placeholder="Tuliskan alasan pengajuan atau deskripsi siswa untuk HRD..." class="w-full text-sm rounded-lg border-slate-300"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs py-3 rounded-lg transition shadow-sm">
                        Kirim Pengajuan Siswa ke Perusahaan 🚀
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>