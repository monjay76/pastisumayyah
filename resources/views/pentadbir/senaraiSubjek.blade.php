@extends('layouts.app')

@section('title', 'Senarai Subjek - Pentadbir')

@section('content')
<style>
    /* Custom Styling */
    .subject-card { border-radius: 15px; border: none; }
    .table-container { border-radius: 12px; overflow: hidden; border: 1px solid #e9ecef; }
    .table thead th { 
        background-color: #f8f9fa; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom: 2px solid #dee2e6;
    }
    .input-group-custom {
        background: #fdfdfd;
        padding: 20px;
        border-radius: 12px;
        border: 1px dashed #cbd5e0;
        margin-bottom: 25px;
    }
    .subject-name { color: #2d3748; font-weight: 600; }
    .action-btn { transition: all 0.2s; border-radius: 8px; }
    .action-btn:hover { transform: translateY(-2px); }
    .modal-content { border-radius: 15px; border: none; }
    .modal-header { background-color: #f8f9fa; border-radius: 15px 15px 0 0; }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="fw-bold mb-0">
                    <span class="text-primary"><i class="bi bi-book-half me-2"></i></span> 
                    Pengurusan Subjek Hafazan
                </h4>
            </div>

            <div class="card shadow-sm subject-card">
                <div class="card-body p-4">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="input-group-custom">
                        <h6 class="fw-bold text-muted mb-3 text-uppercase small">Tambah Subjek Baru</h6>
                        <form method="POST" action="{{ route('pentadbir.storeSubjek') }}" class="row g-3">
                            @csrf
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted">
                                        <i class="bi bi-pencil"></i>
                                    </span>
                                    <input type="text" name="nama_subjek" class="form-control border-start-0 ps-0 shadow-none" placeholder="Contoh: Juzuk 30, Surah Al-Mulk..." required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100 fw-semibold action-btn shadow-sm">
                                    <i class="bi bi-plus-lg me-2"></i>Tambah
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="table-container shadow-sm">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="80">No.</th>
                                    <th>Nama Subjek Hafazan</th>
                                    <th class="text-center" width="250">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjek as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-muted small">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light p-2 rounded-3 me-3">
                                                    <i class="bi bi-journal-bookmark text-primary"></i>
                                                </div>
                                                <span class="subject-name">{{ $item->nama_subjek }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-warning me-1 action-btn px-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </button>
                                            
                                            <form method="POST" action="{{ route('pentadbir.destroySubjek', $item->id) }}" class="d-inline" onsubmit="return confirm('Adakah anda pasti mahu memadam subjek ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger action-btn px-3">
                                                    <i class="bi bi-trash me-1"></i> Padam
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content shadow-lg">
                                                <div class="modal-header border-0">
                                                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2 text-warning"></i>Kemaskini Subjek</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('pentadbir.updateSubjek', $item->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body py-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Nama Subjek</label>
                                                            <input type="text" name="nama_subjek" class="form-control form-control-lg fs-6" value="{{ $item->nama_subjek }}" required>
                                                            <div class="form-text text-muted mt-2 small">Sila pastikan ejaan nama subjek adalah tepat.</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <div class="mb-2">
                                                <i class="bi bi-inboxes text-light" style="font-size: 3rem;"></i>
                                            </div>
                                            <h6 class="fw-bold">Tiada Subjek Rekodkan</h6>
                                            <p class="small">Sila tambah subjek baru menggunakan borang di atas.</p>
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