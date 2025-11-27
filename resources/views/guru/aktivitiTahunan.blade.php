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
                    <div class="row">
                        @php
                            $months = [
                                'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun',
                                'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'
                            ];
                        @endphp
                        @foreach($months as $index => $month)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <a href="{{ route('guru.aktivitiTahunanMonth', ['month' => $index + 1]) }}" class="card h-100 text-decoration-none">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ $month }}</h5>
                                        <div class="image-placeholder" style="height: 200px; background-color: #f8f9fa; border: 2px dashed #dee2e6; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                            <div class="text-muted">
                                                <i class="bi bi-image fs-1"></i>
                                                <p class="mb-0">Klik untuk lihat gambar {{ $month }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
