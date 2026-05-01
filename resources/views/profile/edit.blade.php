@extends('layout')

@section('content')

<div style="max-width: 800px; margin: 0 auto;">

    <div class="header-responsive">
        <div>
            <h1 class="page-title">Profil Saya</h1>
            <p class="page-subtitle">Perbarui informasi akun dan amankan password Anda.</p>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-bottom: 5px; font-size: 1.1rem; color: var(--text-main);">Informasi Akun</h3>
        <p style="color: var(--text-sub); font-size: 0.85rem; margin-bottom: 20px;">Ubah nama tampilan dan alamat email login Anda.</p>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                @if($errors->get('name'))
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                @if($errors->get('email'))
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;">
                    SIMPAN PROFIL
                </button>
                @if (session('status') === 'profile-updated')
                    <span style="font-size: 0.85rem; color: var(--success); font-weight: 600;">✅ Tersimpan.</span>
                @endif
            </div>
        </form>
    </div>

    <div class="card" style="border-top: 4px solid var(--primary);">
        <h3 style="margin-bottom: 5px; font-size: 1.1rem; color: var(--text-main);">Ganti Password</h3>
        <p style="color: var(--text-sub); font-size: 0.85rem; margin-bottom: 20px;">Pastikan menggunakan password yang panjang dan aman.</p>

        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Password Saat Ini</label>
                <input type="password" name="current_password" autocomplete="current-password" placeholder="Masukkan password lama..."
                    style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                @if($errors->updatePassword->get('current_password'))
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $errors->updatePassword->first('current_password') }}</span>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Password Baru</label>
                    <input type="password" name="password" autocomplete="new-password" placeholder="Minimal 8 karakter"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                    @if($errors->updatePassword->get('password'))
                        <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $errors->updatePassword->first('password') }}</span>
                    @endif
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-main);">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="Ulangi password baru"
                        style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg-main); color: var(--text-main);">
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 15px;">
                <button type="submit" style="background: var(--text-main); color: var(--bg-surface); border: 1px solid var(--border); padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;">
                    UPDATE PASSWORD
                </button>
                @if (session('status') === 'password-updated')
                    <span style="font-size: 0.85rem; color: var(--success); font-weight: 600;">✅ Password Berhasil Diubah.</span>
                @endif
            </div>
        </form>
    </div>

</div>
@endsection