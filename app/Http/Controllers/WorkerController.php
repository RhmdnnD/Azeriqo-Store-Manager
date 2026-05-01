<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    // 1. Tampilkan Halaman Daftar Worker & Form Tambah
    public function index()
    {
        // Hanya admin yang boleh akses
        if (Auth::user()->role !== 'admin') { return abort(403); }

        // Ambil list user yang role-nya 'worker'
        $workers = User::where('role', 'worker')->latest()->get();
        
        return view('pages.workers', compact('workers'));
    }

    // 2. Proses Simpan Worker Baru
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'worker', // Pastikan rolenya worker
        ]);

        return redirect()->back()->with('success', 'Akun Worker berhasil dibuat!');
    }

    // 3. Hapus Worker
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        User::destroy($id);
        return redirect()->back()->with('success', 'Akun Worker dihapus.');
    }
}