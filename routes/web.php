<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PentadbirController;

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

// Papar maklumat pentadbir individu
Route::get('/pentadbir/{id}', [PentadbirController::class, 'show'])->name('pentadbir.show');

// Kemas kini pentadbir
Route::put('/pentadbir/{id}', [PentadbirController::class, 'update'])->name('pentadbir.update');

// Padam pentadbir
Route::delete('/pentadbir/{id}', [PentadbirController::class, 'destroy'])->name('pentadbir.destroy');

