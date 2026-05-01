@extends('layout')

@section('content')

    <style>
        .scroll-area { max-height: 450px; overflow-y: auto; padding-right: 5px; }
        .scroll-area::-webkit-scrollbar { width: 6px; }
        .scroll-area::-webkit-scrollbar-track { background: var(--bg-main); border-radius: 4px; }
        .scroll-area::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
        .scroll-area::-webkit-scrollbar-thumb:hover { background: var(--text-sub); }

        /* Style tambahan untuk search bar */
        .search-container { margin-bottom: 20px; padding: 15px; }
        .search-form { display: flex; gap: 10px; }
        .search-input-wrapper { position: relative; flex: 1; }
        .search-input { width: 100%; padding: 12px 15px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main); font-size: 0.9rem; transition: 0.2s; }
        .search-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .btn-search { background: var(--primary); color: white; border: none; padding: 0 20px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9rem; }
        .btn-reset { background: var(--bg-surface); color: var(--text-sub); border: 1px solid var(--border); padding: 0 15px; border-radius: 8px; text-decoration: none; display: flex; align-items: center; font-size: 0.85rem; font-weight: 600; }
    </style>

    <div class="header-responsive">
        <div>
            <h1 class="page-title">Account Database</h1>
            <p class="page-subtitle">Manage your game account stock here.</p>
        </div>
        <a href="{{ route('account.create') }}" style="background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.9rem; white-space: nowrap;">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Account
        </a>
    </div>

    <div class="card search-container">
        <form action="{{ route('dashboard') }}" method="GET" class="search-form">
            <div class="search-input-wrapper">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Search by username or category..." 
                    class="search-input">
            </div>
            <button type="submit" class="btn-search">Search</button>
            @if(request('search'))
                <a href="{{ route('dashboard') }}" class="btn-reset">Reset</a>
            @endif
        </form>
    </div>

    @forelse($accounts as $category => $items)
        <div class="card" style="padding-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 15px; margin-bottom: 20px;">
                <h3 style="color: var(--primary); font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    {{ $category }}
                </h3>
                <span style="background: var(--active-bg); color: var(--primary); padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; white-space: nowrap;">
                    {{ count($items) }} ITEMS
                </span>
            </div>
            
            <div class="scroll-area">
                <div class="grid-workers" style="padding-bottom: 5px;"> 
                    @foreach($items as $acc)
                    <div style="background: var(--bg-main); border: 1px solid var(--border); border-radius: 8px; padding: 15px; transition: 0.2s; position: relative;">
                        
                        <div style="font-family: 'Courier New', monospace; font-weight: 600; color: var(--text-main); font-size: 0.95rem; margin-bottom: 10px; word-break: break-all;">
                            {{ $acc->username }} | <span id="pass-display-{{ $acc->id }}">{{ $acc->password }}</span>
                        </div>

                        <div style="display: flex; justify-content: flex-end; gap: 8px;">
                            
                            @if(Auth::user()->role == 'admin')
                                <button type="button" 
                                    onclick="confirmModal('{{ route('account.sell', $acc->id) }}', 'Mark as Sold?', 'This account will be marked as sold and removed from stock.', 'Yes, Mark as Sold')"
                                    style="border: 1px solid var(--success); background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 5px 10px; border-radius: 6px; cursor: pointer; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    SELL
                                </button>
                            @endif

                            <button onclick="window.copyText('usn: {{ $acc->username }} || pass: {{ $acc->password }}')" 
                                style="border: 1px solid var(--border); background: var(--bg-surface); color: var(--text-main); padding: 5px 10px; border-radius: 6px; cursor: pointer; font-size: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                COPY
                            </button>
                            
                            @if(Auth::user()->role == 'admin')
                                <button onclick="openEditModal('{{ $acc->id }}', '{{ $acc->username }}', '{{ $acc->password }}')"
                                    style="border: 1px solid var(--border); background: var(--bg-surface); color: var(--primary); padding: 5px 8px; border-radius: 6px; cursor: pointer;">
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
        </div>
    @empty
        <div style="text-align: center; padding: 60px 20px;">
            <h3 style="color: var(--text-main);">Data Not Found</h3>
            <p style="color: var(--text-sub);">
                {{ request('search') ? 'No accounts found matching "' . request('search') . '"' : 'No accounts saved yet.' }}
            </p>
            <div style="margin-top: 15px;">
                @if(request('search'))
                    <a href="{{ route('dashboard') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">← Back to All Accounts</a>
                @else
                    <a href="{{ route('account.create') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Input Account Now &rarr;</a>
                @endif
            </div>
        </div>
    @endforelse

    <div id="edit-modal" class="modal-overlay">
        <div class="modal-box" style="text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="modal-title" style="margin: 0;">Change Password</h3>
                <button onclick="closeEditModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-sub);">&times;</button>
            </div>
            <p style="color: var(--text-sub); font-size: 0.9rem; margin-bottom: 15px;">
                Changing password for account: <br>
                <strong id="edit-username-display" style="color: var(--text-main);"></strong>
            </p>
            <form id="edit-form" method="POST">
                @csrf @method('PUT')
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.85rem; color: var(--text-main);">New Password</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" name="password" id="edit-password-input" required
                            style="flex: 1; padding: 10px; border: 1px solid var(--border); border-radius: 6px; font-family: monospace; background: var(--bg-main); color: var(--text-main);">
                        <button type="button" onclick="generateRandomPass()" 
                            style="background: var(--active-bg); border: 1px solid var(--primary); color: var(--primary); padding: 0 15px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.8rem;">RANDOM</button>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-modal-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-modal-delete" style="background: var(--primary); box-shadow: none;">Save</button>
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

        document.getElementById('edit-modal').onclick = function(e) { 
            if(e.target === this) closeEditModal(); 
        };
    </script>

@endsection