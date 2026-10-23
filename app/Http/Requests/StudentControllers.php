<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Placement;

class StudentController extends Controller
{
    // Pengajuan ubah profil oleh Siswa
    public function requestProfileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'class' => 'required|string',
        ]);

        $student = Student::where('user_id', Auth::id())->firstOrFail();
        
        // Simpan permohonan ke format JSON sementara
        $student->pending_data = json_encode([
            'name' => $request->name,
            'phone' => $request->phone,
            'class' => $request->class,
        ]);
        $student->is_profile_requested = true;
        $student->save();

        return redirect()->back()->with('success', 'Pengajuan perubahan profil telah dikirim ke Guru Pembimbing.');
    }

    // Approval perubahan profil oleh Guru
    public function approveProfile($id)
    {
        $student = Student::findOrFail($id);

        if ($student->is_profile_requested && $student->pending_data) {
            $newData = json_decode($student->pending_data, true);
            
            $student->user->update(['name' => $newData['name']]);
            $student->update([
                'phone' => $newData['phone'],
                'class' => $newData['class'],
                'pending_data' => null,
                'is_profile_requested' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Perubahan biodata siswa berhasil disetujui.');
    }

    // Pusat Informasi & Unduh Dokumen
    public function documents()
    {
        $student = Student::where('user_id', Auth::id())->first();
        $placement = Placement::with('company')->where('student_id', $student->id ?? null)->first();

        return view('student.documents', compact('student', 'placement'));
    }
}