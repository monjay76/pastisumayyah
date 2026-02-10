@extends('layouts.app')

@section('title', 'Profil Murid')

@section('content')
<style>
    /* Custom Styling untuk Profil Murid */
    .class-card {
        transition: all 0.3s ease;
        border: 2px solid #f0f2f5;
        border-radius: 15px;
        text-align: center;
        background: #ffffff;
    }
    .class-card:hover {
        transform: translateY(-5px);
        border-color: #0d6efd;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .class-icon {
        font-size: 2rem;
        color: #0d6efd;
        margin-bottom: 10px;
    }
    .student-avatar {
        width: 45px;
        height: 45px;
        background-color: #e9ecef;
        color: #495057;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        text-transform: uppercase;
    }
    .detail-container {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        border-left: 5px solid #0d6efd;
    }
    .info-label {
        color: #6c757d;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .info-value {
        color: #212529;
        font-weight: 500;
        font-size: 1.1rem;
        margin-bottom: 15px;
    }
    .table thead th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-size: 0.85rem;
        border-top: none;
    }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0">
                    <span class="text-primary"><i class="bi bi-mortarboard-fill me-2"></i></span> 
                    Profil Murid 
                    @if($selectedClass) 
                        <span class="text-muted fw-light">| {{ $selectedClass }}</span> 
                    @endif
                </h4>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    
                    @if(!$selectedClass)
                        <div class="text-center mb-4">
                            <h5 class="fw-bold">Sila Pilih Kelas</h5>
                            <p class="text-muted">Pilih kelas untuk melihat senarai murid berdaftar.</p>
                        </div>
                        <div class="row g-3">
                            @foreach($classes as $class)
                                <div class="col-6 col-md-4 col-lg-2">
                                    <a href="{{ route('pentadbir.profilMurid', ['kelas' => $class]) }}" class="text-decoration-none">
                                        <div class="class-card p-4">
                                            <div class="class-icon">
                                                <i class="bi bi-door-closed"></i>
                                            </div>
                                            <div class="fw-bold text-dark">{{ $class }}</div>
                                            <small class="text-primary">Lihat Murid <i class="bi bi-chevron-right small"></i></small>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                    @else
                        <div class="mb-4">
                            <a href="{{ route('pentadbir.profilMurid') }}" class="btn btn-light rounded-pill border shadow-sm btn-sm px-3">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Pilihan Kelas
                            </a>
                        </div>

                        @if(!$selectedStudent)
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-list-ul"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Senarai Murid: {{ $selectedClass }}</h5>
                            </div>

                            @if($students->count())
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th width="50">#</th>
                                                <th>Murid</th>
                                                <th>MyKid ID</th>
                                                <th class="text-end">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students as $index => $student)
                                                <tr>
                                                    <td><span class="text-muted small">{{ $index + 1 }}</span></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="student-avatar me-3">
                                                                {{ substr($student->namaMurid, 0, 1) }}
                                                            </div>
                                                            <div class="fw-bold">{{ $student->namaMurid }}</div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-light text-dark border">{{ $student->MyKidID }}</span></td>
                                                    <td class="text-end">
                                                        <a href="{{ route('pentadbir.profilMurid', ['kelas' => $selectedClass, 'murid' => $student->MyKidID]) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                            Profil Penuh
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/gray/empty-states.svg" alt="Empty" style="width: 150px;" class="mb-3">
                                    <p class="text-muted">Tiada murid didaftarkan dalam kelas ini lagi.</p>
                                </div>
                            @endif

                        @else
                            <div class="row align-items-center mb-4">
                                <div class="col-md-auto text-center text-md-start">
                                    <div class="bg-primary text-white rounded-4 shadow d-inline-flex align-items-center justify-content-center mb-3 mb-md-0" style="width: 100px; height: 100px; font-size: 3rem;">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="fw-bold mb-1">{{ $selectedStudent->namaMurid }}</h3>
                                    <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill border border-info-subtle">
                                        Murid Kelas {{ $selectedStudent->kelas }}
                                    </span>
                                </div>
                            </div>

                            <div class="detail-container">
                                <div class="row">
                                    <div class="col-md-6 border-end-md">
                                        <div class="info-label">ID MyKid</div>
                                        <div class="info-value">{{ $selectedStudent->MyKidID }}</div>
                                        
                                        <div class="info-label">Tarikh Lahir</div>
                                        <div class="info-value">
                                            <i class="bi bi-calendar-check me-2 text-primary"></i>
                                            {{ $selectedStudent->tarikhLahir ? date('d/m/Y', strtotime($selectedStudent->tarikhLahir)) : 'Tidak Maklum' }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 ps-md-4">
                                        <div class="info-label">Alamat Kediaman</div>
                                        <div class="info-value" style="line-height: 1.6;">
                                            <i class="bi bi-geo-alt me-2 text-danger"></i>
                                            {{ $selectedStudent->alamat ?: 'Tiada maklumat alamat.' }}
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
@endsection