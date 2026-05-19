<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Kata Sandi | {{ config('app.name', 'Arsip Surat') }}</title>

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
            <div class="logo-lockup-badge">
                <div class="logo-item logo-danantara">
                    <img src="{{ asset('images/logos/danantara.png') }}" alt="Danantara" class="logo-img" title="Danantara">
                </div>
                <div class="logo-separator"></div>
                <div class="logo-item logo-ptpn">
                    <img src="{{ asset('images/logos/ptpn_holding.png') }}" alt="PTPN Nusantara" class="logo-img" title="PTPN Nusantara">
                </div>
                <div class="logo-separator"></div>
                <div class="logo-item logo-ptpn4">
                    <img src="{{ asset('images/logos/ptpn4.png') }}" alt="PTPN Nusantara" class="logo-img" title="PTPN Nusantara">
                </div>
            </div>
        </div>

        <div class="login-content">
            <div class="header-text" style="margin-bottom: 25px;">
                <h1>Lupa Kata Sandi?</h1>
                <p class="subtitle" style="margin-top: 8px; line-height: 1.5;">Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
            </div>

            @if (session('status'))
                <div class="success-alert">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">ALAMAT EMAIL</label>
                    <input type="email" id="email" name="email" class="input-control" placeholder="admin@perusahaan.com" required autofocus value="{{ old('email') }}">
                </div>

                <button type="submit" class="btn-login" style="margin-top: 10px;">Kirim Tautan Reset</button>
            </form>

            <div class="extra-links">
                Ingat kata sandi? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>
