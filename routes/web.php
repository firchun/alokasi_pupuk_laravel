<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\JenisPupukController;
use App\Http\Controllers\KelompokTaniController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokPupukController;
use App\Http\Controllers\UserController;
use App\Models\KelompokTani;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
});
Route::get('/invoice', function () {
    return view('pages.invoice');
});
Route::get('/pengajuan_pupuk', function () {
    return view('pages.pengajuan');
});
//api
Route::get('/get-kelompok/{id}', [KelompokTaniController::class, 'getKelompok'])->name('get-kelompok');

Auth::routes(['reset' => false]);
Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //kelompok tani managemen
    Route::get('/kelompok-tani/{id}', [KelompokTaniController::class, 'index'])->name('kelompok-tani');
    Route::post('/kelompok-tani/store',  [KelompokTaniController::class, 'store'])->name('kelompok-tani.store');
    Route::get('/kelompok-tani/edit/{id}',  [KelompokTaniController::class, 'edit'])->name('kelompok-tani.edit');
    Route::delete('/kelompok-tani/delete/{id}',  [KelompokTaniController::class, 'destroy'])->name('kelompok-tani.delete');
    //stok managemen
    Route::get('/stok', [StokPupukController::class, 'index'])->name('stok');
    Route::post('/stok/store',  [StokPupukController::class, 'store'])->name('stok.store');
    Route::get('/stok/edit/{id}',  [StokPupukController::class, 'edit'])->name('stok.edit');
    Route::delete('/stok/delete/{id}',  [StokPupukController::class, 'destroy'])->name('stok.delete');
    Route::get('/stok-datatable', [StokPupukController::class, 'getStokDataTable']);
    //jenis pupuk managemen
    Route::get('/jenis-pupuk', [JenisPupukController::class, 'index'])->name('jenis-pupuk');
    Route::post('/jenis-pupuk/store',  [JenisPupukController::class, 'store'])->name('jenis-pupuk.store');
    Route::get('/jenis-pupuk/edit/{id}',  [JenisPupukController::class, 'edit'])->name('jenis-pupuk.edit');
    Route::delete('/jenis-pupuk/delete/{id}',  [JenisPupukController::class, 'destroy'])->name('jenis-pupuk.delete');
    Route::get('/jenis-pupuk-datatable', [JenisPupukController::class, 'getJenisPupukDataTable']);
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/poktan', [UserController::class, 'poktan'])->name('poktan');
    Route::get('/distributor', [UserController::class, 'distributor'])->name('distributor');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable/{role}', [UserController::class, 'getUsersDataTable']);
});