@extends('layouts.app')

@section('title', 'Maklumat Ibu Bapa')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-fill me-2"></i> Maklumat Ibu Bapa
                </div>
                <div class="card-body">
                    @if(!$selectedParent)
                            <h5>Senarai Ibu Bapa</h5>
                            @if($parents->count())
                                <form method="POST" action="{{ route('pentadbir.parentBulkAction') }}" onsubmit="return confirmParentBulkAction(event);">
                                    @csrf
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>ID Parent</th>
                                                <th>Nama</th>
                                                <th>Emel</th>
                                                <th>No. Tel</th>
                                                <th>Maklum Balas</th>
                                                <th>Pilih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parents as $index => $parent)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $parent->ID_Parent }}</td>
                                                    <td>
                                                        <a href="{{ route('pentadbir.maklumatIbuBapa', ['parent' => $parent->ID_Parent]) }}">{{ $parent->namaParent }}</a>
                                                    </td>
                                                    <td>{{ $parent->emel }}</td>
                                                    <td>{{ $parent->noTel }}</td>
                                                    <td>{{ $parent->maklumBalas ?: '-' }}</td>
                                                    <td><input type="checkbox" name="selected_parent[]" value="{{ $parent->ID_Parent }}"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        <button type="submit" name="action" value="edit" class="btn btn-warning">Edit</button>
                                        <button type="submit" name="action" value="delete" class="btn btn-danger">Padam</button>
                                    </div>
                                </form>
                            @else
                                <p class="text-muted mb-0">Tiada ibu bapa didaftarkan lagi.</p>
                            @endif
                    @else
                        <div class="mb-3">
                            <a href="{{ route('pentadbir.maklumatIbuBapa') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali ke Senarai Ibu Bapa
                            </a>
                        </div>
                        <h5>Maklumat Peribadi Ibu Bapa</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>ID Parent:</th>
                                        <td>{{ $selectedParent->ID_Parent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Parent:</th>
                                        <td>{{ $selectedParent->namaParent }}</td>
                                    </tr>
                                    <tr>
                                        <th>Emel:</th>
                                        <td>{{ $selectedParent->emel }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. Tel:</th>
                                        <td>{{ $selectedParent->noTel }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Maklum Balas Section -->
                        <h5 class="mt-4">Maklum Balas</h5>
                        @if($feedbacks->isNotEmpty())
                            @foreach($feedbacks as $feedback)
                                @php
                                    $content = is_array($feedback->kandungan) ? $feedback->kandungan : json_decode($feedback->kandungan, true);
                                    $ratingLabels = [
                                        1 => 'Sangat Tidak Puas',
                                        2 => 'Tidak Puas',
                                        3 => 'Sederhana',
                                        4 => 'Puas',
                                        5 => 'Sangat Puas'
                                    ];
                                    $categoryEmojis = [
                                        'Pujian' => '⭐',
                                        'Cadangan' => '💡',
                                        'Pertanyaan Perkembangan Murid' => '❓',
                                        'Lain-lain' => '📌'
                                    ];
                                @endphp
                                <div class="card bg-light mb-3" style="border-left: 4px solid #2E7D32;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1" style="color: #2E7D32; font-weight: 600;">
                                                    {{ $categoryEmojis[$content['category'] ?? ''] ?? '' }} {{ $content['category'] ?? 'N/A' }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($feedback->tarikh)->format('d/m/Y') }}
                                                </small>
                                            </div>
                                            <div class="text-warning" style="font-size: 1.1rem;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= ($content['rating'] ?? 0))
                                                        ★
                                                    @else
                                                        <span style="opacity: 0.3;">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="card-text mb-0" style="color: #495057; line-height: 1.6; white-space: pre-wrap;">
                                            {{ $content['message'] ?? 'N/A' }}
                                        </p>
                                        <small class="text-muted d-block mt-2">
                                            {{ $ratingLabels[$content['rating'] ?? 0] ?? 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Tiada maklum balas daripada ibu bapa ini.
                            </div>
                        @endif
                        
                        <h5 class="mt-4">Senarai Anak</h5>
                        @if($selectedParent->murid->count())
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>MyKid ID</th>
                                        <th>Nama Murid</th>
                                        <th>Kelas</th>
                                        <th>Tarikh Lahir</th>
                                        <th>Alamat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedParent->murid as $index => $murid)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $murid->MyKidID }}</td>
                                            <td>{{ $murid->namaMurid }}</td>
                                            <td>{{ $murid->kelas }}</td>
                                            <td>{{ $murid->tarikhLahir ? date('d/m/Y', strtotime($murid->tarikhLahir)) : '-' }}</td>
                                            <td>{{ $murid->alamat }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted mb-0">Tiada anak didaftarkan untuk ibu bapa ini.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmParentBulkAction(e) {
    const form = e.target;
    const checked = form.querySelectorAll('input[name="selected_parent[]"]:checked');
    if (checked.length === 0) {
        alert('Sila pilih sekurang-kurangnya seorang ibu bapa.');
        return false;
    }
    if (e.submitter && e.submitter.value === 'delete') {
        return confirm('Adakah anda pasti mahu memadam rekod ibu bapa yang dipilih? Tindakan ini tidak boleh dibatalkan.');
    }
    return true;
}
</script>
@endpush
