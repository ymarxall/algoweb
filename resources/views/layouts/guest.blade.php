<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Algo Coffee - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                font-family: 'Sora', sans-serif;
            }

            :root {
                --primary: #ff6b35;
                --primary-dark: #ff8c61;
                --dark: #0f1419;
            }

            body {
                background: linear-gradient(135deg, var(--dark) 0%, #1a1f28 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .auth-container {
                display: flex;
                gap: 2rem;
                max-width: 1200px;
                width: 100%;
                padding: 2rem;
            }

            .auth-left {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                color: white;
            }

            .auth-left h1 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .auth-left p {
                font-size: 1.125rem;
                color: #ccc;
                line-height: 1.6;
                margin-bottom: 2rem;
            }

            .auth-left .features {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .auth-left .feature-item {
                display: flex;
                gap: 1rem;
                align-items: flex-start;
            }

            .auth-left .feature-item i {
                color: var(--primary);
                font-size: 1.5rem;
                flex-shrink: 0;
            }

            .auth-left .feature-item div h4 {
                margin: 0 0 0.25rem 0;
                color: white;
                font-weight: 600;
            }

            .auth-left .feature-item div p {
                margin: 0;
                font-size: 0.875rem;
                color: #aaa;
            }

            .auth-right {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .login-card {
                background: white;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                width: 100%;
            }

            .login-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .login-header .logo {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 1rem;
                font-size: 2rem;
                color: white;
            }

            .login-header h2 {
                margin: 0 0 0.5rem 0;
                color: var(--dark);
                font-size: 1.75rem;
                font-weight: 700;
            }

            .login-header p {
                margin: 0;
                color: #999;
                font-size: 0.875rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                color: var(--dark);
                font-weight: 600;
                font-size: 0.875rem;
            }

            .form-group input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 2px solid #eee;
                border-radius: 6px;
                font-size: 0.875rem;
                transition: all 0.2s;
                box-sizing: border-box;
            }

            .form-group input:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            }

            .form-group input::placeholder {
                color: #ccc;
            }

            .checkbox-group {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1.5rem;
                font-size: 0.875rem;
            }

            .checkbox-group label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin: 0;
                cursor: pointer;
                color: #666;
                font-weight: 500;
            }

            .checkbox-group input[type="checkbox"] {
                width: auto;
                cursor: pointer;
                accent-color: var(--primary);
            }

            .checkbox-group a {
                color: var(--primary);
                text-decoration: none;
                font-weight: 600;
                transition: color 0.2s;
            }

            .checkbox-group a:hover {
                color: var(--primary-dark);
            }

            .btn-submit {
                width: 100%;
                padding: 0.875rem;
                background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
                color: white;
                border: none;
                border-radius: 6px;
                font-size: 0.875rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
            }

            .btn-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            }

            .btn-submit:active {
                transform: translateY(0);
            }

            .alert {
                padding: 0.875rem 1rem;
                border-radius: 6px;
                margin-bottom: 1.5rem;
                font-size: 0.875rem;
            }

            .alert-danger {
                background: #fee;
                color: #c00;
                border: 1px solid #fcc;
            }

            .alert ul {
                margin: 0;
                padding-left: 1.25rem;
            }

            .alert li {
                margin-bottom: 0.25rem;
            }

            @media (max-width: 768px) {
                .auth-container {
                    flex-direction: column;
                    gap: 1rem;
                }

                .auth-left {
                    display: none;
                }

                .auth-left h1 {
                    font-size: 2rem;
                }

                .login-card {
                    padding: 1.5rem;
                }

                .login-header h2 {
                    font-size: 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="auth-left">
                <h1>Algo Coffee</h1>
                <p>Sistem manajemen pesanan kopi yang cepat dan mudah digunakan untuk meningkatkan efisiensi layanan Anda.</p>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Pesanan Cepat</h4>
                            <p>Terima dan proses pesanan dalam hitungan detik</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-chart-line"></i>
                        <div>
                            <h4>Laporan Lengkap</h4>
                            <p>Monitor pendapatan dan statistik bisnis real-time</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <h4>Multi User</h4>
                            <p>Kelola akses kasir, admin, dan manajer dengan mudah</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-right">
                <div class="login-card">
                    <div class="login-header">
                        <div class="logo">☕</div>
                        <h2>Selamat Datang</h2>
                        <p>Masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
