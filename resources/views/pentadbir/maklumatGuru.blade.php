@extends('layouts.app')

@section('title', 'Maklumat Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-fill me-2"></i> Maklumat Guru
                </div>
                <div class="card-body">
                    @if(!$selectedGuru)
                        <h5>Pilih Guru</h5>
                        @if($gurus->count())
                            <div class="row">
                                @foreach($gurus as $guru)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('pentadbir.maklumatGuru', ['guru' => $guru->ID_Guru]) }}" class="card text-decoration-none">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $guru->namaGuru }}</h6>
                                                <p class="card-text">Emel: {{ $guru->emel }}</p>
                                                <p class="card-text">No. Tel: {{ $guru->noTel }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Tiada guru didaftarkan lagi.</p>
                        @endif
                    @else
                        <div class="mb-3">
                            <a href="{{ route('pentadbir.maklumatGuru') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Senarai Guru
                            </a>
                        </div>
                        <h5>Maklumat Peribadi Guru</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>ID Guru:</th>
                                        <td>{{ $selectedGuru->ID_Guru }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Guru:</th>
                                        <td>{{ $selectedGuru->namaGuru }}</td>
                                    </tr>
                                    <tr>
                                        <th>Emel:</th>
                                        <td>{{ $selectedGuru->emel }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Tel:</th>
                                        <td>{{ $selectedGuru->noTel }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jawatan:</th>
                                        <td>{{ $selectedGuru->jawatan }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
