@extends('layout')

@section('content')

<div style="max-width: 900px; margin: 0 auto;">

    <div class="page-header">
        <h1 class="page-title">Kelola Tim (Workers)</h1>
        <p class="page-subtitle">Tambah akun untuk karyawan Anda di sini.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px;">
        
        <div class="card" style="height: fit-content;">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: var(--text-main); border-bottom: 1px solid var(--border); padding-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Akun Baru
            </h3>
            
            <form action="{{ route('workers.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.85rem;">Nama Worker</label>
                    <input type="text" name="name" placeholder="Nama Lengkap" required
                           style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.85rem;">Email Login</label>
                    <input type="email" name="email" placeholder="worker@azeriqo.com" required
                           style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 5px; font-size: 0.85rem;">Password</label>
                    <input type="text" name="password" placeholder="Password akun" required
                           style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px;">
                </div>
                
                <button type="submit" style="width: 100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    BUAT AKUN
                </button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: var(--text-main); border-bottom: 1px solid var(--border); padding-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Daftar Worker Aktif
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($workers as $worker)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8fafc; border: 1px solid var(--border); border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 35px; height: 35px; background: var(--text-main); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                            {{ substr($worker->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--text-main);">{{ $worker->name }}</div>
                            <div style="font-size: 0.85rem; color: #64748b;">{{ $worker->email }}</div>
                        </div>
                    </div>
                    
                    <form action="{{ route('workers.delete', $worker->id) }}" method="POST" onsubmit="return confirmDelete(event, this)" style="margin: 0;">
                        @csrf @method('DELETE')
                        <button style="background: white; border: 1px solid #fecaca; color: var(--danger); padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 5px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            HAPUS
                        </button>
                    </form>
                </div>
                @empty
                <div style="text-align: center; color: #94a3b8; padding: 30px;">
                    Belum ada worker. Tambahkan di formulir sebelah kiri.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection