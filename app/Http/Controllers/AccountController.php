<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // --- HALAMAN UTAMA ---
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $accounts = Account::orderBy('title')->get()->groupBy('title');
        } else {
            $accounts = Account::where('user_id', $user->id)->orderBy('title')->get()->groupBy('title');
        }
        return view('pages.index', compact('accounts'));
    }

    // --- HALAMAN INPUT (Update: Kirim Data Kategori) ---
    public function create()
    {
        // Ambil semua kategori urut abjad
        $categories = Category::orderBy('name')->get();
        return view('pages.input', compact('categories'));
    }

    public function activityLog()
    {
        if (Auth::user()->role === 'admin') {
            $logs = Account::with('user')->latest()->paginate(20);
        } else {
            $logs = Account::where('user_id', Auth::id())->latest()->paginate(20);
        }
        return view('pages.log', compact('logs'));
    }

    public function generator() { return view('pages.generator'); }

    // --- PROSES SIMPAN AKUN ---
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required', // Sekarang wajib pilih kategori
            'username' => 'required',
            'password' => 'required'
        ]);

        Account::create([
            'user_id' => Auth::id(),
            'title' => $request->title, // Nilai diambil dari dropdown
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil disimpan!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        Account::destroy($id);
        return redirect()->back()->with('success', 'Data dihapus.');
    }

    // --- FITUR BARU: SETTINGS KATEGORI ---
    
    // 1. Tampilkan Halaman Settings
    public function settings()
    {
        // Hanya Admin yang boleh akses
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        $categories = Category::latest()->get();
        return view('pages.settings', compact('categories'));
    }

    // 2. Simpan Kategori Baru
    public function storeCategory(Request $request)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        $request->validate(['name' => 'required|unique:categories,name']);
        
        Category::create(['name' => strtoupper($request->name)]); // Pakai huruf besar semua biar rapi
        
        return redirect()->back()->with('success', 'Kategori baru ditambahkan!');
    }

    // 3. Hapus Kategori
    public function destroyCategory($id)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        Category::destroy($id);
        return redirect()->back()->with('success', 'Kategori dihapus.');
    }
}