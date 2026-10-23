<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Perusahaan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Edit Data Perusahaan</h2>

                <form action="{{ route('companies.update', $company->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Perusahaan *</label>
                        <input type="text" name="name" value="{{ old('name', $company->name) }}" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kota / Lokasi *</label>
                        <input type="text" name="location" value="{{ old('location', $company->location) }}" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap *</label>
                        <textarea name="address" rows="3" required class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $company->address) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">No Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $company->phone) }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Bidang Usaha / Deskripsi</label>
                        <input type="text" name="description" value="{{ old('description', $company->description) }}" class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('hrd.dashboard') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>