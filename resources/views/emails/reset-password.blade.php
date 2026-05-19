<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #0f172a;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 20px;
        }
        .email-card {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .email-body {
            padding: 40px 32px;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            color: #334155;
            margin-top: 0;
            margin-bottom: 24px;
        }
        .btn-container {
            text-align: center;
            margin: 36px 0;
        }
        .btn-action {
            display: inline-block;
            padding: 16px 32px;
            background-color: #059669;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 8px 20px -6px rgba(5, 150, 105, 0.4);
        }
        .email-footer {
            background-color: #f1f5f9;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer p {
            font-size: 13px;
            line-height: 1.5;
            color: #64748b;
            margin: 0;
        }
        .sub-text {
            font-size: 14px;
            color: #64748b;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-card">
            <div class="email-header">
                <h1>Arsip Surat PTPN</h1>
            </div>
            <div class="email-body">
                <p>Halo <strong>{{ $userEmail }}</strong>,</p>
                <p>Kami menerima permintaan untuk mengatur ulang kata sandi pada akun Arsip Surat Anda. Silakan klik tombol di bawah ini untuk membuat kata sandi baru:</p>
                
                <div class="btn-container">
                    <a href="{{ $resetUrl }}" class="btn-action">Atur Ulang Kata Sandi</a>
                </div>

                <p>Jika Anda tidak merasa meminta pengaturan ulang kata sandi, Anda tidak perlu melakukan tindakan apa pun. Tautan ini akan otomatis kedaluwarsa dalam waktu 5 menit demi keamanan akun Anda.</p>

                <div class="sub-text">
                    <p style="margin-bottom: 8px;">Jika Anda mengalami kesulitan mengklik tombol "Atur Ulang Kata Sandi", salin dan tempel URL di bawah ini ke browser web Anda:</p>
                    <p style="word-break: break-all; color: #059669; font-size: 13px;">{{ $resetUrl }}</p>
                </div>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} Arsip Surat - Digital Document Management System. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>
</body>
</html>
