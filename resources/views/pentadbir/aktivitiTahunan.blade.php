@extends('layouts.app')

@section('title', 'Aktiviti Tahunan')

@section('content')
<style>
    /* Custom Styling untuk impak visual lebih moden */
    .card-custom {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.12) !important;
    }
    .image-container {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    .image-container img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        transition: transform 0.5s ease;
    }
    .card-hover:hover .image-container img {
        transform: scale(1.1);
    }
    .month-badge {
        background: rgba(255, 255, 255, 0.2);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 card-custom">
                <div class="card-header bg-success bg-gradient text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-calendar-event-fill me-2"></i> 
                        Aktiviti Tahunan 
                        @if(isset($selectedMonth))
                            <span class="ms-2 opacity-75">|</span> 
                            <span class="ms-2 fw-normal">{{ $monthName }}</span>
                        @endif
                    </h5>
                    @if(isset($selectedMonth))
                        <span class="month-badge text-uppercase fw-bold">{{ $monthName }}</span>
                    @endif
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
                    @endif

                    @if(isset($selectedMonth))
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="text-secondary mb-0">Senarai Aktiviti / Gambar</h6>
                            <a href="{{ route('pentadbir.aktivitiTahunan') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                        @if($images->count())
                            <div class="row g-4">
                                @foreach($images as $image)
                                    <div class="col-xl-3 col-lg-4 col-md-6">
                                        <div class="card h-100 border-0 shadow-sm card-custom card-hover">
                                            <div class="image-container">
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="Aktiviti {{ $monthName }}">
                                            </div>
                                            <div class="card-body p-3 bg-light">
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="bi bi-calendar3 me-2"></i>
                                                    <span class="fw-semibold">Tarikh: {{ date('d/m/Y', strtotime($image->tarikh)) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-image text-light-emphasis display-1"></i>
                                <p class="text-muted mt-3">Tiada rekod gambar dijumpai untuk bulan ini.</p>
                            </div>
                        @endif

                    @else
                        <div class="row justify-content-center py-4">
                            <div class="col-md-5 text-center">
                                <div class="mb-4">
                                    <i class="bi bi-calendar-check text-success display-4"></i>
                                    <h4 class="mt-3 fw-bold">Semak Aktiviti</h4>
                                    <p class="text-muted">Sila pilih bulan untuk melihat koleksi gambar aktiviti.</p>
                                </div>
                                
                                <div class="card p-4 border-0 bg-white rounded-4 shadow-sm text-start" style="border: 2px solid #00843D;">
                                    <div class="mb-3">
                                        <label for="month" class="form-label fw-semibold text-success">Bulan</label>
                                        <select class="form-select border-0 shadow-sm p-3" id="month" required style="border-bottom: 2px solid #00843D !important;">
                                            <option value="">Pilih Bulan...</option>
                                            @php
                                                $months = [
                                                    'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun',
                                                    'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
                                                ];
                                            @endphp
                                            @foreach($months as $index => $month)
                                                <option value="{{ $index + 1 }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-success w-100 py-3 fw-bold rounded-3 shadow" onclick="selectMonth()">
                                        <i class="bi bi-search me-2"></i> Paparkan Aktiviti
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectMonth() {
    const month = document.getElementById('month').value;
    if (month) {
        window.location.href = '{{ url("pentadbir/aktiviti-tahunan") }}/' + month;
    } else {
        alert('Sila pilih bulan terlebih dahulu.');
    }
}
</script>
@endsection