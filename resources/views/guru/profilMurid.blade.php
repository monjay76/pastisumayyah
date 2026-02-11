@extends('layouts.app')

@section('title', 'Profil Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header" style="background: #00843D; color: white; font-weight: 600;">
                    <i class="bi bi-person-bounding-box me-2"></i> Maklumat Profil Murid
                </div>
                <div class="card-body p-4">
                    @if(!isset($selectedClass) || !$selectedClass)
                        <div class="text-center mb-4">
                            <p class="text-muted">Sila pilih kelas untuk melihat senarai murid.</p>
                        </div>
                        <div class="row g-3">
                            @foreach($classes as $class)
                                <div class="col-sm-6 col-md-3">
                                    <a href="{{ route('guru.profilMurid', ['kelas' => $class]) }}" class="btn border-0 w-100 py-3 rounded-4 fw-bold shadow-sm" style="background: linear-gradient(135deg, #f1f8f3 0%, #ffffff 100%); color: #005a2a;">
                                        <i class="bi bi-door-open me-2"></i> {{ $class }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('guru.profilMurid') }}" class="btn btn-light border shadow-sm rounded-pill px-4">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Pilihan Kelas
                                </a>
                            </div>
                            <div class="text-end">
                                <span class="badge" style="background-color: rgba(70,180,110,0.12); color: #005a2a; font-weight:600; padding: 0.6rem 1rem; border-radius: 999px;">Kelas: {{ $selectedClass }}</span>
                            </div>
                        </div>

                        @if(!isset($selectedStudent) || !$selectedStudent)
                            <div class="card border-0 bg-white shadow-sm rounded-4">
                                <div class="card-header" style="background-color: #f1f8f3; color: #005a2a; font-weight:600;">
                                    <i class="bi bi-list-ul me-2"></i> Senarai Murid: {{ $selectedClass }}
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="px-4 text-center" style="width:6%">#</th>
                                                    <th style="width:20%">MyKid ID</th>
                                                    <th style="width:44%">Nama Murid</th>
                                                    <th style="width:15%">Kelas</th>
                                                    <th class="text-center" style="width:15%">Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($students as $index => $student)
                                                    <tr>
                                                        <td class="px-4 text-center fw-semibold">{{ $index + 1 }}</td>
                                                        <td><code style="background-color:#f1f8f3; color:#005a2a; padding:0.25rem 0.5rem; border-radius:0.25rem">{{ $student->MyKidID }}</code></td>
                                                        <td class="text-uppercase fw-bold">{{ $student->namaMurid }}</td>
                                                        <td><span class="badge" style="background-color:#e7f8ef; color:#005a2a; font-weight:600; padding:0.35rem 0.6rem">{{ $student->kelas }}</span></td>
                                                        <td class="text-center">
                                                            <a href="{{ route('guru.profilMurid', ['kelas' => $selectedClass, 'murid' => $student->MyKidID]) }}" class="btn btn-sm" style="background: #00843D; color:white; border-radius:999px; padding:0.4rem 0.9rem;">
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
                                                <img src="{{ asset('storage/' . $selectedStudent->gambar_profil) }}" alt="Gambar Profil" class="img-thumbnail rounded-circle shadow" style="width: 180px; height: 180px; object-fit: cover; border: 6px solid #fff;">
                                            @else
                                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 180px; height: 180px; border: 6px solid #fff;">
                                                    <i class="bi bi-person-fill text-secondary" style="font-size: 4.5rem;"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <form action="{{ route('guru.updateProfilePicture', $selectedStudent->MyKidID) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="file" name="gambar_profil" class="form-control form-control-sm border-0 bg-light rounded-3" accept="image/*" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm w-100 rounded-pill shadow-sm">
                                                <i class="bi bi-camera me-2"></i> Kemas Kini Gambar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card border-0 shadow-sm rounded-4 h-100">
                                        <div class="card-header" style="background-color: #ffffff; border-bottom:1px solid #eef6ef;">
                                            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-person me-2 text-success"></i> Maklumat Peribadi</h5>
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
                                                <div class="col-sm-8"><span class="badge" style="background-color:#e7f8ef; color:#005a2a; padding:0.4rem 0.8rem; font-weight:600">{{ $selectedStudent->kelas }}</span></div>
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

<style>
    .btn { transition: all 0.2s; }
    .btn:hover { transform: translateY(-2px); }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.4px; }
    .card { transition: box-shadow 0.25s ease; }
    .card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
</style>

@endsection