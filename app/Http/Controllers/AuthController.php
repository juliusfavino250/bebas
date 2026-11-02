<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

   public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'age'      => 'required|integer|min:1',
        'school'   => 'required|string|max:255',
        'class'    => 'required|string|max:50', // Validasi kelas
    ]);

    DB::transaction(function () use ($request) {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);

        Profile::create([
            'user_id' => $user->id,
            'age'     => $request->age,
            'school'  => $request->school,
            'class'   => $request->class, // Simpan kelas
        ]);
    });

    return redirect()->route('login')->with('success', 'Registrasi akun berhasil! Silakan masuk.');
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}