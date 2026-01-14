@extends('layouts.app')

@section('title', 'Tambah Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Murid Baru
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('guru.storeMurid') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="MyKidID" class="form-label">MyKid ID</label>
                                <input type="text" class="form-control" id="MyKidID" name="MyKidID" required>
                                @error('MyKidID')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="namaMurid" class="form-label">Nama Murid</label>
                                <input type="text" class="form-control" id="namaMurid" name="namaMurid" required>
                                @error('namaMurid')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control" id="kelas" name="kelas">
                                @error('kelas')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tarikhLahir" class="form-label">Tarikh Lahir</label>
                                <input type="date" class="form-control" id="tarikhLahir" name="tarikhLahir">
                                @error('tarikhLahir')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Parent/Guardian Information Section -->
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-3">Maklumat Penjaga/Ibu Bapa</h6>
                            <div class="mb-3">
                                <label for="parentSearch" class="form-label">Carian Ibu Bapa</label>
                                <input type="text" class="form-control" id="parentSearch" placeholder="Cari berdasarkan nama atau ID ibu bapa...">
                                <small class="text-muted">Mulakan taip untuk mencari ibu bapa yang berdaftar</small>
                            </div>
                            <div class="mb-3">
                                <label for="parentIds" class="form-label">Ibu Bapa Terpilih</label>
                                <select name="parent_ids[]" id="parentIds" class="form-select" multiple>
                                    <option value="" disabled>Tiada ibu bapa dipilih</option>
                                </select>
                                <small class="text-muted">Pilih satu atau lebih ibu bapa untuk murid ini</small>
                                @error('parent_ids')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('guru.senaraiMurid') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Tambah Murid</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const parentSearch = document.getElementById('parentSearch');
    const parentSelect = document.getElementById('parentIds');
    let parentData = [];

    // Fetch parent data when page loads
    fetch('/api/search-parents?q=')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.parents) {
                parentData = data.parents;
            }
        });

    // Search functionality
    parentSearch.addEventListener('input', function() {
        const searchTerm = this.value.trim();

        if (searchTerm.length >= 2) {
            fetch(`/api/search-parents?q=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.parents) {
                        showParentSuggestions(data.parents);
                    } else {
                        showParentSuggestions([]);
                    }
                });
        } else {
            showParentSuggestions([]);
        }
    });

    function showParentSuggestions(parents) {
        // Clear previous suggestions
        const existingOptions = parentSelect.querySelectorAll('option:not([disabled])');
        existingOptions.forEach(option => option.remove());

        if (parents.length > 0) {
            parents.forEach(parent => {
                const option = document.createElement('option');
                option.value = parent.ID_Parent;
                option.textContent = `${parent.namaParent} (${parent.ID_Parent}) - ${parent.emel}`;
                parentSelect.appendChild(option);
            });
        }
    }
});
</script>
@endpush
