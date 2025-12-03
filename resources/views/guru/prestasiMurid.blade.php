@extends('layouts.app')

@section('title', 'Prestasi Murid')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <!-- Form Section: Kemaskini Prestasi Murid -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-pencil-square me-2"></i> Kemaskini Prestasi Murid :
                </div>
                <div class="card-body">
                    <div class="placeholder" role="img" aria-label="Form Kemaskini Prestasi">
                        <p style="color:#999; text-align:center;">Form untuk kemaskini prestasi murid akan dipaparkan di sini</p>
                    </div>
                </div>
            </div>

            <!-- Records Section: Rekod Prestasi Murid Terkini -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-secondary text-white fw-semibold d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-list-check me-2"></i> Rekod Prestasi Murid Terkini :</span>
                    <div>
                        <button class="btn btn-sm btn-light" style="border-radius:18px; margin-right:8px;">Edit</button>
                        <button class="btn btn-sm btn-light" style="border-radius:18px;">Padam</button>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($prestasi) && $prestasi->count())
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Murid</th>
                                        <th>Kategori Prestasi</th>
                                        <th>Tahun</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($prestasi as $record)
                                        <tr>
                                            <td>{{ $record->murid ? $record->murid->namaMurid : 'N/A' }}</td>
                                            <td>{{ $record->kategoriPrestasi ?? '-' }}</td>
                                            <td>{{ $record->tahun ?? '-' }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                                <form action="#" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Anda pasti?');">Padam</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="placeholder" role="img" aria-label="Tiada Rekod Prestasi">
                            <p style="color:#999; text-align:center;">Tiada rekod prestasi ditemui</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
