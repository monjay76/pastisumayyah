@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i> Kemaskini Maklumat Guru
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pentadbir.updateGuru', ['id' => $guru->ID_Guru]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">ID Guru</label>
                            <input type="text" class="form-control" value="{{ $guru->ID_Guru }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Guru</label>
                            <input type="text" name="namaGuru" class="form-control" value="{{ old('namaGuru', $guru->namaGuru) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Emel</label>
                            <input type="email" name="emel" class="form-control" value="{{ old('emel', $guru->emel) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. Tel</label>
                            <input type="text" name="noTel" class="form-control" value="{{ old('noTel', $guru->noTel) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jawatan</label>
                            <input type="text" name="jawatan" class="form-control" value="{{ old('jawatan', $guru->jawatan) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tukar Kata Laluan (biarkan kosong jika tidak mahu tukar)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                            <a href="{{ route('pentadbir.maklumatGuru', ['guru' => $guru->ID_Guru]) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
