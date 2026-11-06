<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\CompanyRequest;
use App\Models\PklJournal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Jika role Admin
        if ($user->role === 'admin') {
            return view('admin.dashboard');
        } 
        
        // 2. Jika role Teacher (Guru)
        elseif ($user->role === 'teacher') {
            $companies = Company::all();
            return view('teacher.dashboard', compact('companies'));
        } 
        
        // 3. Jika role HRD (Langsung render view agar tidak looping redirect)
        elseif ($user->role === 'hrd' || $user->role === 'HRD') {
            $company = Company::where('user_id', $user->id)->first();
            return view('hrd.dashboard', compact('company'));
        } 
        
        // 4. Jika role Student (Siswa)
        else {
            $acceptedRequest = CompanyRequest::where('student_id', $user->id)->first();
            $journals = PklJournal::where('student_id', $user->id)->orderBy('date', 'asc')->get();

            return view('dashboard', compact('acceptedRequest', 'journals'));
        }
    }

    // Method khusus untuk rute /hrd/dashboard
    public function hrdDashboard()
    {
        $user = auth()->user();
        $company = Company::where('user_id', $user->id)->first();
        
        return view('hrd.dashboard', compact('company'));
    }
}