@extends('layouts.app')

@section('title', 'Aktiviti Tahunan')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-success text-white fw-semibold">
                    <i class="bi bi-calendar-event me-2"></i> Aktiviti Tahunan
                </div>
                <div class="card-body">
                    <h5>Pilih Bulan</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="month" class="form-label">Bulan</label>
                            <select class="form-select" id="month" required>
                                <option value="">Pilih Bulan</option>
                                @php
                                    $months = [
                                        'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun',
                                        'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
                                    ];
                                @endphp
                                @foreach($months as $index => $month)
                                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="selectMonth()">Pilih Bulan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectMonth() {
    const month = document.getElementById('month').value;
    if (month) {
        window.location.href = '{{ url("guru/aktiviti-tahunan") }}/' + month;
    } else {
        alert('Sila pilih bulan terlebih dahulu.');
    }
}
</script>
@endsection
