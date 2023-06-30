<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Instansi;
use App\Models\MasterASN;
use App\Models\FileTte;
use App\Models\TTE;
use App\Models\TandaTanganElektronik;

use DataTables,Validator,DB,Hash,Auth,File,Storage, PDF;

class TteController extends Controller
{


	private $title = "Tanda Tangan Elektronik";
	private $menuActive = "surat-lainnya";
	private $submnActive = "tanda-tangan-elektronik";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			// return $request->all();
			$data = FileTte::with(['users'])->orderBy('id_file_surat','desc');
			
			if ($request->range_by == 'tanggal') {
				$data = $data->whereDate('tanggal_surat', $request->date);
			}elseif ($request->range_by == 'bulan') {
				$dateArray = explode('-', $request->date);
				$year = $dateArray[0];
				$month = $dateArray[1];
				$data = $data->whereYear('tanggal_surat', $year)->whereMonth('tanggal_surat', $month);
			}elseif ($request->range_by == 'tahun') {
				
				$data = $data->whereYear('tanggal_surat', $request->date);
			}
			$data = $data->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					// $btn = '<a href="javascript:void(0)" onclick="editForm('.$row->id_file_surat.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn = '<a href="javascript:void(0)" onclick="show('.$row->id_file_surat.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_file_surat.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					return $btn;
					// if ($row->verifikasi_kaban == 'N') {
					// 	$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					// }else {
					// 	$btn .= '<button disabled onclick"sudahVerif()" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></button>';
					// }
					// $btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					// $btn .='</div></div>';
					// return $btn;
				})
				->addColumn('verifSurat', function($row){
					if ($row->is_verif == false) {
						if (Auth::user()->level_user == 2 || Auth::user()->level_user == 1) { // matikan level user 1 nanti
							 // disini tambahkan 1 parameter lagi di onclick untuk dia ttd elektronik atau ttd manual
							 // TTE parameternya t
							 // TTD Manual parameternya f

							// Lalu buat function baru namanya verifKABAN cek functionnya di bawah sendiri
							$btn = '<a href="javascript:void(0)" id="verif_'.$row->id_file_surat.'" onclick="verifSurat('.$row->id_file_surat.')" style="margin-right: 5px;" class="btn btn-success "><i class="bx bx-check-shield me-0"></i></a>';
						}else {
							$btn = '<span class="badge bg-danger">Belum di Verifikasi</span>';
						}
					}else {
						$btn = '<span class="badge bg-success">Sudah di Verifikasi</span>';
					}
					return $btn;
				})
				->rawColumns(['action','verifSurat'])
				->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}


	// private $title = "Tanda Tangan Elektronik";
	// private $menuActive = "tandatangan-e";
	// private $submnActive = "";

	// public function index(Request $request)
	// {
	// 	$this->data['title'] = $this->title;
	// 	$this->data['menuActive'] = $this->menuActive;
	// 	$this->data['submnActive'] = $this->submnActive;
	// 	$this->data['smallTitle'] = "";
	// 	$this->data['tanda_tangan'] = TandaTanganElektronik::get();
	// 	return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	// }
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratKeluar::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			// // $data['instansi'] = MasterASN::get();
			// if (!empty($request->id)) {
			// 	if ($data['data']->jenis_surat_id == '150' || $data['data']->jenis_surat_id == '151' || $data['data']->jenis_surat_id == '152' || $data['data']->jenis_surat_id == '153' || $data['data']->jenis_surat_id == '154' || $data['data']->jenis_surat_id == '155') {
			// 		$data['instansi'] = MasterASN::get();
			// 		$data['surat_tugas'] = SuratTugas::with(['suratkeluar','pegawai'])->where('surat_keluar_id',$request->id)->first();
			// 	}
			// }
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			throw($e);
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}
	public function destroy(Request $request)
	{
		$do_delete = FileTte::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}
	public function show(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? FileTte::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}
	public function verifSurat(Request $request)
	{
		// return $request->id;
		try {
			DB::beginTransaction();
			if ($request->ps != '123456') {
				$return = ['status'=>'error', 'code'=>'201', 'message'=>'Gagal Verifikasi, Passphrase tidak sesuai !!'];
				return response()->json($return);
			}
			$fileSurat= FileTte::find($request->id);
			$fileSurat->is_verif=true;
			$fileSurat->save();
			
			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil di Verifikasi !!'];
			return response()->json($return);
		} catch (\Exception $e) {
			DB::rollback();
			throw($e);
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}


	}
}
