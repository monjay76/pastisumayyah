<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem SMART Pasti Sumayyah')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Vite Assets -->
    <style>
        /* Minimal inline fallback so layout looks like wireframe even without building assets */
        body { margin:0; font-family: Arial, Helvetica, sans-serif; }
        .dashboard { display:flex; min-height:100vh; }
        .sidebar { width:220px; background:#d9d9d9; padding:20px 12px; box-sizing:border-box; }
        .sidebar .logo { width:56px; height:56px; background:#bfbfbf; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; margin-bottom:18px }
        .sidebar nav a { display:block; color:#111; padding:10px 6px; text-decoration:none; margin-bottom:8px }
        .sidebar nav a:hover { background-color: rgba(0, 0, 0, 0.1); }
        .main { flex:1; display:flex; flex-direction:column; }
        .topbar { display:flex; align-items:center; justify-content:space-between; background:#efefef; padding:14px 20px; }
        .content { flex:1; padding:30px 50px; background:#fff; }
        .placeholder { width:80%; height:320px; border:10px solid #e9e9e9; display:flex; align-items:center; justify-content:center; margin:30px auto; background:#f7f7f7 }
        .footer { background:#d9d9d9; padding:12px 20px; text-align:center }
        .logout-btn { background:#000; color:#fff; padding:8px 14px; text-decoration:none; border-radius:6px; }
        @media (max-width:768px){ .sidebar{display:none} .placeholder{width:100%} }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('logo_pasti_sumayyah.jpg') }}" alt="Logo Pasti Sumayyah" style="width:100%; height:100%; border-radius:50%; object-fit:cover;">
            </div>
            <nav>
                <a href="{{ route('pentadbir.createUser') }}">Pendaftaran Akaun</a>
                <a href="{{ route('pentadbir.senaraiMurid') }}">Senarai Murid</a>
                <a href="{{ route('pentadbir.profilMurid') }}">Profil Murid</a>
                <a href="#">Maklumat Ibu Bapa</a>
                <a href="#">Maklumat Guru</a>
                <a href="#">Aktiviti Tahunan</a>
                <a href="#">Laporan</a>
            </nav>
        </aside>

        <div class="main">
            <header class="topbar">
                <div style="display:flex; align-items:center; gap:18px">
                    <h5 style="margin:0">Sistem SMART Pasti Sumayyah</h5>
                </div>
                <div>
                    <a href="#" class="logout-btn">Log Keluar</a>
                </div>
            </header>

            <main class="content">
                @yield('content')
            </main>

            <footer class="footer">Footer</footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
