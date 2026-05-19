<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{ \App\Models\Setting::get('app_name', config('app.name', 'Arsip Surat')) }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logos/ptpn_holding.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('asset/login.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="logo-header">
            <div class="logo-lockup-badge" title="{{ \App\Models\Setting::get('app_name', 'Arsip Surat') }}">
                <div class="logo-item logo-danantara">
                    <img src="{{ asset('images/logos/danantara.png') }}" alt="Danantara" class="logo-img" title="Danantara">
                </div>
                <div class="logo-separator"></div>
                <div class="logo-item logo-ptpn">
                    <img src="{{ asset('images/logos/ptpn_holding.png') }}" alt="PTPN Nusantara" class="logo-img" title="PTPN Nusantara">
                </div>
                <div class="logo-separator"></div>
                <div class="logo-item logo-ptpn4">
                    <img src="{{ asset('images/logos/ptpn4.png') }}" alt="PTPN IV" class="logo-img" title="PTPN IV">
                </div>
            </div>
        </div>

        <div class="login-content">
            <div class="header-text">
                <h1>{{ \App\Models\Setting::get('app_name', 'Arsip Surat') }}</h1>
                <p class="subtitle">{{ \App\Models\Setting::get('app_description', 'Digital Document Management System') }}</p>
            </div>

            @if (session('success'))
                <div class="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">ALAMAT EMAIL</label>
                    <input type="email" id="email" name="email" class="input-control" placeholder="admin@perusahaan.com" required autofocus value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label for="password" style="margin-bottom: 0;">KATA SANDI</label>
                        <a href="{{ route('password.request') }}" style="font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 700;">Lupa Sandi?</a>
                    </div>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="input-control" placeholder="••••••••" required>
                        <button type="button" class="password-toggle" onclick="togglePassword(this)" title="Tampilkan sandi">
                            <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>

                <div style="display: flex; align-items: center; margin-bottom: 25px; cursor: pointer;">
                    <input type="checkbox" id="remember" name="remember" style="width: 16px; height: 16px; cursor: pointer; accent-color: var(--primary);">
                    <label for="remember" style="margin-bottom: 0; margin-left: 10px; font-weight: 500; font-size: 13px; color: var(--text-gray); cursor: pointer; text-transform: none; letter-spacing: normal;">Ingat saya di perangkat ini</label>
                </div>

                <button type="submit" class="btn-login">Masuk Sekarang</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(button) {
            const wrapper = button.closest('.password-wrapper');
            const input = wrapper.querySelector('.input-control');
            const isPassword = input.type === 'password';
            
            input.type = isPassword ? 'text' : 'password';
            button.title = isPassword ? 'Sembunyikan sandi' : 'Tampilkan sandi';
            
            button.innerHTML = isPassword 
                ? '<svg class="eye-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>'
                : '<svg class="eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
        }
    </script>
</body>
</html>
