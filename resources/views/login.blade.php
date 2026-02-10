<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistem SMART Pasti Sumayyah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #4CAF50;
            --accent-color: #8BC34A;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1b5e20 0%, #43a047 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-section {
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 3rem;
            text-align: center;
            color: white;
        }

        .welcome-text {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 400px;
            line-height: 1.6;
        }

        .login-section {
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: #ffffff;
            border-radius: 25px;
            padding: 3rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .logo-box {
            width: 90px;
            height: 90px;
            background: #f0fdf4;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            padding: 10px;
            transition: transform 0.3s ease;
        }

        .logo-box:hover {
            transform: scale(1.05);
        }

        .logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
            margin-left: 5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s;
        }

        .form-control {
            border-radius: 15px;
            border: 1.5px solid #e5e7eb;
            padding: 0.75rem 1rem 0.75rem 45px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .form-control:focus + i {
            color: var(--secondary-color);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 15px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(46, 125, 50, 0.3);
            filter: brightness(1.1);
        }

        .alert-danger {
            border-radius: 15px;
            font-size: 0.85rem;
            border: none;
            background-color: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        @media (max-width: 768px) {
            .login-wrapper { border-radius: 20px; }
            .welcome-section { padding: 3rem 2rem; }
            .welcome-text { font-size: 1.8rem; }
            .login-section { padding: 2rem 1.5rem; }
            .login-container { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-6 welcome-section">
                    <div class="mb-4">
                        <i class="bi bi-shield-check" style="font-size: 4rem; opacity: 0.5;"></i>
                    </div>
                    <div class="welcome-text">Selamat Datang ke Sistem SMART</div>
                    <div class="welcome-subtitle">
                        Memperkasakan hubungan antara guru dan ibu bapa demi kecemerlangan anak-anak di Pasti Sumayyah.
                    </div>
                </div>

                <div class="col-lg-6 login-section">
                    <div class="login-container">
                        <div class="text-center mb-4">
                            <div class="logo-box shadow-sm">
                                <img src="{{ asset('logo_pasti_sumayyah.jpg') }}" alt="Logo Pasti Sumayyah">
                            </div>
                            <h4 class="fw-bold mb-1" style="color: var(--primary-color);">Log Masuk Portal</h4>
                            <p class="text-muted small">Sila masukkan kredensial anda</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger shadow-sm mb-4" role="alert">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                                    <strong>Akses Dinafikan</strong>
                                </div>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">ID Pengguna</label>
                                <div class="input-group-custom">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="cth: GURU001" required autofocus>
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Laluan</label>
                                <div class="input-group-custom">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata laluan" required>
                                    <i class="bi bi-lock"></i>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                                </div>
                                <a href="#" class="small text-success text-decoration-none fw-600">Lupa Kata Laluan?</a>
                            </div>

                            <button type="submit" class="btn btn-login mb-3">
                                Seterusnya <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <p class="small text-muted mb-0">&copy; 2026 Pasti Sumayyah. <br> Hak Cipta Terpelihara.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>