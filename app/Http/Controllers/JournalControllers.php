<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Journal;
use App\Models\Student;

class JournalController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', Auth::id())->first();
        $journals = Journal::where('student_id', $student->id ?? null)->latest()->get();

        return view('student.journals.index', compact('journals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'activity' => 'required|string',
            'problem_faced' => 'nullable|string',
        ]);

        $student = Student::where('user_id', Auth::id())->first();

        Journal::create([
            'student_id' => $student->id,
            'date' => $request->date,
            'activity' => $request->activity,
            'problem_faced' => $request->problem_faced,
        ]);

        return redirect()->back()->with('success', 'Jurnal harian berhasil dikirim!');
    }
}