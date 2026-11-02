<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyRequest;
use App\Models\RequestChat;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class TeacherCompanyController extends Controller
{
    // Menampilkan daftar perusahaan untuk diajukan oleh guru
    public function index()
    {
        $companies = Company::all();
        return view('teacher.companies.index', compact('companies'));
    }

    // Menampilkan halaman pencarian siswa & pencarian perusahaan untuk pengajuan PKL
    public function createRequest(Request $request)
    {
        $search = $request->input('search');
        $schoolFilter = $request->input('school');

        // Filter daftar siswa berdasarkan nama atau asal sekolah
        $students = User::where('role', 'student')
            ->with('profile')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($schoolFilter, function ($query, $school) {
                return $query->whereHas('profile', function ($q) use ($school) {
                    $q->where('school', 'like', "%{$school}%");
                });
            })
            ->get();

        $companies = Company::all();
        // Mengambil daftar unik asal sekolah dari profil siswa untuk opsi filter dropdown
        $schools = Profile::whereNotNull('school')->distinct()->pluck('school');

        return view('teacher.companies.assign', compact('students', 'companies', 'schools', 'search', 'schoolFilter'));
    }

    // Menyimpan pengajuan kerja sama & siswa yang dipilih (bisa melalui route perusahaan langsung atau route assign)
    public function storeRequest(Request $request, Company $company = null)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'message'    => 'required|string',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        // Ambil company_id dari parameter route (jika ada) atau dari body request
        $companyId = $company ? $company->id : $request->company_id;

        if (!$companyId) {
            return redirect()->back()->withErrors(['company_id' => 'Perusahaan wajib dipilih.']);
        }

        CompanyRequest::create([
            'teacher_id' => auth()->id(),
            'company_id' => $companyId,
            'student_id' => $request->student_id,
            'message'    => $request->message,
            'status'     => 'pending',
        ]);

        return redirect()->route('teacher.companies.my-requests')->with('success', 'Pengajuan siswa ke perusahaan berhasil dikirim!');
    }

    // Menampilkan daftar request yang dikirim guru beserta relasi siswa & profilnya
    public function myRequests()
    {
        $requests = CompanyRequest::where('teacher_id', auth()->id())
            ->with(['company', 'student.profile', 'chats.sender'])
            ->latest()
            ->get();

        return view('teacher.companies.my-requests', compact('requests'));
    }

    // Menampilkan halaman chat detail untuk Guru
    public function showChat(CompanyRequest $companyRequest)
    {
        if ($companyRequest->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $companyRequest->load(['company', 'teacher', 'student.profile', 'chats.sender']);
        
        return view('teacher.companies.chat', compact('companyRequest'));
    }

    // Menyimpan pesan chat dari Guru
    public function storeChat(Request $request, CompanyRequest $companyRequest)
    {
        if ($companyRequest->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        RequestChat::create([
            'company_request_id' => $companyRequest->id,
            'sender_id'          => auth()->id(),
            'message'            => $request->message,
        ]);

        return redirect()->back()->with('success', 'Pesan terkirim!');
    }
}