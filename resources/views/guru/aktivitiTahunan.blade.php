@extends('layouts.app')

@section('title', 'Aktiviti Tahunan')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-muted">Aktiviti Tahunan</li>
                    <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: var(--pasti-green);">Pilih Bulan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header p-4" style="background: linear-gradient(135deg, var(--pasti-dark) 0%, var(--pasti-green) 100%); border: none;">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 me-3">
                            <i class="bi bi-calendar-range text-white fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-white fw-bold">Pengurusan Aktiviti Tahunan</h4>
                            <p class="text-white text-opacity-75 mb-0 small">Sila pilih bulan untuk melihat galeri aktiviti murid.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5 bg-white">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-8">
                            
                            <div class="mb-4">
                                <label for="month" class="form-label fw-bold text-muted small text-uppercase mb-2">Pilih Bulan</label>
                                <div class="input-group input-group-lg shadow-sm">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-calendar3 text-success"></i>
                                    </span>
                                    <select class="form-select bg-light border-start-0 ps-0" id="month" required style="font-size: 1rem; height: 55px; cursor: pointer;">
                                        <option value="" disabled selected>Pilih Bulan Aktiviti...</option>
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
                            </div>

                            <div class="d-grid gap-2 pt-2">
                                <button type="button" class="btn btn-lg fw-bold text-white rounded-3 shadow-sm py-3 transition-btn" 
                                        style="background-color: var(--pasti-green); border: none;"
                                        onclick="selectMonth()">
                                    <i class="bi bi-search me-2"></i> Papar Aktiviti
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light border-0 py-3 text-center">
                    <span class="text-muted small">
                        <i class="bi bi-info-circle-fill me-1 text-success"></i> 
                        Sistem akan memaparkan semua gambar aktiviti yang dimuat naik mengikut bulan tersebut.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling untuk elemen tambahan */
    .transition-btn {
        transition: all 0.3s ease;
    }

    .transition-btn:hover {
        background-color: var(--pasti-dark) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 132, 61, 0.3) !important;
    }

    .form-select:focus {
        border-color: var(--pasti-green);
        box-shadow: none;
        background-color: #fff !important;
    }

    .input-group:focus-within {
        ring: 2px solid var(--pasti-green);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #6c757d;
    }
</style>

<script>
function selectMonth() {
    const month = document.getElementById('month').value;
    if (month) {
        window.location.href = '{{ url("guru/aktiviti-tahunan") }}/' + month;
    } else {
        alert('Sila pilih bulan terlebih dahulu.');
    }
}
</script>
@endsection