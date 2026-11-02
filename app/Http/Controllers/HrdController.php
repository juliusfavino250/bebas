<?php

namespace App\Http\Controllers;

use App\Models\CompanyRequest;
use App\Models\RequestChat;
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
}