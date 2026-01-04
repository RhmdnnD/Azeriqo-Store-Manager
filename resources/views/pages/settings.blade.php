@extends('layout')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Pengaturan Toko</h1>
            <p class="page-subtitle">Kelola daftar kategori akun agar lebih rapi.</p>
        </div>
    </div>

    <div class="grid-responsive">
        
        <div class="card" style="height: fit-content;">
            <h3 style="margin-bottom: 15px; font-size: 1rem; color: var(--text-main);">Tambah Kategori Baru</h3>
            
            <form action="{{ route('settings.store') }}" method="POST">
                @csrf
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.85rem;">Nama Kategori</label>
                <input type="text" name="name" placeholder="Contoh: AKUN 35 BEE" required
                       style="width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 6px; margin-bottom: 15px;">
                
                <button type="submit" style="width: 100%; background: var(--primary); color: white; border: none; padding: 10px; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    + SIMPAN KATEGORI
                </button>
            </form>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 15px; font-size: 1rem; color: var(--text-main);">Daftar Kategori Aktif ({{ $categories->count() }})</h3>
            
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @forelse($categories as $cat)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border: 1px solid var(--border); border-radius: 8px;">
                    <span style="font-weight: 600; color: var(--text-main);">{{ $cat->name }}</span>
                    
                    <button type="button" 
                        onclick="confirmDelete('{{ route('settings.delete', $cat->id) }}')"
                        style="background: white; border: 1px solid #fecaca; color: var(--danger); padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.75rem; font-weight: 600;">
                        HAPUS
                    </button>
                </div>
                @empty
                <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada kategori.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection