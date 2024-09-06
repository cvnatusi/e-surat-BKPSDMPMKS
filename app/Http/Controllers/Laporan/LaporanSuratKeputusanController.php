<?php

namespace App\Http\Controllers\Laporan;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\SuratKeputusan;
use App\Exports\LaporanSuratKeputusan;
use DataTables,Validator,DB,Hash,Auth,File,Storage,Excel,PDF;


class LaporanSuratKeputusanController extends Controller
{
	private $title = "Laporan Surat Keputusan";
	private $menuActive = "laporan";
	private $submnActive = "surat-keputusan";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			// $paramTanggal = $request->paramTanggal;
			// if ($request->range == 'tanggal') {
			// 	$data = SuratKeputusan::where('tanggal_surat',$paramTanggal)
			// 	->orderBy('id_surat_keputusan','desc')
			// 	->get();
			// }elseif ($request->range == 'bulan') {
			// 	$data = SuratKeputusan::where('tanggal_surat','LIKE','%'.$paramTanggal.'%')
			// 	->orderBy('id_surat_keputusan','desc')
			// 	->get();
			// }elseif ($request->range == 'tahun') {
			// 	$data = SuratKeputusan::whereYear('tanggal_surat',$paramTanggal)
			// 	->orderBy('id_surat_keputusan','desc')
			// 	->get();
			// }else {
			// }

			$data = SuratKeputusan::orderBy('id_surat_keputusan', 'desc');
			if(isset($request->dateStart) && isset($request->dateEnd)) {
				$data = $data->whereDate('tanggal_surat',  '>=', $request->dateStart)->whereDate('tanggal_surat', '<=', $request->dateEnd);
			}
			// $data = SuratKeputusan::with(['sifat','jenis','penerima'])->where('tanggal_terima_surat','like',date('Y-m-d').'%')->orderBy('id_surat_keputusan','desc')->get();
			// $data = SuratKeputusan::onlyTrashed()->get();
			return Datatables::eloquent($data)
			->addIndexColumn()
            ->addColumn('formatDate', function($row){
                return date('d-m-Y', strtotime($row->tanggal_surat));
            })
			->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}

	public function excel(Request $request)
	{
		// return $request->all();
		$response = SuratKeputusan::orderBy('id_surat_keputusan', 'desc');
			if(isset($request->rangeAwal) && isset($request->rangeAkhir)) {
				$response = $response->whereDate('tanggal_surat',  '>=', $request->rangeAwal)->whereDate('tanggal_surat', '<=', $request->rangeAkhir);
			}
			$data['periode'] = $request->rangeAwal . '_sampai_' . $request->rangeAkhir;
			$data['judul'] = 'LAPORAN SURAT KEPUTUSAN';
			$data['lap'] = $response->get();
            // return view('laporan.surat-keputusan.excel', $data);
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
			//

			// 		$paramTanggal = $request->paramTanggal;
			// 		if ($request->range == 'tanggal') {
			// 			$data['periode'] = 'Tanggal '.$paramTanggal;

			// 			$data['lap'] = SuratKeputusan::where('tanggal_surat',$paramTanggal)
			// 			->orderBy('id_surat_keputusan','desc')
			// 			->get();
			// 		}elseif ($request->range == 'bulan'){
			// 		$data['periode'] = 'Bulan '.$paramTanggal;
			// 			$data['lap'] = SuratKeputusan::where('tanggal_surat','LIKE','%'.$paramTanggal.'%')
			// 			->orderBy('id_surat_keputusan','desc')
			// 			->get();
			// 		}elseif ($request->range == 'tahun') {
			// 			$data['periode'] = 'Tahun '.$paramTanggal;
			// 			$data['lap'] = SuratKeputusan::whereYear('tanggal_surat',$paramTanggal)
			// 			->orderBy('id_surat_keputusan','desc')
			// 			->get();
			// 		}else {
			// 			$data['lap'] = SuratKeputusan::orderBy('id_surat_keputusan','desc')->get();
			// 		}

					// return $data['lap'];
			return Excel::download(new LaporanSuratKeputusan($data), "Laporan Surat Keputusan " . $data['periode'] . '.xlsx');
	}

    public function pdf(Request $request)
	{
		// return $request->all();
		$response = SuratKeputusan::orderBy('id_surat_keputusan', 'desc');
			if(isset($request->rangeAwal) && isset($request->rangeAkhir)) {
				$response = $response->whereDate('tanggal_surat',  '>=', $request->rangeAwal)->whereDate('tanggal_surat', '<=', $request->rangeAkhir);
			}
			$data['periode'] = date('d-m-Y', strtotime($request->rangeAwal)) . ' sampai ' . date('d-m-Y', strtotime($request->rangeAkhir));
			$data['judul'] = 'LAPORAN SURAT KEPUTUSAN';
			$data['lap'] = $response->get();
            // return view('laporan.surat-keputusan.pdf', $data);
            $pdf = PDF::loadView('laporan.surat-keputusan.pdf', $data)
                ->setPaper([0, 0, 609.4488, 935.433], 'portrait');
            return $pdf->download('Laporan_Surat_Keputusan_' . $data['periode'] . '.pdf');
	}
}
