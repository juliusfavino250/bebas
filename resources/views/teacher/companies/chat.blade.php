<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Diskusi dengan HRD: {{ $companyRequest->company->name }}
            </h2>
            <a href="{{ route('teacher.companies.my-requests') }}" class="text-xs bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-medium">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informasi Status Pengajuan -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800">Catatan Pengajuan Anda:</h3>
                    <p class="text-sm text-slate-600 mt-1">{{ $companyRequest->message }}</p>
                </div>
                <div>
                    @if($companyRequest->status == 'pending')
                        <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1.5 rounded-lg">Status: Pending</span>
                    @elseif($companyRequest->status == 'approved')
                        <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1.5 rounded-lg">Status: Disetujui 🎉</span>
                    @else
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1.5 rounded-lg">Status: Ditolak</span>
                    @endif
                </div>
            </div>

            <!-- Kotak Pesan Chat -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
                <h3 class="font-bold text-slate-800 border-b pb-2">Ruang Percakapan Koordinasi dengan HRD</h3>

                <!-- INI BAGIAN WADAH / KOTAK RIWAYAT CHAT YANG MUNCUL DI LAYAR -->
                <div class="space-y-3 max-h-96 overflow-y-auto p-3 border border-slate-100 rounded-xl bg-slate-50">
                    @forelse($companyRequest->chats as $chat)
                        <div class="flex flex-col {{ $chat->sender_id == auth()->id() ? 'items-end' : 'items-start' }}">
                            <div class="max-w-lg rounded-2xl px-4 py-2.5 text-sm {{ $chat->sender_id == auth()->id() ? 'bg-indigo-600 text-white' : 'bg-white text-slate-800 border border-slate-200 shadow-sm' }}">
                                <p class="text-xs font-semibold mb-1 opacity-75">{{ $chat->sender->name ?? 'User' }}</p>
                                <p>{{ $chat->message }}</p>
                            </div>
                            <span class="text-[10px] text-slate-400 mt-1">{{ $chat->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-sm">
                            Belum ada percakapan. Mulai diskusi dengan HRD melalui kolom di bawah.
                        </div>
                    @endforelse
                </div>

                <!-- Form Kirim Pesan & Penanganan Error -->
                <form action="{{ route('teacher.companies.chat.store', $companyRequest->id) }}" method="POST" class="pt-4 border-t flex flex-col gap-2">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="message" required placeholder="Tulis pesan atau balasan untuk HRD..." class="flex-1 text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition">
                            Kirim 🚀
                        </button>
                    </div>
                    @error('message')
                        <span class="text-xs text-red-500 font-medium">{{ $message }}</span>
                    @enderror
                </form>
            </div>

        </div>
    </div>
</x-app-layout>