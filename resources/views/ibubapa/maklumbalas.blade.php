@extends('layouts.app')

@section('title', 'Maklum Balas')

@section('content')
<div class="container-fluid px-4">
	<div class="row mt-4">
		<div class="col-12">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-header bg-primary text-white fw-semibold">
					<i class="bi bi-chat-left-text me-2"></i> Maklum Balas
				</div>
				<div class="card-body">
					@if(session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
					@endif

					<h5>Hantar Maklum Balas</h5>
					<form method="POST" action="{{ route('ibubapa.storeMaklumBalas') }}">
						@csrf
						<div class="mb-3">
							<label for="subject" class="form-label">Subjek</label>
							<input type="text" class="form-control" id="subject" name="subject" required>
						</div>
						<div class="mb-3">
							<label for="category" class="form-label">Kategori</label>
							<select class="form-select" id="category" name="category" required>
								<option value="">Pilih Kategori</option>
								<option value="Guru">Guru</option>
								<option value="Aktiviti">Aktiviti</option>
								<option value="Sekolah">Sekolah</option>
								<option value="Lain-lain">Lain-lain</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="message" class="form-label">Mesej</label>
							<textarea class="form-control" id="message" name="message" rows="4" required></textarea>
						</div>
						<div class="mb-3">
							<label for="rating" class="form-label">Penilaian (1-5)</label>
							<select class="form-select" id="rating" name="rating" required>
								<option value="">Pilih Penilaian</option>
								<option value="1">1 - Sangat Tidak Puas</option>
								<option value="2">2 - Tidak Puas</option>
								<option value="3">3 - Sederhana</option>
								<option value="4">4 - Puas</option>
								<option value="5">5 - Sangat Puas</option>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Hantar Maklum Balas</button>
					</form>

					<hr>

					<h5>Maklum Balas Terdahulu</h5>
					@if($feedbacks->count())
						<div class="row">
							@foreach($feedbacks as $feedback)
								<div class="col-md-6 mb-3">
									<div class="card">
										<div class="card-body">
											<h6 class="card-title">{{ json_decode($feedback->kandungan)->subject }}</h6>
											<p class="card-text"><strong>Kategori:</strong> {{ json_decode($feedback->kandungan)->category }}</p>
											<p class="card-text"><strong>Mesej:</strong> {{ json_decode($feedback->kandungan)->message }}</p>
											<p class="card-text"><strong>Penilaian:</strong> {{ json_decode($feedback->kandungan)->rating }}/5</p>
											<p class="card-text"><small class="text-muted">Tarikh: {{ date('d/m/Y', strtotime($feedback->tarikh)) }}</small></p>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					@else
						<p class="text-muted">Tiada maklum balas lagi.</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
