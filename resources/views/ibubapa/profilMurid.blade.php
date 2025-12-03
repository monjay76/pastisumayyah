@extends('layouts.app')

@section('title', 'Profil Murid')

@section('content')
<div class="container-fluid px-4">
	<div class="row mt-4">
		<div class="col-12">
			<div class="card shadow-sm border-0 rounded-4">
				<div class="card-header bg-primary text-white fw-semibold">
					<i class="bi bi-person-fill me-2"></i> Profil Murid
				</div>
				<div class="card-body">
					<!-- Profile Icon Section -->
					<div class="text-center mb-4">
						<div style="font-size: 80px; color: #333;">
							<i class="bi bi-person-circle"></i>
						</div>
						<h5 class="mt-3">Profil Murid</h5>
					</div>

					<!-- Student Information Section -->
					<div class="placeholder" role="img" aria-label="Butiran Profil Murid">
						<div style="text-align:center; color:#9a9a9a; padding:40px 20px;">
							<p>Butiran profil murid akan dipaparkan di sini</p>
						</div>
					</div>

					<!-- Student Details Table -->
					<div style="margin-top:30px;">
						<h6 class="fw-semibold mb-3">Maklumat Peribadi</h6>
						<div class="table-responsive">
							<table class="table table-borderless">
								<tbody>
									<tr>
										<th style="width:30%;">Nama Murid:</th>
										<td>—</td>
									</tr>
									<tr>
										<th>No. Kad Pengenalan:</th>
										<td>—</td>
									</tr>
									<tr>
										<th>Tarikh Lahir:</th>
										<td>—</td>
									</tr>
									<tr>
										<th>Kelas:</th>
										<td>—</td>
									</tr>
									<tr>
										<th>Alamat:</th>
										<td>—</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
