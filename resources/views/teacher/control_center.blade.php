<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pusat Kendali Guru Pembimbing</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table 1: Approval Ubah Profil -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-blue-600">Persetujuan Perubahan Biodata Siswa</h3>
                @if($pendingProfiles->isEmpty())
                    <p class="text-gray-500">Tidak ada pengajuan perubahan profil saat ini.</p>
                @else
                    <table class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2 text-left">Nama Siswa</th>
                                <th class="border p-2 text-left">Detail Perubahan Baru</th>
                                <th class="border p-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingProfiles as $student)
                                @php $pending = json_decode($student->pending_data, true); @endphp
                                <tr>
                                    <td class="border p-2 font-medium">{{ $student->user->name }}</td>
                                    <td class="border p-2 text-sm">
                                        Nama: {{ $pending['name'] }}<br>
                                        Kelas: {{ $pending['class'] }}<br>
                                        No. HP: {{ $pending['phone'] }}
                                    </td>
                                    <td class="border p-2 text-center">
                                        <form action="{{ route('teacher.approve_profile', $student->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-semibold">Setujui</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Table 2: Approval Penempatan (Assign PKL) -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-blue-600">Persetujuan Penempatan (Assign PKL)</h3>
                @if($pendingPlacements->isEmpty())
                    <p class="text-gray-500">Tidak ada pengajuan penempatan yang menunggu verifikasi.</p>
                @else
                    <table class="w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2 text-left">Siswa</th>
                                <th class="border p-2 text-left">Perusahaan Tujuan</th>
                                <th class="border p-2 text-left">Durasi Magang</th>
                                <th class="border p-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingPlacements as $placement)
                                <tr>
                                    <td class="border p-2">{{ $placement->student->user->name }}</td>
                                    <td class="border p-2 font-semibold">{{ $placement->company->name }}</td>
                                    <td class="border p-2 text-sm">{{ $placement->start_date }} s/d {{ $placement->end_date }}</td>
                                    <td class="border p-2 text-center">
                                        <form action="{{ route('teacher.approve_placement', $placement->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-semibold">Validasi Penempatan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>