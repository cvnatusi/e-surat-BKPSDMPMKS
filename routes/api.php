<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PekerjaanController;
use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\ASNController;
use App\Http\Controllers\API\SuratMasukController;
use App\Http\Controllers\API\SuratDisposisiController;
use App\Http\Controllers\API\AuthSuratController;
use App\Http\Controllers\API\DataMaster\BidangController;
use App\Http\Controllers\API\DataMaster\InstansiController;
use App\Http\Controllers\API\DataMaster\JabatanController;
use App\Http\Controllers\API\DataMaster\JenisSuratController;
use App\Http\Controllers\API\DataMaster\LevelPenggunaController;
use App\Http\Controllers\API\DataMaster\MasterASNController;
use App\Http\Controllers\API\DataMaster\PenandaTanganSuratController;
use App\Http\Controllers\API\DataMaster\PenggunaController;
use App\Http\Controllers\API\DataMaster\SifatSuratController;
use App\Http\Controllers\API\SuratKeluarController;
use Psy\CodeCleaner\FunctionContextPass;

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


# API ANDOROID E-SURAT
Route::post('/surat-login', [AuthSuratController::class, 'login'])->name('index-login');

Route::group(array('prefix' => 'surat-masuk'), function () {
  Route::get('/', [SuratMasukController::class, 'indexSuratMasuk'])->name('index-surat-masuk');
  // Route::get('/get-sifat-surat', [SuratMasukController::class, 'getSifatSurat'])->name('get-sifat-surat');
  // Route::get('/get-jenis-surat', [SuratMasukController::class, 'getJenisSurat'])->name('get-jenis-surat');
  Route::get('/get-detail-surat-masuk/{id}', [SuratMasukController::class, 'getDetailSuratMasuk'])->name('get-detail-surat-masuk');
  // Route::get('/get-pengirim-surat', [SuratMasukController::class, 'getPengirimSurat'])->name('get-pengirim-surat');
  Route::get('/download-pdf-surat-masuk/{id}', [SuratMasukController::class, 'downloadFileSuratMasuk'])->name('download-pdf-surat-masuk');
  Route::post('/create-surat-masuk', [SuratMasukController::class, 'createSuratMasuk'])->name('create-surat-masuk');
  Route::post('/get-range-surat-masuk', [SuratMasukController::class, 'getRangeSuratMasuk'])->name('get-range-surat-masuk');
});

Route::group(array('prefix' => 'surat-disposisi'), function () {
  Route::get('/', [SuratDisposisiController::class, 'indexSuratDisposisi'])->name('index-surat-disposisi');
  Route::get('/get-diteruskan-kepada', [SuratDisposisiController::class, 'diteruskanKepada'])->name('get-diteruskan-kepada');
  Route::get('/get-dengan-hormat-harap', [SuratDisposisiController::class, 'denganHarap'])->name('get-dengan-hormat-harap');
  Route::post('/store-surat-disposisi', [SuratDisposisiController::class, 'storeSuratDisposisi'])->name('store-surat-disposisi');
});

Route::group(array('prefix' => 'surat-keluar'), function () {
  Route::get('/', [SuratKeluarController::class, 'index'])->name('index-surat-keluar');
});

Route::group(array('prefix' => 'data-master'), function () {
  Route::group(array('prefix' => 'pengguna'), function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('index-pengguna');
  });
  Route::group(array('prefix' => 'level-pengguna'), function () {
    Route::get('/', [LevelPenggunaController::class, 'index'])->name('index-level-pengguna');
  });
  Route::group(array('prefix' => 'instansi'), function () {
    Route::get('/', [InstansiController::class, 'index'])->name('index-instansi');
  });
  Route::group(array('prefix' => 'bidang'), function () {
    Route::get('/', [BidangController::class, 'index'])->name('index-bidang');
  });
  Route::group(array('prefix' => 'asn'), function () {
    Route::get('/', [ASNController::class, 'getASN'])->name('get-asn');
  });
  Route::group(array('prefix' => 'jabatan'), function () {
    Route::get('/', [JabatanController::class, 'index'])->name('index-jabatan');
  });
  Route::group(array('prefix' => 'jenis-surat'), function () {
    Route::get('/', [JenisSuratController::class, 'index'])->name('index-jenis-surat');
  });
  Route::group(array('prefix' => 'sifat-surat'), function () {
    Route::get('/', [SifatSuratController::class, 'index'])->name('index-sifat-surat');
  });
  Route::group(array('prefix' => 'penanda-tangan-surat'), function () {
    Route::get('/', [PenandaTanganSuratController::class, 'index'])->name('index-sifat-surat');
  });
});




