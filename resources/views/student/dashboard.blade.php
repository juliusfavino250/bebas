<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📖 Jurnal Kegiatan PKL
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 text-emerald-800 rounded-lg text-sm font-semibold mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-100 text-rose-800 rounded-lg text-sm font-semibold mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- HALAMAN PERTAMA: COVER / IDENTITAS JURNAL -->
            <div class="bg-gradient-to-r from-indigo-900 to-slate-900 text-white p-8 rounded-2xl shadow-lg border border-indigo-700">
                <div class="text-center space-y-2">
                    <span class="bg-indigo-500/30 text-indigo-200 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Dokumen Resmi PKL</span>
                    <h1 class="text-3xl font-extrabold tracking-tight pt-2">JOURNAL PKL</h1>
                    <div class="py-4 space-y-1 text-slate-200 text-sm">
                        <p class="text-lg font-semibold">NAMA MURID: <span class="text-white underline">{{ auth()->user()->name }}</span></p>
                        <p class="font-medium">KELAS: <span class="text-white underline">{{ auth()->user()->profile->class ?? 'Belum diisi' }}</span></p>
                        <p class="font-medium">SEKOLAH: <span class="text-white underline">{{ auth()->user()->profile->school ?? 'Belum diisi' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- FORM KUSTOMISASI JUMLAH JURNAL -->
            @if($acceptedRequest)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <h3 class="text-sm font-bold text-slate-700 mb-3">⚙️ Buat / Kustomisasi Halaman Jurnal</h3>
                    <!-- Menggunakan route createcustom sesuai nama method di controller -->
                    <form action="{{ route('student.journals.createcustom') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $acceptedRequest->company_id }}">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Mulai Tanggal:</label>
                            <input type="date" name="start_date" required class="w-full text-xs rounded-lg border-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Hari (Kustom):</label>
                            <input type="number" name="total_days" min="1" max="60" value="7" required class="w-full text-xs rounded-lg border-slate-300">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs py-2.5 rounded-lg transition shadow-sm">
                                Generate Halaman Jurnal 🚀
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-4 bg-amber-50 text-amber-800 rounded-lg text-sm font-medium border border-amber-200">
                    ⚠️ Anda belum memiliki penempatan PKL yang disetujui (Accepted). Harap tunggu guru mengubah status penempatan Anda menjadi diterima.
                </div>
            @endif

            <!-- DAFTAR HALAMAN JURNAL HARIAN -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-6">
                <h3 class="text-sm font-bold text-slate-700">📝 Lembar Kegiatan & Refleksi Harian</h3>

                @forelse($journals as $index => $journal)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-bold text-indigo-600 uppercase">Hari ke-{{ $index + 1 }} — Tanggal: {{ $journal->date }}</span>
                            <span class="text-[10px] px-2.5 py-1 rounded-full font-bold 
                                {{ $journal->status == 'draft' ? 'bg-slate-200 text-slate-700' : '' }}
                                {{ $journal->status == 'sent_to_hrd' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $journal->status == 'sent_to_teacher' ? 'bg-indigo-100 text-indigo-800' : '' }}">
                                Status: {{ strtoupper(str_replace('_', ' ', $journal->status)) }}
                            </span>
                        </div>

                        <form action="{{ route('student.journals.update', $journal->id) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kegiatan Harian:</label>
                                    <textarea name="activity" rows="2" {{ $journal->status != 'draft' ? 'readonly' : '' }} class="w-full text-xs rounded-lg border-slate-300">{{ $journal->activity }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Refleksi Siswa:</label>
                                    <textarea name="reflection" rows="2" {{ $journal->status != 'draft' ? 'readonly' : '' }} class="w-full text-xs rounded-lg border-slate-300">{{ $journal->reflection }}</textarea>
                                </div>
                            </div>

                            @if($journal->status == 'draft')
                                <div class="flex justify-end gap-2">
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">Simpan Perubahan</button>
                                </div>
                            @endif
                        </form>

                        @if($journal->status == 'draft')
                            <form action="{{ route('student.journals.send', $journal->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold py-2 rounded-lg transition shadow-sm">
                                    Kirim Jurnal Ini ke HRD 📤
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic text-center py-6">Belum ada jurnal yang dibuat. Silakan gunakan form generator di atas.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>