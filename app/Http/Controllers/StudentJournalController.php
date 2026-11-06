<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PklJournal;
use App\Models\CompanyRequest;
use Carbon\Carbon;

class StudentJournalController extends Controller
{
    public function index()
    {
        $student = auth()->user()->load('profile');
        
        $acceptedRequest = CompanyRequest::where('student_id', $student->id)->first();
        $journals = PklJournal::where('student_id', $student->id)->orderBy('date', 'asc')->get();

        return view('student.journals.index', compact('student', 'acceptedRequest', 'journals'));
    }

    public function createcustom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'total_days' => 'required|integer|min:1|max:60',
            'company_id' => 'required|exists:companies,id',
        ]);

        $studentId = auth()->id();
        $startDate = Carbon::parse($request->start_date);
        $totalDays = $request->total_days;

        // Loop untuk membuat lembar jurnal harian secara otomatis
        for ($i = 0; $i < $totalDays; $i++) {
            $date = Carbon::parse($startDate)->addDays($i)->format('Y-m-d');

            PklJournal::firstOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $date,
                ],
                [
                    'company_id' => $request->company_id,
                    'activity' => '',
                    'reflection' => '',
                    'status' => 'draft',
                ]
            );
        }

        return redirect()->route('student.journals.index')->with('success', 'Berhasil membuat ' . $totalDays . ' hari lembar jurnal harian!');
    }

    public function update(Request $request, $id)
    {
        $journal = PklJournal::where('id', $id)->where('student_id', auth()->id())->firstOrFail();
        
        if ($journal->status != 'draft') {
            return back()->with('error', 'Jurnal yang sudah dikirim tidak dapat diubah.');
        }

        $journal->update([
            'activity' => $request->activity,
            'reflection' => $request->reflection,
        ]);

        return back()->with('success', 'Perubahan jurnal berhasil disimpan.');
    }

    public function sendAllToHrd(Request $request)
    {
        $user = Auth::user();
        
        $updated = PklJournal::where('student_id', $user->id)
            ->where('status', 'draft')
            ->update(['status' => 'sent_to_hrd']);

        if ($updated) {
            return back()->with('success', 'Seluruh jurnal berhasil dikirim ke HRD untuk diperiksa!');
        }

        return back()->with('error', 'Tidak ada jurnal berstatus draft yang dapat dikirim.');
    }

    public function sendToTeacher(Request $request)
    {
        $user = Auth::user();
        
        $updated = PklJournal::where('student_id', $user->id)
            ->where('status', 'hrd_approved')
            ->update(['status' => 'sent_to_teacher']);

        if ($updated) {
            return back()->with('success', 'Jurnal yang telah disetujui HRD berhasil dikirim ke Guru Pembimbing!');
        }

        return back()->with('error', 'Tidak ada jurnal berstatus disetujui HRD yang dapat dikirim.');
    }
}