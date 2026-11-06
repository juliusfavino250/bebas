<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👥 Manajemen Pengguna & Role
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

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-slate-700">Daftar Akun Pengguna Sistem</h3>
                    <a href="{{ route('admin.users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-sm">
                        + Tambah Akun Baru
                    </a>
                </div>
                
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b text-xs font-bold text-slate-600 uppercase bg-slate-50">
                            <th class="p-3">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Role</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 font-semibold text-slate-800">{{ $user->name }}</td>
                                <td class="p-3 text-slate-600">{{ $user->email }}</td>
                                <td class="p-3">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider
                                        {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $user->role == 'teacher' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                        {{ $user->role == 'HRD' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $user->role == 'student' ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="p-3 text-center flex items-center justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition shadow-sm">
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>