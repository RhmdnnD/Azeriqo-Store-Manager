@extends('layout')

@section('content')
<style>
    /* --- LANDING PAGE SPECIAL STYLES --- */
    .hero-section { text-align: center; margin-bottom: 40px; padding: 20px 0; }
    .hero-title { font-size: 2rem; font-weight: 800; color: var(--text-main); margin-bottom: 10px; letter-spacing: -0.025em; }
    .hero-subtitle { color: var(--text-sub); font-size: 1rem; max-width: 600px; margin: 0 auto; line-height: 1.6; }

    /* STATS CARDS */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px; }
    .stat-card { background: var(--bg-surface); border: 1px solid var(--border); border-radius: 12px; padding: 24px; text-align: center; transition: transform 0.2s, border-color 0.2s; position: relative; overflow: hidden; }
    .stat-card:hover { transform: translateY(-5px); border-color: var(--primary); }
    .stat-value { font-size: 2.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 5px; }
    .stat-label { color: var(--text-sub); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
    
    /* Decoration Circle in Card */
    .stat-decor { position: absolute; top: -10px; right: -10px; width: 60px; height: 60px; border-radius: 50%; opacity: 0.1; }

    /* CATEGORY PILLS */
    .category-list { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 50px; }
    .cat-pill { background: var(--bg-surface); border: 1px solid var(--border); padding: 8px 16px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; color: var(--text-main); display: flex; align-items: center; gap: 8px; transition: 0.2s; }
    .cat-pill:hover { border-color: var(--primary); background: var(--active-bg); }
    .cat-count { background: var(--primary); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; }

    /* GENERATOR SECTION (Existing Styles Adjusted) */
    .generator-wrapper { max-width: 800px; margin: 0 auto; }
    .generator-tabs { display: flex; gap: 10px; margin-bottom: 25px; border-bottom: 1px solid var(--border); padding-bottom: 20px; }
    .input-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
    .input-row-custom { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 15px; }
    .checkbox-group { background: var(--bg-main); padding: 15px; border-radius: 8px; border: 1px solid var(--border); display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 25px; }
    .checkbox-label { display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem; user-select: none; color: var(--text-main); }
    .result-item { background: var(--bg-main); padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--border); gap: 10px; margin-bottom: 10px; }
    .result-text { font-family: monospace; font-size: 1.1rem; font-weight: 600; color: var(--text-main); word-break: break-all; }
    .result-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .btn-tab-inactive { background: var(--bg-surface) !important; color: var(--text-sub) !important; border-color: var(--border) !important; }

    @media (max-width: 768px) {
        .input-row-custom { grid-template-columns: 1fr; gap: 15px; }
        .result-item { flex-direction: column; align-items: flex-start; }
        .result-actions { width: 100%; justify-content: flex-end; margin-top: 5px; }
        .result-actions button, .result-actions a { flex: 1; justify-content: center; }
        .hero-title { font-size: 1.5rem; }
    }
</style>

