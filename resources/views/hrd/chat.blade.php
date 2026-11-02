<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Diskusi / Koordinasi dengan Guru: {{ $companyRequest->teacher->name }}
            </h2>
            <a href="{{ route('hrd.requests.index') }}" class="text-xs bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-medium">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Informasi Pengajuan -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-slate-800">Detail Request:</h3>
                <p class="text-sm text-slate-600 mt-1">{{ $companyRequest->message }}</p>
                
                <!-- Form Update Status -->
                <form action="{{ route('hrd.requests.status', $companyRequest->id) }}" method="POST" class="mt-4 flex items-center space-x-3">
                    @csrf
                    @method('PUT')
                    <span class="text-sm font-medium text-slate-700">Ubah Status Pengajuan:</span>
                    <select name="status" class="text-xs rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="pending" {{ $companyRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $companyRequest->status == 'approved' ? 'selected' : '' }}>Approved (Setujui)</option>
                        <option value="rejected" {{ $companyRequest->status == 'rejected' ? 'selected' : '' }}>Rejected (Tolak)</option>
                    </select>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs px-3 py-2 rounded-lg font-semibold">Update Status</button>
                </form>
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
                        <p class="text-center text-sm text-slate-400 py-4">Belum ada percakapan. Mulai diskusi dengan mengirim pesan di bawah.</p>
                    @endforelse
                </div>

                <!-- Form Kirim Pesan -->
                <form action="{{ route('hrd.requests.chat.store', $companyRequest->id) }}" method="POST" class="pt-4 border-t flex gap-2">
                    @csrf
                    <input type="text" name="message" required placeholder="Tulis informasi atau balasan untuk guru..." class="flex-1 text-sm rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold">
                        Kirim 🚀
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>