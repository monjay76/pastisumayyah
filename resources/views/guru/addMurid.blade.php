@extends('layouts.app')

@section('title', 'Tambah Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Murid Baru
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guru.storeMurid') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="MyKidID" class="form-label">MyKid ID</label>
                                <input type="text" class="form-control" id="MyKidID" name="MyKidID" required>
                                @error('MyKidID')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="namaMurid" class="form-label">Nama Murid</label>
                                <input type="text" class="form-control" id="namaMurid" name="namaMurid" required>
                                @error('namaMurid')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Tanpa jarak">
                                @error('kelas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tarikhLahir" class="form-label">Tarikh Lahir</label>
                                <input type="date" class="form-control" id="tarikhLahir" name="tarikhLahir">
                                @error('tarikhLahir')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Maklumat Penjaga / Ibu Bapa</h6>
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Pilih Ibu Bapa (Satu sahaja)</label>
                                <select class="form-select select2-tailwind" id="parent_id" name="parent_id" required>
                                    <option value="">-- Pilih Ibu Bapa --</option>
                                    @foreach($listIbuBapa as $parent)
                                        <option value="{{ $parent->ID_Parent }}">
                                            {{ $parent->namaParent }} ({{ $parent->ID_Parent }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Tambah Murid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling untuk Select2 supaya sepadan dengan Tailwind/Bootstrap 5 */
    .select2-container--default .select2-selection--single {
        border: 1px solid #dee2e6 !important;
        height: calc(3.5rem + 2px) !important; /* Menyamakan tinggi dengan input lain */
        padding: 0.375rem 0.75rem !important;
        border-radius: 0.375rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 2.5 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px !important;
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
        placeholder: "Cari nama atau ID ibu bapa...",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush