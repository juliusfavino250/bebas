<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Placement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'student') {
            return view('student.dashboard');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.control_center');
        } elseif ($user->role === 'hrd') {
            return redirect()->route('hrd.dashboard');
        }

        return view('dashboard');
    }

    public function hrdDashboard()
    {
        $user = auth()->user();
        
        // Ambil data perusahaan milik HRD yang sedang login
        $company = Company::where('user_id', $user->id)->first();
        
        $activeStudents = Placement::with('student.user')
            ->where('status', 'approved')
            ->get();

        $activeStudentsCount = $activeStudents->count();

        return view('hrd.dashboard', compact('activeStudentsCount', 'activeStudents', 'company'));
    }

    public function teacherControlCenter()
    {
        return view('teacher.control_center');
    }
}