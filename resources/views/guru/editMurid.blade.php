@extends('layouts.app')

@section('title', 'Edit Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-warning text-white fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i> Edit Murid
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guru.murid.update', $murid->MyKidID) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="MyKidID" class="form-label">MyKid ID</label>
                                <input type="text" class="form-control" id="MyKidID" name="MyKidID" value="{{ $murid->MyKidID }}" readonly>
                                @error('MyKidID')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="namaMurid" class="form-label">Nama Murid</label>
                                <input type="text" class="form-control" id="namaMurid" name="namaMurid" value="{{ $murid->namaMurid }}" required>
                                @error('namaMurid')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $murid->kelas }}">
                                @error('kelas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tarikhLahir" class="form-label">Tarikh Lahir</label>
                                <input type="date" class="form-control" id="tarikhLahir" name="tarikhLahir" value="{{ $murid->tarikhLahir ? date('Y-m-d', strtotime($murid->tarikhLahir)) : '' }}">
                                @error('tarikhLahir')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $murid->alamat }}</textarea>
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Kemas Kini Murid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
