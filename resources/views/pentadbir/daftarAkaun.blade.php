@extends('layouts.app')

@section('title', 'Pendaftaran Akaun')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Pendaftaran Akaun Pengguna
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('pentadbir.storeUser') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Penuh</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Nur Aisyah Binti Ali" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Emel</label>
                                <input type="email" name="email" class="form-control" placeholder="Contoh: aisyah@gmail.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kata Laluan</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Peranan</label>
                                <select name="role" class="form-select" required>
                                    <option value="">-- Pilih Peranan --</option>
                                    <option value="guru">Guru</option>
                                    <option value="ibubapa">Ibu Bapa</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save2 me-1"></i> Daftar Akaun
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Senarai akaun yang telah didaftarkan (optional) --}}
            <div class="card mt-4 shadow-sm border-0 rounded-4">
                <div class="card-header bg-light fw-semibold">
                    <i class="bi bi-people-fill me-2 text-success"></i> Senarai Akaun Pengguna
                </div>
                <div class="card-body">
                    @if($users->count())
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Emel</th>
                                    <th>Peranan</th>
                                    <th>Tarikh Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-capitalize">{{ $user->role }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">Tiada akaun didaftarkan lagi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
