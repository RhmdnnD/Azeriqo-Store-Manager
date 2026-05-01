<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Stok (Real-time)
        $totalStok = Account::count();

        // 2. Ambil Total Terjual (Dari Counter Persistent)
        $setting = \App\Models\Setting::where('key', 'total_sold')->first();
        $totalTerjual = $setting ? $setting->value : 0;

        // 3. Stok Per Kategori (Untuk sementara kita disable view-nya, tapi datanya tetap kita kirim opsional)
        $stokPerKategori = []; 

        return view('welcome', compact('totalStok', 'totalTerjual', 'stokPerKategori'));
    }
}