<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company; // <-- TAMBAHKAN BARIS INI DI SINI

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        return view('admin.dashboard');
    } elseif ($user->role === 'teacher') {
        // Ambil data companies agar tidak error undefined variable di view dashboard teacher
        $companies = \App\Models\Company::all();
        return view('teacher.dashboard', compact('companies'));
    } elseif ($user->role === 'hrd') {
        return redirect()->route('hrd.dashboard');
    }

    return view('dashboard');
}

    public function hrdDashboard()
    {
        // Ambil data perusahaan milik HRD yang sedang login
        $company = auth()->user()->company;

        return view('hrd.dashboard', compact('company'));
    }

    public function teacherControlCenter()
    {
        // Ambil data perusahaan dari database
        $companies = Company::all();

        // Pass variabel $companies ke view menggunakan compact()
        return view('teacher.dashboard', compact('companies'));
    }
}