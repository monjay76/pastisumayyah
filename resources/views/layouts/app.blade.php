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
        body { margin:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .dashboard { display:flex; min-height:100vh; }
        .sidebar { width:260px; background: linear-gradient(180deg, #2E7D32 0%, #4CAF50 100%); padding:30px 20px; box-sizing:border-box; box-shadow: 2px 0 10px rgba(0,0,0,0.1); position: relative; display:flex; flex-direction:column; align-items:left; }
        .sidebar::after { content: ''; position: absolute; top: 0; right: 0; width: 20px; height: 100%; background: linear-gradient(180deg, #2E7D32 0%, #4CAF50 100%); border-radius: 0 20px 20px 0; z-index: -1; }
        .sidebar .logo { width:70px; height:70px; background: rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; margin-bottom:30px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .sidebar nav a { display:block; color:#fff; padding:15px 20px; text-decoration:none; margin-bottom:10px; border-radius:12px; transition: all 0.3s ease; font-weight:500; }
        .sidebar nav a:hover { background: rgba(255,255,255,0.2); transform: translateX(5px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .sidebar nav a.active { background: rgba(255,255,255,0.3); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .main { flex:1; display:flex; flex-direction:column; }
        .topbar { display:flex; align-items:center; justify-content:space-between; background: rgba(255,255,255,0.9); padding:20px 30px; backdrop-filter: blur(10px); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .content { flex:1; padding:40px 60px; background: #f8f9fa; }
        .placeholder { width:80%; height:320px; border:10px solid #e9e9e9; display:flex; align-items:center; justify-content:center; margin:30px auto; background:#f7f7f7; border-radius:15px; }
        .footer { background: #4CAF50; color: #fff; padding:15px 30px; text-align:center; box-shadow: 0 -2px 10px rgba(0,0,0,0.1);}
        .logout-btn { background: linear-gradient(135deg, #FF5722 0%, #D84315 100%); color:#fff; padding:10px 20px; text-decoration:none; border-radius:25px; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .logout-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.2); }
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
                @if(request()->is('pentadbir*') || request()->is('pentadbir'))
                    <!-- Sidebar for Pentadbir pages (use URL paths to avoid missing route names) -->
                    <a href="{{ url('/pentadbir/daftar-akaun') }}">Pendaftaran Akaun</a>
                    <a href="{{ url('/pentadbir/senarai-murid') }}">Senarai Murid</a>
                    <a href="{{ url('/pentadbir/profil-murid') }}">Profil Murid</a>
                    <a href="{{ url('/pentadbir/maklumat-ibubapa') }}">Maklumat Ibu Bapa</a>
                    <a href="{{ url('/pentadbir/maklumat-guru') }}">Maklumat Guru</a>
                    <a href="{{ url('/pentadbir/aktiviti-tahunan') }}">Aktiviti Tahunan</a>
                    <a href="{{ url('/pentadbir/laporan') }}">Laporan</a>

                @elseif(request()->is('guru*') || request()->is('guru'))
                    <!-- Sidebar for Guru pages (use named routes where available) -->
                    <a href="{{ route('guru.senaraiMurid') }}">Senarai Murid</a>
                    <a href="{{ route('guru.profilMurid') }}">Profil Murid</a>
                    <a href="{{ route('guru.senaraiKehadiran') }}">Senarai Kehadiran</a>
                    <a href="{{ route('guru.aktivitiTahunan') }}">Aktiviti Tahunan</a>
                    <a href="{{ route('guru.prestasiMurid') }}">Prestasi Murid</a>
                    <a href="{{ route('guru.laporan') }}">Laporan</a>

                @else
                    <!-- Default / fallback sidebar (link to root) -->
                    <a href="{{ url('/') }}">Utama</a>
                    <a href="{{ route('guru.senaraiMurid') }}">Senarai Murid (Guru)</a>
                    <a href="{{ url('/pentadbir/daftar-akaun') }}">Pendaftaran (Pentadbir)</a>
                @endif
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
