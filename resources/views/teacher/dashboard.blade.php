<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Perusahaan Mitra PKL
            </h2>
            <a href="{{ route('teacher.companies.my-requests') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition">
                📋 Lihat Pengajuan Saya
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Pilih Perusahaan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($companies as $company)
                        <div class="border border-slate-200 rounded-lg p-4 flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">{{ $company->name }}</h4>
                                <p class="text-xs text-slate-500 mt-1">{{ $company->address ?? 'Alamat belum diisi' }}</p>
                            </div>
                            
                            <!-- Form Pengajuan -->
                            <form action="{{ route('teacher.companies.request', $company->id) }}" method="POST" class="mt-4 pt-3 border-t">
                                @csrf
                                <textarea name="message" required placeholder="Catatan pengajuan..." class="w-full text-xs rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 mb-2"></textarea>
                                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white text-xs py-2 rounded-lg font-semibold">
                                    Kirim Pengajuan 🚀
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-slate-400 col-span-3 py-6">Belum ada perusahaan yang terdaftar.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>