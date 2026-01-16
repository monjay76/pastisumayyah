@extends('layouts.app')

@section('title', 'Prestasi Murid - Guru')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <!-- Navigation Tabs - Guru version (only Penilaian Prestasi) -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white">
                    <ul class="nav nav-tabs card-header-tabs" id="mainTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active text-white" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#assessment" type="button" role="tab" aria-controls="assessment" aria-selected="true">
                                <i class="bi bi-pencil-square me-2"></i>Penilaian Prestasi
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="mainTabsContent">
                        <!-- Assessment Tab -->
                        <div class="tab-pane fade show active" id="assessment" role="tabpanel" aria-labelledby="assessment-tab">
                            <!-- Selection Section -->
                            <div class="card shadow-sm border-0 rounded-4 mb-4">
                                <div class="card-header bg-info text-white fw-semibold">
                                    <i class="bi bi-filter me-2"></i> Pilih Kelas, Murid & Subjek
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="{{ route('guru.prestasiMurid') }}" id="filterForm">
                                        <div class="row g-3">
                                            <!-- Select Class -->
                                            <div class="col-md-4">
                                                <label for="kelas" class="form-label fw-semibold">Pilih Kelas</label>
                                                <select name="kelas" id="kelas" class="form-select" required onchange="this.form.submit()">
                                                    <option value="">-- Pilih Kelas --</option>
                                    @if(is_array($classes) || $classes instanceof \Illuminate\Support\Collection)
                                        @foreach($classes as $kelas)
                                            <option value="{{ $kelas }}" {{ $selectedClass == $kelas ? 'selected' : '' }}>
                                                {{ $kelas }}
                                            </option>
                                        @endforeach
                                    @endif
                                                </select>
                                            </div>

                                            <!-- Select Student -->
                                            <div class="col-md-4">
                                                <label for="murid" class="form-label fw-semibold">Pilih Murid</label>
                                                <select name="murid" id="murid" class="form-select" {{ !$selectedClass ? 'disabled' : '' }} onchange="this.form.submit()">
                                                    <option value="">-- Pilih Murid --</option>
                                                    @if(is_array($students) || $students instanceof \Illuminate\Support\Collection)
                                                        @foreach($students as $student)
                                                            <option value="{{ $student->MyKidID }}" {{ $selectedStudent && $selectedStudent->MyKidID == $student->MyKidID ? 'selected' : '' }}>
                                                                {{ $student->namaMurid }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <!-- Select Subject -->
                                            <div class="col-md-4">
                                                <label for="subjek" class="form-label fw-semibold">Pilih Subjek</label>
                                                <select name="subjek" id="subjek" class="form-select" {{ !$selectedStudent ? 'disabled' : '' }} onchange="this.form.submit()">
                                                    <option value="">-- Pilih Subjek --</option>
                                                    @if(is_array($subjekList) || $subjekList instanceof \Illuminate\Support\Collection)
                                                        @foreach($subjekList as $subjek)
                                                            <option value="{{ $subjek }}" {{ $selectedSubjek == $subjek ? 'selected' : '' }}>
                                                                {{ $subjek }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </form>

                                    @if($selectedClass && $selectedStudent && $selectedSubjek)
                                        <div class="alert alert-info mt-3 mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <strong>Dipilih:</strong> Kelas {{ $selectedClass }} | {{ $selectedStudent->namaMurid }} | {{ $selectedSubjek }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Assessment Form Section -->
                            @if($selectedClass && $selectedStudent && $selectedSubjek && (count($ayatList) > 0 || strtolower($selectedSubjek) == 'nurul quran'))
                                @php
                                    $isPratahfiz = strtolower($selectedSubjek) == 'pra tahfiz' || strtolower($selectedSubjek) == 'pratahfiz';
                                    $isNurulQuran = strtolower($selectedSubjek) == 'nurul quran';
                                    $isGeneralSubject = in_array(strtolower($selectedSubjek), [
                                        'bahasa malaysia', 'bahasa inggeris', 'matematik',
                                        'sains', 'jawi', 'peribadi muslim', 'arab'
                                    ]);
                                @endphp
                                <div class="card shadow-sm border-0 rounded-4 mb-4">
                                    <div class="card-header bg-success text-white fw-semibold">
                                        <i class="bi bi-pencil-square me-2"></i>
                                        {{ $isPratahfiz ? 'Penilaian Prestasi - Pratahfiz' : ($isNurulQuran ? 'Penilaian Prestasi - Nurul Quran' : 'Penilaian Prestasi - ' . $selectedSubjek) }}
                                    </div>
                                    <div class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

<<<<<<< HEAD
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

=======
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
                                        @if(session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{ route('guru.prestasiMurid.store') }}">
                                            @csrf
                                            <input type="hidden" name="murid_id" value="{{ $selectedStudent->MyKidID }}">
                                            <input type="hidden" name="subject_id" id="subject_id" value="">
                                            <input type="hidden" name="penggal" id="penggalInput" value="">

                                            <!-- Select Penggal -->
                                            <div class="mb-4">
                                                <label for="penggal" class="form-label fw-bold">Pilih Penggal</label>
                                                <select name="penggal_display" id="penggal" class="form-select w-auto" required onchange="updatePenggalValue()">
                                                    <option value="">-- Pilih Penggal --</option>
                                                    <option value="1">Penggal 1</option>
                                                    <option value="2">Penggal 2</option>
                                                </select>
                                            </div>

                                            <!-- Assessment Table -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover align-middle">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th class="text-center" style="width: 10%;">No.</th>
                                                            <th class="text-center" style="width: 25%;">
                                                                @if($isPratahfiz)
                                                                    Pratahfiz Surah Lazim
                                                                @elseif($isNurulQuran)
                                                                    Bacaan Wajib Nurul Quran
                                                                @elseif($isGeneralSubject)
                                                                    Kriteria Penilaian
                                                                @else
                                                                    Ayat
                                                                @endif
                                                            </th>
                                                            <th class="text-center" style="width: 65%;">Tahap Pencapaian</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($isNurulQuran)
                                                            {{-- Special table structure for Nurul Quran with rowspan --}}
                                                            @php
                                                                $nurulQuranUnits = [
                                                                    'Unit 1 : Mukasurat 1 - 29',
                                                                    'Unit 1 : Mukasurat 29 - 40',
                                                                    'Unit 2 : Mukasurat 42 - 53',
                                                                    'Unit 2 : Mukasurat 54 - 64'
                                                                ];
                                                            @endphp
                                                            @foreach($nurulQuranUnits as $unitIndex => $unitLabel)
                                                                @php
                                                                    $itemLabel = 'Buku 1 - ' . $unitLabel;
                                                                    $itemId = 'NQ_Buku1_Unit' . ($unitIndex + 1);
                                                                    $penggal1Key = $itemLabel . '_Penggal 1';
                                                                    $penggal2Key = $itemLabel . '_Penggal 2';
                                                                    $penggal1 = $prestasi->has($penggal1Key) ? $prestasi->get($penggal1Key)->first() : null;
                                                                    $penggal2 = $prestasi->has($penggal2Key) ? $prestasi->get($penggal2Key)->first() : null;
                                                                @endphp
                                                                <tr>
                                                                    @if($unitIndex == 0)
                                                                    <td class="text-center fw-semibold align-middle" rowspan="4">
                                                                        <span class="d-flex align-items-center justify-content-center h-100">Buku 1</span>
                                                                    </td>
                                                                    @endif
                                                                    <td class="fw-semibold">{{ $unitLabel }}</td>
                                                                    <td>
                                                                        <div class="d-flex justify-content-center gap-3">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="AM"
                                                                                       id="item{{ $itemId }}_AM">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_AM">
                                                                                    <span class="badge bg-warning text-dark">AM</span> Ansur Maju
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="M"
                                                                                       id="item{{ $itemId }}_M">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_M">
                                                                                    <span class="badge bg-info text-dark">M</span> Maju
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="SM"
                                                                                       id="item{{ $itemId }}_SM">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_SM">
                                                                                    <span class="badge bg-success">SM</span> Sangat Maju
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        @if($penggal1 || $penggal2)
                                                                            <div class="mt-2 small text-muted">
                                                                                @if($penggal1)
                                                                                    <span class="me-3"><strong>P1:</strong>
                                                                                        @if($penggal1->tahapPencapaian == 'AM')
                                                                                            <span class="badge bg-warning text-dark">AM</span>
                                                                                        @elseif($penggal1->tahapPencapaian == 'M')
                                                                                            <span class="badge bg-info text-dark">M</span>
                                                                                        @else
                                                                                            <span class="badge bg-success">SM</span>
                                                                                        @endif
                                                                                    </span>
                                                                                @endif
                                                                                @if($penggal2)
                                                                                    <span><strong>P2:</strong>
                                                                                        @if($penggal2->tahapPencapaian == 'AM')
                                                                                            <span class="badge bg-warning text-dark">AM</span>
                                                                                        @elseif($penggal2->tahapPencapaian == 'M')
                                                                                            <span class="badge bg-info text-dark">M</span>
                                                                                        @else
                                                                                            <span class="badge bg-success">SM</span>
                                                                                        @endif
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @elseif($isGeneralSubject)
                                                            {{-- Standardized table structure for general subjects --}}
                                                            @php
                                                                $generalCriteria = [
                                                                    'Pengecaman & Kenal Huruf/Nombor',
                                                                    'Sebutan & Bunyi',
                                                                    'Kemahiran Membaca',
                                                                    'Kemahiran Menulis',
                                                                    'Kefahaman & Aplikasi'
                                                                ];
                                                            @endphp
                                                            @foreach($generalCriteria as $index => $criteria)
                                                                @php
                                                                    $itemLabel = $criteria;
                                                                    $itemId = str_replace([' ', '&'], '_', $criteria);
                                                                    $penggal1Key = $itemLabel . '_Penggal 1';
                                                                    $penggal2Key = $itemLabel . '_Penggal 2';
                                                                    $penggal1 = $prestasi->has($penggal1Key) ? $prestasi->get($penggal1Key)->first() : null;
                                                                    $penggal2 = $prestasi->has($penggal2Key) ? $prestasi->get($penggal2Key)->first() : null;
                                                                @endphp
                                                                <tr>
                                                                    <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                                                    <td class="fw-semibold">{{ $itemLabel }}</td>
                                                                    <td>
                                                                        <div class="d-flex justify-content-center gap-3">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="AM"
                                                                                       id="item{{ $itemId }}_AM">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_AM">
                                                                                    <span class="badge bg-warning text-dark">AM</span> Ansur Maju
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="M"
                                                                                       id="item{{ $itemId }}_M">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_M">
                                                                                    <span class="badge bg-info text-dark">M</span> Maju
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="SM"
                                                                                       id="item{{ $itemId }}_SM">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_SM">
                                                                                    <span class="badge bg-success">SM</span> Sangat Maju
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        @if($penggal1 || $penggal2)
                                                                            <div class="mt-2 small text-muted">
                                                                                @if($penggal1)
                                                                                    <span class="me-3"><strong>P1:</strong>
                                                                                        @if($penggal1->tahapPencapaian == 'AM')
                                                                                            <span class="badge bg-warning text-dark">AM</span>
                                                                                        @elseif($penggal1->tahapPencapaian == 'M')
                                                                                            <span class="badge bg-info text-dark">M</span>
                                                                                        @else
                                                                                            <span class="badge bg-success">SM</span>
                                                                                        @endif
                                                                                    </span>
                                                                                @endif
                                                                                @if($penggal2)
                                                                                    <span><strong>P2:</strong>
                                                                                        @if($penggal2->tahapPencapaian == 'AM')
                                                                                            <span class="badge bg-warning text-dark">AM</span>
                                                                                        @elseif($penggal2->tahapPencapaian == 'M')
                                                                                            <span class="badge bg-info text-dark">M</span>
                                                                                        @else
                                                                                            <span class="badge bg-success">SM</span>
                                                                                        @endif
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @elseif(is_array($ayatList) || $ayatList instanceof \Illuminate\Support\Collection)
                                                            {{-- Original table structure for other subjects --}}
                                                            @foreach($ayatList as $index => $ayatNum)
                                                                @php
                                                                    // Untuk Pratahfiz, gunakan nama surah secara langsung
                                                                    // Untuk subjek lain, tambah prefix "Ayat "
                                                                    $itemLabel = $isPratahfiz ? $ayatNum : "Ayat " . $ayatNum;
                                                                    $itemId = $isPratahfiz ? str_replace(['\'', ' ', '-'], '_', $ayatNum) : $ayatNum;
                                                                    $penggal1Key = $itemLabel . '_Penggal 1';
                                                                    $penggal2Key = $itemLabel . '_Penggal 2';
                                                                    $penggal1 = $prestasi->has($penggal1Key) ? $prestasi->get($penggal1Key)->first() : null;
                                                                    $penggal2 = $prestasi->has($penggal2Key) ? $prestasi->get($penggal2Key)->first() : null;
                                                                @endphp
                                                                <tr>
                                                                    <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                                                    <td class="fw-semibold">{{ $itemLabel }}</td>
                                                                    <td>
                                                                        <div class="d-flex justify-content-center gap-3">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="AM"
                                                                                       id="item{{ $itemId }}_AM">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_AM">
                                                                                    <span class="badge bg-warning text-dark">AM</span> Ansur Maju
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="M"
                                                                                       id="item{{ $itemId }}_M">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_M">
                                                                                    <span class="badge bg-info text-dark">M</span> Maju
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="radio"
                                                                                       name="assessments[{{ $itemLabel }}]"
                                                                                       value="SM"
                                                                                       id="item{{ $itemId }}_SM">
                                                                                <label class="form-check-label" for="item{{ $itemId }}_SM">
                                                                                    <span class="badge bg-success">SM</span> Sangat Maju
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        @if($penggal1 || $penggal2)
                                                                            <div class="mt-2 small text-muted">
                                                                                @if($penggal1)
                                                                                    <span class="me-3"><strong>P1:</strong>
                                                                                        @if($penggal1->tahapPencapaian == 'AM')
                                                                                            <span class="badge bg-warning text-dark">AM</span>
                                                                                        @elseif($penggal1->tahapPencapaian == 'M')
                                                                                            <span class="badge bg-info text-dark">M</span>
                                                                                        @else
                                                                                            <span class="badge bg-success">SM</span>
                                                                                        @endif
                                                                                    </span>
                                                                                @endif
                                                                                @if($penggal2)
                                                                                    <span><strong>P2:</strong>
                                                                                        @if($penggal2->tahapPencapaian == 'AM')
                                                                                            <span class="badge bg-warning text-dark">AM</span>
                                                                                        @elseif($penggal2->tahapPencapaian == 'M')
                                                                                            <span class="badge bg-info text-dark">M</span>
                                                                                        @else
                                                                                            <span class="badge bg-success">SM</span>
                                                                                        @endif
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="bi bi-save me-2"></i>Simpan Penilaian
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif($selectedClass && $selectedStudent && $selectedSubjek)
                                <div class="card shadow-sm border-0 rounded-4 mb-4">
                                    <div class="card-body text-center text-muted py-5">
                                        <i class="bi bi-exclamation-circle" style="font-size: 3rem;"></i>
                                        <p class="mt-3">Tiada senarai ayat untuk subjek ini.</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Information Box -->
                            @if(!$selectedClass)
                                <div class="card shadow-sm border-0 rounded-4 mb-4">
                                    <div class="card-body text-center text-muted py-5">
                                        <i class="bi bi-info-circle" style="font-size: 3rem;"></i>
                                        <p class="mt-3">Sila pilih kelas, murid dan subjek untuk mula menilai prestasi.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update hidden penggal field when dropdown changes
    function updatePenggalValue() {
        const penggalSelect = document.getElementById('penggal');
        const penggalInput = document.getElementById('penggalInput');
        if (penggalSelect && penggalInput) {
            const selectedValue = penggalSelect.value;
            penggalInput.value = selectedValue;
            // Add visual feedback
            if (selectedValue) {
                penggalSelect.classList.remove('is-invalid');
                penggalSelect.classList.add('is-valid');
            } else {
                penggalSelect.classList.remove('is-valid');
                penggalSelect.classList.add('is-invalid');
            }
        }
    }

    // Enhanced subject ID lookup with fallback
    function fetchSubjectIdWithFallback() {
        return new Promise((resolve, reject) => {
            const subjectIdInput = document.getElementById('subject_id');
            const selectedSubjek = '{{ $selectedSubjek }}';

            if (!selectedSubjek) {
                reject('No subject selected');
                return;
            }

            // Try AJAX first
            fetch('/api/get-subject-id?nama_subjek=' + encodeURIComponent('{{ $selectedSubjek }}'))
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.subject_id) {
                        subjectIdInput.value = data.subject_id;
                        console.log('Subject ID successfully retrieved via API:', data.subject_id);
                        resolve(data.subject_id);
                    } else {
                        console.error('Subject ID lookup failed:', data.error || 'Unknown error');
                        throw new Error(data.error || 'Subject not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching subject ID via primary API:', error);

                    // Fallback 1: try to get from existing prestasi records
                    @if($prestasi->isNotEmpty() && $prestasi->first()->subject_id)
                        const fallbackId = '{{ $prestasi->first()->subject_id }}';
                        subjectIdInput.value = fallbackId;
                        console.log('Using fallback subject ID from prestasi records:', fallbackId);
                        resolve(fallbackId);
                    @elseif($prestasi->isNotEmpty() && $prestasi->first()->subjek_id)
                        // Additional fallback for older records
                        const fallbackId = '{{ $prestasi->first()->subjek_id }}';
                        subjectIdInput.value = fallbackId;
                        console.log('Using fallback subject ID from subjek_id:', fallbackId);
                        resolve(fallbackId);
                    @else
                        // Fallback 2: try to find subject by name directly
                        fetch('/api/subjects-by-name?nama_subjek=' + encodeURIComponent(selectedSubjek))
                            .then(response => response.json())
                            .then(data => {
                                if (data.success && data.subjects && data.subjects.length > 0) {
                                    subjectIdInput.value = data.subjects[0].id;
                                    console.log('Using fallback subject ID from subjects-by-name API:', data.subjects[0].id);
                                    resolve(data.subjects[0].id);
                                } else {
                                    // Fallback 3: try to get subject ID from subjek table directly
                                    console.error('All API fallbacks failed, attempting direct subject lookup');
                                    reject('Could not determine subject ID after multiple attempts');
                                }
                            })
                            .catch(fallbackError => {
                                console.error('All subject ID lookup methods failed:', fallbackError);
                                reject('Could not determine subject ID');
                            });
                    @endif
                });
        });
    }

    // Set subject ID when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const subjectIdInput = document.getElementById('subject_id');
        const selectedSubjek = '{{ $selectedSubjek }}';

        if (subjectIdInput && selectedSubjek) {
            fetchSubjectIdWithFallback()
                .then(subjectId => {
                    console.log('Subject ID successfully set to:', subjectId);
                })
                .catch(error => {
                    console.error('Failed to set subject ID:', error);
                    // Show warning to user
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-warning mt-3';
                    alertDiv.innerHTML = `
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Amaran:</strong> Subject ID tidak dapat dijumpai untuk "${selectedSubjek}".
                        Penilaian mungkin tidak dapat disimpan. Sila muat semula halaman atau pilih subjek semula.
                    `;
                    // Insert after the subject select
                    const subjectSelect = document.getElementById('subjek');
                    if (subjectSelect) {
                        subjectSelect.parentNode.insertBefore(alertDiv, subjectSelect.nextSibling);
                    }
                });
        }
    });

