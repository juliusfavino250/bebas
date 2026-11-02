<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentJournalController extends Controller
{
    // Menampilkan daftar jurnal milik siswa yang sedang login
    public function index()
    {
        $journals = Journal::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        return view('student.journals.index', compact('journals'));
    }

    // Menyimpan jurnal baru
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'activity' => 'required|string',
        ]);

        Journal::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'activity' => $request->activity,
            'status' => 'pending',
        ]);

        return redirect()->route('student.journals.index')->with('success', 'Jurnal harian berhasil ditambahkan!');
    }
}