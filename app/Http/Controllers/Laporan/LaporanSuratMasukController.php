<?php

namespace App\Http\Controllers\Laporan;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\SuratMasuk;
use App\Exports\LaporanSuratMasuk;
use DataTables,Validator,DB,Hash,Auth,File,Storage,Excel;


class LaporanSuratMasukController extends Controller
{
	private $title = "Laporan Surat Masuk";
	private $menuActive = "laporan";
	private $submnActive = "surat-masuk";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			// $paramTanggal = $request->paramTanggal;
			// if ($request->range == 'tanggal') {
			// 	$data = SuratMasuk::with(['sifat','jenis','pengirim'])
			// 	->where('tanggal_surat',$paramTanggal)
			// 	->orderBy('id_surat_masuk','desc')
			// 	->get();
			// }elseif ($request->range == 'bulan') {
			// 	$data = SuratMasuk::with(['sifat','jenis','pengirim'])
			// 	->where('tanggal_surat','LIKE','%'.$paramTanggal.'%')
			// 	->orderBy('id_surat_masuk','desc')
			// 	->get();
			// }elseif ($request->range == 'tahun') {
			// 	$data = SuratMasuk::with(['sifat','jenis','pengirim'])
			// 	->whereYear('tanggal_surat',$paramTanggal)
			// 	->orderBy('id_surat_masuk','desc')
			// 	->get();
			// }else {
			// }
			$data = SuratMasuk::with(['sifat','jenis','pengirim'])->orderBy('id_surat_masuk','desc');
			if(isset($request->dateStart) && isset($request->dateEnd)) {
				$data = $data->whereDate('tanggal_surat',  '>=', $request->dateStart)->whereDate('tanggal_surat', '<=', $request->dateEnd);
			}
			// $data = SuratMasuk::with(['sifat','jenis','pengirim'])->where('tanggal_terima_surat','like',date('Y-m-d').'%')->orderBy('id_surat_masuk','desc')->get();
			// $data = SuratMasuk::onlyTrashed()->get();
			return Datatables::eloquent($data)
			->addIndexColumn()
			->addColumn('pengirim', function($row){
				if (!empty($row->pengirim)) {
					$pengirim_surat = $row->pengirim->nama_instansi;
				} else {
					$pengirim_surat = '-';
				}
				return $pengirim_surat;
			})
			->rawColumns(['action'])
			->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}

	public function excel(Request $request)
	{
		// return $request->all();
		$query = SuratMasuk::orderBy('id_surat_masuk','desc');
        if(isset($request->rangeAwal) && isset($request->rangeAkhir)) {
            $query = $query->whereDate('tanggal_surat',  '>=', $request->rangeAwal)->whereDate('tanggal_surat', '<=', $request->rangeAkhir);
        }
        $data['periode'] = $request->rangeAwal . '_sampai_' . $request->rangeAkhir;
        // $date = date('Y-m-d');
        $data['judul'] = 'LAPORAN SURAT MASUK';
        $data['lap'] = $query->get();
			return count($data['lap']);
		// if (!empty($request->rangeAwal)) {
		// 			$data['tanggalAwal']  = date('Y-m-d', strtotime($request->rangeAwal));
		// 	}
		// 	if (!empty($request->rangeAkhir)) {
		// 			$data['tanggalAkhir']  = date('Y-m-d', strtotime($request->rangeAkhir));
		// 	}
		// 	$rangeAwal = $data['tanggalAwal'];
		// 	$tgl_akhir = $data['tanggalAkhir'];

		// 	$awal = date('d', strtotime($data['tanggalAwal'])) . '-' . Formatters::get_bulan(date('m', strtotime($data['tanggalAwal']))) . '-' . date('Y', strtotime($data['tanggalAwal']));
		// 	$akhir = date('d', strtotime($data['tanggalAkhir'])) . '-' . Formatters::get_bulan(date('m', strtotime($data['tanggalAkhir']))) . '-' . date('Y', strtotime($data['tanggalAkhir']));
		// 	//
			// return $data;
			// 		$paramTanggal = $request->paramTanggal;
			// 		if ($request->range == 'tanggal') {
			// 			$data['periode'] = 'Tanggal '.$paramTanggal;
			// 			$data['lap'] = SuratMasuk::with(['sifat','jenis','pengirim'])
			// 			->where('tanggal_surat',$paramTanggal)
			// 			->orderBy('id_surat_masuk','desc')
			// 			->get();
			// 		}elseif ($request->range == 'bulan'){
			// 		$data['periode'] = 'Bulan '.$paramTanggal;
			// 			$data['lap'] = SuratMasuk::with(['sifat','jenis','pengirim'])
			// 			->where('tanggal_surat','LIKE','%'.$paramTanggal.'%')
			// 			->orderBy('id_surat_masuk','desc')
			// 			->get();
			// 		}elseif ($request->range == 'tahun') {
			// 			$data['periode'] = 'Tahun '.$paramTanggal;
			// 			$data['lap'] = SuratMasuk::with(['sifat','jenis','pengirim'])
			// 			->whereYear('tanggal_surat',$paramTanggal)
			// 			->orderBy('id_surat_masuk','desc')
			// 			->get();
			// 		}else {
			// 			$data['lap'] = SuratMasuk::with(['sifat','jenis','pengirim'])->orderBy('id_surat_masuk','desc')->get();
			// 		}
			// $data['lap'] = PendaftaranRawatJalan::with('poli')->join('pasien', 'pasien.id_pasien', 'pendaftaran_rawat_jalan.pasien_id')
			//     ->join('mst_dokter', 'mst_dokter.id_dokter', 'pendaftaran_rawat_jalan.dokter_id')
			//     ->whereBetween('tanggal_daftar', [$tgl_awal, $tgl_akhir])
			//     ->orderBy('tanggal_daftar', 'ASC')
			//     ->orderBy('jam', 'ASC')
			//     ->get();
			return Excel::download(new LaporanSuratMasuk($data), "Laporan Surat Masuk " . $data['periode'] . '.xlsx');
	}
}
