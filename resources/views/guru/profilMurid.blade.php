@extends('layouts.app')

@section('title', 'Profil Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-fill me-2"></i> Profil Murid
                </div>
                <div class="card-body">
                    @if(!isset($selectedClass) || !$selectedClass)
                        <h5>Pilih Kelas</h5>
                        <div class="row">
                            @foreach($classes as $class)
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('guru.profilMurid', ['kelas' => $class]) }}" class="btn btn-outline-primary w-100">
                                        {{ $class }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mb-3">
                            <a href="{{ route('guru.profilMurid') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali 
                            </a>
                        </div>
                        @if(!isset($selectedStudent) || !$selectedStudent)
                            <h5>Pilih Murid dari Kelas {{ $selectedClass }}</h5>
                            <div class="row">
                                @foreach($students as $student)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('guru.profilMurid', ['kelas' => $selectedClass, 'murid' => $student->MyKidID]) }}" class="card text-decoration-none">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $student->namaMurid }}</h6>
                                                <p class="card-text">MyKid ID: {{ $student->MyKidID }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <h5>Maklumat Peribadi Murid</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>MyKid ID:</th>
                                            <td>{{ $selectedStudent->MyKidID }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Murid:</th>
                                            <td>{{ $selectedStudent->namaMurid }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kelas:</th>
                                            <td>{{ $selectedStudent->kelas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tarikh Lahir:</th>
                                            <td>{{ $selectedStudent->tarikhLahir ? date('d/m/Y', strtotime($selectedStudent->tarikhLahir)) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat:</th>
                                            <td>{{ $selectedStudent->alamat }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
