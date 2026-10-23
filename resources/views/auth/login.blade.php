@extends('layouts.auth')

@section('title', 'Masuk ke Akun')

@section('content')
    <h2 class="text-lg font-semibold text-slate-800 mb-6 text-center">Masuk ke Akun Anda</h2>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded mb-6 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@sekolah.sch.id"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <input type="password" name="password" required placeholder="••••••••"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2">Ingat saya</span>
            </label>
        </div>

        <button type="submit" 
            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-600/30 transition duration-200">
            Masuk Sekarang
        </button>
    </form>

<a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
    Daftar Akun Baru
</a>
@endsection