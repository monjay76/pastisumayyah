@extends('layouts.app')

@section('title', 'Aktiviti Tahunan')

@section('content')
<div class="container-fluid px-4">
	<div class="row mt-4">
		<div class="col-12">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-header bg-primary text-white fw-semibold">
					<i class="bi bi-calendar-event me-2"></i> Aktiviti Tahunan
					@if(isset($selectedMonth))
						- {{ $monthName }}
					@endif
				</div>
				<div class="card-body">
					@if(isset($selectedMonth))
						<!-- Month specific content -->
						<div class="mb-3">
							<a href="{{ route('ibubapa.aktivitiTahunan') }}" class="btn btn-secondary">Kembali ke Aktiviti Tahunan</a>
						</div>
						@if($images->count())
							<div class="row">
								@foreach($images as $image)
									<div class="col-md-4 col-sm-6 mb-4">
										<div class="card h-100">
											<img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="Aktiviti {{ $monthName }}">
											<div class="card-body">
												<p class="card-text">Tarikh: {{ date('d/m/Y', strtotime($image->tarikh)) }}</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@else
							<p class="text-muted mb-0">Tiada gambar untuk bulan ini.</p>
						@endif
					@else
						<!-- Month selection -->
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
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function selectMonth() {
	const month = document.getElementById('month').value;
	if (month) {
		window.location.href = '{{ url("ibubapa/aktiviti-tahunan") }}/' + month;
	} else {
		alert('Sila pilih bulan terlebih dahulu.');
	}
}
</script>
@endsection
