<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Azeriqo Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .auth-card { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 10px 15px -3px rgba(0, 0, 0, 0.1); width: 100%; max-width: 400px; border: 1px solid #e2e8f0; }
        .brand { text-align: center; margin-bottom: 30px; font-size: 1.5rem; font-weight: 800; color: #1e293b; display: flex; justify-content: center; align-items: center; gap: 10px; }
        .brand span { color: #4f46e5; }
        label { display: block; font-size: 0.9rem; font-weight: 600; color: #475569; margin-bottom: 8px; }
        input { width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; margin-bottom: 20px; font-size: 0.95rem; box-sizing: border-box; transition: 0.2s; }
        input:focus { outline: none; border-color: #4f46e5; ring: 2px solid #e0e7ff; }
        .btn-primary { width: 100%; background: #4f46e5; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.2s; font-size: 1rem; }
        .btn-primary:hover { background: #4338ca; }
        .links { text-align: center; margin-top: 20px; font-size: 0.85rem; }
        .links a { color: #4f46e5; text-decoration: none; font-weight: 600; }
        .links a:hover { text-decoration: underline; }
        .error-msg { color: #ef4444; font-size: 0.85rem; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 17L12 22L22 17" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2 12L12 17L22 12" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            DAFTAR<span>BARU</span>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                @error('name') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                @error('email') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter">
                @error('password') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div>
                <label for="password_confirmation">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password">
                @error('password_confirmation') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-primary">BUAT AKUN</button>

            <div class="links">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>
</body>
</html>