@extends('layouts.app')

@section('title', 'Maklumat Ibu Bapa')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-fill me-2"></i> Maklumat Ibu Bapa
                </div>
                <div class="card-body">
                    @if(!$selectedParent)
                        <h5>Senarai Ibu Bapa</h5>
                        @if($parents->count())
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID Parent</th>
                                        <th>Nama</th>
                                        <th>Emel</th>
                                        <th>No. Tel</th>
                                        <th>Maklum Balas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($parents as $index => $parent)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $parent->ID_Parent }}</td>
                                            <td>
                                                <a href="{{ route('pentadbir.maklumatIbuBapa', ['parent' => $parent->ID_Parent]) }}">{{ $parent->namaParent }}</a>
                                            </td>
                                            <td>{{ $parent->emel }}</td>
                                            <td>{{ $parent->noTel }}</td>
                                            <td>{{ $parent->maklumBalas ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted mb-0">Tiada ibu bapa didaftarkan lagi.</p>
                        @endif
                    @else
                        <div class="mb-3">
                            <a href="{{ route('pentadbir.maklumatIbuBapa') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Senarai Ibu Bapa
                            </a>
                        </div>
                        <h5>Maklumat Peribadi Ibu Bapa</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>ID Parent:</th>
                                        <td>{{ $selectedParent->ID_Parent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Parent:</th>
                                        <td>{{ $selectedParent->namaParent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Emel:</th>
                                        <td>{{ $selectedParent->emel }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Tel:</th>
                                        <td>{{ $selectedParent->noTel }}</td>
                                    </tr>
                                    <tr>
                                        <th>Maklum Balas:</th>
                                        <td>{{ $selectedParent->maklumBalas ?: '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h5 class="mt-4">Senarai Anak</h5>
                        @if($selectedParent->murid->count())
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
                                    @foreach($selectedParent->murid as $index => $murid)
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
                            <p class="text-muted mb-0">Tiada anak didaftarkan untuk ibu bapa ini.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
