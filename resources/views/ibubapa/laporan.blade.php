@extends('layouts.app')

@section('title', 'Laporan Anak')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white p-3 rounded-3 me-3 shadow-sm">
            <i class="bi bi-file-earmark-bar-graph fs-3"></i>
        </div>
        <div>
            <h3 class="fw-bold mb-0">Laporan Prestasi & Kehadiran</h3>
            <p class="text-muted mb-0">Pantau perkembangan akademik dan kehadiran anak anda</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    @if($children->isNotEmpty())
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label for="childSelector" class="form-label fw-bold text-primary">
                                    <i class="bi bi-person-badge me-2"></i>Pilih Anak
                                </label>
                                <select id="childSelector" class="form-select border-primary-subtle shadow-sm">
                                    <option value="">-- Sila pilih anak --</option>
                                    @foreach($children as $child)
                                        <option value="{{ $child->MyKidID }}" {{ request()->input('mykid') == $child->MyKidID ? 'selected' : '' }}>
                                            {{ $child->namaMurid }} ({{ $child->MyKidID }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if($selectedChild)
                            <hr class="my-4 opacity-25">

                            <div class="row g-3 mb-4">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(45deg, #4e73df, #224abe); color: white;">
                                        <div class="card-body p-4 text-center">
                                            <div class="text-white-50 small fw-bold text-uppercase mb-1">Rekod Prestasi</div>
                                            <div class="h2 mb-0 fw-bold">{{ $totalRecords }}</div>
                                            <i class="bi bi-journal-text mt-2 opacity-50 fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(45deg, #f6ad55, #ed8936); color: white;">
                                        <div class="card-body p-4 text-center">
                                            <div class="text-white-50 small fw-bold text-uppercase mb-1">Jenis Subjek</div>
                                            <div class="h2 mb-0 fw-bold">{{ $subjects->count() }}</div>
                                            <i class="bi bi-book mt-2 opacity-50 fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(45deg, #f56565, #e53e3e); color: white;">
                                        <div class="card-body p-4 text-center">
                                            <div class="text-white-50 small fw-bold text-uppercase mb-1">Purata Markah</div>
                                            <div class="h2 mb-0 fw-bold">{{ number_format($avgMarkah, 1) }}</div>
                                            <i class="bi bi-trophy mt-2 opacity-50 fs-1"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(45deg, #48bb78, #38a169); color: white;">
                                        <div class="card-body p-4 text-center">
                                            <div class="text-white-50 small fw-bold text-uppercase mb-1">Kehadiran</div>
                                            <div class="h2 mb-0 fw-bold">{{ $attendancePercentage }}%</div>
                                            <div class="progress mt-3 bg-white bg-opacity-25" style="height: 6px;">
                                                <div class="progress-bar bg-white" role="progressbar" style="width: {{ $attendancePercentage }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2 mb-4">
                                <div class="col-4">
                                    <div class="p-2 border rounded-3 bg-light text-center">
                                        <span class="d-block text-muted small">Rekod Hari</span>
                                        <span class="fw-bold">{{ $totalDays }}</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 border rounded-3 bg-success bg-opacity-10 text-center text-success">
                                        <span class="d-block small">Hadir</span>
                                        <span class="fw-bold">{{ $presentDays }}</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-2 border rounded-3 bg-danger bg-opacity-10 text-center text-danger">
                                        <span class="d-block small">X-Hadir</span>
                                        <span class="fw-bold">{{ $absentDays }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4">
                                <div class="card-header bg-white border-0 pt-3">
                                    <ul class="nav nav-pills nav-fill mb-0" id="reportTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active fw-semibold" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button" role="tab">
                                                <i class="bi bi-bar-chart-line me-2"></i>Laporan Prestasi
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link fw-semibold" id="kehadiran-tab" data-bs-toggle="tab" data-bs-target="#kehadiran" type="button" role="tab">
                                                <i class="bi bi-calendar-check me-2"></i>Laporan Kehadiran
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body p-4">
                                    <div class="tab-content" id="reportTabsContent">
                                        
                                        <div class="tab-pane fade show active" id="prestasi" role="tabpanel">
                                            <div class="bg-light p-3 rounded-4 mb-4">
                                                <form action="{{ route('ibubapa.laporan') }}" method="GET" id="prestasiFilterForm">
                                                    <input type="hidden" name="mykid" value="{{ request()->input('mykid') }}">
                                                    <div class="row g-3 align-items-end">
                                                        <div class="col-md-3">
                                                            <label class="form-label small fw-bold">Subjek</label>
                                                            <select class="form-select form-select-sm" name="subjek">
                                                                <option value="">Semua Subjek</option>
                                                                @foreach($subjectList as $subj)
                                                                    <option value="{{ $subj }}" {{ request()->input('subjek') == $subj ? 'selected' : '' }}>{{ $subj }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label small fw-bold">Penggal</label>
                                                            <select class="form-select form-select-sm" name="penggal">
                                                                <option value="">Semua</option>
                                                                @foreach($penggalList as $pgg)
                                                                    <option value="{{ $pgg }}" {{ request()->input('penggal') == $pgg ? 'selected' : '' }}>P{{ $pgg }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label small fw-bold text-muted">Dari</label>
                                                            <input type="date" class="form-control form-control-sm" name="tarikh_dari" value="{{ request()->input('tarikh_dari') }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label small fw-bold text-muted">Hingga</label>
                                                            <input type="date" class="form-control form-control-sm" name="tarikh_hingga" value="{{ request()->input('tarikh_hingga') }}">
                                                        </div>
                                                        <div class="col-md-3 text-end">
                                                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                                                <i class="bi bi-funnel-fill me-1"></i> Tapis Data
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle border-light" id="prestasiTable">
                                                    <thead class="bg-primary text-white">
                                                        <tr>
                                                            <th class="text-center py-3" style="width: 5%;">No.</th>
                                                            <th style="width: 15%;">Subjek</th>
                                                            <th style="width: 20%;">Kriteria/Ayat</th>
                                                            <th class="text-center" style="width: 10%;">Penggal</th>
                                                            <th class="text-center" style="width: 15%;">Tahap Pencapaian</th>
                                                            <th class="text-center" style="width: 10%;">Markah</th>
                                                            <th style="width: 15%;">Nama Guru</th>
                                                            <th class="text-end" style="width: 10%;">Tarikh</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($prestasi->isNotEmpty())
                                                            @foreach($prestasi as $index => $record)
                                                            <tr>
                                                                <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                                                <td class="fw-bold text-dark">{{ $record->subjek }}</td>
                                                                <td>{{ $record->kriteria_nama ?: '-' }}</td>
                                                                <td class="text-center"><span class="badge bg-light text-dark border">P{{ $record->penggal }}</span></td>
                                                                <td class="text-center">
                                                                    @php
                                                                        $tp = $record->tahap_pencapaian;
                                                                        $badgeClass = 'bg-secondary';
                                                                        $label = $tp;
                                                                        if($tp == 'AM' || $tp == 1) { $badgeClass = 'bg-warning text-dark'; $label = 'Ansur Maju'; }
                                                                        elseif($tp == 'M' || $tp == 2) { $badgeClass = 'bg-info text-dark'; $label = 'Maju'; }
                                                                        elseif($tp == 'SM' || $tp == 3) { $badgeClass = 'bg-success'; $label = 'Sangat Maju'; }
                                                                    @endphp
                                                                    <span class="badge {{ $badgeClass }} rounded-pill px-3">{{ $label }}</span>
                                                                </td>
                                                                <td class="text-center fw-bold text-primary">{{ $record->markah ?: 'N/A' }}</td>
                                                                <td class="small">{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
                                                                <td class="text-end small text-muted">{{ $record->tarikhRekod ? \Carbon\Carbon::parse($record->tarikhRekod)->format('d/m/y') : 'N/A' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="8" class="text-center py-5">
                                                                    <img src="https://illustrations.popsy.co/gray/no-data.svg" alt="Tiada Data" style="height: 120px;">
                                                                    <p class="mt-3 text-muted">Tiada rekod prestasi dijumpai.</p>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="kehadiran" role="tabpanel">
                                            <div class="bg-light p-3 rounded-4 mb-4">
                                                <form action="{{ route('ibubapa.laporan') }}" method="GET" id="kehadiranFilterForm">
                                                    <input type="hidden" name="mykid" value="{{ request()->input('mykid') }}">
                                                    <div class="row g-3 align-items-end">
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Dari</label>
                                                            <input type="date" class="form-control form-control-sm" name="kehadiran_tarikh_dari" value="{{ request()->input('kehadiran_tarikh_dari') }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label small fw-bold">Hingga</label>
                                                            <input type="date" class="form-control form-control-sm" name="kehadiran_tarikh_hingga" value="{{ request()->input('kehadiran_tarikh_hingga') }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                                <i class="bi bi-search me-1"></i> Tapis Kehadiran
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle" id="kehadiranTable">
                                                    <thead class="table-light text-primary">
                                                        <tr>
                                                            <th class="text-center" style="width: 10%;">No.</th>
                                                            <th style="width: 30%;">Tarikh Rekod</th>
                                                            <th class="text-center" style="width: 20%;">Status Kehadiran</th>
                                                            <th style="width: 40%;">Direkod Oleh</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($kehadiran->isNotEmpty())
                                                            @foreach($kehadiran as $index => $record)
                                                            <tr>
                                                                <td class="text-center text-muted">{{ $index + 1 }}</td>
                                                                <td class="fw-semibold">{{ $record->tarikh ? \Carbon\Carbon::parse($record->tarikh)->format('l, d/m/Y') : 'N/A' }}</td>
                                                                <td class="text-center">
                                                                    @if($record->status == 'hadir')
                                                                        <span class="badge bg-success-subtle text-success border border-success px-3">Hadir</span>
                                                                    @elseif($record->status == 'tidak_hadir')
                                                                        <span class="badge bg-danger-subtle text-danger border border-danger px-3">Tidak Hadir</span>
                                                                    @else
                                                                        <span class="badge bg-light text-dark border px-3">{{ $record->status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="small">{{ $record->guru ? $record->guru->namaGuru : 'Pentadbir' }}</td>
                                                            </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="4" class="text-center py-5 text-muted">
                                                                    <i class="bi bi-calendar-x fs-1 opacity-25"></i>
                                                                    <p class="mt-2">Tiada rekod kehadiran untuk tempoh ini.</p>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-arrow-up-circle-fill text-primary display-3 opacity-25"></i>
                                </div>
                                <h5 class="text-muted">Sila pilih nama anak untuk melihat statistik dan laporan lengkap.</h5>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning border-0 shadow-sm rounded-4 text-center py-4 mb-0">
                            <i class="bi bi-exclamation-triangle-fill fs-2 mb-3 d-block"></i>
                            <h5 class="fw-bold">Tiada Rekod Anak</h5>
                            <p class="mb-0">Sila hubungi pentadbir sekolah jika maklumat anak anda tidak muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling for refined look */
    .card-header .nav-pills .nav-link {
        color: #6c757d;
        border-radius: 8px;
        padding: 10px 20px;
    }
    .card-header .nav-pills .nav-link.active {
        background-color: #f8f9fa;
        color: #4e73df;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #dee2e6;
    }
    .form-select, .form-control {
        border-radius: 8px;
    }
    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .bg-gradient {
        position: relative;
        overflow: hidden;
    }
    .bg-gradient i {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem !important;
    }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const childSelector = document.getElementById('childSelector');
    if (!childSelector) return;

    childSelector.addEventListener('change', function() {
        const selectedMyKid = this.value;
        if (selectedMyKid) {
            const url = new URL(window.location.href);
            url.searchParams.set('mykid', selectedMyKid);
            // Bersihkan tapis lama
            ['subjek', 'penggal', 'tarikh_dari', 'tarikh_hingga', 'kehadiran_tarikh_dari', 'kehadiran_tarikh_hingga'].forEach(param => {
                url.searchParams.delete(param);
            });
            window.location.href = url.toString();
        } else {
            window.location.href = '{{ route("ibubapa.laporan") }}';
        }
    });
});
</script>
@endpush