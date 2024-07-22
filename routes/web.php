<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMaster\InstansiController;
use App\Http\Controllers\DataMaster\JenisSuratController;
use App\Http\Controllers\DataMaster\MasterSuratController;
use App\Http\Controllers\DataMaster\SifatSuratController;
use App\Http\Controllers\DataMaster\PenggunaController;
use App\Http\Controllers\DataMaster\JabatanController;
use App\Http\Controllers\DataMaster\MasterASNController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratDisposisiController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\SuratTugasControllerOld;
use App\Http\Controllers\SuratSPPDController;
use App\Http\Controllers\SuratBASTController;
use App\Http\Controllers\SuratKeputusanController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\TteController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\DataMaster\PenandaTanganSuratController as PenandaTanganSurat;
use App\Http\Controllers\DataMaster\RoleController;
use App\Http\Controllers\Laporan\LaporanSuratMasukController;
use App\Http\Controllers\Laporan\LaporanSuratKeluarController;
use App\Http\Controllers\Laporan\LaporanSuratBASTController;
use App\Http\Controllers\Laporan\LaporanSuratKeputusanController;
use App\Http\Controllers\Laporan\LaporanSuratTugasController;
use App\Http\Controllers\Pengaturan\RolePermissionsController;
use App\Models\PenandaTanganSurat as ModelsPenandaTanganSurat;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [AuthController::class, 'login'])->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/doLogin', [AuthController::class, 'doLogin'])->name('doLogin');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/', function () {
// 	if (\Auth::check()) {
// 		return redirect()->route('dashboard');
// 	} else {
// 		return redirect()->route('dashboard');
// 	}
// });
Route::group(['middleware'=>'XSS'], function() {
	// Route::get('/product', 'ProductController@index');
	Route::group(['middleware' => 'auth'], function () {
		Route::get('/home', function () {
			if (\Auth::check()) {
				return redirect('/dashboard');
			} else {
				return redirect('/login');
			}
		});
		// IF AUTH
		Route::group(array('prefix' => 'dashboard'), function () {
			Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
			Route::post('/getCountSuratMasuk', [DashboardController::class, 'getCountSuratMasuk'])->name('getCountSuratMasuk');
			Route::post('/getCountSuratKeluar', [DashboardController::class, 'getCountSuratKeluar'])->name('getCountSuratKeluar');
			Route::post('/getCountSuratDisposisi', [DashboardController::class, 'getCountSuratDisposisi'])->name('getCountSuratDisposisi');
			Route::post('/getCountSuratTugas', [DashboardController::class, 'getCountSuratTugas'])->name('getCountSuratTugas');
			Route::post('/getCountSuratKeputusan', [DashboardController::class, 'getCountSuratKeputusan'])->name('getCountSuratKeputusan');
			Route::post('/getCountSuratBAST', [DashboardController::class, 'getCountSuratBAST'])->name('getCountSuratBAST');
			Route::post('/getCountSuratSPPD', [DashboardController::class, 'getCountSuratSPPD'])->name('getCountSuratSPPD');
			Route::post('/getChart', [DashboardController::class, 'getChart'])->name('getChart');
		});
		Route::group(array('prefix' => 'data-master'), function () {
			Route::group(array('prefix' => 'pengguna'), function () {
				Route::get('/', [PenggunaController::class, 'index'])->name('pengguna');
				Route::post('/form', [PenggunaController::class, 'form'])->name('form-pengguna');
				Route::post('/store', [PenggunaController::class, 'store'])->name('store-pengguna');
				Route::post('/destroy', [PenggunaController::class, 'destroy'])->name('destroy-pengguna');
			});
			Route::group(array('prefix' => 'level-pengguna'), function() {
				Route::get('/', [RoleController::class, 'index'])->name('level-pengguna');
				Route::post('/form', [RoleController::class, 'form'])->name('form-level-pengguna');
				Route::post('/store', [RoleController::class, 'store'])->name('store-level-pengguna');
			});
			Route::group(array('prefix' => 'instansi'), function () {
				Route::get('/', [InstansiController::class, 'index'])->name('instansi');
				Route::post('/form', [InstansiController::class, 'form'])->name('form-instansi');
				Route::post('/store', [InstansiController::class, 'store'])->name('store-instansi');
				Route::post('/destroy', [InstansiController::class, 'destroy'])->name('destroy-instansi');
			});
			Route::group(array('prefix' => 'bidang'), function () {
				Route::get('/', [BidangController::class, 'index'])->name('bidang');
				Route::get('/edit', [BidangController::class, 'edit'])->name('bidangEdit');
				Route::post('/store', [BidangController::class, 'store'])->name('bidangStore');
				Route::post('/destroy', [BidangController::class, 'destroy'])->name('bidangDestroy');
			});
			Route::group(array('prefix' => 'jenis-surat'), function () {
				Route::get('/', [JenisSuratController::class, 'index'])->name('jenis-surat');
				Route::post('/form', [JenisSuratController::class, 'form'])->name('form-jenis-surat');
				Route::post('/store', [JenisSuratController::class, 'store'])->name('store-jenis-surat');
				Route::post('/destroy', [JenisSuratController::class, 'destroy'])->name('destroy-jenis-surat');
			});
			Route::group(array('prefix' => 'sifat-surat'), function () {
				Route::get('/', [SifatSuratController::class, 'index'])->name('sifat-surat');
				Route::post('/form', [SifatSuratController::class, 'form'])->name('form-sifat-surat');
				Route::post('/store', [SifatSuratController::class, 'store'])->name('store-sifat-surat');
				Route::post('/destroy', [SifatSuratController::class, 'destroy'])->name('destroy-sifat-surat');
			});
			Route::group(array('prefix' => 'penanda-tangan-surat'), function () {
				Route::get('/', [PenandaTanganSurat::class, 'index'])->name('penandaTanganSurat');
				Route::post('/store', [PenandaTanganSurat::class, 'store'])->name('penandaTanganSuratStore');
				Route::get('/edit', [PenandaTanganSurat::class, 'edit'])->name('penandaTanganSuratEdit');
				Route::post('/destroy', [PenandaTanganSurat::class, 'destroy'])->name('penandaTanganSuratDestroy');
				Route::get('pengguna', [PenandaTanganSurat::class, 'getPengguna'])->name('get-pengguna-bylevel');
			});
			Route::group(array('prefix' => 'asn'), function () {
				Route::get('/', [MasterASNController::class, 'index'])->name('asn');
				Route::post('/form', [MasterASNController::class, 'form'])->name('form-asn');
				Route::post('/store', [MasterASNController::class, 'store'])->name('store-asn');
				Route::post('/destroy', [MasterASNController::class, 'destroy'])->name('destroy-asn');
			});
			Route::group(array('prefix' => 'jabatan'), function () {
				Route::get('/', [JabatanController::class, 'index'])->name('jabatan');
				Route::post('/form', [JabatanController::class, 'form'])->name('form-jabatan');
				Route::post('/store', [JabatanController::class, 'store'])->name('store-jabatan');
				Route::post('/destroy', [JabatanController::class, 'destroy'])->name('destroy-jabatan');
			});
			Route::group(array('prefix' => 'master-surat'), function () {
				Route::get('/', [MasterSuratController::class, 'index'])->name('master-surat');
				Route::post('/form', [MasterSuratController::class, 'form'])->name('form-master-surat');
				Route::post('/store', [MasterSuratController::class, 'store'])->name('store-master-surat');
				Route::post('/destroy', [MasterSuratController::class, 'destroy'])->name('destroy-master-surat');
			});
		});

		Route::group(array('prefix' => 'surat-masuk'), function () {
			Route::get('/', [SuratMasukController::class, 'index'])->name('surat-masuk');
			Route::post('/form', [SuratMasukController::class, 'form'])->name('form-surat-masuk');
			Route::post('/store', [SuratMasukController::class, 'store'])->name('store-surat-masuk');
			Route::post('/destroy', [SuratMasukController::class, 'destroy'])->name('destroy-surat-masuk');
			Route::post('/show', [SuratMasukController::class, 'show'])->name('show-surat-masuk');
			Route::post('/getSuratMasukByAgenda', [SuratMasukController::class, 'getSuratMasukByAgenda'])->name('getSuratMasukByAgenda');
			Route::post('/multiPrintDisposisi', [SuratMasukController::class, 'multiPrintDisposisi'])->name('multiPrintDisposisi');
			Route::post('/show-timeline', [SuratMasukController::class, 'showTimeline'])->name('show-timeline-surat-masuk');
			Route::get('/surat-dispos-kosong', [SuratMasukController::class, 'templateDisposisi'])->name('surat-dispos-kosong');
			Route::get('multi-download', [SuratMasukController::class, 'multiDownload'])->name('multi-download');
			Route::get('/show-trash', [SuratMasukController::class, 'showTrash'])->name('show-trash-surat-masuk');
			Route::post('/restore-surat', [SuratMasukController::class, 'restoreSurat'])->name('restoreSurat-surat-masuk');
			Route::post('/delete-surat', [SuratMasukController::class, 'deleteSurat'])->name('deleteSurat-surat-masuk');
			Route::post('/get-id-surat-masuk', [SuratMasukController::class, 'getId'])->name('get-id-surat-masuk');
			Route::post('/get-id-surat-masuk-deleted', [SuratMasukController::class, 'getIdSuratDeleted'])->name('get-id-surat-masuk-deleted');
			Route::post('/delete-all-surat', [SuratMasukController::class, 'deleteAll'])->name('delete-all-surat-masuk');
		});

		Route::group(array('prefix' => 'surat-keluar'), function () {
			Route::get('/', [SuratKeluarController::class, 'index'])->name('surat-keluar');
			Route::post('/form', [SuratKeluarController::class, 'form'])->name('form-surat-keluar');
			Route::post('/store', [SuratKeluarController::class, 'store'])->name('store-surat-keluar');
			Route::post('/destroy', [SuratKeluarController::class, 'destroy'])->name('destroy-surat-keluar');
			// Route::post('/list-surat-tugas', [SuratKeluarController::class, 'listSuratTugas'])->name('list-surat-tugas');
			Route::post('/list-surat-tugas-keluar', [SuratKeluarController::class, 'listSuratTugas'])->name('list-surat-tugas-keluar');
			Route::post('/list-sppd', [SuratKeluarController::class, 'listSPPD'])->name('list-sppd');
			Route::get('/cetakST', [SuratKeluarController::class, 'cetakST'])->name('cetakST');
			Route::get('/cetakSPPD', [SuratKeluarController::class, 'cetakSPPD'])->name('cetakSPPD');
			Route::post('/verifKABAN', [SuratKeluarController::class, 'verifKABAN'])->name('verifKABAN');
			Route::post('/show', [SuratKeluarController::class, 'show'])->name('show-surat-keluar');
			Route::post('/checkSuratKeluarByDate', [SuratKeluarController::class, 'checkSuratKeluarByDate'])->name('checkSuratKeluarByDate');
			Route::post('/get-id', [SuratKeluarController::class, 'getId'])->name('get-id-surat-keluar');
			Route::post('/delete-all-surat-keluar', [SuratKeluarController::class, 'deleteAll'])->name('delete-all-surat-keluar');
		});

		// Route::post('/store', [SuratTugasControllerOld::class, 'store'])->name('store-surat-tugas');

		Route::group(array('prefix' => 'surat-tugas'), function () {
			Route::get('/', [SuratTugasController::class, 'index'])->name('surat-tugas');
			Route::post('/form', [SuratTugasController::class, 'form'])->name('form-surat-tugas');
			Route::post('/store', [SuratTugasController::class, 'store'])->name('store-surat-tugas');
			Route::post('/destroy', [SuratTugasController::class, 'destroy'])->name('destroy-surat-tugas');
			Route::post('/destroyTujuan', [SuratTugasController::class, 'destroyTujuan'])->name('destroyTujuan-surat-tujuan');
			Route::post('/list-surat-tugas', [SuratTugasController::class, 'listSuratTugas'])->name('list-surat-tugas');
			Route::post('/list-sppd', [SuratTugasController::class, 'listSPPD'])->name('list-sppd');
			Route::get('/cetakST', [SuratTugasController::class, 'cetakST'])->name('cetakST');
			Route::get('/cetakSPPD', [SuratTugasController::class, 'cetakSPPD'])->name('cetakSPPD');
			Route::post('/buat-SPPD', [SuratTugasController::class, 'buatSPPD'])->name('buatSPPD');
			Route::get('/preview-surat-tugas', [SuratTugasController::class, 'previewST'])->name('previewST');
			Route::post('/verifikasi-ST', [SuratTugasController::class, 'verifikasiST'])->name('verifikasiST');
			Route::post('/get-id', [SuratTugasController::class, 'getId'])->name('get-id-surat-tugas');
			Route::get('/st-kosong', [SuratTugasController::class, 'stKosong'])->name('st-kosong');
			Route::post('/delete-all-st', [SuratTugasController::class, 'deleteAllSurat'])->name('delete-all-st');
		});
		Route::group(array('prefix' => 'surat-perjalanan-dinas'), function () {
			Route::get('/', [SuratSPPDController::class, 'index'])->name('surat-perjalanan-dinas');
			Route::post('/form', [SuratSPPDController::class, 'form'])->name('form-surat-perjalanan-dinas');
			Route::post('/show', [SuratSPPDController::class, 'show'])->name('show-surat-perjalanan-dinas');
			Route::post('/destroy', [SuratSPPDController::class, 'destroy'])->name('destroy-surat-perjalanan-dinas');
            Route::post('/get-id', [SuratSPPDController::class, 'getId'])->name('get-id-sppd');
			Route::post('/delete-all-surat-sppd', [SuratSPPDController::class, 'deleteAll'])->name('delete-all-surat-sppd');
		});
		Route::group(array('prefix' => 'surat-disposisi'), function () {
			Route::get('/', [SuratDisposisiController::class, 'index'])->name('surat-disposisi');
			Route::post('/form', [SuratDisposisiController::class, 'form'])->name('form-surat-disposisi');
			Route::post('/store', [SuratDisposisiController::class, 'store'])->name('store-surat-disposisi');
			Route::post('/destroy', [SuratDisposisiController::class, 'destroy'])->name('destroy-surat-disposisi');
			Route::post('/show', [SuratDisposisiController::class, 'show'])->name('show-surat-disposisi');
			Route::get('/cetakSD', [SuratDisposisiController::class, 'cetakSD'])->name('cetakSD');
			Route::get('/get-surat-masuk', [SuratDisposisiController::class, 'getSuratMasuk'])->name('get-surat-masuk');
			Route::post('/get-id', [SuratDisposisiController::class, 'getId'])->name('get-id');
			Route::post('/delete-all-surat-disposisi', [SuratDisposisiController::class, 'deleteAll'])->name('delete-all-surat-disposisi');
		});
		Route::group(array('prefix' => 'surat-lainnya'), function () {
			Route::group(array('prefix' => 'utama-surat-bast'), function () {
				Route::get('/', [SuratBASTController::class, 'index'])->name('utama-surat-bast');
				Route::post('/form', [SuratBASTController::class, 'form'])->name('form-surat-bast');
				Route::post('/store', [SuratBASTController::class, 'store'])->name('store-surat-bast');
				Route::post('/destroy', [SuratBASTController::class, 'destroy'])->name('destroy-surat-bast');
				Route::post('/show', [SuratBASTController::class, 'show'])->name('show-surat-bast');
				Route::post('/getSuratBASTByDate', [SuratBASTController::class, 'getSuratBASTByDate'])->name('getSuratBASTByDate');
				Route::post('/get-id-surat-bast', [SuratBASTController::class, 'getId'])->name('get-id-surat-bast');
				Route::post('/delete-all-surat-bast', [SuratBASTController::class, 'deleteAll'])->name('delete-all-surat-bast');
			});
			Route::group(array('prefix' => 'utama-surat-keputusan'), function () {
				Route::get('/', [SuratKeputusanController::class, 'index'])->name('utama-surat-keputusan');
				Route::post('/form', [SuratKeputusanController::class, 'form'])->name('form-surat-keputusan');
				Route::post('/store', [SuratKeputusanController::class, 'store'])->name('store-surat-keputusan');
				Route::post('/destroy', [SuratKeputusanController::class, 'destroy'])->name('destroy-surat-keputusan');
				Route::post('/show', [SuratKeputusanController::class, 'show'])->name('show-surat-keputusan');
				Route::post('/getSuratSKByDate', [SuratKeputusanController::class, 'getSuratSKByDate'])->name('getSuratSKByDate');
				Route::post('/get-id-surat-keputusan', [SuratKeputusanController::class, 'getId'])->name('get-id-surat-keputusan');
				Route::post('/delete-surat-keputusan', [SuratKeputusanController::class, 'deleteAll'])->name('delete-surat-keputusan');
			});
			Route::group(array('prefix' => 'tanda-tangan-elektronik'), function () {
				Route::get('/', [TteController::class, 'index'])->name('tanda-tangan-elektronik');
				Route::post('/form', [TteController::class, 'form'])->name('form-tanda-tangan-elektronik');
				Route::post('/destroy', [TteController::class, 'destroy'])->name('destroy-tanda-tangan-elektronik');
				Route::post('/show', [TteController::class, 'show'])->name('show-tanda-tangan-elektronik');
				Route::post('/get-ttd', [TteController::class, 'getTTD'])->name('getTTD');
				Route::post('/verifSurat', [TteController::class, 'verifSurat'])->name('verifSurat');
				Route::post('/savePDF', [TteController::class, 'savePDF'])->name('savePDF');
			});
		});
		Route::group(array('prefix' => 'pengaturan'), function () {
			Route::get('/', [PengaturanController::class, 'index'])->name('pengaturan');
			Route::post('/form', [PengaturanController::class, 'form'])->name('form-pengaturan');
			Route::post('/store', [PengaturanController::class, 'store'])->name('store-pengaturan');
			Route::group(array('prefix' => 'role-permission'), function () {
				Route::get('/', [RolePermissionsController::class, 'index'])->name('role-permission');
				Route::post('/form', [RolePermissionsController::class, 'form'])->name('form-role-permission');
				Route::post('/store', [RolePermissionsController::class, 'store'])->name('store-role-permission');
				Route::post('/destroy', [RolePermissionsController::class, 'destroy'])->name('destroy-role-permission');
			});
		});

		Route::group(array('prefix' => 'laporan'), function () {
			Route::group(array('prefix' => 'log-activity'), function () {
				Route::get('/', [LogActivityController::class, 'index'])->name('log-activity');
				Route::post('/show', [LogActivityController::class, 'show'])->name('show-log-activity');
			});
			Route::group(array('prefix' => 'laporan-surat-masuk'), function () {
				Route::get('/', [LaporanSuratMasukController::class, 'index'])->name('laporan-surat-masuk');
				Route::get('/excel/{range}/{paramTanggal}', [LaporanSuratMasukController::class, 'excel'])->name('excelLapSurMas');
				Route::get('/excel', [LaporanSuratMasukController::class, 'excel'])->name('excelLapSurMasuk');
			});
			Route::group(array('prefix' => 'laporan-surat-keluar'), function () {
				Route::get('/', [LaporanSuratKeluarController::class, 'index'])->name('laporan-surat-keluar');
				Route::get('/excel/{range}/{paramTanggal}', [LaporanSuratKeluarController::class, 'excel'])->name('excelLapSurKel');
				Route::get('/excel', [LaporanSuratKeluarController::class, 'excel'])->name('excelLapSurKeluar');
			});
			Route::group(array('prefix' => 'laporan-surat-tugas'), function () {
				Route::get('/', [LaporanSuratTugasController::class, 'index'])->name('laporan-surat-tugas');
				Route::get('/excel/{range}/{paramTanggal}', [LaporanSuratTugasController::class, 'excel'])->name('excelLapSurTug');
				Route::get('/excel', [LaporanSuratTugasController::class, 'excel'])->name('excelLapSurTugas');
			});
			Route::group(array('prefix' => 'laporan-surat-bast'), function () {
				Route::get('/', [LaporanSuratBASTController::class, 'index'])->name('laporan-surat-bast');
				Route::get('/excel/{range}/{paramTanggal}', [LaporanSuratBASTController::class, 'excel'])->name('excelLapSurKel');
				Route::get('/excel', [LaporanSuratBASTController::class, 'excel'])->name('excelLapSurBAST');
			});
			Route::group(array('prefix' => 'laporan-surat-keputusan'), function () {
				Route::get('/', [LaporanSuratKeputusanController::class, 'index'])->name('laporan-surat-keputusan');
				Route::get('/excel/{range}/{paramTanggal}', [LaporanSuratKeputusanController::class, 'excel'])->name('excelLapSurKel');
				Route::get('/excel', [LaporanSuratKeputusanController::class, 'excel'])->name('excelLapSurKep');
			});
		});



		// REFERENSI CONTROLLER
		Route::post('getProvinsi', [OtherController::class, 'getProvinsi'])->name('getProvinsi');
		Route::post('getKabupaten', [OtherController::class, 'getKabupaten'])->name('getKabupaten');
		Route::post('getKecamatan', [OtherController::class, 'getKecamatan'])->name('getKecamatan');
		Route::post('getInstansi', [OtherController::class, 'getInstansi'])->name('getInstansi');
		Route::post('getInstansiById', [OtherController::class, 'getInstansiById'])->name('getInstansiById');
		Route::post('getJenisSurat', [OtherController::class, 'getJenisSurat'])->name('getJenisSurat');
		Route::post('getJenisSuratById', [OtherController::class, 'getJenisSuratById'])->name('getJenisSuratById');
		Route::post('getAsnByKategori', [OtherController::class, 'getAsnByKategori'])->name('getAsnByKategori');
		Route::post('getAsnByName', [OtherController::class, 'getAsnByName'])->name('getAsnByName');
		Route::post('getAsnByLevel', [OtherController::class, 'getAsnByLevel'])->name('getAsnByLevel');
		Route::post('getInstansiByName', [OtherController::class, 'getInstansiByName'])->name('getInstansiByName');

		Route::post('test', [OtherController::class, 'test'])->name('test-name');

		Route::group(array('prefix' => 'profile'), function () {
			Route::get('/', [ProfileController::class, 'index'])->name('profile');
			Route::post('/form', [ProfileController::class, 'form'])->name('form-profile');
			Route::post('/update', [ProfileController::class, 'update'])->name('update-profile');
			Route::post('/destroy', [ProfileController::class, 'destroy'])->name('destroy-profile');
		});

	});
});
