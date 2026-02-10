@extends('layouts.app')

@section('title', 'Aktiviti Tahunan')

@section('content')
<style>
    /* Galeri & Kad Styling */
    .activity-card { transition: all 0.3s ease; border-radius: 15px; overflow: hidden; }
    .activity-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    
    .month-grid-item {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.2s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    .month-grid-item:hover {
        background: #f0fdf4;
        border-color: #4CAF50;
        color: #2E7D32;
    }
    .month-icon {
        font-size: 1.5rem;
        margin-bottom: 8px;
        color: #4CAF50;
    }
    .img-wrapper {
        height: 200px;
        overflow: hidden;
        background: #f8f9fa;
    }
    .img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    .activity-card:hover .img-wrapper img { transform: scale(1.1); }
    
    .back-btn { border-radius: 10px; padding: 8px 20px; }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0">
                    <span class="text-primary"><i class="bi bi-calendar-event-fill me-2"></i></span> 
                    Aktiviti Tahunan @if(isset($selectedMonth)) <span class="text-muted fs-5">| {{ $monthName }}</span> @endif
                </h4>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    
                    @if(isset($selectedMonth))
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-semibold mb-0">Koleksi Gambar {{ $monthName }}</h5>
                            <a href="{{ route('ibubapa.aktivitiTahunan') }}" class="btn btn-outline-secondary back-btn btn-sm">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                        @if($images->count())
                            <div class="row">
                                @foreach($images as $image)
                                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                        <div class="card h-100 border-0 shadow-sm activity-card">
                                            <div class="img-wrapper">
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="Aktiviti {{ $monthName }}">
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center text-muted small">
                                                    <i class="bi bi-calendar3 me-2 text-primary"></i>
                                                    Tarikh: {{ date('d/m/Y', strtotime($image->tarikh)) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-images text-light" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3">Tiada gambar aktiviti direkodkan untuk bulan {{ $monthName }}.</p>
                            </div>
                        @endif

                    @else
                        <div class="alert alert-success border-0 rounded-3 mb-4">
                            <i class="bi bi-info-circle-fill me-2"></i> Sila pilih bulan untuk melihat koleksi gambar aktiviti pelajar.
                        </div>

                        <div class="row g-3">
                            @php
                                $months = [
                                    'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun',
                                    'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
                                ];
                            @endphp
                            
                            @foreach($months as $index => $month)
                                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                    <div class="month-grid-item shadow-sm" onclick="goToMonth({{ $index + 1 }})">
                                        <div class="month-icon">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                        <span class="fw-bold">{{ $month }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 d-none">
                            <select class="form-select" id="month">
                                <option value="">Pilih Bulan</option>
                                @foreach($months as $index => $month)
                                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi asal diperkukuhkan dengan navigasi terus
function selectMonth() {
    const month = document.getElementById('month').value;
    if (month) {
        window.location.href = '{{ url("ibubapa/aktiviti-tahunan") }}/' + month;
    } else {
        alert('Sila pilih bulan terlebih dahulu.');
    }
}

// Fungsi tambahan untuk klik pada grid (Lebih moden)
function goToMonth(monthValue) {
    window.location.href = '{{ url("ibubapa/aktiviti-tahunan") }}/' + monthValue;
}
</script>
@endsection