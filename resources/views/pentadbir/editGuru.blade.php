@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<style>
    /* Menyelaraskan gaya input dan card */
    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    .input-group-text {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    .card-custom {
        border-radius: 15px;
        overflow: hidden;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Guru</a></li>
                    <li class="breadcrumb-item active">Kemaskini Profil</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0 card-custom">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Kemaskini Maklumat Guru
                    </h5>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('pentadbir.updateGuru', ['id' => $guru->ID_Guru]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">ID Guru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="text" class="form-control bg-light" value="{{ $guru->ID_Guru }}" readonly>
                                </div>
                                <small class="text-muted text-xs">* ID tidak boleh diubah</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Guru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="namaGuru" class="form-control" value="{{ old('namaGuru', $guru->namaGuru) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Alamat Emel</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="emel" class="form-control" value="{{ old('emel', $guru->emel) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nombor Telefon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="noTel" class="form-control" value="{{ old('noTel', $guru->noTel) }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Jawatan / Gred</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" name="jawatan" class="form-control" value="{{ old('jawatan', $guru->jawatan) }}" placeholder="Contoh: Guru Penolong Kanan">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-50">
                                    <label class="form-label mb-1">
                                        <i class="bi bi-shield-lock me-1"></i> Tukar Kata Laluan
                                    </label>
                                    <input type="password" name="password" class="form-control bg-white" placeholder="Biarkan kosong jika tidak mahu tukar">
                                    <div class="form-text mt-2 text-warning">
                                        <i class="bi bi-exclamation-triangle me-1"></i> Pastikan anda mencatat kata laluan baru jika ada perubahan.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-5 pt-3 border-top">
                            <a href="{{ route('pentadbir.maklumatGuru', ['guru' => $guru->ID_Guru]) }}" class="btn btn-light px-4 rounded-pill border">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <button class="btn btn-primary px-5 rounded-pill shadow-sm" type="submit">
                                <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection