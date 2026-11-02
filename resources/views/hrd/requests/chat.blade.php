<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Koordinasi Pengajuan: {{ $companyRequest->teacher->name }}
            </h2>
            <a href="{{ route('hrd.requests.index') }}" class="text-xs bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-medium">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Aksi Update Status & Detail Request -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase">Guru Pengaju</span>
                    <h3 class="font-bold text-lg text-slate-800">{{ $companyRequest->teacher->name }}</h3>
                    <p class="text-sm text-slate-600 mt-1"><strong>Pesan/Catatan:</strong> {{ $companyRequest->message }}</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold">Status:</span>
                    @if($companyRequest->status == 'pending')
                        <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg">Pending</span>
                    @elseif($companyRequest->status == 'approved')
                        <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1.5 rounded-lg">Disetujui</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1.5 rounded-lg">Ditolak</span>
                    @endif

                    <!-- Tombol Ubah Status -->
                    <form action="{{ route('hrd.requests.update-status', $companyRequest->id) }}" method="POST" class="inline-flex gap-1 ml-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="status" value="approved" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                            Setujui
                        </button>
                        <button type="submit" name="status" value="rejected" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                            Tolak
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kotak Pesan Chat -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-slate-800 border-b pb-2">Ruang Percakapan Koordinasi</h3>

                <div class="space-y-3 max-h-96 overflow-y-auto p-2">
                    @forelse($companyRequest->chats as $chat)
                        <div class="flex flex-col {{ $chat->sender_id == auth()->id() ? 'items-end' : 'items-start' }}">
                            <div class="max-w-lg rounded-2xl px-4 py-2.5 text-sm {{ $chat->sender_id == auth()->id() ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-800' }}">
                                <p class="text-xs font-semibold mb-1 opacity-75">{{ $chat->sender->name }}</p>
                                <p>{{ $chat->message }}</p>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1">{{ $chat->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    @empty
                        <p class="text-center text-sm text-slate-400 py-4">Belum ada percakapan. Mulai diskusi dengan guru melalui kolom di bawah.</p>
                    @endforelse
                </div>

                <!-- Form Kirim Pesan -->
                <form action="{{ route('hrd.requests.chat.store', $companyRequest->id) }}" method="POST" class="pt-4 border-t flex gap-2">
                    @csrf
                    <input type="text" name="message" required placeholder="Tulis balasan pesan untuk guru..." class="flex-1 text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold">
                        Kirim 🚀
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>