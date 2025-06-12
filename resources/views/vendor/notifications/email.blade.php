<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reset Password AgriTech</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            color: #212529;
            margin: 0;
            padding: 20px;
        }

        .email-wrapper {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .email-header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        .email-body {
            padding: 30px;
        }

        .email-body h2 {
            margin-top: 0;
            font-size: 1.25rem;
            color: #333;
        }

        .email-body p {
            font-size: 1rem;
            line-height: 1.5;
            margin: 15px 0;
        }

        .btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .email-footer {
            padding: 20px;
            font-size: 0.9rem;
            text-align: center;
            color: #6c757d;
            background-color: #f1f1f1;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: bold;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <div class="logo" style="text-align: center;">
                <img src="https://agritechbearcyberhunt.my.id/assets/img/icon.png" alt="AgriTech Logo" width="80">
            </div>
        </div>

        <div class="email-body">
            <h2>Reset Password Akun Anda</h2>
            <p>Halo, {{ $user->name ?? 'Pengguna' }},</p>
            <p>Kami menerima permintaan untuk mengatur ulang password akun Anda di <strong>AgriTech</strong>. Silakan
                klik tombol di bawah ini untuk membuat password baru:</p>

            <p style="text-align: center;">
                <a href="{{ $actionUrl }}" class="btn">Reset Password</a>
            </p>

            <p>Tautan ini akan kedaluwarsa dalam 60 menit.</p>

            <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>

            <p>Salam,<br><strong>Tim AgriTech</strong></p>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} AgriTech. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
