@extends('layouts.app')

@section('title', 'Aktiviti Tahunan - ' . $monthName)

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('guru.aktivitiTahunan') }}" class="text-decoration-none text-muted">Aktiviti Tahunan</a></li>
                    <li class="breadcrumb-item active fw-bold" style="color: var(--pasti-green);">Bulan {{ $monthName }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0" style="color: var(--pasti-dark);">Galeri Aktiviti: {{ $monthName }}</h3>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('guru.aktivitiTahunan') }}" class="btn btn-outline-secondary rounded-3 px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
            <button class="btn text-white rounded-3 px-4 shadow-sm" 
                    style="background-color: var(--pasti-green); border: none;"
                    data-bs-toggle="modal" data-bs-target="#addImageModal">
                <i class="bi bi-plus-lg me-2"></i>Tambah Gambar
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="card-body p-4">
            @if($images->count())
                <div class="row g-4">
                    @foreach($images as $image)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <div class="card h-100 border-0 shadow-sm hover-card rounded-4 overflow-hidden">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset('storage/' . $image->path) }}" 
                                         class="object-fit-cover" 
                                         alt="Aktiviti {{ $monthName }}">
                                </div>
                                <div class="card-body p-3 d-flex flex-column justify-content-between">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center text-muted small mb-1">
                                            <i class="bi bi-calendar-check me-2 text-success"></i>
                                            <span class="fw-semibold">Tarikh Aktiviti</span>
                                        </div>
                                        <p class="card-text fw-bold mb-0" style="font-size: 1rem;">
                                            {{ date('d/m/Y', strtotime($image->tarikh)) }}
                                        </p>
                                    </div>
                                    <button class="btn btn-light text-danger btn-sm rounded-3 w-100 fw-bold border-0 py-2" 
                                            onclick="deleteImage({{ $image->id_aktiviti }})">
                                        <i class="bi bi-trash3 me-2"></i>Padam Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-images text-muted opacity-25" style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="text-muted">Tiada gambar dijumpai</h5>
                    <p class="text-muted small">Muat naik gambar aktiviti pertama anda untuk bulan {{ $monthName }} hari ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold" id="addImageModalLabel" style="color: var(--pasti-dark);">
                    Tambah Gambar Aktiviti
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('guru.storeAktivitiImage') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Lengkapkan maklumat di bawah untuk memuat naik gambar aktiviti murid.</p>
                    <input type="hidden" name="month" value="{{ $month }}">
                    
                    <div class="mb-4">
                        <label for="tarikh" class="form-label small fw-bold text-uppercase text-muted">Tarikh Aktiviti</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-calendar-event text-success"></i></span>
                            <input type="date" class="form-control bg-light border-start-0" id="tarikh" name="tarikh" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="image" class="form-label small fw-bold text-uppercase text-muted">Muat Naik Gambar</label>
                        <input type="file" class="form-control bg-light" id="image" name="image" accept="image/*" required>
                        <div class="form-text mt-2 small">Format yang disyorkan: JPG, PNG. Maksimum 2MB.</div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white rounded-3 px-4 fw-bold shadow-sm" style="background-color: var(--pasti-green); border: none;">
                        Simpan Gambar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Hover Effect untuk Kad Gambar */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    /* Ratio styling untuk memastikan gambar seragam */
    .ratio-4x3 {
        --bs-aspect-ratio: 75%;
    }

    /* Styling Input Modal */
    .form-control:focus, .form-select:focus {
        border-color: var(--pasti-green);
        box-shadow: 0 0 0 0.25rem rgba(0, 132, 61, 0.1);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"><path d="M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z" fill="currentColor"/></svg>');
        vertical-align: middle;
    }
</style>

<script>
function deleteImage(id) {
    if (confirm('Adakah anda pasti mahu padam gambar ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("guru.deleteAktivitiImage", ":id") }}'.replace(':id', id);

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection