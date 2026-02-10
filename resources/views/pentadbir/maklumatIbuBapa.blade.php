@extends('layouts.app')

@section('title', 'Maklumat Ibu Bapa')

@section('content')
<style>
    /* Custom Styling untuk konsistensi UI */
    .parent-card { border-radius: 15px; overflow: hidden; }
    .table thead th { 
        background-color: #f8f9fa; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 0.5px;
        color: #6c757d;
        border-top: none;
    }
    .avatar-parent {
        width: 45px;
        height: 45px;
        background-color: #e3f2fd;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: bold;
    }
    .feedback-card {
        border-radius: 12px;
        border: none;
        border-left: 5px solid #2E7D32;
        transition: transform 0.2s;
    }
    .feedback-card:hover { transform: translateX(5px); }
    .detail-label { color: #6c757d; font-size: 0.8rem; text-transform: uppercase; font-weight: 600; }
    .detail-value { font-weight: 500; color: #212529; }
    .btn-action { border-radius: 8px; padding: 0.5rem 1.2rem; font-weight: 500; }
    .hover-row:hover { background-color: rgba(13, 110, 253, 0.02) !important; }
    .child-badge { background-color: #fff4e5; color: #b95000; border: 1px solid #ffd8a8; }
</style>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h4 class="fw-bold mb-0">
                    <span class="text-primary"><i class="bi bi-people-fill me-2"></i></span> Pengurusan Ibu Bapa
                </h4>
            </div>

            <div class="card shadow-sm border-0 parent-card">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-dark">
                        {{ !$selectedParent ? 'Senarai Ibu Bapa & Penjaga' : 'Profil Lengkap Penjaga' }}
                    </h6>
                </div>
                
                <div class="card-body p-4">
                    @if(!$selectedParent)
                        @if($parents->count())
                            <form method="POST" action="{{ route('pentadbir.parentBulkAction') }}">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>ID Parent</th>
                                                <th>Nama Ibu Bapa</th>
                                                <th>Maklumat Hubungan</th>
                                                <th>Maklum Balas</th>
                                                <th class="text-end">Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parents as $index => $parent)
                                                <tr class="hover-row">
                                                    <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                                    <td><span class="badge bg-light text-dark border">{{ $parent->ID_Parent }}</span></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-parent me-3 text-uppercase">
                                                                {{ substr($parent->namaParent, 0, 1) }}
                                                            </div>
                                                            <a href="{{ route('pentadbir.maklumatIbuBapa', ['parent' => $parent->ID_Parent]) }}" class="text-decoration-none fw-bold text-dark">
                                                                {{ $parent->namaParent }}
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="small"><i class="bi bi-envelope me-1"></i> {{ $parent->emel }}</div>
                                                        <div class="small text-muted"><i class="bi bi-telephone me-1"></i> {{ $parent->noTel }}</div>
                                                    </td>
                                                    <td>
                                                        @if($parent->maklumBalas)
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Tersedia</span>
                                                        @else
                                                            <span class="text-muted small">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        <input class="form-check-input border-primary" type="checkbox" name="selected_parent[]" value="{{ $parent->ID_Parent }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                                    <button type="submit" name="action" value="edit" class="btn btn-warning btn-action" onclick="return handleBulkAction(this, event);">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-action" onclick="return handleBulkAction(this, event);">
                                        <i class="bi bi-trash me-1"></i> Padam
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-person-x text-light" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3">Tiada rekod ibu bapa ditemui.</p>
                            </div>
                        @endif
                    @else
                        <div class="mb-4">
                            <a href="{{ route('pentadbir.maklumatIbuBapa') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Senarai
                            </a>
                        </div>

                        <div class="row g-4 align-items-center mb-5">
                            <div class="col-md-auto text-center">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                                    {{ substr($selectedParent->namaParent, 0, 1) }}
                                </div>
                            </div>
                            <div class="col-md">
                                <h3 class="fw-bold mb-1">{{ $selectedParent->namaParent }}</h3>
                                <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i> Penjaga Berdaftar</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-4">
                                <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2 text-primary"></i>Maklumat Peribadi</h6>
                                <div class="p-4 border rounded-4 bg-light bg-opacity-50">
                                    <div class="mb-3 border-bottom pb-2">
                                        <div class="detail-label">ID Parent</div>
                                        <div class="detail-value">{{ $selectedParent->ID_Parent }}</div>
                                    </div>
                                    <div class="mb-3 border-bottom pb-2">
                                        <div class="detail-label">Emel</div>
                                        <div class="detail-value text-primary">{{ $selectedParent->emel }}</div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="detail-label">No. Telefon</div>
                                        <div class="detail-value">{{ $selectedParent->noTel }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-dots me-2 text-primary"></i>Rekod Maklum Balas</h6>
                                @if($feedbacks->isNotEmpty())
                                    <div class="row g-3">
                                    @foreach($feedbacks as $feedback)
                                        @php
                                            $content = is_array($feedback->kandungan) ? $feedback->kandungan : json_decode($feedback->kandungan, true);
                                            $ratingLabels = [1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Sederhana', 4 => 'Puas', 5 => 'Sangat Puas'];
                                            $categoryEmojis = ['Pujian' => '⭐', 'Cadangan' => '💡', 'Pertanyaan Perkembangan Murid' => '❓', 'Lain-lain' => '📌'];
                                        @endphp
                                        <div class="col-12">
                                            <div class="card feedback-card shadow-sm bg-white">
                                                <div class="card-body p-4">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <span class="badge bg-success-subtle text-success px-3 rounded-pill mb-2">
                                                                {{ $categoryEmojis[$content['category'] ?? ''] ?? '' }} {{ $content['category'] ?? 'N/A' }}
                                                            </span>
                                                            <div class="text-muted small">
                                                                <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($feedback->tarikh)->format('d/m/Y') }}
                                                            </div>
                                                        </div>
                                                        <div class="text-warning">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="bi {{ $i <= ($content['rating'] ?? 0) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <p class="card-text text-dark" style="line-height: 1.6; white-space: pre-wrap;">{{ $content['message'] ?? 'Tiada pesanan.' }}</p>
                                                    <div class="mt-2 text-muted small fw-bold text-uppercase" style="font-size: 0.7rem;">
                                                        Tahap Kepuasan: {{ $ratingLabels[$content['rating'] ?? 0] ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-light border d-flex align-items-center p-4">
                                        <i class="bi bi-chat-square-text fs-3 me-3 text-muted"></i>
                                        <div>Tiada maklum balas dikemukakan oleh ibu bapa ini buat masa ini.</div>
                                    </div>
                                @endif

                                <h6 class="fw-bold mt-5 mb-3"><i class="bi bi-mortarboard me-2 text-primary"></i>Tanggungan (Anak-anak)</h6>
                                @if($selectedParent->murid->count())
                                    <div class="table-responsive rounded-4 border">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="ps-3">Nama Murid</th>
                                                    <th>Kelas</th>
                                                    <th>ID Murid (MyKid)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($selectedParent->murid as $murid)
                                                    <tr>
                                                        <td class="ps-3 fw-bold">{{ $murid->namaMurid }}</td>
                                                        <td><span class="badge child-badge px-3">{{ $murid->kelas }}</span></td>
                                                        <td class="text-muted">{{ $murid->MyKidID }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted small italic">Tiada data murid dikaitkan dengan akaun ini.</p>
                                @endif
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
function handleBulkAction(button, e) {
    // Cek checkbox yang dipilih
    const checked = document.querySelectorAll('input[name="selected_parent[]"]:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Sila pilih sekurang-kurangnya seorang ibu bapa.');
        return false;
    }
    
    // Jika button delete, minta konfirmasi
    if (button.value === 'delete') {
        return confirm('Adakah anda pasti mahu memadam rekod ibu bapa yang dipilih? Tindakan ini tidak boleh dibatalkan.');
    }
    
    return true;
}
</script>
@endpush