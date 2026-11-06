<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📖 Validasi Jurnal Kegiatan Siswa PKL
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 text-emerald-800 rounded-lg text-sm font-semibold mb-4 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-100 text-rose-800 rounded-lg text-sm font-semibold mb-4 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tombol Navigasi Kembali ke Request -->
            <div class="flex items-center gap-3">
                <a href="{{ route('hrd.requests.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold px-4 py-2 rounded-xl transition">
                    ← Kembali ke Permohonan PKL
                </a>
            </div>

            <!-- DAFTAR NAMA SISWA & JURNALNYA -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-slate-100 p-6 sm:p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Daftar Siswa Magang & Jurnal Harian</h3>
                    <p class="text-xs text-slate-500 mt-1">Klik pada nama siswa untuk melihat daftar lembar jurnal harian dan memberikan persetujuan.</p>
                </div>

                @php
                    // Mengelompokkan jurnal berdasarkan siswa (student_id)
                    $groupedJournals = $journals->groupBy('student_id');
                @endphp

                <div class="space-y-4" x-data="{ openStudent: null }">
                    @forelse($groupedJournals as $studentId => $studentJournals)
                        @php
                            $student = $studentJournals->first()->student;
                        @endphp

                        <!-- KOTAK AKORDION PER SISWA -->
                        <div class="border border-slate-200 rounded-2xl bg-white shadow-sm overflow-hidden transition">
                            
                            <!-- Header Nama Siswa (Bisa Diklik) -->
                            <button @click="openStudent === {{ $studentId }} ? openStudent = null : openStudent = {{ $studentId }}" 
                                    class="w-full flex items-center justify-between p-5 bg-slate-50 hover:bg-slate-100/70 transition text-left">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-sm">
                                        {{ substr($student->name ?? 'S', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm md:text-base">
                                            {{ $student->name ?? 'Nama Siswa' }}
                                        </h4>
                                        <p class="text-xs text-slate-500">
                                            Sekolah: <span class="font-medium text-slate-700">{{ $student->profile->school ?? '-' }}</span> | 
                                            Kelas: <span class="font-medium text-slate-700">{{ $student->profile->class ?? '-' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs bg-indigo-100 text-indigo-700 font-bold px-3 py-1 rounded-full">
                                        {{ $studentJournals->count() }} Total Jurnal
                                    </span>
                                    <span class="text-slate-400 font-bold transition-transform duration-200" :class="{ 'rotate-180': openStudent === {{ $studentId }} }">
                                        ▼
                                    </span>
                                </div>
                            </button>

                            <!-- Isi / Detail Jurnal Siswa (Muncul Saat Diklik) -->
                            <div x-show="openStudent === {{ $studentId }}" x-collapse class="p-6 space-y-4 border-t border-slate-200 bg-white">
                                @foreach($studentJournals as $journal)
                                    <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 space-y-3">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                            <span class="text-xs font-bold text-indigo-600 uppercase">
                                                📅 Tanggal: {{ $journal->date }}
                                            </span>
                                            <span class="text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-wider 
                                                {{ $journal->status == 'draft' ? 'bg-slate-100 text-slate-700' : '' }}
                                                {{ $journal->status == 'sent_to_hrd' ? 'bg-amber-100 text-amber-800' : '' }}
                                                {{ $journal->status == 'hrd_approved' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                Status: {{ str_replace('_', ' ', $journal->status) }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                            <div class="bg-white p-3 rounded-lg border border-slate-200">
                                                <span class="font-semibold text-slate-600 block mb-1">Kegiatan Harian:</span>
                                                <p class="text-slate-700 whitespace-pre-line">{{ $journal->activity ?? '-' }}</p>
                                            </div>
                                            <div class="bg-white p-3 rounded-lg border border-slate-200">
                                                <span class="font-semibold text-slate-600 block mb-1">Refleksi Siswa:</span>
                                                <p class="text-slate-700 whitespace-pre-line">{{ $journal->reflection ?? '-' }}</p>
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi Approve oleh HRD -->
                                        @if($journal->status == 'sent_to_hrd')
                                            <div class="flex justify-end pt-2">
                                                <form action="{{ route('hrd.journals.approve', $journal->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm">
                                                        Setujui Jurnal Ini ✓
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <p class="text-xs text-slate-400 italic">Belum ada jurnal dari siswa yang masuk untuk divalidasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>