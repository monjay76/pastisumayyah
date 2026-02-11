@extends('layouts.app')

@section('title', 'Senarai Murid')

@section('content')
<style>
    /* Custom Styling untuk Senarai Murid */
    .student-card { border-radius: 15px; overflow: hidden; }
    .filter-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        border: 1px solid #e9ecef;
    }
    .table thead th { 
        background-color: #f8f9fa; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
    }
    .id-badge {
        background-color: #eef2ff;
        color: #4338ca;
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 6px;
    }
    .class-tag {
        background-color: #fff7ed;
        color: #9a3412;
        border: 1px solid #ffedd5;
        font-weight: 600;
    }
    .hover-row:hover { background-color: rgba(13, 110, 253, 0.02) !important; }
    .avatar-placeholder {
        width: 35px;
        height: 35px;
        background-color: #dee2e6;
        color: #495057;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: bold;
    }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0">
                    <span class="text-primary"><i class="bi bi-people-fill me-2"></i></span> 
                    Senarai Murid Keseluruhan
                </h4>
                @if(request()->filled('kelas'))
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                        Menapis: {{ request()->input('kelas') }}
                    </span>
                @endif
            </div>

            <div class="card shadow-sm border-0 student-card">
                <div class="card-body p-4">
                    
                    @if($kelasList->count() > 0)
                    <div class="filter-section mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-auto mb-2 mb-md-0">
                                <span class="small fw-bold text-muted text-uppercase"><i class="bi bi-funnel-fill me-1"></i> Cari mengikut kelas:</span>
                            </div>
                            <div class="col-md-4">
                                <form action="{{ route('pentadbir.senaraiMurid') }}" method="GET" class="d-flex gap-2">
                                    <select class="form-select shadow-sm" name="kelas" onchange="this.form.submit();">
                                        <option value="">-- Semua Kelas --</option>
                                        @foreach($kelasList as $kls)
                                            <option value="{{ $kls }}" {{ request()->input('kelas') == $kls ? 'selected' : '' }}>
                                                {{ $kls }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if(request()->filled('kelas'))
                                        <a href="{{ route('pentadbir.senaraiMurid') }}" class="btn btn-light border shadow-sm" title="Kosongkan Tapis">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($murids->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="50">#</th>
                                        <th>MyKid ID</th>
                                        <th>Nama Murid</th>
                                        <th>Kelas</th>
                                        <th>Tarikh Lahir</th>
                                        <th>Alamat Kediaman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($murids as $index => $murid)
                                        <tr class="hover-row">
                                            <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                            <td><span class="id-badge">{{ $murid->MyKidID }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-placeholder me-2 small">
                                                        {{ substr($murid->namaMurid, 0, 1) }}
                                                    </div>
                                                    <span class="fw-semibold text-dark">{{ $murid->namaMurid }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge class-tag px-3 py-2 rounded-pill">
                                                    {{ $murid->kelas }}
                                                </span>
                                            </td>
                                            <td class="small">
                                                <i class="bi bi-calendar3 me-1 text-muted"></i>
                                                {{ $murid->tarikhLahir ? date('d/m/Y', strtotime($murid->tarikhLahir)) : '-' }}
                                            </td>
                                            <td>
                                                <div class="text-truncate text-muted small" style="max-width: 250px;" title="{{ $murid->alamat }}">
                                                    <i class="bi bi-geo-alt me-1"></i> {{ $murid->alamat }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3 px-2">
                            <p class="small text-muted">
                                Menunjukkan <strong>{{ $murids->count() }}</strong> orang murid.
                            </p>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-search text-light" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">Tiada rekod murid ditemui.</h5>
                            <p class="text-muted small">Sila pastikan data telah didaftarkan atau cuba penapis kelas yang lain.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection