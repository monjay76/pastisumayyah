@extends('layouts.app')

@section('title', 'Senarai Kehadiran')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-calendar-check me-2"></i> Senarai Kehadiran
                </div>
                <div class="card-body">
                    @if(!isset($kelas) || !isset($tarikh))
                        <form method="GET" action="{{ route('guru.senaraiKehadiran') }}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="kelas" class="form-label">Pilih Kelas</label>
                                    <select name="kelas" id="kelas" class="form-select" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class }}" {{ request('kelas') == $class ? 'selected' : '' }}>{{ $class }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tarikh" class="form-label">Pilih Tarikh</label>
                                    <input type="date" name="tarikh" id="tarikh" class="form-control" value="{{ request('tarikh') }}" required>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Papar Kehadiran</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="mb-3">
                            <a href="{{ route('guru.senaraiKehadiran') }}" class="btn btn-secondary">Kembali</a>
                            <a href="{{ route('guru.editKehadiran', ['kelas' => $kelas, 'tarikh' => $tarikh]) }}" class="btn btn-warning">Edit Kehadiran</a>
                        </div>
                        <h5>Kelas: {{ $kelas }} | Tarikh: {{ date('d/m/Y', strtotime($tarikh)) }}</h5>
                        @if($murid->count())
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>MyKid ID</th>
                                        <th>Nama Murid</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($murid as $index => $m)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $m->MyKidID }}</td>
                                            <td>{{ $m->namaMurid }}</td>
                                            <td>
                                                @if(isset($kehadiran[$m->MyKidID]))
                                                    @if($kehadiran[$m->MyKidID]->status == 'hadir')
                                                        <span class="badge bg-success">Hadir</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Hadir</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Belum Direkod</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted mb-0">Tiada murid dalam kelas ini.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
