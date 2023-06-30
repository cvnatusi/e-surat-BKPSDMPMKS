<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\SuratDisposisi;
use App\Models\SuratTugas;
use App\Models\SuratKeputusan;
use App\Models\SuratBAST;
use App\Models\FileSuratTugas;
use App\Models\FileTte;
class DashboardController extends Controller
{
	private $title = "Dashboard";
	private $menuActive = "dashboard";
	private $submnActive = "";

	public function index()
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		$this->data['surat_masuk'] = SuratMasuk::whereYear('tanggal_surat', '=', date('Y'))->whereMonth('tanggal_surat', '=', date('m'))->whereNull('deleted_at')->count();
		$this->data['surat_keluar'] = SuratKeluar::whereYear('tanggal_surat', '=', date('Y'))->whereMonth('tanggal_surat', '=', date('m'))->whereNull('deleted_at')->count();
		$this->data['surat_disposisi'] = SuratDisposisi::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', date('m'))->whereNull('deleted_at')->count();
		$this->data['surat_tugas'] = SuratTugas::whereYear('tanggal_surat', '=', date('Y'))->whereMonth('tanggal_surat', '=', date('m'))->whereNull('deleted_at')->count();
		$this->data['surat_sppd'] = FileSuratTugas::leftjoin('tr_surat_perjalanan_dinas','tr_surat_perjalanan_dinas.id_surat_perjalanan_dinas','tr_file_surat_perjalanan_dinas.surat_tugas_id')
							->whereYear('tanggal_surat', '=', date('Y'))
							->whereMonth('tanggal_surat', '=', date('m'))
							->whereNull('deleted_at')
							->whereNotNull('file_surat_sppd')
							->count();
		$this->data['surat_keputusan'] = SuratKeputusan::whereYear('tanggal_surat', '=', date('Y'))->whereMonth('tanggal_surat', '=', date('m'))->whereNull('deleted_at')->count();
		$this->data['surat_bast'] = SuratBAST::whereYear('tanggal_surat', '=', date('Y'))->whereMonth('tanggal_surat', '=', date('m'))->whereNull('deleted_at')->count();
		$this->data['surat_tte'] = FileTte::whereYear('tanggal_surat', '=', date('Y'))->whereMonth('tanggal_surat', '=', date('m'))->whereNull('deleted_at')->count();

		return view($this->menuActive.'.'.'main')->with('data',$this->data);
	}

	public function getCountSuratMasuk(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = SuratMasuk::whereYear('tanggal_surat', '=', date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		return $data;
	}
	public function getCountSuratKeluar(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = SuratKeluar::whereYear('tanggal_surat', '=', date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		return $data;
	}
	public function getCountSuratDisposisi(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = SuratDisposisi::whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', date('m'))->whereNull('deleted_at')->count();
		return $data;
	}
	public function getCountSuratTugas(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = SuratTugas::whereYear('tanggal_surat', '=', date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		return $data;
	}
	public function getCountSuratKeputusan(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = SuratKeputusan::whereYear('tanggal_surat', '=', date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		return $data;
	}
	public function getCountSuratBAST(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = SuratBAST::whereYear('tanggal_surat', '=', date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		return $data;
	}
	public function getCountSuratSPPD(Request $request)
	{
		$bulan = date('m',strtotime($request->id));
		$tahun = date('Y',strtotime($request->id));
		$data = FileSuratTugas::leftjoin('tr_surat_perjalanan_dinas','tr_surat_perjalanan_dinas.id_surat_perjalanan_dinas','tr_file_surat_perjalanan_dinas.surat_tugas_id')
							->whereYear('tanggal_surat', '=', date($tahun))
							->whereMonth('tanggal_surat', '=', date($bulan))
							->whereNull('deleted_at')
							->whereNotNull('file_surat_sppd')
							->count();
							// ->get();
		return $data;
	}

	public function getChart(Request $request)
	{
		$data = array();
		if (!empty($request->id)) {
			$bulan = date('m',strtotime($request->id));
			$tahun = date('Y',strtotime($request->id));
		}else {
			$bulan = date('m',strtotime(date('Y-m')));
			$tahun = date('Y',strtotime(date('Y-m')));
		}
		$surat_masuk = SuratMasuk::whereYear('tanggal_surat', '=',  date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		$surat_keluar = SuratKeluar::whereYear('tanggal_surat', '=',  date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		$surat_disposisi = SuratDisposisi::whereYear('created_at', '=',  date($tahun))->whereMonth('created_at', '=', date($bulan))->whereNull('deleted_at')->count();
		$surat_tugas = SuratTugas::whereYear('tanggal_surat', '=',  date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		$surat_sppd = FileSuratTugas::leftjoin('tr_surat_perjalanan_dinas','tr_surat_perjalanan_dinas.id_surat_perjalanan_dinas','tr_file_surat_perjalanan_dinas.surat_tugas_id')
							->whereYear('tanggal_surat', '=',  date($tahun))
							->whereMonth('tanggal_surat', '=', date($bulan))
							->whereNull('deleted_at')
							->whereNotNull('file_surat_sppd')
							->count();
		$surat_keputusan = SuratKeputusan::whereYear('tanggal_surat', '=',  date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		$surat_bast = SuratBAST::whereYear('tanggal_surat', '=',  date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->whereNull('deleted_at')->count();
		$surat_tte = FileTte::whereYear('tanggal_surat', '=',  date($tahun))->whereMonth('tanggal_surat', '=', date($bulan))->where('is_verif',true)->whereNull('deleted_at')->count();
		$data = [
			'surat_masuk'=>$surat_masuk,
			'surat_keluar'=>$surat_keluar,
			'surat_disposisi'=>$surat_disposisi,
			'surat_tugas'=>$surat_tugas,
			'surat_sppd'=>$surat_sppd,
			'surat_keputusan'=>$surat_keputusan,
			'surat_bast'=>$surat_bast,
			'surat_tte'=>$surat_tte,
		];
		return $data;
	}

	public function level_name($id)
	{
		if ($id == '1') {
			$return = 'Admin';
		} elseif ($id == '2') {
			$return = 'KABAN';
		} elseif ($id == '3') {
			$return = 'KABID';
		} elseif ($id == '4') {
			$return = 'SEKRETARIS';
		}elseif ($id == '5') {
			$return = 'OPERATOR';
		} else {
			$return = $id;
		}
		return $return;
	}
}
