@extends('layouts.app')

@section('title', 'Laporan Prestasi Murid - Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart-line me-2"></i>Laporan Prestasi & Markah Murid
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Summary Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-file-earmark-text display-4"></i>
                                    <h4>{{ $totalRecords }}</h4>
                                    <p class="mb-0">Jumlah Rekod Prestasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-people display-4"></i>
                                    <h4>{{ $uniqueStudents }}</h4>
                                    <p class="mb-0">Bilangan Murid</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-book display-4"></i>
                                    <h4>{{ $subjects->count() }}</h4>
                                    <p class="mb-0">Jenis Subjek</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-graph-up display-4"></i>
                                    <h4>{{ $prestasi->avg('markah') ? number_format($prestasi->avg('markah'), 1) : '0.0' }}</h4>
                                    <p class="mb-0">Purata Markah</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    <div class="d-flex justify-content-end mb-3">
                        <button onclick="window.print()" class="btn btn-secondary me-2">
                            <i class="bi bi-printer me-2"></i>Cetak Laporan
                        </button>
                        <button onclick="exportToExcel()" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel me-2"></i>Eksport Excel
                        </button>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="card border-0 bg-light mb-3" style="padding: 0.75rem;">
                        <form action="{{ route('guru.laporan') }}" method="GET" id="filterForm">
                            <div class="row g-2 align-items-end">
                                <!-- Search by Name or MyKid ID -->
                                <div class="col-md-4">
                                    <label for="search" class="form-label mb-1 small">
                                        <i class="bi bi-search"></i> Cari
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="search" name="search" 
                                           placeholder="Nama atau MyKid ID" 
                                           value="{{ request()->input('search') }}">
                                </div>

                                <!-- Filter Dropdowns -->
                                <div class="col-md-2">
                                    <label for="kelas" class="form-label mb-1 small">Kelas</label>
                                    <select class="form-select form-select-sm" id="kelas" name="kelas">
                                        <option value="">Semua</option>
                                        @foreach($kelasList as $kls)
                                            <option value="{{ $kls }}" 
                                                {{ request()->input('kelas') == $kls ? 'selected' : '' }}>
                                                {{ $kls }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="subjek" class="form-label mb-1 small">Subjek</label>
                                    <select class="form-select form-select-sm" id="subjek" name="subjek">
                                        <option value="">Semua</option>
                                        @foreach($subjectList as $subj)
                                            <option value="{{ $subj }}" 
                                                {{ request()->input('subjek') == $subj ? 'selected' : '' }}>
                                                {{ $subj }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="penggal" class="form-label mb-1 small">Penggal</label>
                                    <select class="form-select form-select-sm" id="penggal" name="penggal">
                                        <option value="">Semua</option>
                                        @foreach($penggalList as $pgg)
                                            <option value="{{ $pgg }}" 
                                                {{ request()->input('penggal') == $pgg ? 'selected' : '' }}>
                                                P{{ $pgg }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="bi bi-funnel"></i> Tapis
                                    </button>
                                </div>

                                <!-- Date Range Filter -->
                                <div class="col-md-2">
                                    <label for="tarikh_dari" class="form-label mb-1 small">Dari</label>
                                    <input type="date" class="form-control form-control-sm" id="tarikh_dari" name="tarikh_dari" 
                                           value="{{ request()->input('tarikh_dari') }}">
                                </div>

                                <div class="col-md-2">
                                    <label for="tarikh_hingga" class="form-label mb-1 small">Hingga</label>
                                    <input type="date" class="form-control form-control-sm" id="tarikh_hingga" name="tarikh_hingga" 
                                           value="{{ request()->input('tarikh_hingga') }}">
                                </div>

                                <!-- Reset Button -->
                                @if(request()->filled('search') || request()->filled('kelas') || request()->filled('subjek') || request()->filled('penggal') || request()->filled('tarikh_dari') || request()->filled('tarikh_hingga'))
                                <div class="col-md-2">
                                    <a href="{{ route('guru.laporan') }}" class="btn btn-outline-secondary btn-sm w-100">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Detailed Report Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="prestasiTable">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center" style="width: 5%;">No.</th>
                                    <th style="width: 15%;">Nama Murid</th>
                                    <th style="width: 10%;">MyKid ID</th>
                                    <th style="width: 10%;">Kelas</th>
                                    <th style="width: 15%;">Subjek</th>
                                    <th style="width: 10%;">Kriteria/Ayat</th>
                                    <th style="width: 5%;">Penggal</th>
                                    <th style="width: 10%;">Tahap Pencapaian</th>
                                    <th style="width: 5%;">Markah</th>
                                    <th style="width: 10%;">Nama Guru</th>
                                    <th style="width: 10%;">Tarikh Rekod</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($prestasi->isNotEmpty())
                                    @foreach($prestasi as $index => $record)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $record->murid ? $record->murid->namaMurid : 'N/A' }}</td>
                                        <td>{{ $record->murid_id }}</td>
                                        <td>{{ $record->murid ? $record->murid->kelas : 'N/A' }}</td>
                                        <td>{{ $record->subjek }}</td>
                                        <td>{{ $record->kriteria_nama ?: 'N/A' }}</td>
                                        <td class="text-center">{{ $record->penggal }}</td>
                                        <td class="text-center">
                                            @if($record->tahap_pencapaian == 'AM' || $record->tahap_pencapaian == 1)
                                                <span class="badge bg-warning text-dark">Ansur Maju</span>
                                            @elseif($record->tahap_pencapaian == 'M' || $record->tahap_pencapaian == 2)
                                                <span class="badge bg-info text-dark">Maju</span>
                                            @elseif($record->tahap_pencapaian == 'SM' || $record->tahap_pencapaian == 3)
                                                <span class="badge bg-success">Sangat Maju</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $record->tahap_pencapaian }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $record->markah ?: 'N/A' }}</span>
                                        </td>
                                        <td>{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
                                        <td>{{ $record->tarikhRekod ? \Carbon\Carbon::parse($record->tarikhRekod)->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-4">
                                            <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                            <p class="mt-2 mb-0">Tiada data prestasi dijumpai.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Student-wise Summary -->
                    @if($prestasiByStudent->isNotEmpty())
                    <div class="mt-5">
                        <h5 class="mb-3">Ringkasan Prestasi Mengikut Murid</h5>
                        <div class="row">
                            @foreach($prestasiByStudent as $studentId => $studentRecords)
                                @php
                                    $student = $studentRecords->first()->murid;
                                    $avgMarkah = $studentRecords->avg('markah');
                                    $totalSubjects = $studentRecords->pluck('subjek')->unique()->count();
                                    $penggal1Count = $studentRecords->where('penggal', 1)->count();
                                    $penggal2Count = $studentRecords->where('penggal', 2)->count();
                                @endphp
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $student ? $student->namaMurid : 'Murid Tidak Diketahui' }}</h6>
                                            <p class="card-text small text-muted mb-2">MyKid: {{ $studentId }}</p>
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="border rounded p-2">
                                                        <strong>{{ number_format($avgMarkah, 1) }}</strong><br>
                                                        <small class="text-muted">Purata Markah</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-2">
                                                        <strong>{{ $totalSubjects }}</strong><br>
                                                        <small class="text-muted">Subjek</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 small">
                                                <span class="badge bg-light text-dark me-1">P1: {{ $penggal1Count }}</span>
                                                <span class="badge bg-light text-dark">P2: {{ $penggal2Count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportToExcel() {
    // Simple CSV export functionality
    let csv = 'No.,Nama Murid,MyKid ID,Kelas,Subjek,Kriteria/Ayat,Penggal,Tahap Pencapaian,Markah,Nama Guru,Tarikh Rekod\n';

    const rows = document.querySelectorAll('#prestasiTable tbody tr');
    rows.forEach((row, index) => {
        if (row.cells.length > 1) { // Skip empty state row
            const cells = row.querySelectorAll('td');
            const rowData = [
                index + 1,
                cells[1].textContent.trim(),
                cells[2].textContent.trim(),
                cells[3].textContent.trim(),
                cells[4].textContent.trim(),
                cells[5].textContent.trim(),
                cells[6].textContent.trim(),
                cells[7].textContent.trim(),
                cells[8].textContent.trim(),
                cells[9].textContent.trim(),
                cells[10].textContent.trim()
            ];
            csv += rowData.join(',') + '\n';
        }
    });

    // Create and download CSV file
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

// Add print styles
const style = document.createElement('style');
style.textContent = `
@media print {
    .btn, .card-header { display: none !important; }
    .table { font-size: 12px; }
    .badge { border: 1px solid #000; padding: 2px 6px; }
}
`;
document.head.appendChild(style);
</script>

<style>
.table th {
    background-color: #343a40;
    color: white;
    font-weight: 600;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

@media print {
    body * {
        visibility: hidden;
    }
    .container-fluid, .container-fluid * {
        visibility: visible;
    }
    .container-fluid {
        position: absolute;
        left: 0;
        top: 0;
    }
}
</style>
@endsection
