@extends('layouts.app')

@section('title', 'Laporan Prestasi Murid - Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">Laporan Prestasi & Kehadiran</h3>
            <p class="text-muted small">Pantau pencapaian dan rekod kehadiran murid secara keseluruhan.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-primary shadow-sm">
                <i class="bi bi-printer me-2"></i>Cetak
            </button>
            <button onclick="exportToExcel()" class="btn btn-success shadow-sm">
                <i class="bi bi-file-earmark-excel me-2"></i>Eksport Excel
            </button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stats-card bg-gradient-blue text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 uppercase small">Jumlah Rekod</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalRecords }}</h2>
                        </div>
                        <div class="icon-shape bg-white-20 rounded-circle p-3">
                            <i class="bi bi-file-earmark-text fs-3"></i>
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
                            <h6 class="text-white-50 uppercase small">Bilangan Murid</h6>
                            <h2 class="mb-0 fw-bold">{{ $uniqueStudents }}</h2>
                        </div>
                        <div class="icon-shape bg-white-20 rounded-circle p-3">
                            <i class="bi bi-people fs-3"></i>
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
                        <div class="icon-shape bg-white-20 rounded-circle p-3">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 stats-card bg-gradient-purple text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 uppercase small">Purata Markah</h6>
                            <h2 class="mb-0 fw-bold">{{ $prestasi->avg('markah') ? number_format($prestasi->avg('markah'), 1) : '0.0' }}</h2>
                        </div>
                        <div class="icon-shape bg-white-20 rounded-circle p-3">
                            <i class="bi bi-graph-up fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="row g-0 text-center border-top">
                <div class="col-md-3 border-end p-3">
                    <span class="text-muted small d-block">Peratus Kehadiran</span>
                    <h5 class="mb-0 fw-bold text-primary">{{ $attendancePercentage }}%</h5>
                </div>
                <div class="col-md-3 border-end p-3">
                    <span class="text-muted small d-block">Jumlah Hari Rekod</span>
                    <h5 class="mb-0 fw-bold">{{ $totalDays }}</h5>
                </div>
                <div class="col-md-3 border-end p-3">
                    <span class="text-muted small d-block text-success">Hari Hadir</span>
                    <h5 class="mb-0 fw-bold text-success">{{ $presentDays }}</h5>
                </div>
                <div class="col-md-3 p-3">
                    <span class="text-muted small d-block text-danger">Hari Tidak Hadir</span>
                    <h5 class="mb-0 fw-bold text-danger">{{ $absentDays }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <ul class="nav nav-pills mb-0" id="reportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 me-2" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button" role="tab">
                        <i class="bi bi-bar-chart-line me-2"></i>Laporan Prestasi
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4" id="kehadiran-tab" data-bs-toggle="tab" data-bs-target="#kehadiran" type="button" role="tab">
                        <i class="bi bi-calendar-check me-2"></i>Laporan Kehadiran
                    </button>
                </li>
            </ul>
        </div>
        
        <div class="card-body p-4">
            <div class="tab-content" id="reportTabsContent">
                
                <div class="tab-pane fade show active" id="prestasi" role="tabpanel">
                    <div class="p-3 bg-light rounded-4 mb-4 border">
                        <form action="{{ route('guru.laporan') }}" method="GET" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold small text-muted">Carian Murid</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0" name="search" placeholder="Nama / MyKid ID" value="{{ request()->input('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Kelas</label>
                                    <select class="form-select form-select-sm" name="kelas">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelasList as $kls)
                                            <option value="{{ $kls }}" {{ request()->input('kelas') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Subjek</label>
                                    <select class="form-select form-select-sm" name="subjek">
                                        <option value="">Semua Subjek</option>
                                        @foreach($subjectList as $subj)
                                            <option value="{{ $subj }}" {{ request()->input('subjek') == $subj ? 'selected' : '' }}>{{ $subj }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Tarikh Dari</label>
                                    <input type="date" class="form-control form-control-sm" name="tarikh_dari" value="{{ request()->input('tarikh_dari') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold small text-muted">Tarikh Hingga</label>
                                    <input type="date" class="form-control form-control-sm" name="tarikh_hingga" value="{{ request()->input('tarikh_hingga') }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm">
                                        <i class="bi bi-funnel"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0" id="prestasiTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="text-center py-3">No.</th>
                                    <th>Nama Murid</th>
                                    <th>MyKid ID</th>
                                    <th>Kelas</th>
                                    <th>Subjek</th>
                                    <th>Kriteria</th>
                                    <th class="text-center">P.</th>
                                    <th class="text-center">Tahap</th>
                                    <th class="text-center">Markah</th>
                                    <th class="text-center">Tarikh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($prestasi->isNotEmpty())
                                    @foreach($prestasi as $index => $record)
                                    <tr>
                                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                        <td><span class="fw-bold text-dark">{{ $record->murid ? $record->murid->namaMurid : 'N/A' }}</span></td>
                                        <td class="small">{{ $record->murid_id }}</td>
                                        <td><span class="badge bg-light text-primary border border-primary-subtle">{{ $record->murid ? $record->murid->kelas : 'N/A' }}</span></td>
                                        <td>{{ $record->subjek }}</td>
                                        <td class="small">{{ Str::limit($record->kriteria_nama, 20) ?: 'N/A' }}</td>
                                        <td class="text-center fw-bold">{{ $record->penggal }}</td>
                                        <td class="text-center">
                                            @php
                                                $statusClass = [
                                                    'AM' => 'bg-warning text-dark',
                                                    '1' => 'bg-warning text-dark',
                                                    'M' => 'bg-info text-dark',
                                                    '2' => 'bg-info text-dark',
                                                    'SM' => 'bg-success',
                                                    '3' => 'bg-success'
                                                ];
                                                $label = [
                                                    'AM' => 'Ansur Maju', '1' => 'Ansur Maju',
                                                    'M' => 'Maju', '2' => 'Maju',
                                                    'SM' => 'Sangat Maju', '3' => 'Sangat Maju'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusClass[$record->tahap_pencapaian] ?? 'bg-secondary' }} rounded-pill px-3">
                                                {{ $label[$record->tahap_pencapaian] ?? $record->tahap_pencapaian }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="fw-bold text-primary fs-5">{{ $record->markah ?: '0' }}</div>
                                        </td>
                                        <td class="text-center small text-muted">
                                            {{ $record->tarikhRekod ? \Carbon\Carbon::parse($record->tarikhRekod)->format('d/m/Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center py-5">
                                            <img src="https://illustrations.popsy.co/gray/no-results.svg" alt="No data" style="width: 150px;">
                                            <p class="mt-3 text-muted">Tiada data prestasi dijumpai.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($prestasiByStudent->isNotEmpty())
                    <div class="mt-5">
                        <h5 class="fw-bold mb-4 d-flex align-items-center">
                            <span class="bg-primary p-1 rounded me-2"></span> Ringkasan Prestasi Mengikut Murid
                        </h5>
                        <div class="row g-3">
                            @foreach($prestasiByStudent as $studentId => $studentRecords)
                                @php
                                    $student = $studentRecords->first()->murid;
                                    $avgMarkah = $studentRecords->avg('markah');
                                    $totalSubjects = $studentRecords->pluck('subjek')->unique()->count();
                                @endphp
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border shadow-none hover-shadow transition">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="avatar-sm bg-primary-subtle text-primary rounded-circle p-2 me-3">
                                                    <i class="bi bi-person-fill fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold mb-0">{{ $student ? $student->namaMurid : 'Murid Tidak Diketahui' }}</h6>
                                                    <small class="text-muted">MyKid: {{ $studentId }}</small>
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-6 text-center border-end">
                                                    <h4 class="mb-0 fw-bold">{{ number_format($avgMarkah, 1) }}</h4>
                                                    <small class="text-muted uppercase small">Purata</small>
                                                </div>
                                                <div class="col-6 text-center">
                                                    <h4 class="mb-0 fw-bold">{{ $totalSubjects }}</h4>
                                                    <small class="text-muted uppercase small">Subjek</small>
                                                </div>
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
                    <div class="p-3 bg-light rounded-4 mb-4 border">
                        <form action="{{ route('guru.laporan') }}" method="GET">
                            <input type="hidden" name="search" value="{{ request()->input('search') }}">
                            <div class="row g-3 align-items-end justify-content-center">
                                <div class="col-md-4">
                                    <label class="form-label small text-muted fw-bold">Dari Tarikh</label>
                                    <input type="date" class="form-control" name="kehadiran_tarikh_dari" value="{{ request()->input('kehadiran_tarikh_dari') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted fw-bold">Hingga Tarikh</label>
                                    <input type="date" class="form-control" name="kehadiran_tarikh_hingga" value="{{ request()->input('kehadiran_tarikh_hingga') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm">Tapis Kehadiran</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive rounded-3 border">
                        <table class="table table-hover align-middle mb-0" id="kehadiranTable">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="text-center py-3">No.</th>
                                    <th>Nama Murid</th>
                                    <th>MyKid ID</th>
                                    <th>Kelas</th>
                                    <th class="text-center">Tarikh</th>
                                    <th class="text-center">Status</th>
                                    <th>Direkod Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kehadiran as $index => $record)
                                <tr>
                                    <td class="text-center text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $record->murid ? $record->murid->namaMurid : 'N/A' }}</td>
                                    <td>{{ $record->MyKidID }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $record->murid ? $record->murid->kelas : 'N/A' }}</span></td>
                                    <td class="text-center">{{ $record->tarikh ? \Carbon\Carbon::parse($record->tarikh)->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        @if($record->status == 'hadir')
                                            <span class="badge bg-success-subtle text-success border border-success px-3 rounded-pill">Hadir</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 rounded-pill">Tidak Hadir</span>
                                        @endif
                                    </td>
                                    <td class="small">{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted small italic">Tiada data kehadiran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Dashboard Styles */
:root {
    --primary-color: #4361ee;
    --success-color: #2ec4b6;
    --warning-color: #ff9f1c;
    --danger-color: #e71d36;
    --purple-color: #7209b7;
}

.stats-card {
    border-radius: 1rem;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.bg-gradient-blue { background: linear-gradient(45deg, #4361ee, #4cc9f0); }
.bg-gradient-green { background: linear-gradient(45deg, #2ec4b6, #80ed99); }
.bg-gradient-orange { background: linear-gradient(45deg, #ff9f1c, #ffbf69); }
.bg-gradient-purple { background: linear-gradient(45deg, #7209b7, #b5179e); }

.bg-white-20 { background-color: rgba(255, 255, 255, 0.2); }

.nav-pills .nav-link {
    color: #64748b;
    font-weight: 500;
    transition: all 0.3s ease;
}

.nav-pills .nav-link.active {
    background-color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
}

.table thead th {
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    border: none;
}

.hover-shadow:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
}

.transition { transition: all 0.3s ease; }

@media print {
    .btn, #filterForm, .nav-tabs, .card-header { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
    .container-fluid { width: 100% !important; margin: 0 !important; padding: 0 !important; }
    .table { width: 100% !important; }
    body { background: white !important; }
}
</style>

<script>
// Fungsi asal anda (tidak disentuh)
function exportToExcel() {
    let csv = 'No.,Nama Murid,MyKid ID,Kelas,Subjek,Kriteria/Ayat,Penggal,Tahap Pencapaian,Markah,Nama Guru,Tarikh Rekod\n';
    const rows = document.querySelectorAll('#prestasiTable tbody tr');
    rows.forEach((row, index) => {
        if (row.cells.length > 1) {
            const cells = row.querySelectorAll('td');
            const rowData = Array.from(cells).map(cell => cell.textContent.trim());
            csv += rowData.join(',') + '\n';
        }
    });
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'laporan_prestasi_' + new Date().toISOString().split('T')[0] + '.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}
</script>
@endsection