<div class="main-container">

    <div class="hero-section">
        <h1 class="hero-title">Azeriqo Store Public Dashboard</h1>
        <p class="hero-subtitle">Monitor game account stock availability in real-time and use our generator tools for free.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-decor" style="background: var(--primary);"></div>
            <div class="stat-value" style="color: var(--primary);">{{ number_format($totalStok) }}</div>
            <div class="stat-label">Accounts Available</div>
        </div>

        <div class="stat-card">
            <div class="stat-decor" style="background: var(--success);"></div>
            <div class="stat-value" style="color: var(--success);">{{ number_format($totalTerjual) }}</div>
            <div class="stat-label">Accounts Sold</div>
        </div>
    </div>

    <div class="generator-wrapper">
        <div class="card" style="border-top: 4px solid var(--text-main);">
            
            <div style="margin-bottom: 20px; text-align: center;">
                <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--text-main);">Generator Tools</h3>
                <p style="color: var(--text-sub); font-size: 0.9rem;">Generate random Usernames & Passwords.</p>
            </div>

            <div class="generator-tabs">
                <button id="tab-user" onclick="setMode('username')" style="flex: 1; padding: 12px; border: 2px solid var(--primary); background: var(--primary); color: white; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Username
                </button>
                <button id="tab-pass" onclick="setMode('password')" class="btn-tab-inactive" style="flex: 1; padding: 12px; border: 2px solid var(--border); border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Password
                </button>
            </div>

            <div class="controls-area">
                
                <div id="username-options">
                    <div class="input-row-custom">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Custom Words</label>
                            <input type="text" id="custom-words" placeholder="Example: Super, Pro, Mega" 
                                   style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Position</label>
                            <select id="word-position" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                                <option value="prefix">Prefix</option>
                                <option value="suffix">Suffix</option>
                                <option value="random">Random</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="input-row">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Character Length</label>
                        <input type="number" id="length" value="4" min="3" max="20" 
                               style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Quantity</label>
                        <input type="number" id="quantity" value="1" min="1" max="50" 
                               style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                    </div>
                </div>

                <div class="checkbox-group">
                    <label class="checkbox-label"><input type="checkbox" id="use-lower" checked style="accent-color: var(--primary);"> Lowercase</label>
                    <label class="checkbox-label"><input type="checkbox" id="use-upper" checked style="accent-color: var(--primary);"> Uppercase</label>
                    <label class="checkbox-label"><input type="checkbox" id="use-number" checked style="accent-color: var(--primary);"> Numbers</label>
                    <label id="opt-symbol" class="checkbox-label" style="display: none;"><input type="checkbox" id="use-symbol" style="accent-color: var(--primary);"> Symbols (!@#)</label>
                </div>

                <button onclick="generate()" style="width: 100%; padding: 14px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    GENERATE NOW
                </button>

            </div>
        </div>

        <div id="result-container" class="card" style="display: none; animation: slideIn 0.3s ease-out forwards;">
            <h3 style="font-size: 1.1rem; color: var(--text-main); margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
                Generator Results
            </h3>
            <div id="result-list"></div>
        </div>
    </div>

</div>

<script>
    // --- GENERATOR SCRIPT ---
    let currentMode = 'username';

    function setMode(mode) {
        currentMode = mode;
        const btnUser = document.getElementById('tab-user');
        const btnPass = document.getElementById('tab-pass');
        const boxUserOpts = document.getElementById('username-options');
        const optSymbol = document.getElementById('opt-symbol');

        btnUser.className = 'btn-tab-inactive';
        btnPass.className = 'btn-tab-inactive';
        btnUser.style.background = ''; btnUser.style.color = ''; btnUser.style.borderColor = '';
        btnPass.style.background = ''; btnPass.style.color = ''; btnPass.style.borderColor = '';

        if (mode === 'username') {
            btnUser.className = '';
            btnUser.style.background = 'var(--primary)';
            btnUser.style.color = 'white';
            btnUser.style.borderColor = 'var(--primary)';
            boxUserOpts.style.display = 'block';
            optSymbol.style.display = 'none';
        } else {
            btnPass.className = '';
            btnPass.style.background = 'var(--primary)';
            btnPass.style.color = 'white';
            btnPass.style.borderColor = 'var(--primary)';
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
        const useLower = document.getElementById('use-lower').checked;
        const useUpper = document.getElementById('use-upper').checked;
        const useNumber = document.getElementById('use-number').checked;
        const useSymbol = document.getElementById('use-symbol').checked;
        const customWordsVal = document.getElementById('custom-words').value;
        const customWords = customWordsVal.split(/[\s,]+/).filter(Boolean);
        const position = document.getElementById('word-position').value;

        let chars = "";
        if (useLower) chars += "abcdefghijklmnopqrstuvwxyz";
        if (useUpper) chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if (useNumber) chars += "0123456789";
        if (currentMode === 'password' && useSymbol) chars += "!@#$%^&*()_+";

        // Translation: "Select at least 1 character type!"
        if (chars === "") { window.showToast("Select at least 1 character type!"); return; }

        for(let i=0; i<qty; i++) {
            let result = "";
            let randomStr = "";
            for(let j=0; j<length; j++) randomStr += chars.charAt(Math.floor(Math.random() * chars.length));

            if (currentMode === 'username' && customWords.length > 0) {
                const word = customWords[Math.floor(Math.random() * customWords.length)];
                if (position === 'prefix') result = word + randomStr;
                else if (position === 'suffix') result = randomStr + word;
                else result = Math.random() < 0.5 ? (word + randomStr) : (randomStr + word);
            } else {
                result = randomStr;
            }

            const div = document.createElement('div');
            div.className = 'result-item';
            div.innerHTML = `
                <span class="result-text">${result}</span>
                <div class="result-actions">
                    <button onclick="window.copyText('${result}')" style="background: var(--bg-surface); border: 1px solid var(--border); color: var(--primary); padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 600; display:flex; align-items:center; gap:5px;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Copy
                    </button>
                    @auth
                    <a href="{{ route('account.create') }}?${currentMode}=${result}" style="background: var(--success); color: white; text-decoration: none; padding: 8px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; display:flex; align-items:center; gap:5px;">
                         <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                         Use
                    </a>
                    @endauth
                </div>
            `;
            listDiv.appendChild(div);
        }
    }
</script>
@endsection