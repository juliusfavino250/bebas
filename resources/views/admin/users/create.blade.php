<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ Tambah Akun Pengguna Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-rose-50 text-rose-700 rounded-lg text-xs">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap:</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs rounded-lg border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Email:</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-xs rounded-lg border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Password:</label>
                        <input type="password" name="password" required class="w-full text-xs rounded-lg border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Role:</label>
                        <select name="role" required class="w-full text-xs rounded-lg border-slate-300">
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="HRD">HRD</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('admin.users.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold px-4 py-2 rounded-lg transition">Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition shadow-sm">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>