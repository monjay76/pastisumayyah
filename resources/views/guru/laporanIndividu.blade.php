@extends('layouts.app')

@section('title', 'Laporan Individu Murid - Guru')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-person-lines-fill me-2 fs-4"></i>
                        <span>Laporan Individu Murid</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row justify-content-center mb-4">
                        <div class="col-lg-10">
                            <div class="card border-0 bg-light rounded-4">
                                <div class="card-body p-4">
                                    <form method="GET" action="{{ route('guru.laporanIndividu') }}" id="filterForm">
                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-5">
                                                <label for="kelas" class="form-label fw-bold text-secondary small text-uppercase">Pilih Kelas</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-door-open text-primary"></i></span>
                                                    <select name="kelas" id="kelas" class="form-select border-start-0 ps-0" required onchange="this.form.submit()">
                                                        <option value="">-- Pilih Kelas --</option>
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

                                            <div class="col-md-5">
                                                <label for="murid" class="form-label fw-bold text-secondary small text-uppercase">Pilih Murid</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-primary"></i></span>
                                                    <select name="murid" id="murid" class="form-select border-start-0 ps-0" {{ !$selectedClass ? 'disabled' : '' }} onchange="this.form.submit()">
                                                        <option value="">-- Pilih Murid --</option>
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
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">
                                                    <i class="bi bi-search me-1"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($selectedClass && $selectedStudent)
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <div class="card shadow-sm border-0 rounded-4 h-100">
                                    <div class="card-header bg-success bg-gradient text-white fw-semibold py-3 text-center rounded-top-4">
                                        <i class="bi bi-person-badge me-2"></i>Profil Pelajar
                                    </div>
                                    <div class="card-body text-center p-4">
                                        <div class="position-relative d-inline-block mb-3">
                                            @if($selectedStudent->gambar_profil)
                                                <img src="{{ asset('storage/' . $selectedStudent->gambar_profil) }}" alt="Profile" class="rounded-circle shadow-sm border border-4 border-white" style="width: 120px; height: 120px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm border border-4 border-white" style="width: 120px; height: 120px;">
                                                    <i class="bi bi-person-fill text-secondary" style="font-size: 3.5rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <h4 class="fw-bold mb-1">{{ $selectedStudent->namaMurid }}</h4>
                                        <p class="text-muted small mb-3">ID: {{ $selectedStudent->MyKidID }} • Kelas: {{ $selectedStudent->kelas }}</p>

                                        <div class="bg-light rounded-4 p-3 mb-4">
                                            <h6 class="small fw-bold text-uppercase text-muted mb-2">Kehadiran Terkini</h6>
                                            @if($attendance)
                                                @php
                                                    $statusClasses = [
                                                        'hadir' => 'bg-success',
                                                        'tidak hadir' => 'bg-danger',
                                                        'cuti' => 'bg-warning text-dark'
                                                    ];
                                                    $statusLabel = strtolower($attendance->status);
                                                    $badgeClass = $statusClasses[$statusLabel] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }} rounded-pill px-4 py-2 fs-6 mb-2">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                                <p class="text-muted small mb-0">
                                                    <i class="bi bi-clock me-1"></i>{{ $attendance->tarikh ? \Carbon\Carbon::parse($attendance->tarikh)->format('d M Y') : 'N/A' }}
                                                </p>
                                            @else
                                                <span class="text-muted">Tiada rekod</span>
                                            @endif
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="p-2 border rounded-3 bg-white">
                                                    <h3 class="mb-0 fw-bold text-primary">{{ $performanceData->count() }}</h3>
                                                    <small class="text-muted">Subjek</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-2 border rounded-3 bg-white">
                                                    <h3 class="mb-0 fw-bold text-success">
                                                        {{ $performanceData->where('details.penggal2_count', '>', 0)->count() }}
                                                    </h3>
                                                    <small class="text-muted">Dinilai</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="card shadow-sm border-0 rounded-4 mb-4">
                                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <i class="bi bi-bar-chart-fill me-2 text-primary"></i>Analisis Prestasi Penggal
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @if($performanceData->isNotEmpty())
                                            <div style="min-height: 300px;">
                                                <canvas id="performanceChart"></canvas>
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="No data" style="width: 80px; opacity: 0.5;">
                                                <p class="mt-3 text-muted">Tiada data prestasi untuk murid ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($performanceData->isNotEmpty())
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-white border-0 py-3">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <i class="bi bi-list-stars me-2 text-primary"></i>Butiran Pencapaian Subjek
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="ps-4" style="width: 40%;">Subjek</th>
                                                        <th class="text-center">Penggal 1</th>
                                                        <th class="text-center">Penggal 2</th>
                                                        <th class="text-center">Prestasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($performanceData as $data)
                                                    <tr>
                                                        <td class="ps-4">
                                                            <div class="fw-bold text-dark">{{ $data['subject'] }}</div>
                                                            <small class="text-muted">ID: {{ $loop->iteration }}</small>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($data['details']['penggal1_count'] > 0)
                                                                <span class="badge bg-soft-primary text-primary px-3 rounded-pill">{{ $data['penggal1'] }}</span>
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($data['details']['penggal2_count'] > 0)
                                                                <span class="badge bg-soft-success text-success px-3 rounded-pill">{{ $data['penggal2'] }}</span>
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @php $diff = $data['penggal2'] - $data['penggal1']; @endphp
                                                            @if($data['details']['penggal1_count'] > 0 && $data['details']['penggal2_count'] > 0)
                                                                @if($diff > 0)
                                                                    <div class="text-success fw-bold small"><i class="bi bi-graph-up-arrow me-1"></i>+{{ number_format($diff, 1) }}</div>
                                                                @elseif($diff < 0)
                                                                    <div class="text-danger fw-bold small"><i class="bi bi-graph-down-arrow me-1"></i>{{ number_format($diff, 1) }}</div>
                                                                @else
                                                                    <div class="text-secondary small"><i class="bi bi-dash-lg"></i></div>
                                                                @endif
                                                            @else
                                                                <span class="text-muted small">N/A</span>
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
                        <div class="text-center py-5 mt-4">
                            <div class="mb-3">
                                <i class="bi bi-folder2-open text-light-emphasis" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-muted">Sila pilih kelas dan murid untuk melihat laporan.</h5>
                            <p class="text-secondary small">Data prestasi dan kehadiran akan dipaparkan secara automatik.</p>
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

    const labels = performanceData.map(item => item.subject.length > 15 ? item.subject.substring(0, 15) + '...' : item.subject);
    const penggal1Data = performanceData.map(item => parseFloat(item.penggal1));
    const penggal2Data = performanceData.map(item => parseFloat(item.penggal2));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penggal 1',
                data: penggal1Data,
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 2,
                borderRadius: 5,
            }, {
                label: 'Penggal 2',
                data: penggal2Data,
                backgroundColor: 'rgba(25, 135, 84, 0.8)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 2,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 3,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            const labels = {1: 'Ansur Maju', 2: 'Maju', 3: 'Sangat Maju'};
                            return labels[value] || value;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endif

<style>
    /* Custom Color Utilities */
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    
    /* Layout Improvements */
    .form-select, .input-group-text {
        padding: 0.6rem 1rem;
        border-color: #e9ecef;
    }
    
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.05);
    }

    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
        border-top: none;
    }

    .card { transition: all 0.3s ease; }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .col-md-5, .col-md-2 { margin-bottom: 10px; }
    }
</style>
@endsection