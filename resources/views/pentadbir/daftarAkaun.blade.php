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

                    @if(!request('role'))
                        <h5>Pilih Peranan</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('pentadbir.createUser', ['role' => 'guru']) }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-person-badge me-2"></i> Guru
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="{{ route('pentadbir.createUser', ['role' => 'ibubapa']) }}" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-house-heart me-2"></i> Ibu Bapa
                                </a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('pentadbir.createUser') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    @else
                        <div class="mb-3">
                            <a href="{{ route('pentadbir.createUser') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Pilih Peranan Lain
                            </a>
                        </div>

                        <form action="{{ route('pentadbir.storeUser') }}" method="POST">
                            @csrf
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <div class="row g-3">
                                @if(request('role') === 'guru')
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Guru</label>
                                        <input type="text" name="namaGuru" class="form-control" placeholder="Contoh: Nur Aisyah Binti Ali" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jawatan</label>
                                        <input type="text" name="jawatan" class="form-control" placeholder="Contoh: Guru Bahasa Melayu" required>
                                    </div>
                                @elseif(request('role') === 'ibubapa')
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Ibu Bapa</label>
                                        <input type="text" name="namaParent" class="form-control" placeholder="Contoh: Nur Aisyah Binti Ali" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Maklum Balas (Opsional)</label>
                                        <textarea name="maklumBalas" class="form-control" rows="2" placeholder="Sebarang maklum balas"></textarea>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label">Emel</label>
                                    <input type="email" name="email" class="form-control" placeholder="Contoh: aisyah@gmail.com" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. Tel</label>
                                    <input type="text" name="noTel" class="form-control" placeholder="Contoh: 012-3456789" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kata Laluan</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-save2 me-1"></i> Daftar Akaun
                                </button>
                            </div>
                        </form>
                    @endif
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
