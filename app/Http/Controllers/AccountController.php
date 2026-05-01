<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->query('search');

        if ($user->role === 'admin') {
            $query = Account::query();
        } else {
            $query = Account::where('user_id', $user->id);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                ->orWhere('title', 'LIKE', "%{$search}%");
            });
        }

        $accounts = $query->orderBy('title')->get()->groupBy('title');
        
        return view('pages.index', compact('accounts'));
    }

    public function create()
    {
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

        $workerName = Auth::user()->name;
        $msg = "✅ <b>INPUT DATA BARU</b>\n\n" .
               "👤 <b>Worker:</b> {$workerName}\n" .
               "📂 <b>Kategori:</b> {$request->title}\n" .
               "🆔 <b>Akun:</b> {$request->username}\n" .
               "📅 <b>Waktu:</b> " . now()->format('d M Y H:i');
        
        $this->sendTelegram($msg);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil disimpan!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        Account::destroy($id);
        return redirect()->back()->with('success', 'Data dihapus.');
    }
    
    public function settings()
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        $categories = Category::latest()->get();
        return view('pages.settings', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        $request->validate(['name' => 'required|unique:categories,name']);
        
        Category::create(['name' => strtoupper($request->name)]); // Pakai huruf besar semua biar rapi
        
        return redirect()->back()->with('success', 'Kategori baru ditambahkan!');
    }

    public function destroyCategory($id)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        Category::destroy($id);
        return redirect()->back()->with('success', 'Kategori dihapus.');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }

        $request->validate([
            'password' => 'required|string|min:1',
        ]);

        $account = Account::findOrFail($id);
        $account->update([
            'password' => $request->password
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    public function clearLogs()
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }

        Account::truncate();

        return redirect()->back()->with('success', 'Semua riwayat log & data akun berhasil dibersihkan.');
    }

    public function bulkView()
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        $categories = Category::orderBy('name')->get();
        return view('pages.bulk', compact('categories'));
    }

    public function import(Request $request)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }

        $request->validate([
            'file' => 'required|mimes:txt,csv',
            'title' => 'required'
        ]);

        $file = $request->file('file');
        
        $content = file_get_contents($file->getRealPath());
        $lines = explode(PHP_EOL, $content);
        
        $count = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            if (str_contains($line, '|')) {
                $parts = explode('|', $line, 2);
            } elseif (str_contains($line, ',')) {
                $parts = explode(',', $line, 2);
            } elseif (str_contains($line, ':')) {
                $parts = explode(':', $line, 2);
            } else {
                continue;
            }

            if (count($parts) >= 2) {
                Account::create([
                    'user_id' => Auth::id(),
                    'title' => $request->title,
                    'username' => trim($parts[0]),
                    'password' => trim($parts[1]),
                ]);
                $count++;
            }
        }

        if ($count > 0) {
            // --- KIRIM NOTIFIKASI ---
            $adminName = Auth::user()->name;
            $msg = "📦 <b>IMPORT MASSAL SUKSES</b>\n\n" .
                   "👤 <b>Admin:</b> {$adminName}\n" .
                   "📂 <b>Kategori:</b> {$request->title}\n" .
                   "📊 <b>Jumlah:</b> {$count} Akun\n" .
                   "📅 <b>Waktu:</b> " . now()->format('d M Y H:i');
            
            $this->sendTelegram($msg);
            // ------------------------
        }

        return redirect()->back()->with('success', "SUKSES! Berhasil mengimport {$count} akun baru.");
    }

    public function export(Request $request)
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }

        $category = $request->category;
        
        if ($category && $category !== 'all') {
            $accounts = Account::where('title', $category)->get();
            $filename = "Stok-{$category}-" . date('d-m-Y') . ".txt";
        } else {
            $accounts = Account::all();
            $filename = "Stok-SEMUA-" . date('d-m-Y') . ".txt";
        }

        $content = "";
        foreach ($accounts as $acc) {
            $content .= "{$acc->username}|{$acc->password}" . PHP_EOL;
        }

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, $filename);
    }

    // --- FUNGSI KIRIM NOTIFIKASI TELEGRAM ---
    private function sendTelegram($message)
    {
        try {
            $token = env('TELEGRAM_BOT_TOKEN');
            $chat_id = env('TELEGRAM_CHAT_ID');

            if (!$token || !$chat_id) {
                return; // Batalkan jika belum disetting
            }

            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'HTML' // Agar bisa pakai huruf tebal (Bold)
            ]);
        } catch (\Exception $e) {
            // Biarkan error diam (silent fail) agar tidak mengganggu proses utama
        }
    }

    // --- FITUR MARK AS SOLD (JUAL) ---
    public function sell($id)
    {
        // 1. Cari Akun
        $account = Account::findOrFail($id);

        // 2. Simpan ke Riwayat Transaksi (Untuk Log Sementara)
        \App\Models\Transaction::create([
            'user_id'  => Auth::id(),
            'title'    => $account->title,
            'username' => $account->username,
            'password' => $account->password,
            'sold_at'  => now(),
        ]);

        // 3. UPDATE COUNTER PERSISTENT (Agar angka tidak hilang saat log dihapus)
        $counter = \App\Models\Setting::firstOrCreate(
            ['key' => 'total_sold'],
            ['value' => 0]
        );
        $counter->increment('value'); // Tambah 1

        // 4. Hapus dari Stok Aktif
        $account->delete();

        return redirect()->back()->with('success', 'Berhasil! Akun terjual.');
    }

    // --- BERSIHKAN RIWAYAT TRANSAKSI (HEMAT DB) ---
    public function clearTransactions()
    {
        if (Auth::user()->role !== 'admin') { return abort(403); }
        
        // Truncate menghapus semua isi tabel transaksi
        \App\Models\Transaction::truncate();
        
        return redirect()->back()->with('success', 'Riwayat transaksi dibersihkan! Angka Total Terjual tetap aman.');
    }

}