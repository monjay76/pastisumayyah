@extends('layouts.app')

@section('title', 'Profil Anak')

@section('content')
<div class="container-fluid px-4">
	<div class="row mt-4">
		<div class="col-12">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-header bg-primary text-white fw-semibold">
					<i class="bi bi-people-fill me-2"></i> Profil Anak
				</div>
				<div class="card-body">
					<!-- Parent Information Section -->
					<div class="mb-4">
						<h6 class="fw-semibold mb-3">Maklumat Ibu Bapa</h6>
						<div class="table-responsive">
							<table class="table table-borderless">
								<tbody>
									<tr>
										<th style="width:30%;">Nama Ibu Bapa:</th>
										<td>{{ $parent->namaParent ?? '—' }}</td>
									</tr>
									<tr>
										<th>ID Ibu Bapa:</th>
										<td>{{ $parent->ID_Parent ?? '—' }}</td>
									</tr>
									<tr>
										<th>Emel:</th>
										<td>{{ $parent->emel ?? '—' }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<!-- Child Selection Section -->
					@if($children->isNotEmpty())
						<div class="mb-4">
							<h6 class="fw-semibold mb-3">Anak-Anak</h6>
							<div class="row">
								<div class="col-md-8">
									<select id="childSelector" class="form-select">
										@foreach($children as $index => $child)
											<option value="{{ $index }}" data-child-id="{{ $child->MyKidID }}">
												{{ $child->namaMurid }} ({{ $child->MyKidID }})
											</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<!-- Child Profile Section -->
						<div id="childProfileSection">
							@foreach($children as $index => $child)
								<div class="child-profile" id="childProfile_{{ $index }}" style="{{ $index > 0 ? 'display:none;' : '' }}">
									<!-- Profile Icon Section -->
									<div class="text-center mb-4">
										<div style="font-size: 80px; color: #333;">
											<i class="bi bi-person-circle"></i>
										</div>
										<h5 class="mt-3">{{ $child->namaMurid }}</h5>
									</div>

									<!-- Student Details Table -->
									<div style="margin-top:30px;">
										<h6 class="fw-semibold mb-3">Maklumat Peribadi</h6>
										<div class="table-responsive">
											<table class="table table-borderless">
												<tbody>
													<tr>
														<th style="width:30%;">Nama Murid:</th>
														<td>{{ $child->namaMurid }}</td>
													</tr>
													<tr>
														<th>No. MyKid:</th>
														<td>{{ $child->MyKidID }}</td>
													</tr>
													<tr>
														<th>Tarikh Lahir:</th>
														<td>{{ $child->tarikhLahir ? \Carbon\Carbon::parse($child->tarikhLahir)->format('d F Y') : '—' }}</td>
													</tr>
													<tr>
														<th>Kelas:</th>
														<td>{{ $child->kelas ?? '—' }}</td>
													</tr>
													<tr>
														<th>Alamat:</th>
														<td>{{ $child->alamat ?? '—' }}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							@endforeach
						</div>
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
    if (childSelector) {
        childSelector.addEventListener('change', function() {
            const selectedIndex = this.value;
            const allProfiles = document.querySelectorAll('.child-profile');

            allProfiles.forEach(profile => {
                profile.style.display = 'none';
            });

            const selectedProfile = document.getElementById('childProfile_' + selectedIndex);
            if (selectedProfile) {
                selectedProfile.style.display = 'block';
            }
        });
    }
});
</script>
@endpush
