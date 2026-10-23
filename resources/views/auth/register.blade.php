@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
    <h2 class="text-lg font-semibold text-slate-800 mb-6 text-center">Buat Akun Baru</h2>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-6 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Daftar Sebagai (Role)</label>
            <select name="role" id="roleSelect" onchange="toggleStudentFields()" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm bg-white">
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Siswa SMK</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Guru Pembimbing</option>
                <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>HRD Perusahaan Mitra</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ahmad Sanjaya"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="ahmad@smk.sch.id"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <!-- Kolom Khusus Siswa -->
        <div id="studentFields" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="0051234567"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label>
                <input type="text" name="class" value="{{ old('class') }}" placeholder="XII RPL 1"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" name="password" required placeholder="Minimal 8 karakter"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required placeholder="Ketik ulang password"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <button type="submit" 
            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200 mt-2">
            Daftar Akun
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Masuk di sini</a>
    </div>

    <script>
        function toggleStudentFields() {
            const role = document.getElementById('roleSelect').value;
            const studentFields = document.getElementById('studentFields');
            if (role === 'student') {
                studentFields.classList.remove('hidden');
            } else {
                studentFields.classList.add('hidden');
            }
        }
        // Jalankan saat halaman pertama dipanggil
        toggleStudentFields();
    </script>
@endsection