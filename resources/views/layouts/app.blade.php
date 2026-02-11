<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem SMART Pasti Sumayyah')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* KOD WARNA HIJAU PASTI RASMI */
            --pasti-dark: #005a2a;      /* Hijau Gelap PASTI */
            --pasti-green: #00843D;     /* Hijau Utama PASTI */
            --pasti-light: #46b46e;     /* Hijau Terang PASTI */
            --bg-body: #f1f8f3;         /* Warna latar lembut kehijauan */
            --sidebar-width: 270px;
        }

        body { 
            margin: 0; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-body);
            color: #1e293b;
        }

        .dashboard { display: flex; min-height: 100vh; }

        /* SIDEBAR STYLING - Hijau PASTI */
        .sidebar { 
            width: var(--sidebar-width); 
            background: linear-gradient(180deg, var(--pasti-dark) 0%, var(--pasti-green) 100%);
            padding: 30px 18px; 
            display: flex; 
            flex-direction: column; 
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 25px;
        }

        .sidebar .logo-area img {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            padding: 3px;
        }

        .sidebar .brand-text {
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            line-height: 1.2;
        }

        .sidebar nav a { 
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.75); 
            padding: 14px 18px; 
            text-decoration: none; 
            margin-bottom: 6px; 
            border-radius: 12px; 
            transition: all 0.3s;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar nav a:hover { 
            background: rgba(255,255,255,0.1); 
            color: white; 
        }

        /* Menu Aktif: Putih dengan teks Hijau PASTI */
        .sidebar nav a.active, .sidebar nav a[href="{{ request()->url() }}"] { 
            background: white; 
            color: var(--pasti-green); 
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .main { 
            flex: 1; 
            margin-left: var(--sidebar-width);
            display: flex; 
            flex-direction: column; 
        }

        /* TOPBAR - Hijau Padu PASTI */
        .topbar { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            background: var(--pasti-green); 
            padding: 20px 40px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .breadcrumb-area { color: white; }

        .breadcrumb-area h5 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .breadcrumb-area .separator {
            opacity: 0.6;
            font-weight: 300;
        }

        .breadcrumb-area .page-title {
            opacity: 0.9;
            font-weight: 500;
        }

        .logout-btn { 
            background: rgba(255, 255, 255, 0.15);
            color: white; 
            padding: 10px 22px; 
            border-radius: 10px; 
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
            font-size: 0.85rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover { 
            background: #d90429; /* Merah untuk Logout */
            border-color: #d90429;
            color: white;
            box-shadow: 0 4px 12px rgba(217, 4, 41, 0.3);
        }

        .content { padding: 40px; flex: 1; }

        /* FOOTER - Tulisan Hijau PASTI */
        .footer { 
            padding: 20px; 
            text-align: center; 
            font-size: 0.8rem; 
            color: var(--pasti-green); 
            font-weight: 600;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        @media (max-width: 992px) {
            .sidebar { width: 0; padding: 0; overflow: hidden; }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo-area">
                <img src="{{ asset('logo_pasti_sumayyah.jpg') }}" alt="Logo">
                <div class="brand-text">SMART PASTI<br><span style="font-size: 0.75rem; opacity: 0.9; font-weight: 400;">SUMAYYAH</span></div>
            </div>
            
            <nav>
                @php $role = session('role'); @endphp
                @if($role === 'guru')
                    <a href="{{ route('guru.senaraiMurid') }}"><i class="bi bi-people"></i> <span>Senarai Murid</span></a>
                    <a href="{{ route('guru.profilMurid') }}"><i class="bi bi-person-badge"></i> <span>Profil Murid</span></a>
                    <a href="{{ route('guru.prestasiMurid') }}"><i class="bi bi-award"></i> <span>Prestasi Murid</span></a>
                    <a href="{{ route('guru.senaraiKehadiran') }}"><i class="bi bi-calendar-check"></i> <span>Kehadiran</span></a>
                    <a href="{{ route('guru.aktivitiTahunan') }}"><i class="bi bi-images"></i> <span>Aktiviti Tahunan</span></a>
                    <a href="{{ route('guru.laporan') }}"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
                @elseif($role === 'pentadbir')
                    <a href="{{ route('pentadbir.index') }}"><i class="bi bi-person-plus"></i> <span>Pendaftaran Akaun</span></a>
                    <a href="{{ route('pentadbir.senaraiMurid') }}"><i class="bi bi-people"></i> <span>Senarai Murid</span></a>
                    <a href="{{ route('pentadbir.profilMurid') }}"><i class="bi bi-person-badge"></i> <span>Profil Murid</span></a>
                    <a href="{{ route('pentadbir.maklumatGuru') }}"><i class="bi bi-person-workspace"></i> <span>Maklumat Guru</span></a>
                    <a href="{{ route('pentadbir.maklumatIbuBapa') }}"><i class="bi bi-house-heart"></i> <span>Maklumat Ibu Bapa</span></a>
                    <a href="{{ route('pentadbir.aktivitiTahunan') }}"><i class="bi bi-calendar-event"></i> <span>Aktiviti Tahunan</span></a>
                    <a href="{{ route('pentadbir.laporan') }}"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
                @elseif($role === 'ibubapa')
                    <a href="{{ route('ibubapa.profilMurid') }}"><i class="bi bi-person-badge"></i> <span>Profil Murid</span></a>
                    <a href="{{ route('ibubapa.aktivitiTahunan') }}"><i class="bi bi-calendar-event"></i> <span>Aktiviti Tahunan</span></a>
                    <a href="{{ route('ibubapa.laporan') }}"><i class="bi bi-file-earmark-text"></i> <span>Laporan</span></a>
                    <a href="{{ route('ibubapa.maklumbalas') }}"><i class="bi bi-chat-left-text"></i> <span>Maklumbalas</span></a>
                @endif
            </nav>
        </aside>

        <div class="main">
            <header class="topbar">
                <div class="breadcrumb-area">
                    <h5>
                        <span>SMART PASTI SUMAYYAH</span>
                        <span class="separator">/</span>
                        <span class="page-title">@yield('title')</span>
                    </h5>
                </div>
                
                <div class="d-flex align-items-center gap-4">
                    @if(session('user'))
                        <div class="text-end d-none d-md-block text-white">
                            <div class="fw-bold small" style="letter-spacing: 0.3px;">
                                @if($role === 'guru') {{ session('user')->namaGuru }}
                                @elseif($role === 'pentadbir') {{ session('user')->namaAdmin }}
                                @endif
                            </div>
                            <div style="font-size: 0.65rem; opacity: 0.8; font-weight: 700; text-transform: uppercase;">{{ $role }}</div>
                        </div>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="logout-btn border-1">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>LOG KELUAR</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="content">
                @yield('content')
            </main>

            <footer class="footer">
                &copy; {{ date('Y') }} Sistem SMART PASTI Sumayyah 
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>