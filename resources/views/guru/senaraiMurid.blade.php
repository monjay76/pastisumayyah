@extends('layouts.app')

@section('title', 'Senarai Murid')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item text-muted">Pengurusan</li>
                    <li class="breadcrumb-item active fw-bold" style="color: var(--pasti-green);">Senarai Murid</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0" style="color: var(--pasti-dark);">Data Murid SMART PASTI</h3>
        </div>
        <div>
            <a href="{{ route('guru.addMurid') }}" class="btn text-white rounded-3 px-4 shadow-sm transition-btn" 
               style="background-color: var(--pasti-green); border: none;">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Murid Baru
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom-0">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                        <span class="bg-success bg-opacity-10 p-2 rounded-3 me-2">
                            <i class="bi bi-people-fill text-success"></i>
                        </span>
                        Senarai Murid
                    </h5>
                </div>
                <div class="col-md-8 d-flex justify-content-md-end mt-3 mt-md-0">
                    @if($kelasList->count() > 0)
                    <div style="min-width: 250px;">
                        <form action="{{ route('guru.senaraiMurid') }}" method="GET" class="d-flex gap-2">
                            <div class="input-group input-group-sm border rounded-3 overflow-hidden shadow-sm">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-filter text-muted"></i></span>
                                <select class="form-select border-0 bg-light" name="kelas" onchange="this.form.submit();" style="cursor: pointer;">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelasList as $kls)
                                        <option value="{{ $kls }}" {{ request()->input('kelas') == $kls ? 'selected' : '' }}>
                                            Kelas: {{ $kls }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(request()->filled('kelas'))
                                    <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-white border-0 text-danger">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <form method="POST" action="{{ route('guru.bulkAction') }}">
                @csrf
                @if($murid->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="ps-4 py-3">#</th>
                                    <th>MyKid ID</th>
                                    <th>Nama Murid</th>
                                    <th>Kelas</th>
                                    <th>Tarikh Lahir</th>
                                    <th>Alamat</th>
                                    <th class="text-center pe-4">Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($murid as $index => $m)
                                    <tr>
                                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                        <td class="fw-semibold text-primary small">{{ $m->MyKidID }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $m->namaMurid }}</div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 border border-success border-opacity-25">
                                                {{ $m->kelas }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $m->tarikhLahir ? date('d/m/Y', strtotime($m->tarikhLahir)) : '-' }}
                                        </td>
                                        <td class="small text-truncate" style="max-width: 200px;" title="{{ $m->alamat }}">
                                            {{ $m->alamat }}
                                        </td>
                                        <td class="text-center pe-4">
                                            <input type="checkbox" name="selected_murid[]" value="{{ $m->MyKidID }}" class="form-check-input custom-checkbox">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 bg-light border-top">
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted me-2 fw-bold text-uppercase">Tindakan</span>
                            <button type="submit" name="action" value="edit" class="btn btn-warning btn-sm rounded-3 px-4 fw-bold shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i>Kemaskini Terpilih
                            </button>
                            <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm rounded-3 px-4 fw-bold shadow-sm" onclick="return confirm('Adakah anda pasti mahu memadam data murid yang dipilih?')">
                                <i class="bi bi-trash3 me-2"></i>Padam Terpilih
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-person-x text-muted opacity-25" style="font-size: 5rem;"></i>
                        </div>
                        <h5 class="fw-bold text-muted">Tiada Murid Dijumpai</h5>
                        <p class="text-muted small">Sila daftarkan murid baru dengan menekan butang "Tambah Murid Baru".</p>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Styling untuk elemen Senarai Murid */
    .transition-btn {
        transition: all 0.3s ease;
    }

    .transition-btn:hover {
        background-color: var(--pasti-dark) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 132, 61, 0.2) !important;
    }

    .table thead th {
        border-top: none;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 132, 61, 0.02);
    }

    .custom-checkbox {
        width: 1.2rem;
        height: 1.2rem;
        cursor: pointer;
    }

    .custom-checkbox:checked {
        background-color: var(--pasti-green);
        border-color: var(--pasti-green);
    }

    .form-select:focus {
        border-color: var(--pasti-green);
        box-shadow: none;
    }

    /* Ratio styling untuk skrin kecil */
    @media (max-width: 768px) {
        .card-header .col-md-8 {
            margin-top: 1rem;
        }
    }
</style>
@endsection