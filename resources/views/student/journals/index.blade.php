<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📝 Jurnal Kegiatan Harian PKL
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-100 text-emerald-800 rounded-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Tambah Jurnal -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-base font-bold text-slate-800 mb-4">Tambah Catatan Jurnal Hari Ini</h3>
                <form action="{{ route('student.journals.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Kegiatan</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-lg border-slate-300">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi Kegiatan / Pekerjaan</label>
                        <textarea name="activity" rows="3" required placeholder="Tuliskan apa saja yang Anda kerjakan hari ini di tempat PKL..." class="w-full text-sm rounded-lg border-slate-300"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-5 py-2.5 rounded-lg transition shadow-sm">
                            Simpan Jurnal 🚀
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Riwayat Jurnal -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-base font-bold text-slate-800 mb-4">Riwayat Jurnal Anda</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500 border-b">
                            <tr>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Kegiatan</th>
                                <th class="p-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($journals as $journal)
                                <tr>
                                    <td class="p-3 font-medium text-slate-800 whitespace-nowrap">{{ $journal->date }}</td>
                                    <td class="p-3">{{ $journal->activity }}</td>
                                    <td class="p-3 text-center">
                                        @if($journal->status === 'approved')
                                            <span class="bg-emerald-100 text-emerald-800 text-xs px-2.5 py-1 rounded-full font-semibold">Disetujui</span>
                                        @else
                                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-1 rounded-full font-semibold">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-slate-400 py-6">Belum ada jurnal kegiatan yang dicatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>