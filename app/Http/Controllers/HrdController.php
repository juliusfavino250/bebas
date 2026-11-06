<?php

namespace App\Http\Controllers;

use App\Models\CompanyRequest;
use App\Models\RequestChat;
use App\Models\PklJournal;
use Illuminate\Http\Request;

class HrdController extends Controller
{
    public function requestsIndex()
    {
        $hrdCompany = auth()->user()->company;
        
        $requests = collect();
        if ($hrdCompany) {
            $requests = CompanyRequest::where('company_id', $hrdCompany->id)
                ->with(['teacher', 'chats.sender'])
                ->latest()
                ->get();
        }

        return view('hrd.requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, CompanyRequest $companyRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $companyRequest->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    public function showChat(CompanyRequest $companyRequest)
    {
        $companyRequest->load(['company', 'teacher', 'chats.sender']);
        
        return view('hrd.requests.chat', compact('companyRequest'));
    }

    public function storeChat(Request $request, CompanyRequest $companyRequest)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        RequestChat::create([
            'company_request_id' => $companyRequest->id,
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Pesan terkirim!');
    }

    // ==========================================
    // TAMBAHAN FITUR MANAJEMEN JURNAL SISWA OLEH HRD
    // ==========================================

    public function journalsIndex()
{
    $hrdCompany = auth()->user()->company;

    $journals = collect();
    if ($hrdCompany) {
        // Ambil jurnal dari siswa yang memiliki permohonan PKL 'approved' di perusahaan HRD ini
        $journals = PklJournal::whereHas('student.companyRequest', function($query) use ($hrdCompany) {
            $query->where('company_id', $hrdCompany->id)->where('status', 'approved');
        })->with(['student.profile'])->orderBy('date', 'asc')->get();
    }

    return view('hrd.journals.index', compact('journals', 'hrdCompany'));
}
    public function approveJournal($id)
    {
        $journal = PklJournal::findOrFail($id);
        
        $journal->update([
            'status' => 'hrd_approved'
        ]);

        return redirect()->back()->with('success', 'Jurnal kegiatan siswa berhasil disetujui!');
    }
}