@extends('layout')

@section('content')
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2>🛠️ Generator Akun</h2>

        <label>Kata Tambahan (Opsional, untuk Username)</label>
        <input type="text" id="custom-words" placeholder="Contoh: Super, Pro, Mega">

        <div style="display:flex; gap:10px;">
            <div style="flex:1;">
                <label>Panjang</label>
                <input type="number" id="length" value="8">
            </div>
            <div style="flex:1;">
                <label>Jumlah Generate</label>
                <input type="number" id="quantity" value="1">
            </div>
        </div>

        <button onclick="generate()" class="btn" style="margin-bottom:20px;">GENERATE SEKARANG</button>

        <div id="result-area"></div>
    </div>

    <script>
        function generate() {
            const resultArea = document.getElementById('result-area');
            resultArea.innerHTML = "";
            
            const length = parseInt(document.getElementById('length').value);
            const qty = parseInt(document.getElementById('quantity').value);
            const words = document.getElementById('custom-words').value.split(/[\s,]+/).filter(Boolean);
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

            for(let i=0; i<qty; i++) {
                let text = "";
                // Logika: Jika ada kata tambahan, pakai itu + random string. Jika tidak, full random.
                if(words.length > 0) {
                    text = words[Math.floor(Math.random() * words.length)];
                    for(let j=0; j<length; j++) text += chars.charAt(Math.floor(Math.random() * chars.length));
                } else {
                    for(let j=0; j<length; j++) text += chars.charAt(Math.floor(Math.random() * chars.length));
                }

                // Tampilan Hasil per Baris
                const div = document.createElement('div');
                div.style.cssText = "background:#f8fafc; padding:10px; border:1px solid #e2e8f0; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;";
                
                // Tombol "PAKAI" akan mengarahkan ke halaman Input dengan membawa data
                div.innerHTML = `
                    <span style="font-family:monospace; font-weight:bold; font-size:1.1rem;">${text}</span>
                    <a href="/input?username=${text}&password=${text}" 
                       style="background:#f59e0b; color:white; text-decoration:none; padding:5px 10px; border-radius:3px; font-size:0.8rem; font-weight:bold;">
                       PAKAI KE INPUT ➜
                    </a>
                `;
                resultArea.appendChild(div);
            }
        }
    </script>
@endsection