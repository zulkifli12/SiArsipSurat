<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi | {{ config('app.name', 'Arsip Surat') }}</title>

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
                <h1>Atur Ulang Sandi</h1>
                <p class="subtitle" style="margin-top: 8px;">Silakan masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="error-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="countdown-alert" id="countdown-container" style="background: #fff8f1; border: 1px solid #ffedd5; border-left: 4px solid #f97316; padding: 12px 16px; border-radius: 12px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; transition: all 0.3s ease;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span style="font-size: 13px; font-weight: 600; color: #9a3412;">Waktu Kedaluwarsa Tautan:</span>
                </div>
                <span id="timer-display" style="font-family: monospace; font-size: 16px; font-weight: 800; color: #ea580c; background: #ffedd5; padding: 4px 10px; border-radius: 8px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">--:--</span>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email">ALAMAT EMAIL</label>
                    <input type="email" id="email" name="email" class="input-control" value="{{ $email ?? old('email') }}" readonly required style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label for="password">KATA SANDI BARU</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="input-control" placeholder="Minimal 8 karakter" required autofocus>
                        <button type="button" class="password-toggle" onclick="togglePassword(this)" title="Tampilkan sandi">
                            <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="password_confirmation">KONFIRMASI KATA SANDI</label>
                    <div class="password-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="input-control" placeholder="Ulangi kata sandi baru" required>
                        <button type="button" class="password-toggle" onclick="togglePassword(this)" title="Tampilkan sandi">
                            <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="btn-submit-reset" class="btn-login">Simpan Kata Sandi Baru</button>
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

        // Live Countdown Timer Script
        const expiresAt = new Date("{{ $expiresAt }}").getTime();
        const timerDisplay = document.getElementById('timer-display');
        const countdownContainer = document.getElementById('countdown-container');
        const submitBtn = document.getElementById('btn-submit-reset');

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = expiresAt - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                timerDisplay.innerHTML = "KEDALUWARSA";
                timerDisplay.style.color = "#dc2626";
                timerDisplay.style.background = "#fee2e2";
                countdownContainer.style.background = "#fef2f2";
                countdownContainer.style.borderLeftColor = "#ef4444";
                countdownContainer.style.borderColor = "#fee2e2";
                
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.style.background = "#94a3b8";
                    submitBtn.style.cursor = "not-allowed";
                    submitBtn.style.boxShadow = "none";
                    submitBtn.innerHTML = "Tautan Telah Kedaluwarsa";
                }
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const paddedMinutes = String(minutes).padStart(2, '0');
            const paddedSeconds = String(seconds).padStart(2, '0');

            timerDisplay.innerHTML = `${paddedMinutes}:${paddedSeconds}`;
        }, 1000);
    </script>
</body>
</html>
