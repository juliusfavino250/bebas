<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function create()
    {
        $company = Company::where('user_id', auth()->id())->first();
        
        if ($company) {
            return redirect()->route('companies.edit', $company->id);
        }

        return view('hrd.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        Company::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'location' => $request->location,
            'address' => $request->address,
            'phone' => $request->phone,
            'description' => $request->description,
        ]);

        return redirect()->route('hrd.dashboard')->with('success', 'Profil perusahaan berhasil ditambahkan!');
    }

    public function edit(Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('hrd.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $company->update($request->all());

        return redirect()->route('hrd.dashboard')->with('success', 'Profil perusahaan berhasil diperbarui!');
    }
}