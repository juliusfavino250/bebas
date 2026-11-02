<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profil Saya</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">

                @if(session('success'))
                    <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 text-sm rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama & Email (Read Only) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama</label>
                            <input type="text" value="{{ $user->name }}" disabled class="w-full text-sm rounded-lg border-slate-200 bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Role</label>
                            <input type="text" value="{{ strtoupper($user->role) }}" disabled class="w-full text-sm rounded-lg border-slate-200 bg-slate-50 font-bold text-indigo-600">
                        </div>
                    </div>

                    <!-- Umur (Wajib) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Umur <span class="text-red-500">* (Wajib)</span></label>
                        <input type="number" name="age" value="{{ old('age', $user->profile->age ?? '') }}" required class="w-full text-sm rounded-lg border-slate-300">
                    </div>

                    <!-- Khusus Siswa & Guru: Sekolah -->
                    @if(in_array($user->role, ['student', 'teacher']))
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Sekolah</label>
                            <input type="text" name="school" value="{{ old('school', $user->profile->school ?? '') }}" placeholder="Nama Sekolah..." class="w-full text-sm rounded-lg border-slate-300">
                        </div>
                    @endif

                    <!-- Khusus Siswa: Kelas -->
                    @if($user->role === 'student')
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas</label>
                            <input type="text" name="class" value="{{ old('class', $user->profile->class ?? '') }}" placeholder="Contoh: XII RPL 1..." class="w-full text-sm rounded-lg border-slate-300">
                        </div>
                    @endif

                    <!-- Khusus HRD: Perusahaan -->
                    @if($user->role === 'hrd')
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Perusahaan</label>
                            <select name="company_id" class="w-full text-sm rounded-lg border-slate-300">
                                <option value="">-- Pilih Perusahaan --</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ ($user->profile->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Field Opsional (Deskripsi, Kontak, Hobi, Sosial Media) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Deskripsi / Bio (Opsional)</label>
                        <textarea name="bio" rows="3" placeholder="Ceritakan sedikit tentang Anda..." class="w-full text-sm rounded-lg border-slate-300">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Kontak / No. HP (Opsional)</label>
                            <input type="text" name="contact" value="{{ old('contact', $user->profile->contact ?? '') }}" placeholder="0812..." class="w-full text-sm rounded-lg border-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Hobi (Opsional)</label>
                            <input type="text" name="hobby" value="{{ old('hobby', $user->profile->hobby ?? '') }}" placeholder="Membaca, Koding..." class="w-full text-sm rounded-lg border-slate-300">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Media Sosial (Opsional)</label>
                            <input type="text" name="social_media" value="{{ old('social_media', $user->profile->social_media ?? '') }}" placeholder="@username..." class="w-full text-sm rounded-lg border-slate-300">
                        </div>
                    </div>

                    <div class="pt-4 border-t flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs px-5 py-2.5 rounded-lg transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>