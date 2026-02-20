@extends('layouts.app')

@section('title', 'Laporan Anak')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">Laporan Prestasi & Kehadiran</h3>
            <p class="text-muted small">Pantau perkembangan akademik dan kehadiran anak anda secara terperinci.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-primary shadow-sm">
                <i class="bi bi-printer me-2"></i>Cetak Laporan
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4 stats-card">
        <div class="card-body p-3">
            @if($children->isNotEmpty())
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>
                            <div class="w-100">
                                <label for="childSelector" class="form-label small fw-bold text-muted mb-1">Pilih Rekod Anak</label>
                                <select id="childSelector" class="form-select border-0 bg-light shadow-none">
                                    <option value="">-- Sila pilih anak --</option>
                                    @foreach($children as $child)
                                        <option value="{{ $child->MyKidID }}" {{ request()->input('mykid') == $child->MyKidID ? 'selected' : '' }}>
                                            {{ $child->namaMurid }} ({{ $child->MyKidID }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-2">
                    <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Tiada Rekod Anak Ditemui</span>
                </div>
            @endif
        </div>
    </div>

    @if($selectedChild)
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 stats-card bg-gradient-blue text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 uppercase small">Jumlah Rekod</h6>
                                <h2 class="mb-0 fw-bold">{{ $totalRecords }}</h2>
                            </div>
                            <div class="icon-shape bg-white text-primary rounded-circle shadow-sm">
                                <i class="bi bi-journal-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 stats-card bg-gradient-orange text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 uppercase small">Jenis Subjek</h6>
                                <h2 class="mb-0 fw-bold">{{ $subjects->count() }}</h2>
                            </div>
                            <div class="icon-shape bg-white text-warning rounded-circle shadow-sm">
                                <i class="bi bi-book"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 stats-card bg-gradient-red text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 uppercase small">Purata Markah</h6>
                                <h2 class="mb-0 fw-bold">{{ number_format($avgMarkah, 1) }}</h2>
                            </div>
                            <div class="icon-shape bg-white text-danger rounded-circle shadow-sm">
                                <i class="bi bi-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 stats-card bg-gradient-green text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 uppercase small">Kehadiran (%)</h6>
                                <h2 class="mb-0 fw-bold">{{ $attendancePercentage }}%</h2>
                            </div>
                            <div class="icon-shape bg-white text-success rounded-circle shadow-sm">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                        </div>
                        <div class="progress mt-3 bg-white bg-opacity-25" style="height: 5px;">
                            <div class="progress-bar bg-white" role="progressbar" style="width: {{ $attendancePercentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-2 mb-4">
            <div class="col-4">
                <div class="p-3 border-0 shadow-sm rounded-3 bg-white text-center">
                    <span class="d-block text-muted small uppercase fw-bold">Hari Rekod</span>
                    <h5 class="fw-bold mb-0">{{ $totalDays }}</h5>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 border-0 shadow-sm rounded-3 bg-white text-center">
                    <span class="d-block text-success small uppercase fw-bold">Hadir</span>
                    <h5 class="fw-bold mb-0 text-success">{{ $presentDays }}</h5>
                </div>
            </div>
            <div class="col-4">
                <div class="p-3 border-0 shadow-sm rounded-3 bg-white text-center">
                    <span class="d-block text-danger small uppercase fw-bold">Tidak Hadir</span>
                    <h5 class="fw-bold mb-0 text-danger">{{ $absentDays }}</h5>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <ul class="nav nav-tabs nav-tabs-custom border-bottom-0" id="reportTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button" role="tab">
                            <i class="bi bi-bar-chart-line me-2"></i>Prestasi Akademik
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="kehadiran-tab" data-bs-toggle="tab" data-bs-target="#kehadiran" type="button" role="tab">
                            <i class="bi bi-calendar-check me-2"></i>Rekod Kehadiran
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="reportTabsContent">
                    
                    <div class="tab-pane fade show active" id="prestasi" role="tabpanel">
                        <div class="filter-box bg-light p-3 rounded-3 mb-4">
                            <form action="{{ route('ibubapa.laporan') }}" method="GET" id="prestasiFilterForm">
                                <input type="hidden" name="mykid" value="{{ request()->input('mykid') }}">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold">Subjek</label>
                                        <select class="form-select form-select-sm border-0 shadow-sm" name="subjek">
                                            <option value="">Semua Subjek</option>
                                            @foreach($subjectList as $subj)
                                                <option value="{{ $subj }}" {{ request()->input('subjek') == $subj ? 'selected' : '' }}>{{ $subj }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold">Penggal</label>
                                        <select class="form-select form-select-sm border-0 shadow-sm" name="penggal">
                                            <option value="">Semua</option>
                                            @foreach($penggalList as $pgg)
                                                <option value="{{ $pgg }}" {{ request()->input('penggal') == $pgg ? 'selected' : '' }}>Penggal {{ $pgg }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted">Dari</label>
                                        <input type="date" class="form-control form-control-sm border-0 shadow-sm" name="tarikh_dari" value="{{ request()->input('tarikh_dari') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted">Hingga</label>
                                        <input type="date" class="form-control form-control-sm border-0 shadow-sm" name="tarikh_hingga" value="{{ request()->input('tarikh_hingga') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                                            <i class="bi bi-funnel me-1"></i> Tapis Prestasi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle custom-table" id="prestasiTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Subjek</th>
                                        <th>Kriteria</th>
                                        <th class="text-center">Penggal</th>
                                        <th class="text-center">Tahap Pencapaian</th>
                                        <th class="text-center">Markah</th>
                                        <th>Guru Penilai</th>
                                        <th class="text-end">Tarikh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prestasi as $index => $record)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                        <td><span class="fw-bold text-dark">{{ $record->subjek }}</span></td>
                                        <td class="small">{{ $record->kriteria_nama ?: '-' }}</td>
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
                                        <td class="text-center fw-bold text-primary">{{ $record->markah ?: '-' }}</td>
                                        <td class="small text-muted">{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
                                        <td class="text-end small text-muted">{{ $record->tarikhRekod ? \Carbon\Carbon::parse($record->tarikhRekod)->format('d/m/y') : 'N/A' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <img src="https://illustrations.popsy.co/gray/no-data.svg" alt="Tiada Data" style="height: 100px;" class="mb-3">
                                            <p class="text-muted">Tiada rekod prestasi dijumpai.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="kehadiran" role="tabpanel">
                        <div class="filter-box bg-light p-3 rounded-3 mb-4">
                            <form action="{{ route('ibubapa.laporan') }}" method="GET" id="kehadiranFilterForm">
                                <input type="hidden" name="mykid" value="{{ request()->input('mykid') }}">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Dari</label>
                                        <input type="date" class="form-control form-control-sm border-0 shadow-sm" name="kehadiran_tarikh_dari" value="{{ request()->input('kehadiran_tarikh_dari') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold">Hingga</label>
                                        <input type="date" class="form-control form-control-sm border-0 shadow-sm" name="kehadiran_tarikh_hingga" value="{{ request()->input('kehadiran_tarikh_hingga') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                                            <i class="bi bi-search me-1"></i> Tapis Kehadiran
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle custom-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Tarikh Hari</th>
                                        <th class="text-center">Status</th>
                                        <th>Direkod Oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kehadiran as $index => $record)
                                    <tr>
                                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ \Carbon\Carbon::parse($record->tarikh)->translatedFormat('l, d/m/Y') }}</td>
                                        <td class="text-center">
                                            @if($record->status == 'hadir')
                                                <span class="badge bg-success-subtle text-success border border-success px-3">Hadir</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger px-3">Tidak Hadir</span>
                                            @endif
                                        </td>
                                        <td class="small text-muted">{{ $record->guru ? $record->guru->namaGuru : 'Pentadbir' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-calendar-x fs-1 opacity-25"></i>
                                            <p class="mt-2">Tiada rekod kehadiran untuk tempoh ini.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 mt-5">
            <div class="card-body">
                <i class="bi bi-person-bounding-box display-1 text-primary opacity-10 mb-4"></i>
                <h4 class="fw-bold text-dark">Selamat Datang ke Portal Laporan</h4>
                <p class="text-muted mx-auto" style="max-width: 400px;">Sila pilih nama anak anda daripada senarai di atas untuk melihat statistik prestasi dan rekod kehadiran lengkap.</p>
            </div>
        </div>
    @endif
</div>

<style>
    body { background-color: #f8f9fc; }
    
    /* Stats Cards Styles from Guru layout */
    .bg-gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .bg-gradient-orange { background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%); }
    .bg-gradient-red { background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%); }
    .bg-gradient-green { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); }

    .stats-card {
        border-radius: 15px;
        transition: transform 0.2s;
    }
    .stats-card:hover { transform: translateY(-5px); }

    .icon-shape {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Tabs Styling */
    .nav-tabs-custom .nav-link {
        border: none;
        color: #6c757d;
        padding: 12px 20px;
        border-bottom: 3px solid transparent;
    }
    .nav-tabs-custom .nav-link.active {
        color: #4e73df;
        background: none;
        border-bottom-color: #4e73df;
    }

    /* Table Styling */
    .custom-table thead th {
        background-color: #f8f9fc;
        color: #4e73df;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.8px;
        padding: 15px;
        border-bottom: 2px solid #e3e6f0;
    }
    .custom-table tbody td { padding: 12px 15px; }

    @media print {
        .btn, .filter-box, #childSelector, .card-header, .sidebar { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
        .container-fluid { width: 100% !important; margin: 0 !important; padding: 0 !important; }
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
            // Bersihkan tapis lama bila tukar anak
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