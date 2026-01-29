@extends('layouts.app')

@section('title', 'Maklum Balas')

@section('content')
<div class="container-fluid px-4 py-5" style="background: #f8f9fa; min-height: 100vh;">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<!-- Form Section -->
			<div class="card shadow-sm border-0 rounded-lg mb-5" style="background: white;">
				<div class="card-header bg-white border-0 pb-4">
					<h4 class="mb-2" style="color: #2E7D32; font-weight: 700;">
						<i class="bi bi-chat-left-dots me-2"></i>Hantar Maklum Balas
					</h4>
					<p class="text-muted small mb-0">Kami menghargai pendapat dan maklum balas anda untuk peningkatan berkala.</p>
				</div>

				<div class="card-body pt-0">
					@if(session('success'))
						<div class="alert alert-success border-0 rounded-lg mb-4" style="background: #d4edda; color: #155724;">
							<i class="bi bi-check-circle me-2"></i>
							{{ session('success') }}
						</div>
					@endif

					<form method="POST" action="{{ route('ibubapa.storeMaklumBalas') }}" id="feedbackForm">
						@csrf

						<!-- Category Selection -->
						<div class="mb-4">
							<label for="category" class="form-label" style="color: #2E7D32; font-weight: 600; font-size: 0.95rem;">
								Kategori <span class="text-danger">*</span>
							</label>
							<select class="form-select rounded-lg border-0" id="category" name="category" required 
									style="background: #f8f9fa; padding: 0.75rem 1rem; border: 2px solid #e9ecef; font-size: 0.95rem;">
								<option value="">-- Pilih Kategori --</option>
								<option value="Pujian" {{ old('category') == 'Pujian' ? 'selected' : '' }}>
									⭐ Pujian
								</option>
								<option value="Cadangan" {{ old('category') == 'Cadangan' ? 'selected' : '' }}>
									💡 Cadangan
								</option>
								<option value="Pertanyaan Perkembangan Murid" {{ old('category') == 'Pertanyaan Perkembangan Murid' ? 'selected' : '' }}>
									❓ Pertanyaan Perkembangan Murid
								</option>
								<option value="Lain-lain" {{ old('category') == 'Lain-lain' ? 'selected' : '' }}>
									📌 Lain-lain
								</option>
							</select>
							@error('category')
								<small class="text-danger d-block mt-2">{{ $message }}</small>
							@enderror
						</div>

						<!-- Message Input -->
						<div class="mb-4">
							<label for="message" class="form-label" style="color: #2E7D32; font-weight: 600; font-size: 0.95rem;">
								Mesej <span class="text-danger">*</span>
							</label>
							<textarea class="form-control rounded-lg border-0" id="message" name="message" rows="5" 
									placeholder="Tuliskan mesej anda di sini... Sila nyatakan dengan jelas dan ringkas untuk membantu kami memahami maklumbalas anda dengan lebih baik."
									required style="background: #f8f9fa; padding: 0.75rem 1rem; border: 2px solid #e9ecef !important; font-size: 0.95rem; resize: vertical;">{{ old('message') }}</textarea>
							@error('message')
								<small class="text-danger d-block mt-2">{{ $message }}</small>
							@enderror
						</div>

						<!-- Star Rating -->
						<div class="mb-5">
							<label class="form-label" style="color: #2E7D32; font-weight: 600; font-size: 0.95rem; display: block; margin-bottom: 1rem;">
								Penilaian <span class="text-danger">*</span>
							</label>
							<div class="d-flex gap-3 align-items-center" id="starRating">
								<div class="d-flex gap-2">
									@for($i = 1; $i <= 5; $i++)
										<button type="button" class="star-btn" data-rating="{{ $i }}" 
												style="background: none; border: none; font-size: 2.5rem; cursor: pointer; color: #d4af37; opacity: 0.4; transition: all 0.2s ease;">
											★
										</button>
									@endfor
								</div>
								<span id="ratingText" style="color: #6c757d; font-weight: 500; min-width: 200px;">Pilih penilaian anda</span>
							</div>
							<input type="hidden" id="rating" name="rating" value="">
							@error('rating')
								<small class="text-danger d-block mt-2">{{ $message }}</small>
							@enderror
						</div>

						<!-- Submit Button -->
						<button type="submit" class="btn w-100 rounded-lg" style="background: #2E7D32; color: white; padding: 0.75rem; font-weight: 600; border: none; transition: all 0.3s ease; font-size: 1rem;">
							<i class="bi bi-send me-2"></i>Hantar Maklum Balas
						</button>
					</form>
				</div>
			</div>

			<!-- Previous Feedback Section -->
			@if($feedbacks->count())
				<div class="mb-4">
					<h5 style="color: #2E7D32; font-weight: 700; margin-bottom: 1.5rem;">
						<i class="bi bi-chat-dots me-2"></i>Maklum Balas Terdahulu
					</h5>

					@foreach($feedbacks as $feedback)
						@php
							$content = json_decode($feedback->kandungan);
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
						<div class="card shadow-sm border-0 rounded-lg mb-3" style="background: #f8f9fa; border-left: 4px solid #2E7D32;">
							<div class="card-body">
								<div class="d-flex justify-content-between align-items-start mb-2">
									<div>
										<h6 class="mb-1" style="color: #2E7D32; font-weight: 600;">
											{{ $categoryEmojis[$content->category] ?? '' }} {{ $content->category }}
										</h6>
										<small class="text-muted">
											<i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($feedback->tarikh)->format('d/m/Y') }}
										</small>
									</div>
									<div class="text-warning" style="font-size: 1.1rem;">
										@for($i = 1; $i <= 5; $i++)
											@if($i <= $content->rating)
												★
											@else
												<span style="opacity: 0.3;">★</span>
											@endif
										@endfor
									</div>
								</div>
								<p class="card-text mb-0" style="color: #495057; line-height: 1.6;">
									{{ $content->message }}
								</p>
								<small class="text-muted d-block mt-2">
									{{ $ratingLabels[$content->rating] ?? 'N/A' }}
								</small>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="alert alert-info border-0 rounded-lg" style="background: #e7f3ff; color: #0c5460;">
					<i class="bi bi-info-circle me-2"></i>
					<strong>Belum ada maklum balas.</strong> Maklum balas anda akan dipaparkan di sini setelah dihantar.
				</div>
			@endif
		</div>
	</div>
