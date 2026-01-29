@extends('layouts.app')

@section('title', 'Senarai Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-people-fill me-2"></i> Senarai Murid
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('guru.addMurid') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus me-1"></i>Tambah Murid
                        </a>
                    </div>

                    <!-- Kelas Filter -->
                    @if($kelasList->count() > 0)
                    <div class="mb-3" style="max-width: 300px;">
                        <form action="{{ route('guru.senaraiMurid') }}" method="GET" class="d-flex gap-2">
                            <select class="form-select form-select-sm" name="kelas" onchange="this.form.submit();">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($kelasList as $kls)
                                    <option value="{{ $kls }}" {{ request()->input('kelas') == $kls ? 'selected' : '' }}>
                                        {{ $kls }}
                                    </option>
                                @endforeach
                            </select>
                            @if(request()->filled('kelas'))
                                <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('guru.bulkAction') }}">
                        @csrf
                        @if($murid->count())
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>MyKid ID</th>
                                        <th>Nama Murid</th>
                                        <th>Kelas</th>
                                        <th>Tarikh Lahir</th>
                                        <th>Alamat</th>
                                        <th>Pilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($murid as $index => $m)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $m->MyKidID }}</td>
                                            <td>{{ $m->namaMurid }}</td>
                                            <td>{{ $m->kelas }}</td>
                                            <td>{{ $m->tarikhLahir ? date('d/m/Y', strtotime($m->tarikhLahir)) : '-' }}</td>
                                            <td>{{ $m->alamat }}</td>
                                            <td><input type="checkbox" name="selected_murid[]" value="{{ $m->MyKidID }}"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <button type="submit" name="action" value="edit" class="btn btn-warning">Edit </button>
                                <button type="submit" name="action" value="delete" class="btn btn-danger">Padam </button>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Tiada murid didaftarkan lagi.</strong><br>
                                Klik butang "Tambah Murid" di atas untuk mula mendaftarkan murid baru.
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
