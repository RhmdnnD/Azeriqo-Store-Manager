@extends('layout')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">

    <div class="header-responsive">
        <div>
            <h1 class="page-title">Input Akun Manual</h1>
            <p class="page-subtitle">Masukkan data akun baru ke database.</p>
        </div>
        <a href="{{ route('dashboard') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 5px;">
            &larr; Kembali ke Database
        </a>
    </div>

    <div class="card">
        <form action="{{ route('account.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Kategori Akun</label>
                    <div style="position: relative;">
                        <select name="title" required 
                            style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #f8fafc; appearance: none; font-size: 0.95rem; color: var(--text-main);">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        
                        <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    @if($categories->count() == 0)
                        <div style="margin-top: 5px; font-size: 0.8rem; color: var(--danger);">
                            ⚠ Belum ada kategori. 
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('settings') }}" style="text-decoration: underline; color: var(--danger);">Buat dulu di Settings</a>.
                            @else
                                Hubungi Admin.
                            @endif
                        </div>
                    @endif
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Username / Email</label>
                    <input type="text" name="username" value="{{ request('username') }}" placeholder="Masukkan username..." required
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.95rem;">
                </div>

            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Password</label>
                <input type="text" name="password" value="{{ request('password') }}" placeholder="Masukkan password..." required
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-family: monospace; font-size: 0.95rem;">
            </div>

            <button type="submit" 
                style="width: 100%; background: var(--primary); color: white; padding: 14px; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                SIMPAN DATA
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