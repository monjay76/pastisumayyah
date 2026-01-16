@extends('layouts.app')

@section('title', 'Senarai Subjek - Pentadbir')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-list-ul me-2"></i> Senarai Subjek Hafazan
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Add New Subject Form -->
                    <div class="mb-4">
                        <h5 class="mb-3">Tambah Subjek Baru</h5>
                        <form method="POST" action="{{ route('pentadbir.storeSubjek') }}" class="row g-3">
                            @csrf
                            <div class="col-md-8">
                                <input type="text" name="nama_subjek" class="form-control" placeholder="Masukkan nama subjek" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-plus-circle me-2"></i>Tambah Subjek
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Subjects List -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th class="text-center" style="width: 10%;">No.</th>
                                    <th style="width: 60%;">Nama Subjek</th>
                                    <th class="text-center" style="width: 30%;">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjek as $index => $item)
                                    <tr>
                                        <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $item->nama_subjek }}</span>
                                        </td>
                                        <td class="text-center">
                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('pentadbir.destroySubjek', $item->id) }}" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam subjek ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Padam
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Subjek</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('pentadbir.updateSubjek', $item->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="nama_subjek{{ $item->id }}" class="form-label">Nama Subjek</label>
                                                            <input type="text" name="nama_subjek" id="nama_subjek{{ $item->id }}" class="form-control" value="{{ $item->nama_subjek }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                                            <p class="mt-2">Tiada subjek direkodkan.</p>
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

<style>
    .table th {
        background-color: #e7f1ff;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection
