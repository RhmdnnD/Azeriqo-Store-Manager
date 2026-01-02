@extends('layout')

@section('content')

<div style="max-width: 600px; margin: 0 auto;">

    <div style="margin-bottom: 30px;">
        <h1 class="page-title">Input Akun Baru</h1>
        <p class="page-subtitle">Masukkan data akun game secara manual atau dari generator.</p>
    </div>

    <div class="card">
        <form action="{{ route('account.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 20px;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem; color: var(--text-main);">
                    Pilih Kategori / Paket
                </label>
                
                @if($categories->count() > 0)
                    <select name="title" required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #f8fafc; font-size: 1rem; cursor: pointer;">
                        <option value="" disabled selected>-- Pilih Salah Satu --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                @else
                    <div style="padding: 15px; background: #fff1f2; border: 1px solid #fecaca; border-radius: 8px; color: #be123c; font-size: 0.9rem;">
                        ⚠️ Belum ada kategori tersimpan. 
                        @if(Auth::user()->role == 'admin')
                            Silakan buat di menu <a href="{{ route('settings') }}" style="font-weight: bold; text-decoration: underline;">Settings</a> terlebih dahulu.
                        @else
                            Hubungi Admin untuk menambahkan kategori.
                        @endif
                    </div>
                @endif
            </div>
                <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 5px;">
                    *Tips: Gunakan nama yang sama agar data otomatis berkelompok di Dashboard.
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 30px;">
                
                <div style="flex: 1;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem; color: var(--text-main);">
                        Username / ID
                    </label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 12px; top: 12px; color: #94a3b8;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="username" value="{{ request('username') }}" required placeholder="Username"
                            style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid var(--border); border-radius: 8px; font-family: 'Courier New', monospace; font-weight: 600;">
                    </div>
                </div>

                <div style="flex: 1;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.95rem; color: var(--text-main);">
                        Password
                    </label>
                    <div style="position: relative;">
                        <div style="position: absolute; left: 12px; top: 12px; color: #94a3b8;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="text" name="password" value="{{ request('password') }}" required placeholder="Password"
                            style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid var(--border); border-radius: 8px; font-family: 'Courier New', monospace; font-weight: 600;">
                    </div>
                </div>
            </div>

            <button type="submit" 
                style="width: 100%; background: var(--primary); color: white; padding: 14px; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.2s;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                SIMPAN KE DATABASE
            </button>

        </form>
    </div>

    @if(request('username'))
        <div style="text-align: center; color: var(--success); font-weight: 500; margin-top: 15px; font-size: 0.9rem;">
            ✅ Data dari Generator berhasil dimuat otomatis.
        </div>
    @endif

</div>
@endsection