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
                            @if($students->count())
                                <table class="table table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>MyKid ID</th>
                                            <th>Nama Murid</th>
                                            <th>Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $index => $student)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $student->MyKidID }}</td>
                                                <td>
                                                    <a href="{{ route('guru.profilMurid', ['kelas' => $selectedClass, 'murid' => $student->MyKidID]) }}">
                                                        {{ $student->namaMurid }}
                                                    </a>
                                                </td>
                                                <td>{{ $student->kelas }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted mb-0">Tiada murid didaftarkan lagi.</p>
                            @endif
                        @else
                            <h5>Maklumat Peribadi Murid</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <h6>Gambar Profil</h6>
                                        @if($selectedStudent->gambar_profil)
                                            <img src="{{ asset('storage/' . $selectedStudent->gambar_profil) }}" alt="Gambar Profil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                                                <i class="bi bi-person-fill text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                        @endif
                                        <form action="{{ route('guru.updateProfilePicture', $selectedStudent->MyKidID) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <input type="file" name="gambar_profil" class="form-control" accept="image/*" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Kemas Kini Gambar</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-8">
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
                                        <tr>
                                            <th>No. Telefon Ibu Bapa:</th>
                                            <td>
                                                @php
                                                    $phones = $selectedStudent->ibubapa->pluck('noTel')->filter()->unique()->toArray();
                                                @endphp
                                                {{ count($phones) ? implode(', ', $phones) : '-' }}
                                            </td>
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
