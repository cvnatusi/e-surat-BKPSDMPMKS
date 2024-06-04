<?php

namespace App\Http\Controllers\Laporan;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\SuratKeluar;
use App\Exports\LaporanSuratKeluar;
use DataTables,Validator,DB,Hash,Auth,File,Storage,Excel;


class LaporanSuratKeluarController extends Controller
{
	private $title = "Laporan Surat Keluar";
	private $menuActive = "laporan";
	private $submnActive = "surat-keluar";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
		// 	$paramTanggal = $request->paramTanggal;
		// 	if ($request->range == 'tanggal') {
		// 		$data = SuratKeluar::with(['sifat','jenis','penerima'])
		// 		->where('tanggal_surat',$paramTanggal)
		// 		->orderBy('id_surat_keluar','desc')
		// 		->get();
		// 	}elseif ($request->range == 'bulan') {
		// 		$data = SuratKeluar::with(['sifat','jenis','penerima'])
		// 		->where('tanggal_surat','LIKE','%'.$paramTanggal.'%')
		// 		->orderBy('id_surat_keluar','desc')
		// 		->get();
		// 	}elseif ($request->range == 'tahun') {
		// 		$data = SuratKeluar::with(['sifat','jenis','penerima'])
		// 		->whereYear('tanggal_surat',$paramTanggal)
		// 		->orderBy('id_surat_keluar','desc')
		// 		->get();
		// 	}else {
		// 		$data = SuratKeluar::with(['sifat','jenis','penerima'])->orderBy('id_surat_keluar','desc')->get();
		// 	}
		$data = SuratKeluar::with(['sifat','jenis','penerima'])->orderBy('id_surat_keluar','desc');
		if(isset($request->dateStart) && isset($request->dateEnd)) {
			$data = $data->whereDate('tanggal_surat',  '>=', $request->dateStart)->whereDate('tanggal_surat', '<=', $request->dateEnd);

		}
			// $data = SuratKeluar::with(['sifat','jenis','penerima'])->where('tanggal_terima_surat','like',date('Y-m-d').'%')->orderBy('id_surat_keluar','desc')->get();
			// $data = SuratKeluar::onlyTrashed()->get();
			return Datatables::of($data)
			->addIndexColumn()
			->addColumn('penerima', function($row){
				if (!empty($row->penerima)) {
					$penerima_surat = $row->penerima->nama_instansi;
				} else {
					$penerima_surat = '-';
				}
				return $penerima_surat;
			})
			->addColumn('verifKABAN', function($row){
				if ($row->is_verif == false) {
						$btn = '<span class="badge bg-danger">Belum di Verifikasi</span>';
				}else {
					$btn = '<span class="badge bg-success">Sudah di Verifikasi</span>';
				}
				return $btn;
			})
			->rawColumns(['action','verifKABAN'])
			->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}

	public function dateRange(Request $request)
    {
		if(request()->ajax())
		{
		if(!empty($request->from_date))
		{
		$data = SuratKeluar::table('tbl_order')
			->whereBetween('order_date', array($request->from_date, $request->to_date))
			->get();
		}
		else
		{
		$data = SuratKeluar::table('tbl_order')
			->get();
		}
		return datatables()->of($data)->make(true);
		}
		return view('daterange');
    }

	public function excel(Request $request)
	{
		// return $request->all();
		$datas = SuratKeluar::orderBy('id_surat_keluar','desc');
        // return $datas;
		if(isset($request->rangeAwal) && isset($request->rangeAkhir)) {
			$datas = $datas->whereDate('tanggal_surat',  '>=', $request->rangeAwal)->whereDate('tanggal_surat', '<=', $request->rangeAkhir);
		}
		$data['periode'] = $request->rangeAwal . '_sampai_' . $request->rangeAkhir;
		$data['judul'] = 'LAPORAN SURAT KELUAR';
		$data['lap'] = $datas->get();
		// return $data['lap'];
		// if ($request->range == 'tanggal') {
		// 	$data['periode'] = 'Tanggal '.$request->rangeAwal;

		// 	$data['lap'] = SuratKeluar::with(['sifat', 'jenis', 'penerima'])
		// 							  ->whereDate('tanggal_surat', $request->rangeAwal)
		// 							  ->orderBy('id_surat_keluar', 'desc')
		// 							  ->get();
		// } elseif ($request->range == 'bulan') {
		// 	$data['periode'] = 'Bulan '.$request->rangeAwal;

		// 	$data['lap'] = SuratKeluar::with(['sifat', 'jenis', 'penerima'])
		// 							  ->where('tanggal_surat', 'LIKE', '%'.$request->rangeAwal.'%')
		// 							  ->orderBy('id_surat_keluar', 'desc')
		// 							  ->get();
		// } elseif ($request->range == 'tahun') {
		// 	$data['periode'] = 'Tahun '.$request->rangeAwal;

		// 	$data['lap'] = SuratKeluar::with(['sifat', 'jenis', 'penerima'])
		// 							  ->whereYear('tanggal_surat', $request->rangeAwal)
		// 							  ->orderBy('id_surat_keluar', 'desc')
		// 							  ->get();
		// } else {
		// 	$data['lap'] = SuratKeluar::with(['sifat', 'jenis', 'penerima'])
		// 							  ->orderBy('id_surat_keluar', 'desc')
		// 							  ->get();
		// }


		// return $data->get();
			// $date = date('Y-m-d');
			// if (!empty($request->tgl_awal)) {
			// 		$data['tanggalAwal']  = date('Y-m-d', strtotime($request->tgl_awal));
			// } else {
			// 		$data['tanggalAwal']  = date('Y-m-d', strtotime($date));
			// }
			// if (!empty($request->tgl_akhir)) {
			// 		$data['tanggalAkhir']  = date('Y-m-d', strtotime($request->tgl_akhir));
			// } else {
			// 		$data['tanggalAkhir']  = date('Y-m-d', strtotime($date));
			// }
			// $tgl_awal = $data['tanggalAwal'];
			// $tgl_akhir = $data['tanggalAkhir'];
			//
			// $awal = date('d', strtotime($data['tanggalAwal'])) . '-' . Formatters::get_bulan(date('m', strtotime($data['tanggalAwal']))) . '-' . date('Y', strtotime($data['tanggalAwal']));
			// $akhir = date('d', strtotime($data['tanggalAkhir'])) . '-' . Formatters::get_bulan(date('m', strtotime($data['tanggalAkhir']))) . '-' . date('Y', strtotime($data['tanggalAkhir']));
					// $paramTanggal = $request->paramTanggal;
					// if ($request->range == 'tanggal') {
					// 	$data['periode'] = 'Tanggal '.$paramTanggal;

					// 	$data['lap'] = SuratKeluar::with(['sifat','jenis','penerima'])
					// 	->where('tanggal_surat',$paramTanggal)
					// 	->orderBy('id_surat_keluar','desc')
					// 	->get();
					// }elseif ($request->range == 'bulan'){
					// $data['periode'] = 'Bulan '.$paramTanggal;
					// 	$data['lap'] = SuratKeluar::with(['sifat','jenis','penerima'])
					// 	->where('tanggal_surat','LIKE','%'.$paramTanggal.'%')
					// 	->orderBy('id_surat_keluar','desc')
					// 	->get();
					// }elseif ($request->range == 'tahun') {
					// 	$data['periode'] = 'Tahun '.$paramTanggal;
					// 	$data['lap'] = SuratKeluar::with(['sifat','jenis','penerima'])
					// 	->whereYear('tanggal_surat',$paramTanggal)
					// 	->orderBy('id_surat_keluar','desc')
					// 	->get();
					// }else {
					// 	$data['lap'] = SuratKeluar::with(['sifat','jenis','penerima'])->orderBy('id_surat_keluar','desc')->get();
					// }


					// return $data['lap'];
					// $startDate = $request->input('start_date');
    				// $endDate = $request->input('end_date');
					// $dataCollection = $data->get(); // Ambil data dari query builder

					return Excel::download(new LaporanSuratKeluar($data), "Laporan Surat Keluar " . $data['periode'] . '.xlsx');


}
}
