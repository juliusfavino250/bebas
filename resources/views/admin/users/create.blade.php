<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin - Buat Akun Guru atau HRD
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="text-xl font-bold text-slate-800 mb-4">Form Pendaftaran Akun Khusus (Guru / HRD)</h2>
                <p class="text-sm text-slate-500 mb-6">Gunakan form ini untuk mendaftarkan akun pengajar atau perwakilan perusahaan mitra secara manual.</p>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Role / Peran *</label>
                        <select name="role" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Role --</option>
                            <option value="teacher">Guru Pembimbing (Teacher)</option>
                            <option value="hrd">HRD Perusahaan Mitra (HRD)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nama lengkap beserta gelar...">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email Aktif *</label>
                        <input type="email" name="email" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="email@sekolah/perusahaan.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Password Sementara *</label>
                        <input type="password" name="password" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Minimal 8 karakter">
                        <p class="text-xs text-slate-400 mt-1">Berikan password ini kepada Guru/HRD yang bersangkutan agar dapat login.</p>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                            Buat Akun Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>