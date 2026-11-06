<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyRequest;
use App\Models\User;
use App\Models\Profile;
use App\Models\RequestChat;
use Illuminate\Http\Request;

class TeacherCompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        
        // Ambil juga data students agar view index.blade.php tidak error jika menampilkan form assign
        $students = User::where('role', 'student')->with('profile')->get();

        $schools = [
            'SMK Negeri 1',
            'SMK Negeri 2',
            'SMK Swasta Mandiri',
        ];

        return view('teacher.companies.index', compact('companies', 'students', 'schools'));
    }

    public function createRequest(Request $request)
    {
        $search = $request->input('search');
        $schoolFilter = $request->input('school');

        // Filter siswa berdasarkan nama dan asal sekolah
        $students = User::where('role', 'student')
            ->with('profile')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($schoolFilter, function ($query, $school) {
                return $query->whereHas('profile', function ($q) use ($school) {
                    $q->where('school', $school);
                });
            })
            ->get();

        $companies = Company::all();

        // Opsi pilihan sekolah dibuat fix (mirip role) agar tidak pernah kosong
        $schools = [
            'SMK Negeri 1',
            'SMK Negeri 2',
            'SMK Swasta Mandiri',
            // Tambahkan nama sekolah mitra lainnya di sini jika ada
        ];

        return view('teacher.companies.assign', compact('students', 'companies', 'schools', 'search', 'schoolFilter'));
    }

    public function storeRequest(Request $request, Company $company = null)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'message'    => 'required|string',
            'company_id' => 'nullable|exists:companies,id',
        ]);

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

    public function myRequests()
    {
        $requests = CompanyRequest::where('teacher_id', auth()->id())
            ->with(['company', 'student.profile', 'chats.sender'])
            ->latest()
            ->get();

        return view('teacher.companies.my-requests', compact('requests'));
    }

    public function showChat(CompanyRequest $companyRequest)
    {
        if ($companyRequest->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $companyRequest->load(['company', 'teacher', 'student.profile', 'chats.sender']);
        return view('teacher.companies.chat', compact('companyRequest'));
    }

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