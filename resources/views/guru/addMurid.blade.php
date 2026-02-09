@extends('layouts.app')

@section('title', 'Tambah Murid')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header py-3" style="background-color: var(--pasti-header); border: none;">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-3 me-3">
                            <i class="bi bi-person-plus-fill text-white fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0 text-white fw-bold">Borang Pendaftaran Murid Baru</h5>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5" style="background-color: #ffffff;">
                    <form method="POST" action="{{ route('guru.storeMurid') }}">
                        @csrf
                        
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <span class="badge rounded-pill me-2" style="background-color: var(--pasti-green); width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">1</span>
                                <h6 class="fw-bold mb-0" style="color: var(--pasti-dark);">Maklumat Peribadi Murid</h6>
                                <hr class="flex-grow-1 ms-3 opacity-10">
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="MyKidID" class="form-label fw-semibold small text-muted text-uppercase">MyKid ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-success"></i></span>
                                        <input type="text" class="form-control bg-light border-start-0 ps-0" id="MyKidID" name="MyKidID" placeholder="Contoh: 180101011234" required value="{{ old('MyKidID') }}">
                                    </div>
                                    @error('MyKidID')
                                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="namaMurid" class="form-label fw-semibold small text-muted text-uppercase">Nama Penuh Murid</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-success"></i></span>
                                        <input type="text" class="form-control bg-light border-start-0 ps-0" id="namaMurid" name="namaMurid" placeholder="Nama penuh mengikut MyKid" required value="{{ old('namaMurid') }}">
                                    </div>
                                    @error('namaMurid')
                                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="kelas" class="form-label fw-semibold small text-muted text-uppercase">Kelas</label>
                                    <input type="text" class="form-control bg-light" id="kelas" name="kelas" placeholder="Contoh: 5 Adnin" value="{{ old('kelas') }}">
                                    @error('kelas')
                                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="tarikhLahir" class="form-label fw-semibold small text-muted text-uppercase">Tarikh Lahir</label>
                                    <input type="date" class="form-control bg-light" id="tarikhLahir" name="tarikhLahir" value="{{ old('tarikhLahir') }}">
                                    @error('tarikhLahir')
                                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="alamat" class="form-label fw-semibold small text-muted text-uppercase">Alamat Rumah</label>
                                    <textarea class="form-control bg-light" id="alamat" name="alamat" rows="3" placeholder="Alamat surat-menyurat lengkap">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <span class="badge rounded-pill me-2" style="background-color: var(--pasti-green); width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">2</span>
                                <h6 class="fw-bold mb-0" style="color: var(--pasti-dark);">Maklumat Penjaga / Ibu Bapa</h6>
                                <hr class="flex-grow-1 ms-3 opacity-10">
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label fw-semibold small text-muted text-uppercase">Cari & Pilih Ibu Bapa</label>
                                <select class="form-select select2-tailwind" id="parent_id" name="parent_id" required>
                                    <option value="">-- Sila taip nama atau ID --</option>
                                    @foreach($listIbuBapa as $parent)
                                        <option value="{{ $parent->ID_Parent }}" {{ old('parent_id') == $parent->ID_Parent ? 'selected' : '' }}>
                                            {{ $parent->namaParent }} ({{ $parent->ID_Parent }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small mt-2"><i class="bi bi-info-circle me-1"></i> Pastikan maklumat ibu bapa telah didaftarkan terlebih dahulu dalam sistem.</div>
                                @error('parent_id')
                                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 border-top">
                            <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-link text-muted text-decoration-none mb-3 mb-md-0">
                                <i class="bi bi-arrow-left me-2"></i>Kembali ke Senarai
                            </a>
                            <button type="submit" class="btn px-5 py-2 fw-bold text-white rounded-3 shadow-sm" style="background-color: var(--pasti-green);">
                                <i class="bi bi-check-circle me-2"></i>Simpan Maklumat Murid
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling untuk Input & Select2 */
    .form-control, .form-select, .input-group-text {
        border: 1px solid #e2e8f0 !important;
        padding: 0.75rem 1rem;
        border-radius: 10px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--pasti-green) !important;
        box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1) !important;
        background-color: #fff !important;
    }

    /* Styling Khas Select2 Hijau */
    .select2-container--default .select2-selection--single {
        border: 1px solid #e2e8f0 !important;
        height: 52px !important;
        border-radius: 10px !important;
        background-color: #f8fafc !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #475569 !important;
        padding-left: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px !important;
        right: 10px !important;
    }
    .select2-dropdown {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2-tailwind').select2({
        placeholder: "Taip nama atau No. Kad Pengenalan...",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush