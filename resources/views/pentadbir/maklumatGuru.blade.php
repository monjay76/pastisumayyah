@extends('layouts.app')

@section('title', 'Maklumat Guru')

@section('content')
<style>
    /* Custom Styling untuk impak visual premium */
    .guru-card { border-radius: 15px; overflow: hidden; transition: 0.3s; }
    .table thead th { 
        background-color: #f8f9fa; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #e9ecef;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
    }
    .detail-label { color: #6c757d; font-size: 0.85rem; text-transform: uppercase; font-weight: 600; }
    .detail-value { font-weight: 500; color: #212529; }
    .btn-action { border-radius: 8px; padding: 0.5rem 1.2rem; font-weight: 500; }
    .hover-row:hover { background-color: rgba(13, 110, 253, 0.02) !important; }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="fw-bold mb-0">
                    <span class="text-primary"><i class="bi bi-people-fill me-2"></i></span> Pengurusan Guru
                </h4>
            </div>

            <div class="card shadow-sm border-0 guru-card">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        {{ !$selectedGuru ? 'Senarai Keseluruhan Guru' : 'Profil Lengkap Guru' }}
                    </h6>
                </div>
                
                <div class="card-body p-4">
                    @if(!$selectedGuru)
                        @if($gurus->count())
                            <form method="POST" action="{{ route('pentadbir.guruBulkAction') }}">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">#</th>
                                                <th>Guru</th>
                                                <th>ID Guru</th>
                                                <th>Hubungan (Emel/Tel)</th>
                                                <th>Jawatan</th>
                                                <th class="text-end">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gurus as $index => $guru)
                                                <tr class="hover-row">
                                                    <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle me-3">
                                                                {{ substr($guru->namaGuru, 0, 1) }}
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('pentadbir.maklumatGuru', ['guru' => $guru->ID_Guru]) }}" class="text-decoration-none fw-bold text-dark">
                                                                    {{ $guru->namaGuru }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-light text-primary border">{{ $guru->ID_Guru }}</span></td>
                                                    <td>
                                                        <div class="small"><i class="bi bi-envelope me-1"></i> {{ $guru->emel }}</div>
                                                        <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $guru->noTel }}</div>
                                                    </td>
                                                    <td><span class="text-secondary small fw-semibold">{{ $guru->jawatan }}</span></td>
                                                    <td class="text-end">
                                                        <div class="form-check d-inline-block">
                                                            <input class="form-check-input border-primary" type="checkbox" name="selected_guru[]" value="{{ $guru->ID_Guru }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                                    <button type="submit" name="action" value="edit" class="btn btn-warning btn-action" onclick="return handleGuruBulkAction(this, event);">
                                        <i class="bi bi-pencil-square me-1"></i> Kemaskini Terpilih
                                    </button>
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-action" onclick="return handleGuruBulkAction(this, event);">
                                        <i class="bi bi-trash me-1"></i> Padam Terpilih
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-person-x text-light" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3">Tiada guru didaftarkan lagi dalam sistem.</p>
                            </div>
                        @endif
                    @else
                        <div class="mb-4">
                            <a href="{{ route('pentadbir.maklumatGuru') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Senarai
                            </a>
                        </div>

                        <div class="row g-4 align-items-center">
                            <div class="col-md-auto text-center">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                                    {{ substr($selectedGuru->namaGuru, 0, 1) }}
                                </div>
                            </div>
                            <div class="col-md">
                                <h3 class="fw-bold mb-1">{{ $selectedGuru->namaGuru }}</h3>
                                <p class="text-muted mb-0"><i class="bi bi-briefcase me-1"></i> {{ $selectedGuru->jawatan }}</p>
                            </div>
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-50 h-100">
                                    <div class="mb-3">
                                        <div class="detail-label">ID Guru</div>
                                        <div class="detail-value fs-5">{{ $selectedGuru->ID_Guru }}</div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="detail-label">Emel Rasmi</div>
                                        <div class="detail-value text-primary">{{ $selectedGuru->emel }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light bg-opacity-50 h-100">
                                    <div class="mb-3">
                                        <div class="detail-label">No. Telefon</div>
                                        <div class="detail-value">{{ $selectedGuru->noTel }}</div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="detail-label">Kategori Jawatan</div>
                                        <div class="detail-value"><span class="badge bg-info text-dark">{{ $selectedGuru->jawatan }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function handleGuruBulkAction(button, e) {
    // Cek checkbox yang dipilih
    const checked = document.querySelectorAll('input[name="selected_guru[]"]:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Sila pilih sekurang-kurangnya seorang guru.');
        return false;
    }
    
    // Jika button delete, minta konfirmasi
    if (button.value === 'delete') {
        return confirm('Adakah anda pasti mahu memadam rekod guru yang dipilih? Tindakan ini tidak boleh dibatalkan.');
    }
    
    return true;
}
</script>
@endpush