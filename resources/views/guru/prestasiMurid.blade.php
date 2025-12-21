@extends('layouts.app')

@section('title', 'Prestasi Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <!-- Selection Section -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white fw-semibold">
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
            @if($selectedClass && $selectedStudent && $selectedSubjek && count($ayatList) > 0)
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-success text-white fw-semibold">
                        <i class="bi bi-pencil-square me-2"></i> Penilaian Prestasi Hafazan - {{ $selectedSubjek }}
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

                        <form method="POST" action="{{ route('guru.prestasiMurid.store') }}">
                            @csrf
                            <input type="hidden" name="MyKidID" value="{{ $selectedStudent->MyKidID }}">
                            <input type="hidden" name="subjek" value="{{ $selectedSubjek }}">

                            <!-- Select Penggal -->
                            <div class="mb-4">
                                <label for="penggal" class="form-label fw-bold">Pilih Penggal</label>
                                <select name="penggal" id="penggal" class="form-select w-auto" required>
                                    <option value="">-- Pilih Penggal --</option>
                                    <option value="Penggal 1">Penggal 1</option>
                                    <option value="Penggal 2">Penggal 2</option>
                                </select>
                            </div>

                            <!-- Assessment Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-primary">
                                        <tr>
                                            <th class="text-center" style="width: 10%;">No.</th>
                                            <th class="text-center" style="width: 25%;">Ayat</th>
                                            <th class="text-center" style="width: 65%;">Tahap Pencapaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(is_array($ayatList) || $ayatList instanceof \Illuminate\Support\Collection)
                                        @foreach($ayatList as $index => $ayatNum)
                                            @php
                                                $ayatLabel = "Ayat " . $ayatNum;
                                                $penggal1Key = $ayatLabel . '_Penggal 1';
                                                $penggal2Key = $ayatLabel . '_Penggal 2';
                                                $penggal1 = $prestasi->has($penggal1Key) ? $prestasi->get($penggal1Key)->first() : null;
                                                $penggal2 = $prestasi->has($penggal2Key) ? $prestasi->get($penggal2Key)->first() : null;
                                            @endphp
                                            <tr>
                                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                                <td class="fw-semibold">{{ $ayatLabel }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                   name="assessments[{{ $ayatLabel }}]" 
                                                                   value="AM" 
                                                                   id="ayat{{ $ayatNum }}_AM">
                                                            <label class="form-check-label" for="ayat{{ $ayatNum }}_AM">
                                                                <span class="badge bg-warning text-dark">AM</span> Ansur Maju
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                   name="assessments[{{ $ayatLabel }}]" 
                                                                   value="M" 
                                                                   id="ayat{{ $ayatNum }}_M">
                                                            <label class="form-check-label" for="ayat{{ $ayatNum }}_M">
                                                                <span class="badge bg-info text-dark">M</span> Maju
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" 
                                                                   name="assessments[{{ $ayatLabel }}]" 
                                                                   value="SM" 
                                                                   id="ayat{{ $ayatNum }}_SM">
                                                            <label class="form-check-label" for="ayat{{ $ayatNum }}_SM">
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
</style>
@endsection