</div>

<style>
	.form-control:focus,
	.form-select:focus {
		border-color: #2E7D32 !important;
		box-shadow: 0 0 0 0.2rem rgba(46, 125, 50, 0.15) !important;
	}

	.btn:hover {
		background-color: #1b5e20 !important;
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
	}

	.btn:active {
		transform: translateY(0);
	}

	.star-btn:hover,
	.star-btn.active {
		opacity: 1 !important;
		transform: scale(1.2);
	}

	.star-btn:hover ~ .star-btn {
		opacity: 0.4 !important;
	}

	.card {
		transition: all 0.3s ease;
	}

	.card:hover {
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08) !important;
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const starBtns = document.querySelectorAll('.star-btn');
		const ratingInput = document.getElementById('rating');
		const ratingText = document.getElementById('ratingText');
		
		const ratingLabels = {
			1: 'Sangat Tidak Puas',
			2: 'Tidak Puas',
			3: 'Sederhana',
			4: 'Puas',
			5: 'Sangat Puas'
		};

		starBtns.forEach(btn => {
			btn.addEventListener('click', function(e) {
				e.preventDefault();
				const rating = this.dataset.rating;
				ratingInput.value = rating;
				
				// Update star display
				starBtns.forEach(b => {
					if (b.dataset.rating <= rating) {
						b.classList.add('active');
						b.style.opacity = '1';
					} else {
						b.classList.remove('active');
						b.style.opacity = '0.4';
					}
				});
				
				// Update text
				ratingText.textContent = ratingLabels[rating];
				ratingText.style.color = '#2E7D32';
			});

			// Hover effect
			btn.addEventListener('mouseenter', function() {
				const rating = this.dataset.rating;
				starBtns.forEach(b => {
					if (b.dataset.rating <= rating) {
						b.style.opacity = '1';
					} else {
						b.style.opacity = '0.4';
					}
				});
			});
		});

		// Reset on mouse leave
		document.getElementById('starRating').addEventListener('mouseleave', function() {
			const currentRating = ratingInput.value;
			starBtns.forEach(b => {
				if (currentRating && b.dataset.rating <= currentRating) {
					b.style.opacity = '1';
				} else if (!currentRating) {
					b.style.opacity = '0.4';
				}
			});
		});
	});
</script>
@endsection

