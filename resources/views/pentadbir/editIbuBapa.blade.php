@extends('layouts.app')

@section('title', 'Edit Ibu Bapa')

@section('content')
<style>
    /* Custom CSS untuk estetik borang */
    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        color: #6c757d;
    }
    .form-control {
        border-left: none;
    }
    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
        background-color: #fff;
    }
    .input-group:focus-within .input-group-text {
        border-color: #0d6efd;
        color: #0d6efd;
    }
    .input-group:focus-within .form-control {
        border-color: #0d6efd;
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
                    <li class="breadcrumb-item text-primary">Pentadbir</li>
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Ibu Bapa</a></li>
                    <li class="breadcrumb-item active">Kemaskini</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0 card-custom">
                <div class="card-header bg-primary bg-gradient text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-person-gear me-2"></i> Kemaskini Maklumat Ibu Bapa
                    </h5>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('pentadbir.updateIbuBapa', ['id' => $parent->ID_Parent]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">No. Kad Pengenalan / ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-vcard"></i></span>
                                    <input type="text" class="form-control bg-light" value="{{ $parent->ID_Parent }}" readonly>
                                </div>
                                <small class="text-muted small">ID ini adalah unik dan tidak boleh diubah.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Penuh</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="namaParent" class="form-control" value="{{ old('namaParent', $parent->namaParent) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Alamat Emel</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="emel" class="form-control" value="{{ old('emel', $parent->emel) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nombor Telefon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" name="noTel" class="form-control" value="{{ old('noTel', $parent->noTel) }}">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="p-4 rounded-4 bg-light border border-info border-opacity-25">
                                    <label class="form-label text-info">
                                        <i class="bi bi-key-fill me-1"></i> Keselamatan Akaun
                                    </label>
                                    <input type="password" name="password" class="form-control bg-white border-start" placeholder="Masukkan kata laluan baru jika ingin menukar">
                                    <p class="form-text text-muted mb-0 mt-2">
                                        <i class="bi bi-info-circle me-1"></i> Biarkan kosong jika anda ingin mengekalkan kata laluan sedia ada.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-5 pt-3 border-top">
                            <a href="{{ route('pentadbir.maklumatIbuBapa', ['parent' => $parent->ID_Parent]) }}" class="btn btn-outline-secondary px-4 rounded-pill">
                                Batal
                            </a>
                            <button class="btn btn-primary px-5 rounded-pill shadow" type="submit">
                                <i class="bi bi-check-lg me-1"></i> Simpan Maklumat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection