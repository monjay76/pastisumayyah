@extends('layouts.app')

@section('title', 'Laporan Individu Murid - Pentadbir')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>Laporan Individu Murid
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Selection Section -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-header bg-info text-white fw-semibold">
                            <i class="bi bi-filter me-2"></i> Pilih Kelas dan Murid
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('pentadbir.laporanIndividu') }}" id="filterForm">
                                <div class="row g-3">
                                    <!-- Select Class -->
                                    <div class="col-md-6">
                                        <label for="kelas" class="form-label fw-semibold">Pilih Kelas</label>
                                        <select name="kelas" id="kelas" class="form-select" required onchange="this.form.submit()">
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

                                    <!-- Select Student -->
                                    <div class="col-md-6">
                                        <label for="murid" class="form-label fw-semibold">Pilih Murid</label>
                                        <select name="murid" id="murid" class="form-select" {{ !$selectedClass ? 'disabled' : '' }} onchange="this.form.submit()">
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
                            </form>

                            @if($selectedClass && $selectedStudent)
                                <div class="alert alert-info mt-3 mb-0">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Dipilih:</strong> Kelas {{ $selectedClass }} | {{ $selectedStudent->namaMurid }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($selectedClass && $selectedStudent)
                        <!-- Student Report Section -->
                        <div class="row">
                            <!-- Student Info and Attendance -->
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 rounded-4 mb-4">
                                    <div class="card-header bg-success text-white fw-semibold">
                                        <i class="bi bi-person-circle me-2"></i>Maklumat Murid
                                    </div>
                                    <div class="card-body text-center">
                                        @if($selectedStudent->gambar_profil)
                                            <img src="{{ asset('storage/' . $selectedStudent->gambar_profil) }}" alt="Profile Picture" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                                <i class="bi bi-person-fill text-secondary" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                        <h5 class="mb-1">{{ $selectedStudent->namaMurid }}</h5>
                                        <p class="text-muted mb-1">MyKid ID: {{ $selectedStudent->MyKidID }}</p>
                                        <p class="text-muted mb-3">Kelas: {{ $selectedStudent->kelas }}</p>

                                        <!-- Attendance Status -->
                                        <div class="border rounded p-3 mb-0">
                                            <h6 class="mb-2">
                                                <i class="bi bi-calendar-check me-2"></i>Status Kehadiran Terkini
                                            </h6>
                                            @if($attendance)
                                                <div class="d-flex align-items-center justify-content-center mb-2">
                                                    @if(strtolower($attendance->status) == 'hadir')
                                                        <span class="badge bg-success fs-6 px-3 py-2">
                                                            <i class="bi bi-check-circle-fill me-1"></i>Hadir
                                                        </span>
                                                    @elseif(strtolower($attendance->status) == 'tidak hadir')
                                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Tidak Hadir
                                                        </span>
                                                    @elseif(strtolower($attendance->status) == 'cuti')
                                                        <span class="badge bg-warning fs-6 px-3 py-2">
                                                            <i class="bi bi-calendar-x me-1"></i>Cuti
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                                            {{ $attendance->status }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">
                                                    Tarikh: {{ $attendance->tarikh ? \Carbon\Carbon::parse($attendance->tarikh)->format('d/m/Y') : 'N/A' }}
                                                </small>
                                            @else
                                                <div class="text-muted">
                                                    <i class="bi bi-dash-circle me-1"></i>Tiada rekod kehadiran
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Performance Chart -->
                            <div class="col-md-8">
                                <div class="card shadow-sm border-0 rounded-4 mb-4">
                                    <div class="card-header bg-primary text-white fw-semibold">
                                        <i class="bi bi-bar-chart me-2"></i>Perbandingan Markah Penggal 1 vs Penggal 2
                                    </div>
                                    <div class="card-body">
                                        @if($performanceData->isNotEmpty())
                                            <canvas id="performanceChart" width="400" height="200"></canvas>
                                            <div class="mt-3">
                                                <small class="text-muted">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Graf menunjukkan purata markah bagi setiap subjek
                                                </small>
                                            </div>
                                        @else
                                            <div class="text-center text-muted py-5">
                                                <i class="bi bi-graph-up" style="font-size: 3rem;"></i>
                                                <p class="mt-3">Tiada data prestasi dijumpai untuk murid ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Detailed Performance Table -->
                                @if($performanceData->isNotEmpty())
                                <div class="card shadow-sm border-0 rounded-4">
                                    <div class="card-header bg-secondary text-white fw-semibold">
                                        <i class="bi bi-table me-2"></i>Butiran Prestasi
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover align-middle">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="text-center" style="width: 5%;">No.</th>
                                                        <th style="width: 40%;">Subjek</th>
                                                        <th class="text-center" style="width: 15%;">Penggal 1</th>
                                                        <th class="text-center" style="width: 15%;">Penggal 2</th>
                                                        <th class="text-center" style="width: 15%;">Perbezaan</th>
                                                        <th class="text-center" style="width: 10%;">Trend</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($performanceData as $index => $data)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td class="fw-semibold">{{ $data['subject'] }}</td>
                                                        <td class="text-center">
                                                            @if($data['details']['penggal1_count'] > 0)
                                                                <span class="badge bg-primary">{{ $data['penggal1'] }}</span>
                                                                <br><small class="text-muted">({{ $data['details']['penggal1_count'] }} rekod)</small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($data['details']['penggal2_count'] > 0)
                                                                <span class="badge bg-info">{{ $data['penggal2'] }}</span>
                                                                <br><small class="text-muted">({{ $data['details']['penggal2_count'] }} rekod)</small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $diff = $data['penggal2'] - $data['penggal1'];
                                                            @endphp
                                                            @if($data['details']['penggal1_count'] > 0 && $data['details']['penggal2_count'] > 0)
                                                                <span class="badge {{ $diff > 0 ? 'bg-success' : ($diff < 0 ? 'bg-danger' : 'bg-secondary') }}">
                                                                    {{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 1) }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($data['details']['penggal1_count'] > 0 && $data['details']['penggal2_count'] > 0)
                                                                @if($diff > 0)
                                                                    <i class="bi bi-arrow-up-circle-fill text-success" title="Meningkat"></i>
                                                                @elseif($diff < 0)
                                                                    <i class="bi bi-arrow-down-circle-fill text-danger" title="Menurun"></i>
                                                                @else
                                                                    <i class="bi bi-dash-circle-fill text-secondary" title="Tidak berubah"></i>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">-</span>
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
                        <!-- Information Box -->
                        <div class="card shadow-sm border-0 rounded-4 mb-4">
                            <div class="card-body text-center text-muted py-5">
                                <i class="bi bi-info-circle" style="font-size: 3rem;"></i>
                                <p class="mt-3">Sila pilih kelas dan murid untuk melihat laporan individu.</p>
                            </div>
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
                backgroundColor: 'rgba(13, 110, 253, 0.7)',
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1
            }, {
                label: 'Penggal 2',
                data: penggal2Data,
                backgroundColor: 'rgba(25, 135, 84, 0.7)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 3,
                    ticks: {
                        stepSize: 0.5,
                        callback: function(value) {
                            if (value === 1) return 'Ansur Maju (1)';
                            if (value === 2) return 'Maju (2)';
                            if (value === 3) return 'Sangat Maju (3)';
                            return value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y;
                            if (context.parsed.y === 1) label += ' (Ansur Maju)';
                            else if (context.parsed.y === 2) label += ' (Maju)';
                            else if (context.parsed.y === 3) label += ' (Sangat Maju)';
                            return label;
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
.table th {
    background-color: #343a40;
    color: white;
    font-weight: 600;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.8rem;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
