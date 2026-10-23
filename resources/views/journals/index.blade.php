<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jurnal Harian Digital</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form Pengisian Logbook -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Isi Kegiatan Harian Magang</h3>
                <form action="{{ route('student.journals.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Aktivitas / Pekerjaan Harian</label>
                        <textarea name="activity" rows="3" required placeholder="Jelaskan secara detail pekerjaan yang diselesaikan hari ini..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kendala yang Dihadapi (Opsional)</label>
                        <textarea name="problem_faced" rows="2" placeholder="Tuliskan jika ada hambatan teknis/non-teknis..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md shadow">
                        Kirim Jurnal
                    </button>
                </form>
            </div>

            <!-- List Logbook Riwayat -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Riwayat Jurnal Harian</h3>
                <div class="space-y-4 divide-y divide-gray-100">
                    @forelse($journals as $journal)
                        <div class="pt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($journal->date)->format('d M Y') }}</span>
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-semibold">
                                    {{ ucfirst($journal->status) }}
                                </span>
                            </div>
                            <p class="text-gray-600 mt-1 text-sm">{{ $journal->activity }}</p>
                            @if($journal->problem_faced)
                                <p class="text-xs text-red-500 mt-1"><strong>Kendala:</strong> {{ $journal->problem_faced }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada catatan jurnal harian.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>