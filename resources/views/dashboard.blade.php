<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azeriqo Dashboard</title>
    <style>
        /* --- THEME VARIABLES --- */
        :root {
            --bg-color: #f0f4f8; --card-bg: #ffffff; --primary-color: #3b82f6; --primary-hover: #2563eb;
            --text-main: #1e293b; --text-muted: #64748b; --border-color: #e2e8f0; --input-bg: #f8fafc;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        body.dark-mode {
            --bg-color: #0f172a; --card-bg: #1e293b; --primary-color: #60a5fa; --primary-hover: #93c5fd;
            --text-main: #f8fafc; --text-muted: #94a3b8; --border-color: #334155; --input-bg: #0f172a;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        /* --- BASIC SETUP --- */
        body { font-family: 'Segoe UI', Inter, sans-serif; background-color: var(--bg-color); color: var(--text-main); margin: 0; min-height: 100vh; transition: 0.3s; }
        #particles-js { position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 0; }
        .page-wrapper { position: relative; z-index: 1; padding: 20px; }
        .container-fluid { max-width: 1200px; margin: 0 auto; }
        
        /* --- LAYOUT --- */
        .grid-split { display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px; }
        @media (max-width: 768px) { .grid-split { grid-template-columns: 1fr; } }

        /* --- CARD --- */
        .card { background: var(--card-bg); padding: 25px; border-radius: 16px; border: 1px solid var(--border-color); box-shadow: var(--shadow); position: relative; }
        h3 { margin-top: 0; color: var(--primary-color); border-bottom: 2px solid var(--border-color); padding-bottom: 10px; margin-bottom: 20px; }

        /* --- INPUTS --- */
        .controls { display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 6px; font-weight: 600; }
        input[type="text"], input[type="number"] {
            width: 100%; background: var(--input-bg); border: 2px solid var(--border-color);
            color: var(--text-main); padding: 12px; border-radius: 8px; box-sizing: border-box;
        }
        input:focus { outline: none; border-color: var(--primary-color); }
        .row { display: flex; gap: 15px; } .col { flex: 1; }
        
        .checkbox-group { display: flex; gap: 10px; background: var(--input-bg); padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); flex-wrap: wrap;}
        .check-item { display: flex; align-items: center; cursor: pointer; font-size: 0.9rem; font-weight: 500; }
        input[type="checkbox"] { accent-color: var(--primary-color); margin-right: 8px; width: 18px; height: 18px; }

        /* --- BUTTONS --- */
        .generate-btn {
            background-color: var(--primary-color); color: #fff; border: none; padding: 12px; width: 100%;
            font-size: 1rem; font-weight: 600; border-radius: 8px; cursor: pointer; transition: 0.2s;
        }
        .generate-btn:hover { opacity: 0.9; transform: translateY(-2px); }
        .theme-toggle { position: absolute; top: 20px; right: 20px; background: var(--card-bg); border: 1px solid var(--border-color); width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 100; font-size: 1.2rem;}

        /* --- LIST RESULTS --- */
        .list-container { max-height: 400px; overflow-y: auto; }
        .result-item {
            background: var(--input-bg); padding: 10px; margin-bottom: 8px; border-radius: 8px; 
            display: flex; justify-content: space-between; align-items: center; border: 1px solid transparent;
        }
        .result-item:hover { border-color: var(--primary-color); }
        .res-text { font-family: monospace; font-weight: bold; font-size: 1.1rem; }
        .action-btns { display: flex; gap: 5px; }
        .btn-mini { padding: 5px 10px; border-radius: 4px; border: none; cursor: pointer; font-size: 0.75rem; color: white; }
        .btn-copy { background: #10b981; } 
        .btn-use { background: #f59e0b; }
        .btn-del { background: #ef4444; }

        /* --- HEADER & TOAST --- */
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: var(--card-bg); padding: 15px; border-radius: 12px; border: 1px solid var(--border-color); }
        .logout-btn { background: #ef4444; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold;}
        #toast { visibility: hidden; min-width: 200px; background-color: #333; color: #fff; text-align: center; border-radius: 50px; padding: 12px; position: fixed; z-index: 999; bottom: 30px; left: 50%; transform: translateX(-50%); }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;} }
        @keyframes fadeout { from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;} }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <button class="theme-toggle" onclick="toggleTheme()">🌓</button>
    <div id="toast">Notifikasi</div>

    <div class="page-wrapper">
        <div class="container-fluid">
            
            <div class="top-bar">
                <div>
                    Halo, <strong>{{ Auth::user()->name }}</strong> 
                    <span style="font-size:0.8rem; background:var(--primary-color); color:white; padding:2px 8px; border-radius:10px; margin-left:5px;">
                        {{ Auth::user()->role == 'admin' ? 'BOSS' : 'STAFF' }}
                    </span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Keluar</button>
                </form>
            </div>

            @if(session('success'))
                <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="grid-split">
                
                <div class="card">
                    <h3>🛠️ Generator Otomatis</h3>
                    
                    <div style="display:flex; gap:10px; margin-bottom:15px;">
                        <button class="generate-btn" id="btn-mode-user" style="padding:8px;" onclick="setMode('username')">Mode Username</button>
                        <button class="generate-btn" id="btn-mode-pass" style="padding:8px; background-color:#64748b;" onclick="setMode('password')">Mode Password</button>
                    </div>

                    <div class="controls">
                        <input type="text" id="custom-words" placeholder="Kata Tambahan (Khusus Username)">
                        <div class="row">
                            <div class="col"><label>Panjang</label><input type="number" id="length" value="8"></div>
                            <div class="col"><label>Jumlah</label><input type="number" id="quantity" value="1" max="10"></div>
                        </div>
                        <div class="checkbox-group">
                            <label class="check-item"><input type="checkbox" id="use-lower" checked> a-z</label>
                            <label class="check-item"><input type="checkbox" id="use-upper" checked> A-Z</label>
                            <label class="check-item"><input type="checkbox" id="use-number" checked> 0-9</label>
                            <label class="check-item" id="box-symbol" style="display:none;"><input type="checkbox" id="use-symbol"> !@#</label>
                        </div>
                    </div>
                    <button class="generate-btn" onclick="runGenerator()">GENERATE SEKARANG</button>

                    <div id="gen-result" class="list-container" style="margin-top:15px; max-height:150px; border:1px dashed var(--border-color); padding:10px;">
                        <div style="text-align:center; color:var(--text-muted); font-size:0.8rem;">Hasil akan muncul di sini...</div>
                    </div>

                    <hr style="border-color: var(--border-color); margin: 25px 0;">

                    <h3 style="margin-bottom:10px;">💾 Input ke Database</h3>
                    <form action="{{ route('account.store') }}" method="POST">
                        @csrf
                        <input type="text" name="title" placeholder="Nama Paket (Opsional)" style="margin-bottom:10px;">
                        <div class="row" style="margin-bottom:10px;">
                            <input type="text" id="input-username" name="username" placeholder="Username" required>
                            <input type="text" id="input-password" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="generate-btn" style="background: #10b981;">KIRIM DATA</button>
                    </form>
                </div>

                <div class="card">
                    <h3>📂 Data Tersimpan</h3>
                    <div class="list-container" style="max-height:600px;">
                        @forelse($accounts as $acc)
                        <div class="result-item" style="border-left: 4px solid var(--primary-color);">
                            <div>
                                <div style="font-weight:bold; color:var(--primary-color); font-size:0.9rem;">{{ $acc->title ?? 'Tanpa Judul' }}</div>
                                <div style="font-family:monospace; font-size:1rem; margin-top:2px;">{{ $acc->username }} | {{ $acc->password }}</div>
                                <div style="font-size:0.7rem; color:var(--text-muted); margin-top:4px;">
                                    {{ $acc->created_at->diffForHumans() }} 
                                    @if(Auth::user()->role == 'admin') • Oleh: {{ $acc->user->name }} @endif
                                </div>
                            </div>
                            <div class="action-btns">
                                <button type="button" class="btn-mini btn-copy" onclick="copyFormat('{{ $acc->username }}','{{ $acc->password }}')">COPY</button>
                                @if(Auth::user()->role == 'admin')
                                <form action="{{ route('account.delete', $acc->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-mini btn-del">X</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div style="text-align:center; padding:20px; color:var(--text-muted);">Belum ada data.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <script>
        // 1. SETUP LOGIC
        let currentMode = 'username';

        function setMode(mode) {
            currentMode = mode;
            // Atur tampilan tombol
            document.getElementById('btn-mode-user').style.background = mode === 'username' ? 'var(--primary-color)' : '#64748b';
            document.getElementById('btn-mode-pass').style.background = mode === 'password' ? 'var(--primary-color)' : '#64748b';
            
            // Atur input yang muncul
            document.getElementById('custom-words').style.display = mode === 'username' ? 'block' : 'none';
            document.getElementById('box-symbol').style.display = mode === 'password' ? 'flex' : 'none';
        }

        function runGenerator() {
            const listDiv = document.getElementById('gen-result');
            listDiv.innerHTML = ""; // Bersihkan hasil lama

            // Ambil Nilai Input
            const length = parseInt(document.getElementById('length').value);
            const quantity = parseInt(document.getElementById('quantity').value);
            const useLower = document.getElementById('use-lower').checked;
            const useUpper = document.getElementById('use-upper').checked;
            const useNumber = document.getElementById('use-number').checked;
            const useSymbol = document.getElementById('use-symbol').checked;
            const customWords = document.getElementById('custom-words').value.split(/[\s,]+/).filter(Boolean);

            // Tentukan Karakter yang boleh dipakai
            let chars = "";
            if (useLower) chars += "abcdefghijklmnopqrstuvwxyz";
            if (useUpper) chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            if (useNumber) chars += "0123456789";
            if (currentMode === 'password' && useSymbol) chars += "!@#$%^&*()_+";

            if (chars === "") { alert("Pilih minimal 1 jenis karakter!"); return; }

            // Loop Pembuatan
            for(let i=0; i<quantity; i++) {
                let result = "";
                
                // Jika Mode Username & ada kata tambahan
                if (currentMode === 'username' && customWords.length > 0) {
                    const word = customWords[Math.floor(Math.random() * customWords.length)];
                    let randomSuffix = "";
                    for(let j=0; j<length; j++) randomSuffix += chars.charAt(Math.floor(Math.random() * chars.length));
                    result = word + randomSuffix;
                } else {
                    // Murni Random (Password)
                    for(let j=0; j<length; j++) result += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                // Render HTML Hasil
                const item = document.createElement('div');
                item.className = 'result-item';
                item.innerHTML = `
                    <span class="res-text">${result}</span>
                    <div class="action-btns">
                        <button class="btn-mini btn-copy" onclick="copyText('${result}')">COPY</button>
                        <button class="btn-mini btn-use" onclick="fillInput('${result}')">PAKAI</button>
                    </div>
                `;
                listDiv.appendChild(item);
            }
        }

        // 2. FUNGSI PEMBANTU
        function fillInput(text) {
            if (currentMode === 'username') {
                document.getElementById('input-username').value = text;
                showToast("Username terisi!");
            } else {
                document.getElementById('input-password').value = text;
                showToast("Password terisi!");
            }
        }

        function copyText(text) {
            navigator.clipboard.writeText(text);
            showToast("Disalin: " + text);
        }

        function copyFormat(user, pass) {
            const text = `usn: ${user} || pass: ${pass}`;
            navigator.clipboard.writeText(text);
            showToast("Disalin Format Toko!");
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.innerText = msg; t.className = "show";
            setTimeout(() => { t.className = t.className.replace("show", ""); }, 3000);
        }

        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            initParticles(); // Reset partikel agar warnanya menyesuaikan
        }

        // 3. PARTICLES JS CONFIG
        function initParticles() {
            const isDark = document.body.classList.contains('dark-mode');
            const colorVal = isDark ? "#ffffff" : "#3b82f6";
            particlesJS("particles-js", {
                "particles": {
                    "number": { "value": 50 },
                    "color": { "value": colorVal },
                    "shape": { "type": "circle" },
                    "opacity": { "value": 0.5 },
                    "size": { "value": 3 },
                    "line_linked": { "enable": true, "distance": 150, "color": colorVal, "opacity": 0.4, "width": 1 },
                    "move": { "enable": true, "speed": 2 }
                },
                "interactivity": { "events": { "onhover": { "enable": true, "mode": "grab" } } }
            });
        }

        // Jalankan saat load
        window.onload = function() {
            initParticles();
        };
    </script>
</body>
</html>