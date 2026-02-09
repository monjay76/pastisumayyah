@extends('layouts.app')

@section('title', 'Senarai Kehadiran')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header" style="background: linear-gradient(135deg, #005a2a 0%, #00843D 100%); color: white; font-weight: 600;">
                    <i class="bi bi-calendar-check me-2"></i> Senarai Kehadiran
                </div>
                <div class="card-body">
                    @if(!isset($kelas) || !isset($tarikh))
                        <form method="GET" action="{{ route('guru.senaraiKehadiran') }}">
                            <div class="row mb-3 g-3">
                                <div class="col-md-4">
                                    <label for="kelas" class="form-label fw-semibold" style="color: #005a2a;">Pilih Kelas</label>
                                    <select name="kelas" id="kelas" class="form-select border-0 shadow-sm" style="background-color: #f1f8f3;" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class }}" {{ request('kelas') == $class ? 'selected' : '' }}>{{ $class }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tarikh" class="form-label fw-semibold" style="color: #005a2a;">Pilih Tarikh</label>
                                    <input type="date" name="tarikh" id="tarikh" class="form-control border-0 shadow-sm" style="background-color: #f1f8f3;" value="{{ request('tarikh') }}" required>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn fw-semibold w-100" style="background: linear-gradient(135deg, #00843D 0%, #005a2a 100%); color: white; box-shadow: 0 2px 8px rgba(0, 132, 61, 0.2);">
                                        <i class="bi bi-search me-2"></i>Papar Kehadiran
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="mb-4 d-flex gap-2">
                            <a href="{{ route('guru.senaraiKehadiran') }}" class="btn btn-outline-secondary fw-semibold">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('guru.editKehadiran', ['kelas' => $kelas, 'tarikh' => $tarikh]) }}" class="btn fw-semibold" style="background-color: #f0ad4e; color: white; border: none;">
                                <i class="bi bi-pencil me-2"></i>Edit Kehadiran
                            </a>
                        </div>
                        <div class="alert mb-4 border-0 shadow-sm" style="background-color: rgba(70, 180, 110, 0.1); color: #005a2a; border-left: 4px solid #00843D;">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Kelas:</strong> {{ $kelas }} &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Tarikh:</strong> {{ date('d/m/Y', strtotime($tarikh)) }}
                        </div>
                        @if($murid->count())
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead style="background-color: #f1f8f3; color: #005a2a; font-weight: 600; border-bottom: 3px solid #00843D;">
                                        <tr>
                                            <th class="text-center" style="width: 8%;">#</th>
                                            <th style="width: 18%;">MyKid ID</th>
                                            <th style="width: 37%;">Nama Murid</th>
                                            <th style="width: 37%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($murid as $index => $m)
                                            <tr>
                                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                                <td><code style="background-color: #f1f8f3; color: #005a2a; padding: 0.3rem 0.6rem; border-radius: 0.25rem;">{{ $m->MyKidID }}</code></td>
                                                <td>{{ $m->namaMurid }}</td>
                                                <td>
                                                    @if(isset($kehadiran[$m->MyKidID]))
                                                        @if($kehadiran[$m->MyKidID]->status == 'hadir')
                                                            <span class="badge fw-semibold" style="background-color: #46b46e; font-size: 0.85rem; padding: 0.5rem 0.8rem;">
                                                                <i class="bi bi-check-circle me-1"></i>Hadir
                                                            </span>
                                                        @else
                                                            <span class="badge fw-semibold" style="background-color: #dc3545; font-size: 0.85rem; padding: 0.5rem 0.8rem;">
                                                                <i class="bi bi-x-circle me-1"></i>Tidak Hadir
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="badge fw-semibold" style="background-color: #6c757d; font-size: 0.85rem; padding: 0.5rem 0.8rem;">
                                                            <i class="bi bi-question-circle me-1"></i>Belum Direkod
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #46b46e;"></i>
                                <p class="text-muted mt-3 fw-semibold">Tiada murid dalam kelas ini.</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #46b46e;
        box-shadow: 0 0 0 0.25rem rgba(70, 180, 110, 0.25);
        background-color: white;
    }

    .form-label {
        color: #005a2a;
        font-weight: 600;
        margin-bottom: 0.6rem;
    }

    .table td {
        border-color: #e0e8e4;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(70, 180, 110, 0.05);
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4rem 0.7rem;
        font-weight: 600;
    }

    .btn-outline-secondary {
        color: #005a2a;
        border-color: #46b46e;
    }

    .btn-outline-secondary:hover {
        background-color: #005a2a;
        border-color: #005a2a;
        color: white;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 132, 61, 0.1) !important;
    }

    code {
        font-family: 'Courier New', monospace;
    }
</style>
@endsection
