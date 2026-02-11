@extends('layouts.app')

@section('title', 'Pendaftaran Akaun')

@section('content')
<style>
    /* Custom styles untuk meningkatkan estetika */
    .role-card {
        transition: all 0.3s ease;
        border: 2px solid #f8f9fa;
        border-radius: 15px;
    }
    .role-card:hover {
        transform: translateY(-5px);
        border-color: #198754;
        background-color: #f8fffb;
    }
    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }
    .table-container {
        border-radius: 15px;
        overflow: hidden;
    }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12 col-lg-9 mx-auto">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-success bg-gradient text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-plus-fill fs-4 me-2"></i>
                        <h5 class="mb-0 fw-bold">Pendaftaran Akaun Pengguna</h5>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(!request('role'))
                        <div class="text-center mb-4">
                            <h5 class="fw-bold">Pilih Peranan Pengguna</h5>
                            <p class="text-muted">Sila pilih kategori akaun yang ingin didaftarkan</p>
                        </div>
                        
                        <div class="row g-4 justify-content-center">
                            <div class="col-md-5">
                                <a href="{{ route('pentadbir.createUser', ['role' => 'guru']) }}" class="text-decoration-none">
                                    <div class="role-card p-4 text-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                            <i class="bi bi-person-badge fs-2"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Guru</h5>
                                        <p class="small text-muted mb-0">Daftar akaun untuk tenaga pengajar</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-5">
                                <a href="{{ route('pentadbir.createUser', ['role' => 'ibubapa']) }}" class="text-decoration-none">
                                    <div class="role-card p-4 text-center">
                                        <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                            <i class="bi bi-house-heart fs-2"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark">Ibu Bapa</h5>
                                        <p class="small text-muted mb-0">Daftar akaun untuk penjaga murid</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="mt-5 border-top pt-3">
                            <a href="{{ route('pentadbir.createUser') }}" class="btn btn-light rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <div>
                                <span class="badge bg-primary text-uppercase px-3 py-2 rounded-pill mb-2">
                                    Peranan: {{ request('role') }}
                                </span>
                                <h5 class="fw-bold mb-0 text-dark">Maklumat Peribadi</h5>
                            </div>
                            <a href="{{ route('pentadbir.createUser') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-arrow-left me-1"></i> Tukar Peranan
                            </a>
                        </div>

                        <form action="{{ route('pentadbir.storeUser') }}" method="POST">
                            @csrf
                            @if($errors->any())
                                <div class="alert alert-danger border-0 shadow-sm">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            
                            <div class="row g-4">
                                @if(request('role') === 'guru')
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">ID Guru</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-muted"></i></span>
                                            <input type="text" name="ID_Guru" class="form-control border-start-0" value="{{ old('ID_Guru') }}" placeholder="Contoh: GURU001" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Guru</label>
                                        <input type="text" name="namaGuru" class="form-control" value="{{ old('namaGuru') }}" placeholder="Masukkan nama penuh" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jawatan</label>
                                        <input type="text" name="jawatan" class="form-control" value="{{ old('jawatan') }}" placeholder="Contoh: Guru Kelas" required>
                                    </div>
                                @elseif(request('role') === 'ibubapa')
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">No. Kad Pengenalan</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-vcard text-muted"></i></span>
                                            <input type="text" name="ID_Parent" class="form-control border-start-0" value="{{ old('ID_Parent') }}" placeholder="Tanpa simbol '-' " required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Ibu Bapa</label>
                                        <input type="text" name="namaParent" class="form-control" value="{{ old('namaParent') }}" placeholder="Masukkan nama penuh" required>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Emel</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0" value="{{ old('email') }}" placeholder="alamat@emel.com" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">No. Telefon</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-muted"></i></span>
                                        <input type="text" name="noTel" class="form-control border-start-0" value="{{ old('noTel') }}" placeholder="01XXXXXXXX" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kata Laluan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                        <input type="password" name="password" class="form-control border-start-0" placeholder="Minimum 8 karakter" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <button type="submit" class="btn btn-success bg-gradient px-5 py-2 rounded-pill shadow-sm">
                                    <i class="bi bi-save2 me-2"></i> Daftar Akaun
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-people-fill me-2 text-success fs-5"></i>
                        <h6 class="mb-0 fw-bold">Senarai Akaun Pengguna Terkini</h6>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold">#</th>
                                    <th class="py-3 text-uppercase small fw-bold">Nama Pengguna</th>
                                    <th class="py-3 text-uppercase small fw-bold">Emel</th>
                                    <th class="py-3 text-uppercase small fw-bold">Peranan</th>
                                    <th class="py-3 text-uppercase small fw-bold">Tarikh Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td class="ps-4">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role == 'guru')
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill text-capitalize">
                                                    {{ $user->role }}
                                                </span>
                                            @else
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill text-capitalize">
                                                    {{ $user->role }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">
                                            <i class="bi bi-calendar3 me-1"></i> {{ $user->created_at->format('d/m/Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Tiada akaun didaftarkan lagi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection