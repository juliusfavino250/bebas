<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pengajuan (Request) Kerja Sama Guru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Masuknya Pengajuan Penempatan / PKL</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Guru Pengaju</th>
                                <th class="px-4 py-3 text-left font-semibold">Pesan / Catatan</th>
                                <th class="px-4 py-3 text-center font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi / Koordinasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($requests as $req)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-800">
                                        <!-- Nama Guru -->
                                        <div class="font-bold text-slate-900">{{ $req->teacher->name ?? 'Guru' }}</div>
                                        
                                        <!-- Username & Email -->
                                        <div class="text-xs text-slate-500">
                                            👤 Username: <span class="font-medium text-slate-700">{{ $req->teacher->username ?? '-' }}</span> 
                                            | 📧 {{ $req->teacher->email ?? '-' }}
                                        </div>

                                        <!-- Asal Sekolah -->
                                        <div class="text-xs text-indigo-600 font-semibold mt-0.5">
                                            🏫 Sekolah: {{ $req->teacher->school ?? 'Belum diatur' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600">
                                        {{ $req->message }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($req->status == 'pending')
                                            <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1 rounded">Pending</span>
                                        @elseif($req->status == 'approved')
                                            <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1 rounded">Disetujui</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1 rounded">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center space-x-2">
                                        <a href="{{ route('hrd.requests.chat', $req->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
                                            💬 Chat / Koordinasi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-slate-500">
                                        Belum ada pengajuan masuk dari guru pembimbing.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>