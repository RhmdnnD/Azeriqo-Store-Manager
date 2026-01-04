<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azeriqo Store Manager</title>
    
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpeg">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- ATURAN WARNA 60-30-10 --- */
        :root {
            --bg-main: #f8fafc; 
            --bg-surface: #ffffff;
            --text-main: #1e293b;
            --border: #e2e8f0;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --danger: #ef4444;
            --success: #10b981;
            --sidebar-width: 250px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg-main); color: var(--text-main); min-height: 100vh; display: flex; }

        /* --- SIDEBAR --- */
        .sidebar { 
            width: var(--sidebar-width); background: var(--bg-surface); 
            border-right: 1px solid var(--border); 
            height: 100vh; /* Fallback */
            height: 100dvh; /* Full height di mobile browser modern */
            position: fixed; left: 0; top: 0; 
            display: flex; flex-direction: column; padding: 24px; z-index: 50; 
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .brand { font-size: 1.25rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 10px; margin-bottom: 30px; flex-shrink: 0; }
        .brand span { color: var(--primary); }
        .brand img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
        
        /* Navigasi Scrollable (PENTING AGAR PANEL BAWAH TIDAK HILANG) */
        .nav-menu { 
            list-style: none; display: flex; flex-direction: column; gap: 8px; flex: 1; 
            overflow-y: auto; /* Menu bisa discroll */
            padding-right: 5px; /* Ruang scrollbar */
            margin-bottom: 10px;
        }
        /* Custom Scrollbar tipis untuk nav */
        .nav-menu::-webkit-scrollbar { width: 4px; }
        .nav-menu::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; color: #64748b; font-weight: 500; font-size: 0.95rem; border-radius: 8px; transition: all 0.2s ease; flex-shrink: 0; }
        .nav-link:hover { background: #f1f5f9; color: var(--primary); }
        .nav-link.active { background: #eef2ff; color: var(--primary); font-weight: 600; }
        .nav-icon { width: 20px; height: 20px; }
        
        .user-panel { 
            padding-top: 20px; border-top: 1px solid var(--border); 
            flex-shrink: 0; /* Jangan menyusut */
            background: var(--bg-surface); /* Pastikan background putih */
        }
        .btn-logout { width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fef2f2; color: var(--danger); border: 1px solid #fecaca; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.85rem; transition: 0.2s; }
        .btn-logout:hover { background: #fee2e2; }
        .btn-login { width: 100%; text-align: center; padding: 10px; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: block; }

        /* --- CONTENT --- */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); padding: 40px; position: relative; z-index: 1; transition: margin-left 0.3s; }
        .card { background: var(--bg-surface); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid var(--border); padding: 24px; margin-bottom: 24px; }
        .page-header { margin-bottom: 30px; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-main); }
        .page-subtitle { color: #64748b; font-size: 0.9rem; margin-top: 4px; }
        #particles-js { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }

        /* --- UTILITY CLASSES --- */
        .grid-responsive { display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px; }
        .header-responsive { display: flex; justify-content: space-between; align-items: end; margin-bottom: 30px; }

        /* --- NOTIFIKASI POPUP --- */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
        .toast-box { pointer-events: auto; background: white; border-left: 4px solid var(--success); padding: 16px 20px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 12px; min-width: 300px; animation: slideIn 0.3s ease-out forwards; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* --- MODAL --- */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 99999; display: none; align-items: center; justify-content: center; backdrop-filter: blur(2px); opacity: 0; transition: opacity 0.2s; }
        .modal-overlay.show { opacity: 1; }
        .modal-box { background: white; width: 100%; max-width: 400px; padding: 30px; border-radius: 16px; text-align: center; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); transform: scale(0.9); transition: transform 0.2s; }
        .modal-overlay.show .modal-box { transform: scale(1); }
        .modal-icon { width: 60px; height: 60px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
        .modal-title { font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 10px; }
        .modal-desc { color: #64748b; font-size: 0.95rem; margin-bottom: 25px; line-height: 1.5; }
        .modal-actions { display: flex; gap: 10px; justify-content: center; }
        .btn-modal-cancel { background: white; border: 1px solid var(--border); color: var(--text-main); padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1; transition: 0.2s; }
        .btn-modal-delete { background: var(--danger); border: none; color: white; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; flex: 1; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3); }
        
        /* --- MOBILE ELEMENTS --- */
        .mobile-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 100; background: white; border: 1px solid var(--border); color: var(--text-main); padding: 10px; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .sidebar-backdrop { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 40; backdrop-filter: blur(2px); }

        /* --- MEDIA QUERIES (MOBILE RESPONSIVE) --- */
        @media (max-width: 768px) { 
            .sidebar { transform: translateX(-100%); box-shadow: none; }
            .sidebar.active { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,0.1); }
            
            .main-wrapper { margin-left: 0; padding: 20px; padding-top: 80px; }
            
            .mobile-toggle { display: flex; align-items: center; justify-content: center; }
            .sidebar-backdrop.show { display: block; }

            /* Tabel Scrollable */
            .card { overflow-x: auto; }
            table { min-width: 600px; }
            
            /* Responsive Utilities Update */
            .grid-responsive { grid-template-columns: 1fr; gap: 24px; }
            .header-responsive { flex-direction: column; align-items: flex-start; gap: 15px; }
            .header-responsive button { width: 100%; justify-content: center; }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        // --- 1. NOTIFIKASI TOAST ---
        window.showToast = function(message) {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast-container';
                document.body.appendChild(container);
            }
            const box = document.createElement('div');
            box.className = 'toast-box';
            box.innerHTML = `
                <svg width="24" height="24" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div><div style="font-weight: 700; font-size: 0.9rem;">Berhasil!</div><div style="color: #64748b; font-size: 0.85rem;">${message}</div></div>
            `;
            container.appendChild(box);
            setTimeout(() => { box.remove(); }, 3000);
        };

        // --- 2. COPY TEXT ---
        window.copyText = function(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => window.showToast("Disalin: " + text));
            } else {
                let ta = document.createElement("textarea");
                ta.value = text; ta.style.position="fixed"; ta.style.left="-9999px";
                document.body.appendChild(ta); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);
                window.showToast("Disalin: " + text);
            }
        };

        // --- 3. GLOBAL DELETE ---
        let deleteUrlTarget = ''; 
        window.confirmDelete = function(url) {
            deleteUrlTarget = url; 
            const modal = document.getElementById('confirm-modal');
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('show'); }, 10);
        };
        window.closeModal = function() {
            const modal = document.getElementById('confirm-modal');
            modal.classList.remove('show');
            setTimeout(() => { modal.style.display = 'none'; }, 200);
            deleteUrlTarget = '';
        };

        // --- 4. MOBILE SIDEBAR TOGGLE ---
        window.toggleSidebar = function() {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.querySelector('.sidebar-backdrop');
            sidebar.classList.toggle('active');
            backdrop.classList.toggle('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            NProgress.configure({ showSpinner: false, speed: 500 });
            
            const confirmBtn = document.getElementById('confirm-btn-action');
            if(confirmBtn) {
                confirmBtn.onclick = function() {
                    if (deleteUrlTarget) {
                        const globalForm = document.getElementById('global-delete-form');
                        globalForm.action = deleteUrlTarget;
                        globalForm.submit();
                    }
                    closeModal();
                };
            }
            
            const modalOverlay = document.getElementById('confirm-modal');
            if(modalOverlay) modalOverlay.onclick = function(e) { if (e.target === this) closeModal(); };

            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if(window.innerWidth <= 768) toggleSidebar();
                });
            });

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && link.href && !link.href.startsWith('#') && !link.target && link.hostname === window.location.hostname) {
                    NProgress.start();
                }
            });
            document.addEventListener('submit', function(e) { NProgress.start(); });
            window.addEventListener('pageshow', function() { NProgress.done(); });
        });
    </script>
