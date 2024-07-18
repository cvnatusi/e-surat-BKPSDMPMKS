<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\Instansi;
use App\Models\MasterASN;
use App\Models\SuratTugas;
use App\Models\TujuanSuratTugas;
use App\Models\FileSuratTugas;

use DataTables,Validator,DB,Hash,Auth,File,Storage, PDF;

class SuratSPPDController extends Controller
{
	private $title = "Surat Perjalanan Dinas";
	private $menuActive = "surat-sppd";
	private $submnActive = "";

    public function index(Request $request)
    {
        $this->data['title'] = $this->title;
        $this->data['menuActive'] = $this->menuActive;
        $this->data['submnActive'] = $this->submnActive;
        $this->data['smallTitle'] = "";

        if ($request->ajax()) {
            $paramTglAwal = $request->tglAwal;
            $paramTglAkhir = $request->tglAkhir;

            $data = FileSuratTugas::with(['pegawai','surattugas'])
                    ->whereHas('surattugas', fn($query) => $query->whereBetween('tanggal_surat', [$paramTglAwal, $paramTglAkhir]))
                    ->whereNotNull('file_surat_sppd')
                    ->orderBy('id_file_perjalanan_dinas', 'desc')
                    ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="showSuratSPPD('.$row->id_file_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
                        $btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_file_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
                        return $btn;
                    })
                    ->addColumn('check', function($row){
                        $btn = '<input class="form-check-input select-checkbox" data-id="'.$row->id_file_perjalanan_dinas.'" id="check_'.$row->id_file_perjalanan_dinas.'" name="check" value="'.$row->id_file_perjalanan_dinas.'" type="checkbox">';
                        return $btn;
                    })
                    ->rawColumns(['action', 'check'])
                    ->make(true);
        }

        return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data', $this->data);
    }

	// public function index(Request $request)
	// {
	// 	$this->data['title'] = $this->title;
	// 	$this->data['menuActive'] = $this->menuActive;
	// 	$this->data['submnActive'] = $this->submnActive;
	// 	// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
	// 	$this->data['smallTitle'] = "";
	// 	if ($request->ajax()) {
	// 		$paramTglAwal = $request->tglAwal;
	// 		$paramTglAkhir = $request->tglAkhir;
	// 			$data = FileSuratTugas::with(['pegawai','surattugas'])->whereHas('surattugas',fn($query)=>$query->whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir]))
	// 			->whereNotNull('file_surat_sppd')
	// 			->orderBy('id_file_perjalanan_dinas','desc')
	// 			->get();

	// 		// return $data;
	// 		return Datatables::of($data)
	// 			->addIndexColumn()
	// 			->addColumn('action', function($row){
	// 				$btn = '<a href="javascript:void(0)" onclick="showSuratSPPD('.$row->id_file_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
	// 				// $btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_file_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
	// 				$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_file_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
	// 				$btn .='</div></div>';
	// 				return $btn;
	// 			})
	// 			->addColumn('check', function($row){
	// 				$btn = '<input class="form-check-input select-checkbox" data-id="'.$row->id_file_perjalanan_dinas.'" id="check_'.$row->id_file_perjalanan_dinas.'" name="check" value="'.$row->id_file_perjalanan_dinas.'" type="checkbox"></a>';
	// 				return $btn;
	// 			})
	// 			->rawColumns(['action', 'check'])
	// 			->make(true);;
	// 	}
	// 	return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	// }
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratTugas::find($request->id) : "";
			$data['jenis_surat'] = JenisSurat::get();
			$data['sifat_surat'] = SifatSurat::orderBy('id_sifat_surat','ASC')->get();
			$data['instansi'] = MasterASN::get();
			$data['tanda_tangan'] = MasterASN::where('jabatan',1)->get();
			// if (!empty($request->id)) {
			// 	if ($data['data']->jenis_surat_id == '150' || $data['data']->jenis_surat_id == '151' || $data['data']->jenis_surat_id == '152' || $data['data']->jenis_surat_id == '153' || $data['data']->jenis_surat_id == '154' || $data['data']->jenis_surat_id == '155') {
			// 		$data['instansi'] = MasterASN::get();
					// $data['surat_tugas'] = SuratTugas::with(['suratkeluar','pegawai'])->where('surat_keluar_id',$request->id)->first();
			// 	}
			// }
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			throw($e);
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function show(Request $request)
	{
		try {
			$data['data'] = FileSuratTugas::with(['surattugas.pegawai'])->find($request->id);

			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'error', 'content' => '','errMsg'=>$e];
		}
	}
	public function destroy(Request $request)
	{
		$do_delete = FileSuratTugas::find($request->id);
		if(!empty($do_delete)){
			// $do_delete->delete();
			$do_delete->file_surat_sppd = null;
			$do_delete->save();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}

    public function getId(Request $request) {
       $data = FileSuratTugas::whereNotNull('file_surat_sppd')
        ->pluck('id_file_perjalanan_dinas');

		// $data = FileSuratTugas::get()->pluck('id_file_perjalanan_dinas');
		return response()->json($data);
	}
}
