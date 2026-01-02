<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azeriqo Store Manager</title>
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
        .sidebar { width: var(--sidebar-width); background: var(--bg-surface); border-right: 1px solid var(--border); height: 100vh; position: fixed; left: 0; top: 0; display: flex; flex-direction: column; padding: 24px; z-index: 10; }
        .brand { font-size: 1.25rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 10px; margin-bottom: 40px; }
        .brand span { color: var(--primary); }
        .nav-menu { list-style: none; display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; color: #64748b; font-weight: 500; font-size: 0.95rem; border-radius: 8px; transition: all 0.2s ease; }
        .nav-link:hover { background: #f1f5f9; color: var(--primary); }
        .nav-link.active { background: #eef2ff; color: var(--primary); font-weight: 600; }
        .nav-icon { width: 20px; height: 20px; }
        .user-panel { padding-top: 20px; border-top: 1px solid var(--border); }
        .btn-logout { width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #fef2f2; color: var(--danger); border: 1px solid #fecaca; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.85rem; transition: 0.2s; }
        .btn-logout:hover { background: #fee2e2; }
        .btn-login { width: 100%; text-align: center; padding: 10px; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: block; }

        /* --- CONTENT --- */
        .main-wrapper { flex: 1; margin-left: var(--sidebar-width); padding: 40px; position: relative; z-index: 1; }
        .card { background: var(--bg-surface); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid var(--border); padding: 24px; margin-bottom: 24px; }
        .page-header { margin-bottom: 30px; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: var(--text-main); }
        .page-subtitle { color: #64748b; font-size: 0.9rem; margin-top: 4px; }
        #particles-js { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }

        /* --- NOTIFIKASI POPUP (TOAST) --- */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 99999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
        .toast-box { pointer-events: auto; background: white; border-left: 4px solid var(--success); padding: 16px 20px; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); display: flex; align-items: center; gap: 12px; min-width: 300px; animation: slideIn 0.3s ease-out forwards; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); transition: 0.3s; } .main-wrapper { margin-left: 0; padding: 20px; } }
    </style>

    <script>
        // 1. FUNGSI POPUP GLOBAL
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
                <div>
                    <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Berhasil!</div>
                    <div style="color: #64748b; font-size: 0.85rem;">${message}</div>
                </div>
            `;
            container.appendChild(box);
            // Hapus otomatis setelah 3 detik
            setTimeout(() => { box.remove(); }, 3000);
        };

        // 2. FUNGSI COPY GLOBAL
        window.copyText = function(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    window.showToast("Disalin: " + text);
                }).catch(err => {
                    alert("Gagal menyalin otomatis. Silakan copy manual.");
                });
            } else {
                // Fallback untuk browser lama
                let textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed"; 
                textArea.style.left = "-9999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    window.showToast("Disalin: " + text);
                } catch (err) {
                    alert("Gagal menyalin.");
                }
                document.body.removeChild(textArea);
            }
        };
    </script>
</head>
<body>

    <div class="toast-container" id="toast-container">
        @if(session('success'))
        <div class="toast-box">
            <svg width="24" height="24" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <div style="font-weight: 700; color: var(--text-main); font-size: 0.9rem;">Berhasil!</div>
                <div style="color: #64748b; font-size: 0.85rem;">{{ session('success') }}</div>
            </div>
        </div>
        @endif
    </div>

    <aside class="sidebar">
        <div class="brand">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 17L12 22L22 17" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12L12 17L22 12" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            AZERIQO<span>STORE</span>
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

    <main class="main-wrapper">
        @yield('content')
    </main>

    <div id="particles-js"></div>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        // Hapus notifikasi server setelah 3 detik
        setTimeout(() => {
            const serverToast = document.querySelector('.toast-box');
            if(serverToast) serverToast.style.display = 'none';
        }, 3000);

        // Init Particles dengan Pengecekan
        if(typeof particlesJS !== 'undefined') {
            particlesJS("particles-js", {
                "particles": { "number": { "value": 40 }, "color": { "value": "#cbd5e1" }, "shape": { "type": "circle" }, "opacity": { "value": 0.5 }, "size": { "value": 3 }, "line_linked": { "enable": true, "distance": 150, "color": "#cbd5e1", "opacity": 0.4, "width": 1 }, "move": { "enable": true, "speed": 1 } },
                "interactivity": { "events": { "onhover": { "enable": true, "mode": "grab" } } }
            });
        }
    </script>
</body>
</html>