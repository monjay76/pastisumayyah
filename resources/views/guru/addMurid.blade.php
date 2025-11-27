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
                                <input type="text" class="form-control" id="kelas" name="kelas">
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
@endsection
