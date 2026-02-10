@extends('layouts.app')

@section('title', 'Maklum Balas')

@section('content')
<div class="container-fluid px-4 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #1b5e20;">Pusat Maklum Balas</h2>
                <p class="text-secondary">Suara anda membantu kami membina masa depan yang lebih baik untuk anak-anak.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="card-header p-4" style="background: #2E7D32;">
                            <h5 class="mb-0 text-white fw-600">
                                <i class="bi bi-pencil-square me-2"></i>Hantar Maklum Balas
                            </h5>
                        </div>

                        <div class="card-body p-4 bg-white">
                            @if(session('success'))
                                <div class="alert alert-success border-0 rounded-3 d-flex align-items-center mb-4" role="alert">
                                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('ibubapa.storeMaklumBalas') }}" id="feedbackForm">
                                @csrf

                                <div class="mb-3">
                                    <label for="category" class="form-label small fw-bold text-uppercase text-muted">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select custom-input" id="category" name="category" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Pujian" {{ old('category') == 'Pujian' ? 'selected' : '' }}>⭐ Pujian</option>
                                        <option value="Cadangan" {{ old('category') == 'Cadangan' ? 'selected' : '' }}>💡 Cadangan</option>
                                        <option value="Pertanyaan Perkembangan Murid" {{ old('category') == 'Pertanyaan Perkembangan Murid' ? 'selected' : '' }}>❓ Pertanyaan</option>
                                        <option value="Lain-lain" {{ old('category') == 'Lain-lain' ? 'selected' : '' }}>📌 Lain-lain</option>
                                    </select>
                                    @error('category')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label small fw-bold text-uppercase text-muted">Mesej Anda <span class="text-danger">*</span></label>
                                    <textarea class="form-control custom-input" id="message" name="message" rows="4" 
                                              placeholder="Tuliskan ulasan atau cadangan anda..." required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-uppercase text-muted d-block">Penilaian Kepuasan <span class="text-danger">*</span></label>
                                    <div class="rating-container bg-light rounded-3 p-3 text-center">
                                        <div class="d-flex justify-content-center gap-1" id="starRating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" class="star-btn" data-rating="{{ $i }}">★</button>
                                            @endfor
                                        </div>
                                        <div id="ratingText" class="small mt-2 fw-600 text-muted">Pilih rating</div>
                                    </div>
                                    <input type="hidden" id="rating" name="rating" value="">
                                    @error('rating')
                                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-submit w-100 py-3 shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i>Hantar Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0" style="color: #2E7D32;">
                            <i class="bi bi-clock-history me-2"></i>Rekod Maklum Balas
                        </h5>
                        <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 border">
                            {{ $feedbacks->count() }} Rekod
                        </span>
                    </div>

                    <div class="scroll-container" style="max-height: 700px; overflow-y: auto; padding-right: 10px;">
                        @if($feedbacks->count())
                            @foreach($feedbacks as $feedback)
                                @php
                                    $content = json_decode($feedback->kandungan);
                                    $ratingLabels = [1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Sederhana', 4 => 'Puas', 5 => 'Sangat Puas'];
                                    $categoryEmojis = ['Pujian' => '⭐', 'Cadangan' => '💡', 'Pertanyaan Perkembangan Murid' => '❓', 'Lain-lain' => '📌'];
                                @endphp
                                <div class="card border-0 shadow-sm rounded-4 mb-3 feedback-card-item">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between mb-3">
                                            <span class="badge rounded-pill px-3 py-2" style="background: rgba(46, 125, 50, 0.1); color: #2E7D32;">
                                                {{ $categoryEmojis[$content->category] ?? '' }} {{ $content->category }}
                                            </span>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $content->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <p class="card-text text-dark mb-3" style="font-size: 0.95rem; line-height: 1.6;">
                                            "{{ $content->message }}"
                                        </p>

                                        <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-2">
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bi bi-calendar-event me-2"></i>
                                                {{ \Carbon\Carbon::parse($feedback->tarikh)->format('d M Y') }}
                                            </div>
                                            <span class="small fw-bold text-success">{{ $ratingLabels[$content->rating] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card border-0 rounded-4 p-5 text-center shadow-sm bg-white">
                                <img src="https://illustrations.popsy.co/green/no-messages.svg" alt="Empty" style="height: 150px;" class="mb-3">
                                <h6 class="text-muted">Tiada sejarah maklum balas ditemui.</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Input Styling */
    .custom-input {
        background-color: #f1f3f5 !important;
        border: 2px solid transparent !important;
        padding: 0.8rem 1rem !important;
        border-radius: 12px !important;
        transition: all 0.3s ease !important;
    }

    .custom-input:focus {
        background-color: #ffffff !important;
        border-color: #2E7D32 !important;
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1) !important;
    }

    /* Star Rating Styling */
    .star-btn {
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: #dee2e6;
        transition: all 0.2s ease;
        padding: 0;
        line-height: 1;
    }

    .star-btn.active, .star-btn:hover {
        color: #ffc107;
        transform: scale(1.15);
    }

    /* Button Styling */
    .btn-submit {
        background: #2E7D32;
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: #1b5e20;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(46, 125, 50, 0.2);
        color: white;
    }

    /* Card History Animation */
    .feedback-card-item {
        transition: transform 0.3s ease;
    }

    .feedback-card-item:hover {
        transform: translateX(5px);
        border-left: 5px solid #2E7D32 !important;
    }

    /* Custom Scrollbar */
    .scroll-container::-webkit-scrollbar {
        width: 6px;
    }
    .scroll-container::-webkit-scrollbar-track {
        background: transparent;
    }
    .scroll-container::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    @media (max-width: 991.98px) {
        .scroll-container { max-height: none !important; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starBtns = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating');
        const ratingText = document.getElementById('ratingText');
        
        const ratingLabels = {
            1: 'Sangat Tidak Puas 😞',
            2: 'Tidak Puas 😕',
            3: 'Sederhana 😐',
            4: 'Puas 🙂',
            5: 'Sangat Puas 😄'
        };

        starBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const rating = this.dataset.rating;
                ratingInput.value = rating;
                updateStars(rating);
            });

            btn.addEventListener('mouseenter', function() {
                updateStars(this.dataset.rating);
            });
        });

        document.getElementById('starRating').addEventListener('mouseleave', function() {
            updateStars(ratingInput.value || 0);
        });

        function updateStars(rating) {
            starBtns.forEach(btn => {
                const isSelected = btn.dataset.rating <= rating;
                btn.classList.toggle('active', isSelected);
                btn.style.color = isSelected ? '#ffc107' : '#dee2e6';
            });
            ratingText.textContent = ratingLabels[rating] || 'Pilih rating anda';
            if(rating > 0) ratingText.style.color = '#2E7D32';
        }
    });
</script>
@endsection