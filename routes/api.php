<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PekerjaanController;
use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\SuratMasukController;
use App\Http\Controllers\API\SuratDisposisiController;
use App\Http\Controllers\API\AuthSuratController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->users();
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('get-pegawai', [AuthController::class, 'getPegawai'])->name('getPegawai');
Route::group(['middleware' => ['authapi:sanctum']], function () {
  Route::group(array('prefix' => 'pekerjaan'), function () {
    Route::post('/', [PekerjaanController::class, 'list_pekerjaan'])->name('list-pekerjaan');
    Route::post('create-pekerjaan', [PekerjaanController::class, 'create_pekerjaan'])->name('create-pekerjaan');
    Route::post('get-kegiatan-jabatan', [PekerjaanController::class, 'getKegiatanJabatan'])->name('getKegiatanJabatan');
  });
  Route::group(array('prefix' => 'absensi'), function () {
    Route::post('/', [AbsensiController::class, 'index'])->name('index');
    Route::post('create-absensi', [AbsensiController::class, 'create_absen'])->name('create-absen');
    Route::post('list-absensi', [AbsensiController::class, 'list_absen'])->name('list-absen');
  });
});
Route::group(array('prefix' => 'surat-masuk'), function () {
  Route::get('/', [SuratMasukController::class, 'indexSuratMasuk'])->name('index-surat-masuk');
  Route::post('create-surat-masuk', [SuratMasukController::class, 'createSuratMasuk'])->name('create-surat-masuk');
});
Route::get('user', [SuratMasukController::class, 'indexUser'])->name('index-user');
Route::get('surat-disposisi', [SuratDisposisiController::class, 'indexSuratDisposisi'])->name('index-surat-disposisi');

Route::post('/surat-login', [AuthSuratController::class, 'login'])->name('index-login');
