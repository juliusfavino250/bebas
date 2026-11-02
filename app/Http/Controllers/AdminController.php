<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Menampilkan form tambah akun Guru/HRD oleh Admin
    public function createUser()
    {
        return view('admin.users.create');
    }

    // Menyimpan akun Guru/HRD baru ke database
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:teacher,hrd', // Admin hanya bisa mendaftarkan teacher atau hrd
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Akun ' . strtoupper($request->role) . ' berhasil dibuatkan oleh Admin!');
    }
}