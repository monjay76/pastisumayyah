<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PentadbirController;
use App\Http\Controllers\GuruPageController;

Route::get('/', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Papar senarai pentadbir (paparan view)
Route::get('/pentadbir', function () {
    $users = \App\Models\User::whereIn('role', ['guru', 'ibubapa'])->latest()->get();
    return view('pentadbir.daftarAkaun', compact('users'));
})->name('pentadbir.index');

// Papar borang tambah pentadbir
Route::get('/pentadbir/create', [PentadbirController::class, 'create'])->name('pentadbir.create');

// Simpan pentadbir baru
Route::post('/pentadbir', [PentadbirController::class, 'store'])->name('pentadbir.store');

// Daftar akaun routes (must be before {id} route)
Route::get('/pentadbir/daftar-akaun', [PentadbirController::class, 'createUser'])->name('pentadbir.createUser');
Route::post('/pentadbir/daftar-akaun', [PentadbirController::class, 'storeUser'])->name('pentadbir.storeUser');

// Senarai Murid (must be before {id} route)
Route::get('/pentadbir/senarai-murid', [PentadbirController::class, 'senaraiMurid'])->name('pentadbir.senaraiMurid');

// Profil Murid (must be before {id} route)
Route::get('/pentadbir/profil-murid', [PentadbirController::class, 'profilMurid'])->name('pentadbir.profilMurid');

// Maklumat Guru (must be before {id} route)
Route::get('/pentadbir/maklumat-guru', [PentadbirController::class, 'maklumatGuru'])->name('pentadbir.maklumatGuru');
// Pentadbir - Guru edit/delete routes
Route::post('/pentadbir/guru/bulk-action', [PentadbirController::class, 'guruBulkAction'])->name('pentadbir.guruBulkAction');
Route::get('/pentadbir/guru/{id}/edit', [PentadbirController::class, 'editGuru'])->name('pentadbir.editGuru');
Route::put('/pentadbir/guru/{id}', [PentadbirController::class, 'updateGuru'])->name('pentadbir.updateGuru');
Route::delete('/pentadbir/guru/{id}', [PentadbirController::class, 'destroyGuru'])->name('pentadbir.destroyGuru');

// Maklumat Ibu Bapa (must be before {id} route)
Route::get('/pentadbir/maklumat-ibubapa', [PentadbirController::class, 'maklumatIbuBapa'])->name('pentadbir.maklumatIbuBapa');
// Pentadbir - Ibu Bapa edit/delete routes
Route::post('/pentadbir/ibubapa/bulk-action', [PentadbirController::class, 'parentBulkAction'])->name('pentadbir.parentBulkAction');
Route::get('/pentadbir/ibubapa/{id}/edit', [PentadbirController::class, 'editIbuBapa'])->name('pentadbir.editIbuBapa');
Route::put('/pentadbir/ibubapa/{id}', [PentadbirController::class, 'updateIbuBapa'])->name('pentadbir.updateIbuBapa');
Route::delete('/pentadbir/ibubapa/{id}', [PentadbirController::class, 'destroyIbuBapa'])->name('pentadbir.destroyIbuBapa');

// Aktiviti Tahunan (Pentadbir)
Route::get('/pentadbir/aktiviti-tahunan', [PentadbirController::class, 'aktivitiTahunan'])->name('pentadbir.aktivitiTahunan');
Route::get('/pentadbir/aktiviti-tahunan/{month}', [PentadbirController::class, 'aktivitiTahunanMonth'])->name('pentadbir.aktivitiTahunanMonth');

// API endpoint for subject ID lookup
Route::get('/api/get-subject-id', function () {
    $namaSubjek = trim(request('nama_subjek'));
    if (!$namaSubjek) {
        return response()->json(['success' => false, 'error' => 'Nama subjek diperlukan']);
    }

    $subject = \App\Models\Subjek::whereRaw('LOWER(nama_subjek) = LOWER(?)', [$namaSubjek])->first();

    if (!$subject) {
        return response()->json(['success' => false, 'error' => 'Subjek tidak dijumpai']);
    }

    return response()->json(['success' => true, 'subject_id' => $subject->id]);
});

// Fallback API endpoint for subject lookup by name
Route::get('/api/subjects-by-name', function () {
    $namaSubjek = request('nama_subjek');
    if (!$namaSubjek) {
        return response()->json(['success' => false, 'error' => 'Nama subjek diperlukan']);
    }

    $subjects = \App\Models\Subjek::where('nama_subjek', 'like', '%' . $namaSubjek . '%')
        ->orderBy('nama_subjek')
        ->get();

    if ($subjects->isEmpty()) {
        return response()->json(['success' => false, 'error' => 'Tiada subjek dijumpai']);
    }

    return response()->json([
        'success' => true,
        'subjects' => $subjects->map(function ($subject) {
            return [
                'id' => $subject->id,
                'nama_subjek' => $subject->nama_subjek,
                'created_at' => $subject->created_at,
                'updated_at' => $subject->updated_at
            ];
        })
    ]);
});

// API endpoint for parent search
Route::get('/api/search-parents', function () {
    $query = request('q', '');

    if (strlen($query) < 2 && !empty($query)) {
        return response()->json([
            'success' => false,
            'error' => 'Minimum 2 karakter diperlukan untuk carian'
        ]);
    }

    $parents = \App\Models\IbuBapa::query()
        ->where(function($q) use ($query) {
            $q->where('namaParent', 'like', '%' . $query . '%')
              ->orWhere('ID_Parent', 'like', '%' . $query . '%')
              ->orWhere('emel', 'like', '%' . $query . '%');
        })
        ->orderBy('namaParent')
        ->limit(20)
        ->get();

    return response()->json([
        'success' => true,
        'parents' => $parents->map(function ($parent) {
            return [
                'ID_Parent' => $parent->ID_Parent,
                'namaParent' => $parent->namaParent,
                'emel' => $parent->emel,
                'noTel' => $parent->noTel
            ];
        })
    ]);
});

// Laporan Prestasi (Pentadbir)
Route::get('/pentadbir/laporan', [PentadbirController::class, 'laporan'])->name('pentadbir.laporan');

// Senarai Subjek (Pentadbir)
Route::get('/pentadbir/senarai-subjek', [PentadbirController::class, 'senaraiSubjek'])->name('pentadbir.senaraiSubjek');
Route::post('/pentadbir/senarai-subjek', [PentadbirController::class, 'storeSubjek'])->name('pentadbir.storeSubjek');
Route::put('/pentadbir/senarai-subjek/{id}', [PentadbirController::class, 'updateSubjek'])->name('pentadbir.updateSubjek');
Route::delete('/pentadbir/senarai-subjek/{id}', [PentadbirController::class, 'destroySubjek'])->name('pentadbir.destroySubjek');

// Papar maklumat pentadbir individu
Route::get('/pentadbir/{id}', [PentadbirController::class, 'show'])->name('pentadbir.show');

// Kemas kini pentadbir
Route::put('/pentadbir/{id}', [PentadbirController::class, 'update'])->name('pentadbir.update');

// Padam pentadbir
Route::delete('/pentadbir/{id}', [PentadbirController::class, 'destroy'])->name('pentadbir.destroy');


// Guru pages (only the pages required for Guru role)
Route::get('/guru/senarai-murid', [GuruPageController::class, 'senaraiMurid'])->name('guru.senaraiMurid');
Route::get('/guru/profil-murid/{id?}', [GuruPageController::class, 'profilMurid'])->name('guru.profilMurid');
Route::post('/guru/profil-murid/{id}/update-picture', [GuruPageController::class, 'updateProfilePicture'])->name('guru.updateProfilePicture');
Route::get('/guru/senarai-kehadiran', [GuruPageController::class, 'senaraiKehadiran'])->name('guru.senaraiKehadiran');
Route::post('/guru/kehadiran', [GuruPageController::class, 'storeKehadiran'])->name('guru.storeKehadiran');
Route::get('/guru/edit-kehadiran', [GuruPageController::class, 'editKehadiran'])->name('guru.editKehadiran');
Route::get('/guru/aktiviti-tahunan', [GuruPageController::class, 'aktivitiTahunan'])->name('guru.aktivitiTahunan');
Route::get('/guru/aktiviti-tahunan/{month}', [GuruPageController::class, 'aktivitiTahunanMonth'])->name('guru.aktivitiTahunanMonth');
Route::post('/guru/aktiviti-tahunan/store-image', [GuruPageController::class, 'storeAktivitiImage'])->name('guru.storeAktivitiImage');
Route::post('/guru/aktiviti-tahunan/delete-image/{id}', [GuruPageController::class, 'deleteAktivitiImage'])->name('guru.deleteAktivitiImage');
Route::match(['GET'], '/guru/prestasi-murid', [\App\Http\Controllers\Guru\PrestasiController::class, 'index'])->name('guru.prestasiMurid');
Route::match(['GET'], '/guru/prestasi-murid/get-performance', [\App\Http\Controllers\Guru\PrestasiController::class, 'getPerformance'])->name('guru.getPerformance');
Route::post('/guru/prestasi-murid', [\App\Http\Controllers\Guru\PrestasiController::class, 'storeOrUpdate'])->name('guru.prestasiMurid.store');
Route::get('/guru/laporan-individu', [\App\Http\Controllers\Guru\PrestasiController::class, 'laporanIndividu'])->name('guru.laporanIndividu');
Route::get('/guru/laporan', [GuruPageController::class, 'laporan'])->name('guru.laporan');
Route::post('/guru/bulk-action', [GuruPageController::class, 'bulkAction'])->name('guru.bulkAction');
Route::get('/guru/add-murid', [GuruPageController::class, 'addMurid'])->name('guru.addMurid');
Route::post('/guru/add-murid', [GuruPageController::class, 'storeMurid'])->name('guru.storeMurid');

// Ibu Bapa pages (simple view routes)
Route::get('/ibubapa/profil-murid', [App\Http\Controllers\IbuBapaController::class, 'profilMurid'])->name('ibubapa.profilMurid');

Route::get('/ibubapa/maklumbalas', [App\Http\Controllers\IbuBapaController::class, 'maklumBalas'])->name('ibubapa.maklumbalas');
Route::post('/ibubapa/maklumbalas', [App\Http\Controllers\IbuBapaController::class, 'storeMaklumBalas'])->name('ibubapa.storeMaklumBalas');

Route::get('/ibubapa/aktiviti-tahunan', [App\Http\Controllers\IbuBapaController::class, 'aktivitiTahunan'])->name('ibubapa.aktivitiTahunan');
Route::get('/ibubapa/aktiviti-tahunan/{month}', [App\Http\Controllers\IbuBapaController::class, 'aktivitiTahunanMonth'])->name('ibubapa.aktivitiTahunanMonth');

Route::get('/ibubapa/laporan', [App\Http\Controllers\IbuBapaController::class, 'laporan'])->name('ibubapa.laporan');

// Murid CRUD for guru: edit / update / destroy / show
use App\Http\Controllers\MuridController;

Route::get('/guru/murid/{id}', [MuridController::class, 'show'])->name('guru.murid.show');
Route::get('/guru/murid/{id}/edit', [MuridController::class, 'edit'])->name('guru.murid.edit');
Route::put('/guru/murid/{id}', [MuridController::class, 'update'])->name('guru.murid.update');
Route::delete('/guru/murid/{id}', [MuridController::class, 'destroy'])->name('guru.murid.destroy');

// Redirect base /guru to senarai murid
Route::get('/guru', function () {
    return redirect()->route('guru.senaraiMurid');
})->name('guru.index');
