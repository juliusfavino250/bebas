@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
    <h2 class="text-lg font-semibold text-slate-800 mb-6 text-center">Buat Akun Siswa Baru</h2>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-6 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-sm rounded-lg border-slate-300">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-sm rounded-lg border-slate-300">
        </div>

        <!-- Umur -->
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Umur <span class="text-red-500">*</span></label>
            <input type="number" name="age" value="{{ old('age') }}" min="1" required placeholder="Masukkan umur..." class="w-full text-sm rounded-lg border-slate-300">
        </div>
<!-- Asal Sekolah -->
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1">Asal Sekolah <span class="text-red-500">*</span></label>
    <input type="text" name="school" value="{{ old('school') }}" required placeholder="Contoh: SMK Negeri 1 Jakarta" class="w-full text-sm rounded-lg border-slate-300">
</div>

<!-- Kelas (Ditambahkan kembali) -->
<div>
    <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas <span class="text-red-500">*</span></label>
    <input type="text" name="class" value="{{ old('class') }}" required placeholder="Contoh: XII RPL 1" class="w-full text-sm rounded-lg border-slate-300">
</div>

        <!-- Password -->
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
            <input type="password" name="password" required class="w-full text-sm rounded-lg border-slate-300">
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="w-full text-sm rounded-lg border-slate-300">
        </div>

        <div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs py-2.5 rounded-lg transition">
                Daftar Sekarang 🚀
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Masuk di sini</a>
    </div>
@endsection