@extends('layouts.app')

@section('title', 'Edit Kehadiran')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted">Kehadiran</a></li>
                    <li class="breadcrumb-item active fw-bold" style="color: var(--pasti-green);">Edit Kehadiran</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0" style="color: var(--pasti-dark);">Kemaskini Kehadiran Murid</h3>
        </div>
        <div>
            <a href="{{ route('guru.senaraiKehadiran', ['kelas' => $kelas, 'tarikh' => $tarikh]) }}" class="btn btn-outline-secondary rounded-3 px-4 shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="p-4 text-white d-flex align-items-center justify-content-center" style="background-color: var(--pasti-green); min-width: 100px;">
                            <i class="bi bi-info-circle-fill fs-2"></i>
                        </div>
                        <div class="p-4">
                            <h5 class="mb-1 fw-bold text-uppercase small text-muted">Maklumat Sesi</h5>
                            <span class="fs-5 fw-bold me-3"><i class="bi bi-door-open me-2 text-success"></i>Kelas: {{ $kelas }}</span>
                            <span class="fs-5 fw-bold"><i class="bi bi-calendar-event me-2 text-success"></i>Tarikh: {{ date('d/m/Y', strtotime($tarikh)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold d-flex align-items-center">
                        <span class="bg-warning bg-opacity-10 p-2 rounded-3 me-2">
                            <i class="bi bi-pencil-square text-warning"></i>
                        </span>
                        Senarai Semak Kehadiran
                    </h5>
                </div>

                <div class="card-body p-0">
                    <form method="POST" action="{{ route('guru.storeKehadiran') }}">
                        @csrf
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                        <input type="hidden" name="tarikh" value="{{ $tarikh }}">

                        @if($murid->count())
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                                        <tr>
                                            <th class="ps-4 py-3">#</th>
                                            <th>MyKid ID</th>
                                            <th>Nama Murid</th>
                                            <th class="pe-4" style="width: 250px;">Status Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($murid as $index => $m)
                                            <tr>
                                                <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                                <td class="fw-semibold text-primary small">{{ $m->MyKidID }}</td>
                                                <td>
                                                    <div class="fw-bold text-dark">{{ $m->namaMurid }}</div>
                                                </td>
                                                <td class="pe-4">
                                                    <select name="status[{{ $m->MyKidID }}]" class="form-select border-2 status-select">
                                                        <option value="hadir" {{ isset($kehadiran[$m->MyKidID]) && $kehadiran[$m->MyKidID]->status == 'hadir' ? 'selected' : '' }}>
                                                            ✅ Hadir
                                                        </option>
                                                        <option value="tidak_hadir" {{ isset($kehadiran[$m->MyKidID]) && $kehadiran[$m->MyKidID]->status == 'tidak_hadir' ? 'selected' : '' }}>
                                                            ❌ Tidak Hadir
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-4 bg-light border-top">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-lg text-white rounded-3 px-5 fw-bold shadow-sm transition-btn" 
                                            style="background-color: var(--pasti-green); border: none;">
                                        <i class="bi bi-cloud-check me-2"></i>Simpan Kemaskini
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-people text-muted opacity-25" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3 mb-0">Tiada murid dalam kelas ini untuk dikemaskini.</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling */
    .transition-btn {
        transition: all 0.3s ease;
    }

    .transition-btn:hover {
        background-color: var(--pasti-dark) !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 132, 61, 0.2) !important;
    }

    .status-select {
        border-radius: 10px;
        font-weight: 600;
        transition: border-color 0.2s;
    }

    .status-select:focus {
        border-color: var(--pasti-green);
        box-shadow: 0 0 0 0.25rem rgba(0, 132, 61, 0.1);
    }

    /* Row Hover Effect */
    .table tbody tr:hover {
        background-color: rgba(0, 132, 61, 0.02);
    }

    .table thead th {
        border-top: none;
        letter-spacing: 0.5px;
    }
</style>
@endsection