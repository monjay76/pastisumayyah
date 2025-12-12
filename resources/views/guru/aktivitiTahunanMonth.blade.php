@extends('layouts.app')

@section('title', 'Aktiviti Tahunan - {{ $monthName }}')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white fw-semibold">
                    <i class="bi bi-calendar-event me-2"></i> Aktiviti Tahunan - {{ $monthName }}
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="mb-3">
                        <a href="{{ route('guru.aktivitiTahunan') }}" class="btn btn-secondary">Kembali ke Aktiviti Tahunan</a>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImageModal">Tambah Gambar</button>
                    </div>
                    @if($images->count())
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="Aktiviti {{ $monthName }}">
                                        <div class="card-body">
                                            <p class="card-text">Tarikh: {{ date('d/m/Y', strtotime($image->tarikh)) }}</p>
                                            <button class="btn btn-danger btn-sm" onclick="deleteImage({{ $image->id_aktiviti }})">Padam</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">Tiada gambar untuk bulan ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Image Modal -->
<div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addImageModalLabel">Tambah Gambar untuk {{ $monthName }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('guru.storeAktivitiImage') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <div class="mb-3">
                        <label for="tarikh" class="form-label">Tarikh</label>
                        <input type="date" class="form-control" id="tarikh" name="tarikh" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Gambar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteImage(id) {
    if (confirm('Adakah anda pasti mahu padam gambar ini?')) {
        // Create a form to submit POST request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("guru.deleteAktivitiImage", ":id") }}'.replace(':id', id);

        // Add CSRF token
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
