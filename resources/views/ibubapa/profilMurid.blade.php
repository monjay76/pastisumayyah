@extends('layouts.app')

@section('title', 'Profil Tanggungan')

@section('content')
<div class="container-fluid px-4 py-5" style="background: #f8f9fa; min-height: 100vh;">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary rounded-3 p-2 me-3 shadow-sm">
            <i class="bi bi-people-fill text-white fs-4"></i>
        </div>
        <div>
            <h3 class="fw-bold mb-0 text-dark">Profil Keluarga</h3>
            <p class="text-muted mb-0 small">Lihat maklumat peribadi ibu bapa dan butiran pendidikan anak-anak.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                <div class="card-header border-0 py-3" style="background: #ffffff;">
                    <h6 class="fw-bold mb-0 text-primary uppercase small tracking-wider">
                        <i class="bi bi-person-badge me-2"></i>Maklumat Ibu Bapa
                    </h6>
                </div>
                <div class="card-body bg-white">
                    <div class="d-flex flex-column align-items-center text-center mb-4 pb-3 border-bottom">
                        <div class="bg-light rounded-circle p-3 mb-3 border">
                            <i class="bi bi-person-vcard text-secondary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-1 text-dark">{{ $parent->namaParent ?? '—' }}</h5>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Penjaga Sah</span>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item bg-transparent border-0 px-0 mb-2">
                            <label class="small text-muted d-block">ID Ibu Bapa</label>
                            <span class="fw-semibold text-dark">{{ $parent->ID_Parent ?? '—' }}</span>
                        </div>
                        <div class="list-group-item bg-transparent border-0 px-0">
                            <label class="small text-muted d-block">Alamat Emel</label>
                            <span class="fw-semibold text-dark">{{ $parent->emel ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header border-0 py-3 d-flex align-items-center justify-content-between" style="background: #ffffff;">
                    <h6 class="fw-bold mb-0 text-primary uppercase small tracking-wider">
                        <i class="bi bi-mortarboard me-2"></i>Maklumat Anak
                    </h6>
                    @if($children->isNotEmpty())
                        <div style="width: 250px;">
                            <select id="childSelector" class="form-select form-select-sm rounded-pill border-primary-subtle shadow-sm">
                                @foreach($children as $index => $child)
                                    <option value="{{ $index }}" data-child-id="{{ $child->MyKidID }}" {{ $index === 0 ? 'selected' : '' }}>
                                        {{ $child->namaMurid }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="card-body p-0">
                    @if($children->isNotEmpty())
                        <div id="childProfileSection">
                            @foreach($children as $index => $child)
                                <div class="child-profile fade-in" id="childProfile_{{ $index }}" data-index="{{ $index }}" style="{{ $index === 0 ? 'display:block;' : 'display:none;' }}">
                                    <div class="p-4 bg-light border-bottom border-top border-light d-md-flex align-items-center justify-content-between text-center text-md-start">
                                        <div class="d-md-flex align-items-center">
                                            <div class="position-relative d-inline-block mb-3 mb-md-0">
                                                <div class="bg-white rounded-circle shadow-sm p-1">
                                                    <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                                                </div>
                                            </div>
                                            <div class="ms-md-4">
                                                <h4 class="fw-bold mb-1 text-dark">{{ $child->namaMurid }}</h4>
                                                <p class="text-muted mb-0"><i class="bi bi-fingerprint me-1"></i>MyKid: {{ $child->MyKidID }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-3 mt-md-0">
                                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i>Murid Aktif</span>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <h6 class="fw-bold text-dark mb-4"><i class="bi bi-info-square-fill text-primary me-2"></i>Butiran Akademik & Peribadi</h6>
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border border-light-subtle bg-light shadow-sm h-100">
                                                    <div class="small text-muted mb-1 text-uppercase">Tarikh Lahir</div>
                                                    <div class="fw-bold text-dark fs-6">{{ $child->tarikhLahir ? \Carbon\Carbon::parse($child->tarikhLahir)->format('d F Y') : '—' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="p-3 rounded-3 border border-light-subtle bg-light shadow-sm h-100">
                                                    <div class="small text-muted mb-1 text-uppercase">Kelas Terkini</div>
                                                    <div class="fw-bold text-dark fs-6">{{ $child->kelas ?? '—' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="p-3 rounded-3 border border-light-subtle bg-light shadow-sm">
                                                    <div class="small text-muted mb-1 text-uppercase">Alamat Rumah</div>
                                                    <div class="fw-bold text-dark fs-6">{{ $child->alamat ?? '—' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-5 text-center">
                            <div class="mb-3">
                                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-dark fw-bold">Tiada Rekod Anak</h5>
                            <p class="text-muted">Sila hubungi pentadbir sekolah jika anda percaya ini adalah kesilapan.</p>
                            <a href="#" class="btn btn-primary rounded-pill px-4 btn-sm mt-2">Hubungi Sokongan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom CSS for visual enhancements */
    .bg-primary-subtle { background-color: #e7f1ff; }
    .text-primary { color: #0d6efd !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .fade-in {
        animation: fadeIn 0.4s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .card { transition: transform 0.2s ease; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var childSelector = document.getElementById('childSelector');
    if (!childSelector) return;

    var allProfiles = document.querySelectorAll('.child-profile');
    
    function showProfile(index) {
        allProfiles.forEach(profile => {
            profile.style.display = 'none';
            profile.classList.remove('fade-in');
        });

        var targetProfile = document.getElementById('childProfile_' + index);
        if (targetProfile) {
            targetProfile.style.display = 'block';
            // Trigger animation
            setTimeout(() => {
                targetProfile.classList.add('fade-in');
            }, 10);
        }
    }

    childSelector.addEventListener('change', function() {
        var selectedIndex = this.value;
        if (selectedIndex !== '') {
            showProfile(selectedIndex);
        }
    });

    // Initialize
    showProfile(childSelector.value || '0');
});
</script>
@endsection