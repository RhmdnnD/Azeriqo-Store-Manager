@extends('layout')

@section('content')

    <div class="header-responsive">
        <div>
            <h1 class="page-title">Database Akun</h1>
            <p class="page-subtitle">Kelola stok akun game Anda di sini.</p>
        </div>
        <a href="{{ route('account.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.9rem; white-space: nowrap;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Akun
        </a>
    </div>

    @forelse($accounts as $category => $items)
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="color: var(--primary); font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    {{ $category }}
                </h3>
                <span style="background: #eef2ff; color: var(--primary); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; white-space: nowrap;">
                    {{ count($items) }} ITEM
                </span>
            </div>
            
            <div class="grid-workers">
                @foreach($items as $acc)
                <div style="background: #f8fafc; border: 1px solid var(--border); border-radius: 8px; padding: 15px; transition: 0.2s; position: relative;">
                    
                    <div style="font-family: 'Courier New', monospace; font-weight: 600; color: var(--text-main); font-size: 0.95rem; margin-bottom: 10px; word-break: break-all;">
                        {{ $acc->username }} | <span id="pass-display-{{ $acc->id }}">{{ $acc->password }}</span>
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button onclick="window.copyText('usn: {{ $acc->username }} || pass: {{ $acc->password }}')" 
                            style="border: 1px solid var(--border); background: white; color: var(--text-main); padding: 5px 10px; border-radius: 6px; cursor: pointer; font-size: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            COPY
                        </button>
                        
                        @if(Auth::user()->role == 'admin')
                        <button onclick="openEditModal('{{ $acc->id }}', '{{ $acc->username }}', '{{ $acc->password }}')"
                            style="border: 1px solid var(--border); background: white; color: var(--primary); padding: 5px 8px; border-radius: 6px; cursor: pointer;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>

                        <button type="button" 
                            onclick="confirmDelete('{{ route('account.delete', $acc->id) }}')"
                            style="border: 1px solid #fecaca; background: #fef2f2; color: var(--danger); padding: 5px 8px; border-radius: 6px; cursor: pointer;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 60px 20px;">
            <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg width="40" height="40" stroke="#94a3b8" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
            </div>
            <h3 style="color: var(--text-main); margin-bottom: 10px;">Database Kosong</h3>
            <p style="color: #64748b; margin-bottom: 25px;">Belum ada akun yang tersimpan.</p>
            <a href="{{ route('account.create') }}" style="color: var(--primary); font-weight: 600;">Input Akun Sekarang &rarr;</a>
        </div>
    @endforelse

    <div id="edit-modal" class="modal-overlay">
        <div class="modal-box" style="text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="modal-title" style="margin: 0;">Ubah Password</h3>
                <button onclick="closeEditModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #64748b;">&times;</button>
            </div>
            
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 15px;">
                Mengubah password untuk akun: <br>
                <strong id="edit-username-display" style="color: var(--text-main);"></strong>
            </p>

            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.85rem;">Password Baru</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="password" id="edit-password-input" required
                            style="flex: 1; padding: 10px; border: 1px solid var(--border); border-radius: 6px; font-family: monospace;">
                        <button type="button" onclick="generateRandomPass()" 
                            style="background: #eef2ff; border: 1px solid var(--primary); color: var(--primary); padding: 0 15px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.8rem;">ACAK</button>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-modal-cancel" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-modal-delete" style="background: var(--primary); box-shadow: none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, username, currentPass) {
            document.getElementById('edit-form').action = "/account/" + id;
            document.getElementById('edit-username-display').innerText = username;
            document.getElementById('edit-password-input').value = currentPass;
            const modal = document.getElementById('edit-modal');
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('show'); }, 10);
        }
        function closeEditModal() {
            const modal = document.getElementById('edit-modal');
            modal.classList.remove('show');
            setTimeout(() => { modal.style.display = 'none'; }, 200);
        }
        function generateRandomPass() {
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let pass = "";
            for(let i=0; i<8; i++) pass += chars.charAt(Math.floor(Math.random() * chars.length));
            document.getElementById('edit-password-input').value = pass;
        }
        document.getElementById('edit-modal').onclick = function(e) { if(e.target === this) closeEditModal(); };
    </script>

@endsection