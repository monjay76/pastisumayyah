@extends('layouts.app')

@section('title', 'Edit Kehadiran')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-warning text-white fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i> Edit Kehadiran
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('guru.senaraiKehadiran', ['kelas' => $kelas, 'tarikh' => $tarikh]) }}" class="btn btn-secondary">Kembali</a>
                    </div>
                    <h5>Kelas: {{ $kelas }} | Tarikh: {{ date('d/m/Y', strtotime($tarikh)) }}</h5>
                    <form method="POST" action="{{ route('guru.storeKehadiran') }}">
                        @csrf
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                        <input type="hidden" name="tarikh" value="{{ $tarikh }}">
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
                                                <select name="status[{{ $m->MyKidID }}]" class="form-select">
                                                    <option value="hadir" {{ isset($kehadiran[$m->MyKidID]) && $kehadiran[$m->MyKidID]->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                    <option value="tidak_hadir" {{ isset($kehadiran[$m->MyKidID]) && $kehadiran[$m->MyKidID]->status == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Simpan Kehadiran</button>
                            </div>
                        @else
                            <p class="text-muted mb-0">Tiada murid dalam kelas ini.</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
