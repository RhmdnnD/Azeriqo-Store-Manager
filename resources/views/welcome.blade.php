@extends('layout')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">

    <div class="page-header" style="text-align: center;">
        <h1 class="page-title">Generator Akun & Password</h1>
        <p class="page-subtitle">Tools otomatis untuk kebutuhan stok toko game Anda.</p>
    </div>

    <div class="card">
        
        <div style="display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <button id="tab-user" onclick="setMode('username')" style="flex: 1; padding: 12px; border: 2px solid var(--primary); background: var(--primary); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Mode Username
            </button>
            <button id="tab-pass" onclick="setMode('password')" style="flex: 1; padding: 12px; border: 2px solid var(--border); background: white; color: #64748b; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Mode Password
            </button>
        </div>

        <div class="controls-area">
            
            <div id="username-options">
                <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div style="flex: 2;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Kata Tambahan</label>
                        <input type="text" id="custom-words" placeholder="Contoh: Super, Pro, Mega" 
                               style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #f8fafc;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Posisi Kata</label>
                        <select id="word-position" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #f8fafc;">
                            <option value="prefix">Di Depan (Prefix)</option>
                            <option value="suffix">Di Belakang (Suffix)</option>
                            <option value="random">Acak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Panjang Karakter</label>
                    <input type="number" id="length" value="4" min="4" max="20" 
                           style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #f8fafc;">
                </div>
                <div style="flex: 1;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Jumlah Generate</label>
                    <input type="number" id="quantity" value="1" min="1" max="50" 
                           style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: #f8fafc;">
                </div>
            </div>

            <div style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid var(--border); display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 25px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" id="use-lower" checked style="accent-color: var(--primary); width: 18px; height: 18px;"> Huruf Kecil (a-z)
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" id="use-upper" checked style="accent-color: var(--primary); width: 18px; height: 18px;"> Huruf Besar (A-Z)
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" id="use-number" checked style="accent-color: var(--primary); width: 18px; height: 18px;"> Angka (0-9)
                </label>
                <label id="opt-symbol" style="display: none; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="checkbox" id="use-symbol" style="accent-color: var(--primary); width: 18px; height: 18px;"> Simbol (!@#)
                </label>
            </div>

            <button onclick="generate()" style="width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                GENERATE SEKARANG
            </button>

        </div>
    </div>

    <div id="result-container" class="card" style="display: none;">
        <h3 style="font-size: 1.1rem; color: var(--text-main); margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
            Hasil Generator
        </h3>
        <div id="result-list" style="display: grid; gap: 10px;"></div>
    </div>

</div>

<script>
    let currentMode = 'username';

    function setMode(mode) {
        currentMode = mode;
        const btnUser = document.getElementById('tab-user');
        const btnPass = document.getElementById('tab-pass');
        const boxUserOpts = document.getElementById('username-options');
        const optSymbol = document.getElementById('opt-symbol');

        if (mode === 'username') {
            // Style Active Tab
            btnUser.style.background = 'var(--primary)';
            btnUser.style.color = 'white';
            btnUser.style.borderColor = 'var(--primary)';
            
            btnPass.style.background = 'white';
            btnPass.style.color = '#64748b';
            btnPass.style.borderColor = 'var(--border)';

            // Show/Hide Options
            boxUserOpts.style.display = 'block';
            optSymbol.style.display = 'none';
        } else {
            // Style Active Tab
            btnPass.style.background = 'var(--primary)';
            btnPass.style.color = 'white';
            btnPass.style.borderColor = 'var(--primary)';

            btnUser.style.background = 'white';
            btnUser.style.color = '#64748b';
            btnUser.style.borderColor = 'var(--border)';

            // Show/Hide Options
            boxUserOpts.style.display = 'none';
            optSymbol.style.display = 'flex';
        }
    }

    function generate() {
        const listDiv = document.getElementById('result-list');
        document.getElementById('result-container').style.display = 'block';
        listDiv.innerHTML = "";

        const length = parseInt(document.getElementById('length').value);
        const qty = parseInt(document.getElementById('quantity').value);
        
        // Checkboxes
        const useLower = document.getElementById('use-lower').checked;
        const useUpper = document.getElementById('use-upper').checked;
        const useNumber = document.getElementById('use-number').checked;
        const useSymbol = document.getElementById('use-symbol').checked;
        
        // Custom Words Options
        const customWordsVal = document.getElementById('custom-words').value;
        const customWords = customWordsVal.split(/[\s,]+/).filter(Boolean);
        const position = document.getElementById('word-position').value;

        // Build Charset
        let chars = "";
        if (useLower) chars += "abcdefghijklmnopqrstuvwxyz";
        if (useUpper) chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if (useNumber) chars += "0123456789";
        if (currentMode === 'password' && useSymbol) chars += "!@#$%^&*()_+";

        if (chars === "") { alert("Pilih minimal 1 jenis karakter!"); return; }

        for(let i=0; i<qty; i++) {
            let result = "";
            let randomStr = "";
            
            // Generate Random Part
            for(let j=0; j<length; j++) {
                randomStr += chars.charAt(Math.floor(Math.random() * chars.length));
            }

            // Logic Mode Username (Menggabungkan Custom Word)
            if (currentMode === 'username' && customWords.length > 0) {
                const word = customWords[Math.floor(Math.random() * customWords.length)];
                
                if (position === 'prefix') {
                    result = word + randomStr;
                } else if (position === 'suffix') {
                    result = randomStr + word;
                } else {
                    // Random Position
                    result = Math.random() < 0.5 ? (word + randomStr) : (randomStr + word);
                }
            } else {
                // Mode Password atau Username tanpa custom words
                result = randomStr;
            }

            // Render Item
            const div = document.createElement('div');
            div.style.background = '#f1f5f9';
            div.style.padding = '12px';
            div.style.borderRadius = '8px';
            div.style.display = 'flex';
            div.style.justifyContent = 'space-between';
            div.style.alignItems = 'center';
            div.style.border = '1px solid var(--border)';
            
            div.innerHTML = `
                <span style="font-family: monospace; font-size: 1.1rem; font-weight: 600; color: var(--text-main);">${result}</span>
                <div style="display: flex; gap: 8px;">
                    <button onclick="copyToClip('${result}')" style="background: white; border: 1px solid var(--border); color: var(--primary); padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600; display:flex; align-items:center; gap:5px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Copy
                    </button>
                    @auth
                    <a href="{{ route('account.create') }}?${currentMode}=${result}" style="background: var(--success); color: white; text-decoration: none; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display:flex; align-items:center; gap:5px;">
                         <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                         Pakai
                    </a>
                    @endauth
                </div>
            `;
            listDiv.appendChild(div);
        }
    }

    function copyToClip(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Panggil fungsi Pop-Up dari Layout (jika ada)
            if (typeof window.showToast === "function") {
                window.showToast("Disalin: " + text);
            } else {
                // Fallback jika belum load (jarang terjadi)
                alert("Berhasil disalin: " + text);
            }
        });
    }
</script>
@endsection