</head>
<body>

    <button class="mobile-toggle" onclick="toggleSidebar()">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button>
    <div class="sidebar-backdrop" onclick="toggleSidebar()"></div>

    <form id="global-delete-form" method="POST" style="display: none;">
        @csrf @method('DELETE')
    </form>

    <div class="toast-container" id="toast-container">
        @if(session('success'))
        <div class="toast-box">
            <svg width="24" height="24" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div><div style="font-weight: 700; font-size: 0.9rem;">Berhasil!</div><div style="color: #64748b; font-size: 0.85rem;">{{ session('success') }}</div></div>
        </div>
        @endif
    </div>

    <div id="confirm-modal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="modal-title">Hapus Data?</h3>
            <p class="modal-desc">Data akan hilang permanen dari database.</p>
            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeModal()">Batal</button>
                <button type="button" id="confirm-btn-action" class="btn-modal-delete">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <aside class="sidebar">
        <div class="brand">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo"> AZERIQO<span>STORE</span>
        </div>
        
        <nav class="nav-menu">
            <a href="{{ route('home') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                Generator
            </a>
            @auth
            <div style="margin: 10px 0 5px 12px; font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                Database Akun
            </a>
            <a href="{{ route('account.create') }}" class="nav-link {{ Request::is('input') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Input Manual
            </a>
            <a href="{{ route('account.log') }}" class="nav-link {{ Request::is('activity-log') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Log Aktivitas
            </a>
            @if(Auth::user()->role == 'admin')
            <a href="{{ route('settings') }}" class="nav-link {{ Request::is('settings') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Settings Toko
            </a>
            <a href="{{ route('workers.index') }}" class="nav-link {{ Request::is('manage-workers') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Kelola Workers
            </a>
            @endif
            @endauth
        </nav>

        <div class="user-panel">
            @auth
                <div style="margin-bottom: 10px;">
                    <div style="font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                    <div style="color: #64748b; font-size: 0.75rem;">{{ Auth::user()->role == 'admin' ? 'Administrator' : 'Worker Staff' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-logout">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">Login Staff</a>
            @endauth
        </div>
    </aside>

    <main class="main-wrapper">@yield('content')</main>
    <div id="particles-js"></div>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        if(typeof particlesJS !== 'undefined') {
            particlesJS("particles-js", { "particles": { "number": { "value": 40 }, "color": { "value": "#cbd5e1" }, "shape": { "type": "circle" }, "opacity": { "value": 0.5 }, "size": { "value": 3 }, "line_linked": { "enable": true, "distance": 150, "color": "#cbd5e1", "opacity": 0.4, "width": 1 }, "move": { "enable": true, "speed": 1 } }, "interactivity": { "events": { "onhover": { "enable": true, "mode": "grab" } } } });
        }
    </script>
</body>
</html>