<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratBAST;

use DataTables,Validator,DB,Hash,Auth,File,Storage;

class SuratBASTController extends Controller
{
	private $title = "Surat BAST";
	private $menuActive = "surat-lainnya";
	private $submnActive = "utama-surat-bast";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$paramTglAwal = $request->tglAwal;
			$paramTglAkhir = $request->tglAkhir;

			$data = SuratBAST::orderBy('tanggal_surat','DESC')
			->whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir])
			->get();

			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id_surat_bast.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_bast.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_bast.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					$btn .='</div></div>';
					return $btn;
				})
				->addColumn('check', function($row){
					$btn = '<input class="form-check-input select-checkbox row_surat" onchange="checkedRow(this)" data-id="'.$row->id_surat_bast.'" id="check_'.$row->id_surat_bast.'" name="check" value="'.$row->id_surat_bast.'" type="checkbox"></a>';
					return $btn;
				})
                ->addColumn('tanggalSurat', function($row){
                    return date('d-m-Y', strtotime($row->tanggal_surat));
                })
				->rawColumns(['action', 'check'])
				->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratBAST::find($request->id) : "";
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}
	public function store(Request $request)
	{
		// return $request->all();
		$validator = Validator::make(
			$request->all(),
			[
				// 'nomor_surat_bast' => 'required',
				'tanggal_surat' => 'required',
				'penyedia_jasa' => 'required',
				'jenis_pekerjaan' => 'required',
				'kegiatan' => 'required',
				'jumlah' => 'required',
			],
			[
				'required' => ':attribute Wajib diisi',
			]
		);
		if ($validator->fails()) {
			$pesan = $validator->errors();
			$pakai_pesan = join(',',$pesan->all());
			$return = ['status'=>'warning', 'code'=>201, 'message'=>$pakai_pesan];
			return response()->json($return);
		}

		DB::beginTransaction();
		$tanggal_surat = $request->tanggal_surat;
		$tanggal_now =  date('Y-m-d');
		if ($tanggal_surat < $tanggal_now) {
			$cekSurat = SuratBAST::find($request->surat_bast);


			if (!empty($cekSurat)) {
				// buatkan nomor sisipan
				$explodeSurat = explode("/",$cekSurat->nomor_surat_bast);
				if (strpos($explodeSurat[1], '.A') !== false) {
					$noSurat2 = str_replace("A","B",$explodeSurat[1]);
				}elseif (strpos($explodeSurat[1], 'B') !== false) {
					$noSurat2 = str_replace("B","C",$explodeSurat[1]);
				}elseif (strpos($explodeSurat[1], 'C') !== false) {
					$noSurat2 = str_replace("C","D",$explodeSurat[1]);
				}elseif (strpos($explodeSurat[1], 'D') !== false) {
					$noSurat2 = str_replace("D","E",$explodeSurat[1]);
				}else{
					$noSurat2 = $explodeSurat[1].'.A';
				}
				$noSurat1 = $explodeSurat[0];
				$noSurat3 = $explodeSurat[2];
				$noSurat4 = $explodeSurat[3];
				$noSurat = $noSurat1.'/'.$noSurat2.'/'.$noSurat3.'/'.$noSurat4;
			}
            // return $noSurat;
			// else {
			// 	// cek tanggal kemaren dengan loop
			// 	return 'datamu kosong';
			// }
		}else {
		$findAgendaTerakhir = SuratBAST::selectRaw("MAX(CAST(regexp_replace(no_agenda, '[^0-9]', '', 'g') AS INTEGER)) AS max_number")
                                        ->whereYear('tanggal_surat', '=', date('Y'))
                                        ->whereNull('deleted_at')
                                        ->first()
                                        ->max_number;
			if ($findAgendaTerakhir == 0) {
				$findAgendaTerakhir = 1;
			}else {
				$findAgendaTerakhir = $findAgendaTerakhir+1;
			}
		}

		try{
			$newdata = (!empty($request->id)) ? SuratBAST::find($request->id) : new SuratBAST;
			if (!empty($request->id)) {
				$newdata->no_agenda = $newdata->no_agenda;
				$noSurat = $newdata->nomor_surat_bast;
			}else {
				if ($tanggal_surat < $tanggal_now) {
					$newdata->no_agenda = $noSurat2;
					$noSurat = $noSurat1.'/'.$noSurat2.'/'.$noSurat3.'/'.$noSurat4;
				}else {
					$newdata->no_agenda = $findAgendaTerakhir;
					$noSurat = '027/'.$findAgendaTerakhir.'/432.403/'.date('Y');
				}
			}

			$newdata->nomor_surat_bast = $noSurat;
			$newdata->penyedia_jasa = $request->penyedia_jasa;
			$newdata->jenis_pekerjaan = $request->jenis_pekerjaan;
			$newdata->kegiatan = $request->kegiatan;
			$newdata->tanggal_surat = $request->tanggal_surat;
			// $newdata->jumlah = $request->jumlah;
			$newdata->jumlah = str_replace(['Rp. ', '.'], '', $request->jumlah);
			if (!empty($request->file_scan)) {
				if (!empty($newdata->file_scan)) {
					if (is_file($newdata->file_scan)) {
						Storage::delete($newdata->file_scan);
						unlink(storage_path('public/surat-bast/'.$newdata->file_scan));
						// File::delete($newdata->file_scan);
					}
				}
				$file = $request->file('file_scan');
				if($request->hasFile('file_scan')){
					$filename = $file->getClientOriginalName();
					$ext_foto = $file->getClientOriginalExtension();
					$filename = $newdata->no_agenda."-".date('YmdHis').".".$ext_foto;
					$file->storeAs('public/surat-bast/',$filename);
                    file_put_contents(public_path('storage/surat-bast/' . $filename), file_get_contents($file->getRealPath()));
					$newdata->file_scan = $filename;
				}
			}
			$cekNoSurat = SuratBAST::where('nomor_surat_bast','ilike','%'.$noSurat.'%')->first(); // 0
			if (!empty($cekNoSurat)) {
				$return = ['status'=>'error', 'code'=>'201', 'message'=>'Nomor Surat Sudah Ada!!'];
				DB::rollback();
				return response()->json($return);
			}else {
				$newdata->save();
			}

			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
			return response()->json($return);
		}catch(\Exception $e){
			DB::rollback();
			report($e);
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}
	}
	public function destroy(Request $request)
	{
		$do_delete = SuratBAST::find($request->id);
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
			$data['data'] = (!empty($request->id)) ? SuratBAST::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function getSuratBASTByAgenda(Request $request)
	{
		$data = SuratBAST::where('no_agenda', $request->id)->get();
		return response()->json($data);
	}
	public function getSuratBASTByDate(Request $request)
	{
		// $data = SuratBAST::where('tanggal_surat',$request->tanggal)->get();
		$data = SuratBAST::where('tanggal_surat',$request->tanggal)
                ->whereRaw("no_agenda !~ '[a-zA-Z.]'")
                ->get();
		if (count($data) > 0) {
			return response()->json($data);
		}else {
			$dataa = SuratBAST::whereDate('tanggal_surat','<',$request->tanggal)->limit(10)->orderBy('tanggal_surat','DESC')->get();
			return response()->json($dataa);
		}
	}

	public function getId(Request $request) {
        return $request->arrSuratId;
		// $data = SuratBAST::pluck('id_surat_bast');
		// return response()->json($data);
	}

	public function deleteAll(Request $request) {
		$dataId = $request->listId;
		// return $dataId;
		if (is_array($dataId)) {
			foreach ($dataId as $id) {
				$suratBAST = SuratBAST::find($id);
				if ($suratBAST) {
					$suratBAST->delete();
				}
			}
		}
		return response()->json(['message' => 'Data berhasuil dihapus']);
	}
}
