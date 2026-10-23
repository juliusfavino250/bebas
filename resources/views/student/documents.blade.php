<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pusat Informasi & Unduh Dokumen PKL</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Informasi Masa PKL -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-3 text-indigo-600">Informasi Magang & Sisa Durasi</h3>
                @if($placement)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Perusahaan Tempat PKL:</p>
                            <p class="font-bold text-gray-800 text-base">{{ $placement->company->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Periode Magang:</p>
                            <p class="font-semibold text-gray-800">{{ $placement->start_date }} s/d {{ $placement->end_date }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Siswa belum ditempatkan di perusahaan mitra manapun.</p>
                @endif
            </div>

            <!-- Download Dokumen Digital -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Berkas Digital PKL</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Surat Tugas -->
                    <div class="border p-4 rounded-md flex justify-between items-center bg-gray-50">
                        <div>
                            <p class="font-semibold text-gray-700">Surat Tugas PKL</p>
                            <p class="text-xs text-gray-500">Format PDF Digital</p>
                        </div>
                        @if($placement && $placement->assignment_letter_path)
                            <a href="{{ asset('storage/' . $placement->assignment_letter_path) }}" download class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-blue-700">Unduh Surat</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Belum Tersedia</span>
                        @endif
                    </div>

                    <!-- Sertifikat Digital -->
                    <div class="border p-4 rounded-md flex justify-between items-center bg-gray-50">
                        <div>
                            <p class="font-semibold text-gray-700">Sertifikat Magang Digital</p>
                            <p class="text-xs text-gray-500">Diberikan setelah selesai PKL</p>
                        </div>
                        @if($placement && $placement->certificate_path)
                            <a href="{{ asset('storage/' . $placement->certificate_path) }}" download class="bg-green-600 text-white px-3 py-1.5 rounded text-xs font-semibold hover:bg-green-700">Unduh Sertifikat</a>
                        @else
                            <span class="text-xs text-gray-400 italic">Belum Tersedia</span>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Form Pengajuan Ubah Profil (Fitur Tambahan 2) -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-2 text-gray-800">Pengajuan Perubahan Biodata</h3>
                <p class="text-xs text-gray-500 mb-4">Setiap perubahan biodata membutuhkan konfirmasi dan persetujuan dari Guru Pembimbing terlebih dahulu.</p>
                
                <form action="{{ route('student.profile.request') }}" method="POST" class="space-y-3 max-w-md">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase">Nama Lengkap Baru</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required class="w-full text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase">Kelas</label>
                        <input type="text" name="class" value="{{ $student->class ?? '' }}" required class="w-full text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase">No. WhatsApp / HP</label>
                        <input type="text" name="phone" value="{{ $student->phone ?? '' }}" required class="w-full text-sm border-gray-300 rounded-md">
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded">
                        Kirim Pengajuan Ubah Data
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>