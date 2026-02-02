@extends('layouts.app')

@section('title', 'Laporan Anak')

@section('content')
<div class="container-fluid px-4">
	<div class="row mt-4">
		<div class="col-12">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-header bg-primary text-white fw-semibold">
					<i class="bi bi-file-earmark-text me-2"></i> Laporan Anak
				</div>
				<div class="card-body">
					<!-- Child Selection Section -->
					@if($children->isNotEmpty())
						<div class="mb-4">
							<h6 class="fw-semibold mb-3">Pilih Anak</h6>
							<div class="row">
								<div class="col-md-6">
									<select id="childSelector" class="form-select">
										<option value="">-- Sila pilih anak --</option>
										@foreach($children as $child)
											<option value="{{ $child->MyKidID }}" {{ request()->input('mykid') == $child->MyKidID ? 'selected' : '' }}>
												{{ $child->namaMurid }} ({{ $child->MyKidID }})
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						@if($selectedChild)
							<!-- Summary Statistics -->
							<div class="row mb-4">
								<!-- Prestasi Statistics -->
								<div class="col-md-3 mb-3">
									<div class="card bg-info text-white h-100">
										<div class="card-body text-center">
											<i class="bi bi-file-earmark-text display-4"></i>
											<h4>{{ $totalRecords }}</h4>
											<p class="mb-0">Jumlah Rekod Prestasi</p>
										</div>
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="card bg-warning text-white h-100">
										<div class="card-body text-center">
											<i class="bi bi-book display-4"></i>
											<h4>{{ $subjects->count() }}</h4>
											<p class="mb-0">Jenis Subjek</p>
										</div>
									</div>
								</div>
								<div class="col-md-3 mb-3">
									<div class="card bg-danger text-white h-100">
										<div class="card-body text-center">
											<i class="bi bi-graph-up display-4"></i>
											<h4>{{ number_format($avgMarkah, 1) }}</h4>
											<p class="mb-0">Purata Markah</p>
										</div>
									</div>
								</div>
								<!-- Kehadiran Statistics -->
								<div class="col-md-3 mb-3">
									<div class="card bg-success text-white h-100">
										<div class="card-body text-center">
											<i class="bi bi-calendar-check display-4"></i>
											<h4>{{ $attendancePercentage }}%</h4>
											<p class="mb-0">Peratusan Kehadiran</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Additional Kehadiran Stats -->
							<div class="row mb-4">
								<div class="col-md-4 mb-3">
									<div class="card bg-light h-100">
										<div class="card-body text-center">
											<h5 class="text-primary">{{ $totalDays }}</h5>
											<p class="mb-0 text-muted">Jumlah Hari Direkod</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="card bg-light h-100">
										<div class="card-body text-center">
											<h5 class="text-success">{{ $presentDays }}</h5>
											<p class="mb-0 text-muted">Hari Hadir</p>
										</div>
									</div>
								</div>
								<div class="col-md-4 mb-3">
									<div class="card bg-light h-100">
										<div class="card-body text-center">
											<h5 class="text-danger">{{ $absentDays }}</h5>
											<p class="mb-0 text-muted">Hari Tidak Hadir</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Tabs for Prestasi and Kehadiran -->
							<ul class="nav nav-tabs mb-3" id="reportTabs" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" id="prestasi-tab" data-bs-toggle="tab" data-bs-target="#prestasi" type="button" role="tab">
										<i class="bi bi-bar-chart-line me-2"></i>Laporan Prestasi
									</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" id="kehadiran-tab" data-bs-toggle="tab" data-bs-target="#kehadiran" type="button" role="tab">
										<i class="bi bi-calendar-check me-2"></i>Laporan Kehadiran
									</button>
								</li>
							</ul>

							<div class="tab-content" id="reportTabsContent">
								<!-- Prestasi Tab -->
								<div class="tab-pane fade show active" id="prestasi" role="tabpanel">
									<!-- Prestasi Filters -->
									<div class="card border-0 bg-light mb-3" style="padding: 0.75rem;">
										<form action="{{ route('ibubapa.laporan') }}" method="GET" id="prestasiFilterForm">
											<input type="hidden" name="mykid" value="{{ request()->input('mykid') }}">
											<div class="row g-2 align-items-end">
												<div class="col-md-3">
													<label for="subjek" class="form-label mb-1 small">Subjek</label>
													<select class="form-select form-select-sm" id="subjek" name="subjek">
														<option value="">Semua</option>
														@foreach($subjectList as $subj)
															<option value="{{ $subj }}" {{ request()->input('subjek') == $subj ? 'selected' : '' }}>
																{{ $subj }}
															</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-2">
													<label for="penggal" class="form-label mb-1 small">Penggal</label>
													<select class="form-select form-select-sm" id="penggal" name="penggal">
														<option value="">Semua</option>
														@foreach($penggalList as $pgg)
															<option value="{{ $pgg }}" {{ request()->input('penggal') == $pgg ? 'selected' : '' }}>
																P{{ $pgg }}
															</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-2">
													<label for="tarikh_dari" class="form-label mb-1 small">Dari</label>
													<input type="date" class="form-control form-control-sm" id="tarikh_dari" name="tarikh_dari" value="{{ request()->input('tarikh_dari') }}">
												</div>
												<div class="col-md-2">
													<label for="tarikh_hingga" class="form-label mb-1 small">Hingga</label>
													<input type="date" class="form-control form-control-sm" id="tarikh_hingga" name="tarikh_hingga" value="{{ request()->input('tarikh_hingga') }}">
												</div>
												<div class="col-md-3">
													<button type="submit" class="btn btn-primary btn-sm w-100">
														<i class="bi bi-funnel"></i> Tapis
													</button>
												</div>
											</div>
										</form>
									</div>

									<!-- Prestasi Table -->
									<div class="table-responsive">
										<table class="table table-bordered table-hover align-middle" id="prestasiTable">
											<thead class="table-dark">
												<tr>
													<th class="text-center" style="width: 5%;">No.</th>
													<th style="width: 15%;">Subjek</th>
													<th style="width: 15%;">Kriteria/Ayat</th>
													<th style="width: 10%;">Penggal</th>
													<th style="width: 15%;">Tahap Pencapaian</th>
													<th style="width: 10%;">Markah</th>
													<th style="width: 15%;">Nama Guru</th>
													<th style="width: 15%;">Tarikh Rekod</th>
												</tr>
											</thead>
											<tbody>
												@if($prestasi->isNotEmpty())
													@foreach($prestasi as $index => $record)
													<tr>
														<td class="text-center">{{ $index + 1 }}</td>
														<td>{{ $record->subjek }}</td>
														<td>{{ $record->kriteria_nama ?: 'N/A' }}</td>
														<td class="text-center">{{ $record->penggal }}</td>
														<td class="text-center">
															@if($record->tahap_pencapaian == 'AM' || $record->tahap_pencapaian == 1)
																<span class="badge bg-warning text-dark">Ansur Maju</span>
															@elseif($record->tahap_pencapaian == 'M' || $record->tahap_pencapaian == 2)
																<span class="badge bg-info text-dark">Maju</span>
															@elseif($record->tahap_pencapaian == 'SM' || $record->tahap_pencapaian == 3)
																<span class="badge bg-success">Sangat Maju</span>
															@else
																<span class="badge bg-secondary">{{ $record->tahap_pencapaian }}</span>
															@endif
														</td>
														<td class="text-center">
															<span class="badge bg-primary">{{ $record->markah ?: 'N/A' }}</span>
														</td>
														<td>{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
														<td>{{ $record->tarikhRekod ? \Carbon\Carbon::parse($record->tarikhRekod)->format('d/m/Y') : 'N/A' }}</td>
													</tr>
													@endforeach
												@else
													<tr>
														<td colspan="8" class="text-center text-muted py-4">
															<i class="bi bi-info-circle" style="font-size: 2rem;"></i>
															<p class="mt-2 mb-0">Tiada data prestasi dijumpai.</p>
														</td>
													</tr>
												@endif
											</tbody>
										</table>
									</div>
								</div>

								<!-- Kehadiran Tab -->
								<div class="tab-pane fade" id="kehadiran" role="tabpanel">
									<!-- Kehadiran Filters -->
									<div class="card border-0 bg-light mb-3" style="padding: 0.75rem;">
										<form action="{{ route('ibubapa.laporan') }}" method="GET" id="kehadiranFilterForm">
											<input type="hidden" name="mykid" value="{{ request()->input('mykid') }}">
											<div class="row g-2 align-items-end">
												<div class="col-md-4">
													<label for="kehadiran_tarikh_dari" class="form-label mb-1 small">Dari</label>
													<input type="date" class="form-control form-control-sm" id="kehadiran_tarikh_dari" name="kehadiran_tarikh_dari" value="{{ request()->input('kehadiran_tarikh_dari') }}">
												</div>
												<div class="col-md-4">
													<label for="kehadiran_tarikh_hingga" class="form-label mb-1 small">Hingga</label>
													<input type="date" class="form-control form-control-sm" id="kehadiran_tarikh_hingga" name="kehadiran_tarikh_hingga" value="{{ request()->input('kehadiran_tarikh_hingga') }}">
												</div>
												<div class="col-md-4">
													<button type="submit" class="btn btn-primary btn-sm w-100">
														<i class="bi bi-funnel"></i> Tapis
													</button>
												</div>
											</div>
										</form>
									</div>

									<!-- Kehadiran Table -->
									<div class="table-responsive">
										<table class="table table-bordered table-hover align-middle" id="kehadiranTable">
											<thead class="table-dark">
												<tr>
													<th class="text-center" style="width: 5%;">No.</th>
													<th style="width: 30%;">Tarikh</th>
													<th style="width: 30%;">Status</th>
													<th style="width: 35%;">Direkod Oleh</th>
												</tr>
											</thead>
											<tbody>
												@if($kehadiran->isNotEmpty())
													@foreach($kehadiran as $index => $record)
													<tr>
														<td class="text-center">{{ $index + 1 }}</td>
														<td>{{ $record->tarikh ? \Carbon\Carbon::parse($record->tarikh)->format('d/m/Y') : 'N/A' }}</td>
														<td>
															@if($record->status == 'hadir')
																<span class="badge bg-success">Hadir</span>
															@elseif($record->status == 'tidak_hadir')
																<span class="badge bg-danger">Tidak Hadir</span>
															@else
																<span class="badge bg-secondary">{{ $record->status }}</span>
															@endif
														</td>
														<td>{{ $record->guru ? $record->guru->namaGuru : 'N/A' }}</td>
													</tr>
													@endforeach
												@else
													<tr>
														<td colspan="4" class="text-center text-muted py-4">
															<i class="bi bi-info-circle" style="font-size: 2rem;"></i>
															<p class="mt-2 mb-0">Tiada data kehadiran dijumpai.</p>
														</td>
													</tr>
												@endif
											</tbody>
										</table>
									</div>
								</div>
							</div>
						@else
							<div class="alert alert-info text-center">
								<i class="bi bi-info-circle me-2"></i>
								Sila pilih anak untuk melihat laporan.
							</div>
						@endif
					@else
						<div class="alert alert-info text-center">
							<i class="bi bi-info-circle me-2"></i>
							Tiada rekod anak dijumpai. Sila hubungi pentadbir sekolah jika anda percaya ini adalah kesilapan.
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const childSelector = document.getElementById('childSelector');
    if (!childSelector) return;

    childSelector.addEventListener('change', function() {
        const selectedMyKid = this.value;
        if (selectedMyKid) {
            // Build URL with selected child and preserve existing filters
            const url = new URL(window.location.href);
            url.searchParams.set('mykid', selectedMyKid);
            // Remove other filters when changing child
            url.searchParams.delete('subjek');
            url.searchParams.delete('penggal');
            url.searchParams.delete('tarikh_dari');
            url.searchParams.delete('tarikh_hingga');
            url.searchParams.delete('kehadiran_tarikh_dari');
            url.searchParams.delete('kehadiran_tarikh_hingga');
            window.location.href = url.toString();
        } else {
            // If no child selected, go to base laporan page
            window.location.href = '{{ route("ibubapa.laporan") }}';
        }
    });
});
</script>
@endpush
