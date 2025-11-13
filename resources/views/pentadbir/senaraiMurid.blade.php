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
                    @if($murids->count())
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>MyKid ID</th>
                                    <th>Nama Murid</th>
                                    <th>Kelas</th>
                                    <th>Tarikh Lahir</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($murids as $index => $murid)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $murid->MyKidID }}</td>
                                        <td>{{ $murid->namaMurid }}</td>
                                        <td>{{ $murid->kelas }}</td>
                                        <td>{{ $murid->tarikhLahir ? date('d/m/Y', strtotime($murid->tarikhLahir)) : '-' }}</td>
                                        <td>{{ $murid->alamat }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">Tiada murid didaftarkan lagi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