<<<<<<< HEAD
    // Add form validation and AJAX submission
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{ route("guru.prestasiMurid.store") }}"]');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault(); // Prevent default form submission

=======
    // Add form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{ route("guru.prestasiMurid.store") }}"]');
        if (form) {
            form.addEventListener('submit', function(e) {
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
                const subjectIdInput = document.getElementById('subject_id');
                const penggalInput = document.getElementById('penggalInput');
                const penggalSelect = document.getElementById('penggal');

<<<<<<< HEAD
                // Ensure subject ID is set
                if (!subjectIdInput.value) {
                    try {
                        await fetchSubjectIdWithFallback();
                    } catch (error) {
                        alert('Subject ID tidak dapat diperoleh. Sila muat semula halaman.');
                        return false;
                    }
                }

                // Validate subject ID
                if (!subjectIdInput || !subjectIdInput.value) {
=======
                // Validate subject ID
                if (!subjectIdInput || !subjectIdInput.value) {
                    e.preventDefault();
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
                    alert('Subject ID tidak dijumpai. Sila muat semula halaman atau pilih subjek semula.');
                    if (penggalSelect) penggalSelect.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }

                // Validate penggal
                if (!penggalInput || !penggalInput.value) {
<<<<<<< HEAD
=======
                    e.preventDefault();
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
                    alert('Sila pilih Penggal sebelum menyimpan.');
                    if (penggalSelect) {
                        penggalSelect.focus();
                        penggalSelect.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        penggalSelect.classList.add('is-invalid');
                    }
                    return false;
                }

                // Check if any assessments are selected
                const assessments = form.querySelectorAll('input[name^="assessments"]:checked');
                if (assessments.length === 0) {
                    if (!confirm('Tiada penilaian dipilih. Adakah anda pasti ingin menyimpan penilaian kosong?')) {
<<<<<<< HEAD
=======
                        e.preventDefault();
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
                        return false;
                    }
                }

<<<<<<< HEAD
                // Collect form data
                const formData = new FormData(form);

                // Submit via AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        alert('BERJAYA DISIMPAN!');
                        // Optionally reload the page or update UI
                        location.reload();
                    } else {
                        alert('Ralat: ' + (data.message || 'Gagal menyimpan data'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ralat menyimpan data. Sila cuba lagi.');
                });

                return false;
=======
                return true;
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
            });
        }
    });
</script>

<<<<<<< HEAD
<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-check-circle me-2"></i>Berjaya!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                <p class="mt-3 mb-0" id="successMessage">Penilaian prestasi berjaya disimpan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Show success modal if success message exists
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Success message found:', '{{ session("success") }}');
            alert('{{ session("success") }}');
        });
    @endif
</script>

=======
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
<style>
    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .table th {
        background-color: #e7f1ff;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
    }

    /* Fix tab text readability */
    .nav-tabs .nav-link.active {
        color: #000 !important;
        background-color: rgba(255, 255, 255, 0.9) !important;
        border-color: #dee2e6 #dee2e6 #fff !important;
    }

    .nav-tabs .nav-link {
        color: #fff !important;
    }

    .nav-tabs .nav-link:hover {
        color: rgba(255, 255, 255, 0.8) !important;
    }
</style>
@endsection
