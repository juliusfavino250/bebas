<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏢 Daftar Perusahaan Mitra & Pengajuan Siswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 text-emerald-800 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($companies as $company)
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">{{ $company->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1">📍 {{ $company->address ?? 'Alamat tidak tersedia' }}</p>
                            <p class="text-sm text-slate-600 mt-3">{{ $company->description ?? 'Tidak ada deskripsi perusahaan.' }}</p>
                        </div>

                        <!-- Form Pengajuan Siswa ke Perusahaan Ini -->
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <form action="{{ route('teacher.companies.store-request', $company->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Siswa yang Diajukan:</label>
                                    <select name="student_id" required class="w-full text-xs rounded-lg border-slate-300">
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach(\App\Models\User::where('role', 'student')->with('profile')->get() as $student)
                                            <option value="{{ $student->id }}">
                                                {{ $student->name }} {{ $student->profile->class ? '('.$student->profile->class.')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pesan / Catatan Pengantar:</label>
                                    <textarea name="message" rows="2" required placeholder="Tulis pesan pengajuan untuk HRD..." class="w-full text-xs rounded-lg border-slate-300"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs py-2 rounded-lg transition shadow-sm">
                                    Kirim Pengajuan Siswa 🚀
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>