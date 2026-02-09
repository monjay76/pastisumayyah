@extends('layouts.app')

@section('title', 'Kemaskini Murid')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('guru.senaraiMurid') }}" class="text-decoration-none text-muted">Senarai Murid</a></li>
                    <li class="breadcrumb-item active fw-bold" style="color: var(--pasti-green);">Edit Profil Murid</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0" style="color: var(--pasti-dark);">Kemaskini Maklumat Murid</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header p-4" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 me-3">
                            <i class="bi bi-pencil-square text-white fs-3"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 text-white fw-bold">Borang Kemaskini</h4>
                            <p class="text-white text-opacity-75 mb-0 small">Sila pastikan maklumat murid adalah tepat sebelum disimpan.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form method="POST" action="{{ route('guru.murid.update', $murid->MyKidID) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="MyKidID" class="form-label fw-bold text-muted small text-uppercase">MyKid ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-warning"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="MyKidID" name="MyKidID" value="{{ $murid->MyKidID }}" required>
                                </div>
                                @error('MyKidID')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="namaMurid" class="form-label fw-bold text-muted small text-uppercase">Nama Penuh Murid</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-warning"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0 text-uppercase" id="namaMurid" name="namaMurid" value="{{ $murid->namaMurid }}" required>
                                </div>
                                @error('namaMurid')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kelas" class="form-label fw-bold text-muted small text-uppercase">Kelas</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-door-open text-warning"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="kelas" name="kelas" value="{{ $murid->kelas }}">
                                </div>
                                @error('kelas')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tarikhLahir" class="form-label fw-bold text-muted small text-uppercase">Tarikh Lahir</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event text-warning"></i></span>
                                    <input type="date" class="form-control bg-light border-start-0 ps-0" id="tarikhLahir" name="tarikhLahir" value="{{ $murid->tarikhLahir ? date('Y-m-d', strtotime($murid->tarikhLahir)) : '' }}">
                                </div>
                                @error('tarikhLahir')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="alamat" class="form-label fw-bold text-muted small text-uppercase">Alamat Rumah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 align-items-start pt-2"><i class="bi bi-geo-alt text-warning"></i></span>
                                    <textarea class="form-control bg-light border-start-0 ps-0" id="alamat" name="alamat" rows="3">{{ $murid->alamat }}</textarea>
                                </div>
                                @error('alamat')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                            <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-light rounded-3 px-4 fw-bold">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white rounded-3 px-5 fw-bold shadow-sm transition-btn">
                                <i class="bi bi-check-circle me-2"></i>Kemas Kini Maklumat
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-shield-lock me-1"></i> Data peribadi murid dilindungi di bawah sistem SMART PASTI.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Input & Hover */
    .form-control:focus {
        background-color: #fff !important;
        border-color: #f59e0b !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.1) !important;
    }

    .input-group-text {
        border-color: #dee2e6;
    }

    .transition-btn {
        transition: all 0.3s ease;
    }

    .transition-btn:hover {
        transform: translateY(-2px);
        filter: brightness(95%);
        box-shadow: 0 5px 15px rgba(217, 119, 6, 0.3) !important;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: #6c757d;
    }
</style>
@endsection