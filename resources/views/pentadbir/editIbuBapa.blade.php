@extends('layouts.app')

@section('title', 'Edit Ibu Bapa')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i> Kemaskini Maklumat Ibu Bapa
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pentadbir.updateIbuBapa', ['id' => $parent->ID_Parent]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">ID Ibu Bapa</label>
                            <input type="text" class="form-control" value="{{ $parent->ID_Parent }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Ibu Bapa</label>
                            <input type="text" name="namaParent" class="form-control" value="{{ old('namaParent', $parent->namaParent) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Emel</label>
                            <input type="email" name="emel" class="form-control" value="{{ old('emel', $parent->emel) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Tel</label>
                            <input type="text" name="noTel" class="form-control" value="{{ old('noTel', $parent->noTel) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tukar Kata Laluan (biarkan kosong jika tidak mahu tukar)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="{{ route('pentadbir.maklumatIbuBapa', ['parent' => $parent->ID_Parent]) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
