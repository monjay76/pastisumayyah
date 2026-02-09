@extends('layouts.app')

@section('title', 'Profil Murid')

@section('content')
<div class="d-flex" id="wrapper">
    <div class="bg-dark text-white" id="sidebar-wrapper" style="min-width: 250px; background-color: #1a4d2e !important;">
        <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
            <img src="{{ asset('path_to_logo/logo.png') }}" alt="Logo" width="40" class="me-2"> SMART PASTI
            <div class="fs-6 fw-light text-capitalize">SUMAYYAH</div>
        </div>
        <div class="list-group list-group-flush my-3">
            <a href="{{ route('guru.senaraiMurid') }}" class="list-group-item list-group-item-action bg-transparent text-white">
                <i class="bi bi-people me-2"></i>Senarai Murid
            </a>
            <a href="{{ route('guru.profilMurid') }}" class="list-group-item list-group-item-action bg-transparent text-white active" style="background-color: rgba(255,255,255,0.2) !important;">
                <i class="bi bi-person-badge me-2"></i>Profil Murid
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-transparent text-white">
                <i class="bi bi-calendar-check me-2"></i>Kehadiran
            </a>
            <a href="{{ route('guru.prestasiMurid') }}" class="list-group-item list-group-item-action bg-transparent text-white">
                <i class="bi bi-graph-up-arrow me-2"></i>Laporan
            </a>
        </div>
    </div>

    <div id="page-content-wrapper" class="w-100 bg-light">
        <nav class="navbar navbar-expand-lg navbar-dark py-3 px-4" style="background-color: #2d7a3e;">
            <div class="d-flex align-items-center">
                <h5 class="m-0 text-white fw-bold">SMART PASTI SUMAYYAH <span class="fw-light mx-2">/</span> <span class="fw-normal">Profil Murid</span></h5>
            </div>
        </nav>

        <div class="container-fluid px-4 mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h4 class="fw-bold text-dark mb-0">
                                <i class="bi bi-person-bounding-box text-success me-2"></i>Maklumat Profil Murid
                            </h4>
                        </div>

                        <div class="card-body p-4">
                            @if(!isset($selectedClass) || !$selectedClass)
                                <div class="text-center mb-4">
                                    <p class="text-muted">Sila pilih kelas untuk melihat senarai murid.</p>
                                </div>
                                <div class="row g-3">
                                    @foreach($classes as $class)
                                        <div class="col-md-3">
                                            <a href="{{ route('guru.profilMurid', ['kelas' => $class]) }}" class="btn btn-outline-success w-100 py-3 rounded-4 fw-bold shadow-sm border-2">
                                                <i class="bi bi-door-open me-2"></i>{{ $class }}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mb-4">
                                    <a href="{{ route('guru.profilMurid') }}" class="btn btn-light border shadow-sm rounded-pill px-4">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Pilihan Kelas
                                    </a>
                                </div>

                                @if(!isset($selectedStudent) || !$selectedStudent)
                                    <div class="card border-0 bg-white shadow-sm rounded-4">
                                        <div class="card-header bg-success-subtle border-0 py-3">
                                            <h5 class="mb-0 fw-bold text-success"><i class="bi bi-list-ul me-2"></i>Senarai Murid: {{ $selectedClass }}</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="px-4">#</th>
                                                            <th>MyKid ID</th>
                                                            <th>Nama Murid</th>
                                                            <th>Kelas</th>
                                                            <th class="text-center">Tindakan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($students as $index => $student)
                                                            <tr>
                                                                <td class="px-4">{{ $index + 1 }}</td>
                                                                <td class="fw-bold text-primary">{{ $student->MyKidID }}</td>
                                                                <td class="text-uppercase">{{ $student->namaMurid }}</td>
                                                                <td><span class="badge bg-info text-dark">{{ $student->kelas }}</span></td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('guru.profilMurid', ['kelas' => $selectedClass, 'murid' => $student->MyKidID]) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                                        Lihat Profil <i class="bi bi-chevron-right ms-1"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4">
                                                <h6 class="fw-bold text-muted mb-4 text-uppercase">Gambar Profil</h6>
                                                <div class="position-relative d-inline-block mx-auto mb-4">
                                                    @if($selectedStudent->gambar_profil)
                                                        <img src="{{ asset('storage/' . $selectedStudent->gambar_profil) }}" alt="Gambar Profil" class="img-thumbnail rounded-circle shadow" style="width: 180px; height: 180px; object-fit: cover; border: 5px solid #f8f9fa;">
                                                    @else
                                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 180px; height: 180px; border: 5px solid #fff;">
                                                            <i class="bi bi-person-fill text-secondary" style="font-size: 5rem;"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <form action="{{ route('guru.updateProfilePicture', $selectedStudent->MyKidID) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <input type="file" name="gambar_profil" class="form-control form-control-sm border-0 bg-light rounded-3" accept="image/*" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-sm w-100 rounded-pill shadow-sm">
                                                        <i class="bi bi-camera me-2"></i>Kemas Kini Gambar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8">
                                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                                <div class="card-header bg-white border-bottom py-3 px-4">
                                                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-person me-2 text-primary"></i>Maklumat Peribadi</h5>
                                                </div>
                                                <div class="card-body px-4 py-4">
                                                    <div class="row mb-3 border-bottom pb-2">
                                                        <div class="col-sm-4 fw-bold text-muted">MyKid ID</div>
                                                        <div class="col-sm-8 fw-bold text-primary">{{ $selectedStudent->MyKidID }}</div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-2">
                                                        <div class="col-sm-4 fw-bold text-muted">Nama Penuh</div>
                                                        <div class="col-sm-8 text-uppercase fw-bold">{{ $selectedStudent->namaMurid }}</div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-2">
                                                        <div class="col-sm-4 fw-bold text-muted">Kelas</div>
                                                        <div class="col-sm-8"><span class="badge bg-success px-3">{{ $selectedStudent->kelas }}</span></div>
                                                    </div>
                                                    <div class="row mb-3 border-bottom pb-2">
                                                        <div class="col-sm-4 fw-bold text-muted">Tarikh Lahir</div>
                                                        <div class="col-sm-8">{{ $selectedStudent->tarikhLahir ? date('d/m/Y', strtotime($selectedStudent->tarikhLahir)) : '-' }}</div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-sm-4 fw-bold text-muted">Alamat Kediaman</div>
                                                        <div class="col-sm-8 text-secondary">{{ $selectedStudent->alamat ?? 'Tiada maklumat alamat' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Sidebar & Global */
    #sidebar-wrapper .list-group-item { padding: 1.2rem 1.5rem; border: none; transition: 0.3s; }
    #sidebar-wrapper .list-group-item:hover { background-color: rgba(255,255,255,0.1) !important; padding-left: 2rem; }
    .card { transition: transform 0.2s; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; }
    .btn-outline-success:hover { background-color: #2d7a3e; color: white; }
    .bg-success-subtle { background-color: #e8f5e9 !important; }
</style>
@endsection