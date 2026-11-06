<?php


namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load(['profile.company']);
        $companies = Company::all(); // Untuk pilihan HRD jika belum memilih perusahaan

        return view('profile.show', compact('user', 'companies'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'age' => 'required|integer|min:1',
            'bio' => 'nullable|string',
            'contact' => 'nullable|string',
            'hobby' => 'nullable|string',
            'social_media' => 'nullable|string',
            'school' => 'nullable|string',
            'class' => 'nullable|string',
            'company_id' => 'nullable|exists:companies,id',
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        // Redirect dinamis berdasarkan role masing-masing setelah update profil
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('success', 'Profil berhasil diperbarui!');
        } 
        elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard')->with('success', 'Profil berhasil diperbarui!');
        } 
        elseif ($user->role === 'HRD') {
            return redirect()->route('hrd.dashboard')->with('success', 'Profil berhasil diperbarui!');
        } 
        else {
            // Default untuk Student / Siswa
            return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
        }
    }
}