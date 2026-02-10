@extends('layouts.app')

@section('title', 'Laporan Individu Murid - Pentadbir')

@section('content')
<style>
    /* Custom Styles untuk impak visual lebih premium */
    .main-card { border-radius: 15px; overflow: hidden; }
    .filter-section { background: #f8f9fa; border-left: 5px solid #0dcaf0; }
    .info-section { border-left: 5px solid #198754; }
    .chart-section { border-left: 5px solid #0d6efd; }
    
    .profile-img-container {
        position: relative;
        display: inline-block;
    }
    .profile-img-container::after {
        content: '';
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 15px;
        height: 15px;
        background: #198754;
        border: 2px solid white;
        border-radius: 50%;
    }

    .table thead th {
        background-color: #212529;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border: none;
    }
    
    .stat-badge {
        font-weight: 600;
        padding: 0.5em 1em;
        border-radius: 8px;
    }

    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>

<div class="container-fluid px-4 pb-5">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-4">
        <h3 class="fw-bold text-dark mb-0">
            <i class="bi bi-person-badge-fill me-2 text-primary"></i>Laporan Individu Murid
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Pentadbir</a></li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 main-card">
                <div class="card-body p-4">
                    
                    <div class="card border-0 shadow-none filter-section mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-info"><i class="bi bi-filter-right me-2"></i>TAPISAN DATA</h6>
                            <form method="GET" action="{{ route('pentadbir.laporanIndividu') }}" id="filterForm">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="kelas" class="form-label small fw-bold text-uppercase">Pilih Kelas</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-door-closed"></i></span>
                                            <select name="kelas" id="kelas" class="form-select border-start-0" required onchange="this.form.submit()">
                                                <option value="">-- Semua Kelas --</option>
                                                @if(is_array($classes) || $classes instanceof \Illuminate\Support\Collection)
                                                    @foreach($classes as $kelas)
                                                        <option value="{{ $kelas }}" {{ $selectedClass == $kelas ? 'selected' : '' }}>
                                                            {{ $kelas }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="murid" class="form-label small fw-bold text-uppercase">Pilih Murid</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                            <select name="murid" id="murid" class="form-select border-start-0" {{ !$selectedClass ? 'disabled' : '' }} onchange="this.form.submit()">
                                                <option value="">-- Cari Nama Murid --</option>
                                                @if(is_array($students) || $students instanceof \Illuminate\Support\Collection)
                                                    @foreach($students as $student)
                                                        <option value="{{ $student->MyKidID }}" {{ $selectedStudent && $selectedStudent->MyKidID == $student->MyKidID ? 'selected' : '' }}>
                                                            {{ $student->namaMurid }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($selectedClass && $selectedStudent)
                        <div class="row g-4">
                            <div class="col-xl-4 col-lg-5">
                                <div class="card h-100 shadow-sm border-0 info-section">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-4">
                                            <div class="profile-img-container mb-3">
                                                @if($selectedStudent->gambar_profil)
                                                    <img src="{{ asset('storage/' . $selectedStudent->gambar_profil) }}" class="rounded-circle border p-1" style="width: 120px; height: 120px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center border" style="width: 120px; height: 120px;">
                                                        <i class="bi bi-person-fill text-secondary" style="font-size: 3.5rem;"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <h5 class="fw-bold mb-1">{{ $selectedStudent->namaMurid }}</h5>
                                            <span class="badge bg-light text-dark border mb-3">ID: {{ $selectedStudent->MyKidID }}</span>
                                        </div>

                                        <div class="list-group list-group-flush mb-4">
                                            <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                                                <span class="text-muted small text-uppercase">Kelas</span>
                                                <span class="fw-bold text-primary">{{ $selectedStudent->kelas }}</span>
                                            </div>
                                            <div class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0 border-0">
                                                <span class="text-muted small text-uppercase">Status Kehadiran</span>
                                                @if($attendance)
                                                    @php
                                                        $statusClass = strtolower($attendance->status) == 'hadir' ? 'success' : (strtolower($attendance->status) == 'tidak hadir' ? 'danger' : 'warning');
                                                    @endphp
                                                    <span class="stat-badge bg-{{ $statusClass }} text-white small">
                                                        {{ strtoupper($attendance->status) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted italic">Tiada Rekod</span>
                                                @endif
                                            </div>
                                        </div>

                                        @if($attendance)
                                        <div class="alert alert-light border-0 mb-0 text-center">
                                            <small class="text-muted fw-bold">KEMASKINI TERAKHIR</small><br>
                                            <span class="text-dark">{{ \Carbon\Carbon::parse($attendance->tarikh)->format('d F Y') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow-sm border-0 chart-section mb-4">
                                    <div class="card-header bg-white py-3 border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box bg-primary-subtle text-primary rounded me-3 p-2">
                                                <i class="bi bi-graph-up-arrow fs-5"></i>
                                            </div>
                                            <h6 class="mb-0 fw-bold">Analisis Prestasi Penggal</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if($performanceData->isNotEmpty())
                                            <div style="height: 300px;">
                                                <canvas id="performanceChart"></canvas>
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.5;">
                                                <p class="mt-3 text-muted italic">Tiada data prestasi untuk dipaparkan.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($performanceData->isNotEmpty())
                                <div class="card shadow-sm border-0 border-top border-secondary border-4">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead>
                                                    <tr class="text-white">
                                                        <th class="text-center px-3" style="width: 80px;">#</th>
                                                        <th>Subjek</th>
                                                        <th class="text-center">P1</th>
                                                        <th class="text-center">P2</th>
                                                        <th class="text-center">Prestasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($performanceData as $index => $data)
                                                    <tr>
                                                        <td class="text-center text-muted">{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="fw-bold text-dark">{{ $data['subject'] }}</div>
                                                            <small class="text-muted text-uppercase" style="font-size: 0.65rem;">Rekod: {{ $data['details']['penggal1_count'] + $data['details']['penggal2_count'] }} sesi</small>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $data['penggal1'] }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $data['penggal2'] }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            @php $diff = $data['penggal2'] - $data['penggal1']; @endphp
                                                            @if($diff > 0)
                                                                <span class="text-success"><i class="bi bi-caret-up-fill"></i> +{{ number_format($diff, 1) }}</span>
                                                            @elseif($diff < 0)
                                                                <span class="text-danger"><i class="bi bi-caret-down-fill"></i> {{ number_format($diff, 1) }}</span>
                                                            @else
                                                                <span class="text-muted"><i class="bi bi-dash-lg"></i> 0</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-clipboard2-data text-light" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-muted">Sila pilih Kelas dan Murid untuk menjana laporan.</h5>
                            <p class="text-muted small">Data akan dipaparkan secara automatik selepas pilihan dibuat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($selectedClass && $selectedStudent && $performanceData->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart').getContext('2d');
    const performanceData = @json($performanceData);

    const labels = performanceData.map(item => item.subject.length > 12 ? item.subject.substring(0, 12) + '...' : item.subject);
    const penggal1Data = performanceData.map(item => parseFloat(item.penggal1));
    const penggal2Data = performanceData.map(item => parseFloat(item.penggal2));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penggal 1',
                data: penggal1Data,
                backgroundColor: 'rgba(13, 110, 253, 0.8)',
                borderRadius: 5,
                barThickness: 20
            }, {
                label: 'Penggal 2',
                data: penggal2Data,
                backgroundColor: 'rgba(25, 135, 84, 0.8)',
                borderRadius: 5,
                barThickness: 20
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 3,
                    grid: { drawBorder: false },
                    ticks: {
                        stepSize: 1,
                        callback: function(v) {
                            const labels = {1: 'Ansur Maju', 2: 'Maju', 3: 'Sangat Maju'};
                            return labels[v] || v;
                        }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endif
@endsection