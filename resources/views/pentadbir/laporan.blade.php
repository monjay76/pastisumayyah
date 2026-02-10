@extends('layouts.app')

@section('title', 'Laporan Prestasi Murid - Pentadbir')

@section('content')
<style>
    /* Custom Styling untuk Laporan */
    .stat-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: none;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .icon-shape {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 1rem 1.5rem;
    }
    .nav-tabs-custom .nav-link.active {
        color: #0d6efd;
        background: none;
        border-bottom: 3px solid #0d6efd;
    }
    .student-card {
        border-radius: 12px;
        border-left: 4px solid #0d6efd;
    }
    .table-custom thead {
        background-color: #f8f9fa;
    }
    .badge-p1 { background-color: #e3f2fd; color: #0d6efd; }
    .badge-p2 { background-color: #f3e5f5; color: #9c27b0; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Laporan Prestasi & Markah Murid</h3>
            <p class="text-muted">Analisis data pencapaian dan kehadiran murid secara menyeluruh.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary shadow-sm px-3">
                <i class="bi bi-printer me-2"></i>Cetak Laporan
            </button>
            <button onclick="exportToExcel()" class="btn btn-success shadow-sm px-3">
                <i class="bi bi-file-earmark-excel me-2"></i>Eksport Excel
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-primary text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="icon-shape"><i class="bi bi-file-earmark-text"></i></div>
                    <h3 class="fw-bold mb-0">{{ $totalRecords }}</h3>
                    <p class="small opacity-75 mb-0">Jumlah Rekod Prestasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-success text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="icon-shape"><i class="bi bi-people"></i></div>
                    <h3 class="fw-bold mb-0">{{ $uniqueStudents }}</h3>
                    <p class="small opacity-75 mb-0">Bilangan Murid</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-info text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="icon-shape"><i class="bi bi-book"></i></div>
                    <h3 class="fw-bold mb-0">{{ $subjects->count() }}</h3>
                    <p class="small opacity-75 mb-0">Jenis Subjek</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-danger text-white h-100 shadow-sm">
                <div class="card-body">
                    <div class="icon-shape"><i class="bi bi-graph-up"></i></div>
                    <h3 class="fw-bold mb-0">{{ $prestasi->avg('markah') ? number_format($prestasi->avg('markah'), 1) : '0.0' }}</h3>
                    <p class="small opacity-75 mb-0">Purata Markah Keseluruhan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary-subtle p-3 rounded-3 me-3">
                        <i class="bi bi-calendar-check text-primary fs-4"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">{{ $attendancePercentage }}%</h5>
                        <p class="text-muted small mb-0">Peratus Kehadiran</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3">
                <p class="text-muted small mb-1">Jumlah Hari</p>
                <h5 class="mb-0 fw-bold text-primary">{{ $totalDays }}</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3">
                <p class="text-muted small mb-1">Hari Hadir</p>
                <h5 class="mb-0 fw-bold text-success">{{ $presentDays }}</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3">
                <p class="text-muted small mb-1">Hari Tidak Hadir</p>
                <h5 class="mb-0 fw-bold text-danger">{{ $absentDays }}</h5>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="p-4 border-bottom bg-light rounded-top-4">
                <form action="{{ route('pentadbir.laporan') }}" method="GET" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-muted">Carian</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" class="form-control border-start-0" name="search" placeholder="Nama atau MyKid ID" value="{{ request()->input('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted">Kelas</label>
                            <select class="form-select form-select-sm" name="kelas">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $kls)
                                    <option value="{{ $kls }}" {{ request()->input('kelas') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted">Subjek</label>
                            <select class="form-select form-select-sm" name="subjek">
                                <option value="">Semua Subjek</option>
                                @foreach($subjectList as $subj)
                                    <option value="{{ $subj }}" {{ request()->input('subjek') == $subj ? 'selected' : '' }}>{{ $subj }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label small fw-bold text-muted">Penggal</label>
                            <select class="form-select form-select-sm" name="penggal">
                                <option value="">Semua</option>
                                @foreach($penggalList as $pgg)
                                    <option value="{{ $pgg }}" {{ request()->input('penggal') == $pgg ? 'selected' : '' }}>P{{ $pgg }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-bold text-muted">Tempoh</label>
                            <div class="d-flex gap-1">
                                <input type="date" class="form-control form-control-sm" name="tarikh_dari" value="{{ request()->input('tarikh_dari') }}">
                                <input type="date" class="form-control form-control-sm" name="tarikh_hingga" value="{{ request()->input('tarikh_hingga') }}">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="bi bi-filter"></i> Tapis</button>
                            @if(request()->anyFilled(['search', 'kelas', 'subjek', 'penggal', 'tarikh_dari', 'tarikh_hingga']))
                                <a href="{{ route('pentadbir.laporan') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-clockwise"></i></a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <ul class="nav nav-tabs nav-tabs-custom px-4" id="reportTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button">
                        <i class="bi bi-bar-chart-line me-2"></i>Jadual Prestasi
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="kehadiran-tab" data-bs-toggle="tab" data-bs-target="#kehadiran" type="button">
                        <i class="bi bi-calendar-check me-2"></i>Jadual Kehadiran
                    </button>
                </li>
            </ul>

            <div class="tab-content p-4" id="reportTabsContent">
                <div class="tab-pane fade show active" id="prestasi" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="prestasiTable">
                            <thead class="table-light">
                                <tr class="small text-uppercase text-muted">
                                    <th class="text-center py-3">No.</th>
                                    <th>Nama Murid</th>
                                    <th>Kelas/Subjek</th>
                                    <th>Kriteria</th>
                                    <th class="text-center">Tahap</th>
                                    <th class="text-center">Markah</th>
                                    <th>Direkod Oleh</th>
                                    <th>Tarikh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($prestasi->isNotEmpty())
                                    @foreach($prestasi as $index => $record)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $record->murid ? $record->murid->namaMurid : 'N/A' }}</div>
                                            <div class="small text-muted">{{ $record->murid_id }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $record->murid ? $record->murid->kelas : 'N/A' }}</span>
                                            <div class="small mt-1 fw-semibold text-primary">{{ $record->subjek }}</div>
                                        </td>
                                        <td class="small">{{ $record->kriteria_nama ?: 'N/A' }}</td>
                                        <td class="text-center">
                                            @php
                                                $tp_class = [
                                                    'AM' => 'bg-warning', '1' => 'bg-warning',
                                                    'M' => 'bg-info', '2' => 'bg-info',
                                                    'SM' => 'bg-success', '3' => 'bg-success'
                                                ][$record->tahap_pencapaian] ?? 'bg-secondary';
                                                
                                                $tp_label = [
                                                    'AM' => 'Ansur Maju', '1' => 'Ansur Maju',
                                                    'M' => 'Maju', '2' => 'Maju',
                                                    'SM' => 'Sangat Maju', '3' => 'Sangat Maju'
                                                ][$record->tahap_pencapaian] ?? $record->tahap_pencapaian;
                                            @endphp
                                            <span class="badge {{ $tp_class }}">{{ $tp_label }}</span>
                                            <div class="small text-muted mt-1">Penggal {{ $record->penggal }}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="h5 mb-0 fw-bold text-primary">{{ $record->markah ?: '0' }}</div>
                                        </td>
                                        <td class="small">{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
                                        <td class="small text-muted">{{ $record->tarikhRekod ? $record->tarikhRekod->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="8" class="text-center py-5 text-muted">Tiada data prestasi dijumpai.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($prestasiByStudent->isNotEmpty())
                    <div class="mt-5">
                        <h5 class="fw-bold mb-4 px-2">Ringkasan Pencapaian Individu</h5>
                        <div class="row g-3">
                            @foreach($prestasiByStudent as $studentId => $studentRecords)
                                @php
                                    $student = $studentRecords->first()->murid;
                                    $avgMarkah = $studentRecords->avg('markah');
                                    $totalSubjects = $studentRecords->pluck('subjek')->unique()->count();
                                @endphp
                                <div class="col-md-4">
                                    <div class="card student-card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="fw-bold text-truncate mb-1">{{ $student ? $student->namaMurid : 'Murid N/A' }}</h6>
                                            <p class="small text-muted mb-3">MyKid: {{ $studentId }}</p>
                                            <div class="row g-2 text-center">
                                                <div class="col-6">
                                                    <div class="bg-light rounded p-2 border">
                                                        <div class="fw-bold text-primary fs-5">{{ number_format($avgMarkah, 1) }}</div>
                                                        <div class="small text-muted">Purata</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="bg-light rounded p-2 border">
                                                        <div class="fw-bold text-dark fs-5">{{ $totalSubjects }}</div>
                                                        <div class="small text-muted">Subjek</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <span class="badge badge-p1 me-1">P1: {{ $studentRecords->where('penggal', 1)->count() }} rekod</span>
                                                <span class="badge badge-p2">P2: {{ $studentRecords->where('penggal', 2)->count() }} rekod</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="tab-pane fade" id="kehadiran" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="kehadiranTable">
                            <thead class="table-light">
                                <tr class="small text-uppercase text-muted">
                                    <th class="text-center py-3">No.</th>
                                    <th>Nama Murid</th>
                                    <th>MyKid ID</th>
                                    <th>Kelas</th>
                                    <th>Tarikh Kehadiran</th>
                                    <th class="text-center">Status</th>
                                    <th>Direkod Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($kehadiran->isNotEmpty())
                                    @foreach($kehadiran as $index => $record)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                        <td class="fw-bold">{{ $record->murid ? $record->murid->namaMurid : 'N/A' }}</td>
                                        <td class="small">{{ $record->MyKidID }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $record->murid ? $record->murid->kelas : 'N/A' }}</span></td>
                                        <td class="small">{{ $record->tarikh ? \Carbon\Carbon::parse($record->tarikh)->format('d/m/Y') : 'N/A' }}</td>
                                        <td class="text-center">
                                            @if($record->status == 'hadir')
                                                <span class="badge bg-success-subtle text-success px-3">Hadir</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger px-3">Tidak Hadir</span>
                                            @endif
                                        </td>
                                        <td class="small">{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="7" class="text-center py-5 text-muted">Tiada data kehadiran dijumpai.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Logik sedia ada kekal berfungsi sepenuhnya
    function exportToExcel() {
        let csv = 'No.,Nama Murid,MyKid ID,Kelas,Subjek,Kriteria/Ayat,Penggal,Tahap Pencapaian,Markah,Nama Guru,Tarikh Rekod\n';
        const rows = document.querySelectorAll('#prestasiTable tbody tr');
        rows.forEach((row, index) => {
            if (row.cells.length > 1) {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    index + 1,
                    cells[1].innerText.replace(/\n/g, " ").trim(),
                    cells[1].querySelector('.small') ? cells[1].querySelector('.small').innerText : '',
                    cells[2].querySelector('.badge') ? cells[2].querySelector('.badge').innerText : '',
                    cells[2].querySelector('.fw-semibold') ? cells[2].querySelector('.fw-semibold').innerText : '',
                    cells[3].innerText.trim(),
                    cells[4].querySelector('.small') ? cells[4].querySelector('.small').innerText.replace('Penggal ', '') : '',
                    cells[4].querySelector('.badge') ? cells[4].querySelector('.badge').innerText : '',
                    cells[5].innerText.trim(),
                    cells[6].innerText.trim(),
                    cells[7].innerText.trim()
                ];
                csv += rowData.join(',') + '\n';
            }
        });

        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'laporan_prestasi_' + new Date().toISOString().split('T')[0] + '.csv';
        a.click();
    }
</script>
@endsection