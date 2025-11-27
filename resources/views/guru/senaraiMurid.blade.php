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
                                <a href="{{ route('guru.addMurid') }}" class="btn btn-primary">Tambah Murid</a>
                                <button type="submit" name="action" value="edit" class="btn btn-warning">Edit </button>
                                <button type="submit" name="action" value="delete" class="btn btn-danger">Padam </button>
                            </div>
                        @else
                            <p class="text-muted mb-0">Tiada murid didaftarkan lagi.</p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
