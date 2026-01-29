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
                    <!-- Kelas Filter -->
                    @if($kelasList->count() > 0)
                    <div class="mb-3" style="max-width: 300px;">
                        <form action="{{ route('pentadbir.senaraiMurid') }}" method="GET" class="d-flex gap-2">
                            <select class="form-select form-select-sm" name="kelas" onchange="this.form.submit();">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($kelasList as $kls)
                                    <option value="{{ $kls }}" {{ request()->input('kelas') == $kls ? 'selected' : '' }}>
                                        {{ $kls }}
                                    </option>
                                @endforeach
                            </select>
                            @if(request()->filled('kelas'))
                                <a href="{{ route('pentadbir.senaraiMurid') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                    @endif

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
