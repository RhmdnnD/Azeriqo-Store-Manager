function initParticles(isDark) {
    const colorShape = isDark ? "#ffffff" : "#3b82f6";
    const colorLine = isDark ? "#ffffff" : "#94a3b8";
    
    particlesJS("particles-js", {
        "particles": {
            "number": { "value": 70, "density": { "enable": true, "value_area": 800 } },
            "color": { "value": colorShape },
            "shape": { "type": "circle" },
            "opacity": { "value": 0.5, "random": false },
            "size": { "value": 3, "random": true },
            "line_linked": { "enable": true, "distance": 150, "color": colorLine, "opacity": 0.4, "width": 1 },
            "move": { "enable": true, "speed": 3, "direction": "none", "random": false, "straight": false, "out_mode": "out", "bounce": false }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": true, "mode": "push" }, "resize": true },
            "modes": { "grab": { "distance": 140, "line_linked": { "opacity": 1 } } }
        },
        "retina_detect": true
    });
}

function toggleTheme() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    const isDark = body.classList.contains('dark-mode');
    
    if (isDark) { localStorage.setItem('theme', 'dark'); } 
    else { localStorage.setItem('theme', 'light'); }
    
    initParticles(isDark);
}

window.onload = function() {
    const savedTheme = localStorage.getItem('theme');
    let isDark = false;
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        isDark = true;
    }
    initParticles(isDark);
    generateBulk();
}

function generateBulk() {
    // --- KONFIGURASI BATASAN (LIMIT) ---
    const MAX_QUANTITY = 500; // Batas jumlah baris
    const MAX_LENGTH = 20;    // Batas panjang karakter per baris
    
    const lengthInput = document.getElementById('length');
    const quantityInput = document.getElementById('quantity');
    
    let length = parseInt(lengthInput.value);
    let quantity = parseInt(quantityInput.value);

    // --- VALIDASI JUMLAH (QUANTITY) ---
    if (quantity > MAX_QUANTITY) {
        quantity = MAX_QUANTITY;
        quantityInput.value = MAX_QUANTITY;
        showToast(`Maksimal jumlah baris dibatasi ${MAX_QUANTITY}!`);
    }
    if (quantity < 1 || isNaN(quantity)) {
        quantity = 1;
        quantityInput.value = 1;
    }

    // --- VALIDASI PANJANG (LENGTH) ---
    if (length > MAX_LENGTH) {
        length = MAX_LENGTH;
        lengthInput.value = MAX_LENGTH;
        showToast(`Panjang karakter dibatasi maksimal ${MAX_LENGTH}!`);
    }
    if (length < 1 || isNaN(length)) {
        length = 4;
        lengthInput.value = 4;
    }

    const useLower = document.getElementById('use-lower').checked;
    const useUpper = document.getElementById('use-upper').checked;
    const useNumber = document.getElementById('use-number').checked;

    const lowerChars = "abcdefghijklmnopqrstuvwxyz";
    const upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const numChars = "0123456789";

    let allowedChars = "";
    if (useLower) allowedChars += lowerChars;
    if (useUpper) allowedChars += upperChars;
    if (useNumber) allowedChars += numChars;

    const rawCustomWords = document.getElementById('custom-words').value;
    const position = document.getElementById('word-position').value;
    const customList = rawCustomWords.split(/[\s,]+/).filter(Boolean);

    const listOutput = document.getElementById('list-output');
    listOutput.innerHTML = ""; 

    if (allowedChars === "") {
        listOutput.innerHTML = "<div style='color:#ff5555; text-align:center; padding:20px;'>⚠️ Pilih minimal satu karakter!</div>";
        return;
    }

    for (let i = 0; i < quantity; i++) {
        let randomPart = "";
        for (let j = 0; j < length; j++) {
            const randomIndex = Math.floor(Math.random() * allowedChars.length);
            randomPart += allowedChars[randomIndex];
        }

        let selectedCustomWord = "";
        if (customList.length > 0 && position !== 'none') {
            const randWordIndex = Math.floor(Math.random() * customList.length);
            selectedCustomWord = customList[randWordIndex];
        }

        let finalResult = "";
        let displayHTML = "";

        if (position === 'prefix' && selectedCustomWord) {
            finalResult = selectedCustomWord + randomPart;
            displayHTML = `<span class="highlight">${selectedCustomWord}</span>${randomPart}`;
        } else if (position === 'suffix' && selectedCustomWord) {
            finalResult = randomPart + selectedCustomWord;
            displayHTML = `${randomPart}<span class="highlight">${selectedCustomWord}</span>`;
        } else {
            finalResult = randomPart;
            displayHTML = randomPart;
        }

        const div = document.createElement('div');
        div.className = 'result-item';
        // Animasi fade-in bertahap
        div.style.animation = `fadein 0.3s ease forwards ${i * 0.005}s`; 
        div.innerHTML = `<span>${displayHTML}</span> <span class="copy-icon">COPY</span>`;
        div.onclick = function() { copyToClipboard(finalResult); };
        listOutput.appendChild(div);
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast("Disalin: " + text);
    });
}

function showToast(message) {
    const toast = document.getElementById("toast");
    toast.innerText = message;
    toast.className = "toast show";
    setTimeout(() => { toast.className = toast.className.replace("toast show", "toast"); }, 2000);
}