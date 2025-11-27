<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PentadbirController;
use App\Http\Controllers\GuruPageController;

Route::get('/', function () {
    return view('welcome');
});

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

// Maklumat Ibu Bapa (must be before {id} route)
Route::get('/pentadbir/maklumat-ibubapa', [PentadbirController::class, 'maklumatIbuBapa'])->name('pentadbir.maklumatIbuBapa');

// Papar maklumat pentadbir individu
Route::get('/pentadbir/{id}', [PentadbirController::class, 'show'])->name('pentadbir.show');

// Kemas kini pentadbir
Route::put('/pentadbir/{id}', [PentadbirController::class, 'update'])->name('pentadbir.update');

// Padam pentadbir
Route::delete('/pentadbir/{id}', [PentadbirController::class, 'destroy'])->name('pentadbir.destroy');


// Guru pages (only the pages required for Guru role)
Route::get('/guru/senarai-murid', [GuruPageController::class, 'senaraiMurid'])->name('guru.senaraiMurid');
Route::get('/guru/profil-murid/{id?}', [GuruPageController::class, 'profilMurid'])->name('guru.profilMurid');
Route::get('/guru/senarai-kehadiran', [GuruPageController::class, 'senaraiKehadiran'])->name('guru.senaraiKehadiran');
Route::post('/guru/kehadiran', [GuruPageController::class, 'storeKehadiran'])->name('guru.storeKehadiran');
Route::get('/guru/edit-kehadiran', [GuruPageController::class, 'editKehadiran'])->name('guru.editKehadiran');
Route::get('/guru/aktiviti-tahunan', [GuruPageController::class, 'aktivitiTahunan'])->name('guru.aktivitiTahunan');
Route::get('/guru/aktiviti-tahunan/{month}', [GuruPageController::class, 'aktivitiTahunanMonth'])->name('guru.aktivitiTahunanMonth');
Route::post('/guru/aktiviti-tahunan/store-image', [GuruPageController::class, 'storeAktivitiImage'])->name('guru.storeAktivitiImage');
Route::delete('/guru/aktiviti-tahunan/delete-image/{id}', [GuruPageController::class, 'deleteAktivitiImage'])->name('guru.deleteAktivitiImage');
Route::get('/guru/prestasi-murid', [GuruPageController::class, 'prestasiMurid'])->name('guru.prestasiMurid');
Route::get('/guru/laporan', [GuruPageController::class, 'laporan'])->name('guru.laporan');
Route::post('/guru/bulk-action', [GuruPageController::class, 'bulkAction'])->name('guru.bulkAction');
Route::get('/guru/add-murid', [GuruPageController::class, 'addMurid'])->name('guru.addMurid');
Route::post('/guru/add-murid', [GuruPageController::class, 'storeMurid'])->name('guru.storeMurid');

// Ibu Bapa pages (simple view routes)
Route::get('/ibubapa/profil-murid', function () {
    return view('ibubapa.profilMurid');
})->name('ibubapa.profilMurid');

Route::get('/ibubapa/maklumbalas', function () {
    return view('ibubapa.maklumbalas');
})->name('ibubapa.maklumbalas');

Route::get('/ibubapa/aktiviti-tahunan', function () {
    return view('ibubapa.aktivitiTahunan');
})->name('ibubapa.aktivitiTahunan');

Route::get('/ibubapa/laporan', function () {
    return view('ibubapa.laporan');
})->name('ibubapa.laporan');

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

