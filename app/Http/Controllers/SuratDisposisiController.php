<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\SuratDisposisi;
use App\Models\Instansi;
use App\Models\DenganHarap;
use App\Models\MasterASN;
use Log;
use DataTables,Validator,DB,Hash,Auth,File,Storage,PDF,QrCode;

class SuratDisposisiController extends Controller
{
	private $title = "Disposisi Surat";
	private $menuActive = "surat-disposisi";
	private $submnActive = "";

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
				$data = SuratDisposisi::with(['suratMasukId','pemberi','penerima'])
				// ->whereHas('suratMasukId',fn($query)=>$query->whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir]))
				->whereBetween('created_at',[$paramTglAwal,$paramTglAkhir])
				->orderBy('id_surat_disposisi','desc')
				->get();
            // return $data;
				// $data = SuratDisposisi::with(['suratMasukId','pemberi','penerima'])->orderBy('id_surat_disposisi','desc')->get();

			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id_surat_disposisi.')" style="margin-right: 5px;" class="btn btn-secondary " title="Lihat file"><i class="bx bx-show me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_disposisi.')" style="margin-right: 5px;" class="btn btn-warning "data-toggle="popover" data-trigger="hover" title="Disposisi"><i class="bx bx-task-x me-0"></i></a>';
					if(Auth::user()->level_user == 2) {
					} else {
						$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_disposisi.')" style="margin-right: 5px;" class="btn btn-danger " title="Hapus"><i class="bx bx-trash me-0"></i></a>';
					}
					$btn .= '<a href="javascript:void(0)" onclick="previewSuratMasuk('.$row->surat_masuk_id.')" style="margin-right: 5px;" class="btn btn-info" title="Download"><i class="bx bx-download me-0"></i></a>';
					$btn .='</div></div>';
					return $btn;
				})
				->addColumn('check', function($row){
					$btn = '<input class="form-check-input select-checkbox row_surat" onchange="checkedRow(this)" data-id="'.$row->id_surat_disposisi.'" id="check_'.$row->id_surat_disposisi.'" name="check" value="'.$row->id_surat_disposisi.'" type="checkbox"></a>';
					return $btn;
				})
				->rawColumns(['action', 'check'])
				->make(true);
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratDisposisi::with('suratMasukId.pengirim')->find($request->id) : "";
			$data['jenis_surat'] = JenisSurat::get();
			$data['sifat_surat'] = SifatSurat::get();
			$data['instansi'] = Instansi::get();
			$data['dengan_harap'] = DenganHarap::get();
            // $data['surat_masuk'] = SuratMasuk::whereNotNull('deleted_at')->get();
			$data['user_login'] = MasterASN::where('users_id',Auth::user()->id)->first();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			throw($e);
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}
	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				// 'surat_masuk_id' => 'required',
				'pemberi_disposisi_id' => 'required',
				'penerima_disposisi_id' => 'required',
				'dengan_harap' => 'required',
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
		//
		// $findAgendaTerakhir = SuratMasuk::whereYear('tanggal_terima_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_masuk','DESC')->count();
		// if ($findAgendaTerakhir == 0) {
		// 	$findAgendaTerakhir = 1;
		// }else {
		// 	$findAgendaTerakhir = $findAgendaTerakhir+1;
		// }
		// // if (empty($findAgendaTerakhir)) {
		// // 	$count = 0001;
		// // } else {
		// // 	$count =  $findAgendaTerakhir->no_agenda;
		// // 	$count += 1;
		// // }
		// // if ($count < 10) {
		// // 	$count = '000'.$count;
		// // }else if ($count < 100) {
		// // 	$count = '00'.$count;
		// // }else if ($count < 1000){
		// // 	$count = '0'.$count;
		// // }
		try{
			$newdata = (!empty($request->id)) ? SuratDisposisi::find($request->id) : new SuratDisposisi;
			if (!empty($request->id)) {
				$newdata->no_agenda_disposisi = $newdata->no_agenda_disposisi;
			}else {
				$suratMasuk = SuratMasuk::findOrFail($request->surat_masuk_id);
				if (Auth::user()->level_user == '2') {
					$suratMasuk->status_disposisi = 'Disposisi Kaban';
					$suratMasuk->save();
				}
				$newdata->no_agenda_disposisi = $suratMasuk->no_agenda;
				$cekDisposisi = SuratDisposisi::where('surat_masuk_id',$request->surat_masuk_id)->first();
				if (!empty($cekDisposisi)) {
					$return = ['status'=>'error', 'code'=>'201', 'message'=>'Surat Disposisi Sudah Dibuat!!','errMsg'=>'Duplikasi Data'];
					return response()->json($return);
				}
			}
			if (empty($request->id)) {
				$newdata->surat_masuk_id = $request->surat_masuk_id;
				$newdata->pemberi_disposisi_id = $request->pemberi_disposisi_id;
				$newdata->penerima_disposisi_id = $request->penerima_disposisi_id;
				$newdata->catatan_disposisi = $request->catatan_disposisi;
			}else {
				$newdata->pemberi_disposisi2_id = $request->pemberi_disposisi_id;
				$newdata->penerima_disposisi2_id = $request->penerima_disposisi_id;
				$newdata->catatan_disposisi_sekretaris = $request->catatan_disposisi_sekretaris ;
			}
			$newdata->dengan_hormat_harap = implode(",",$request->dengan_harap);
			// if (!empty($request->file_scan)) {
			// 	if (!empty($newdata->file_scan)) {
			// 		if (is_file($newdata->file_scan)) {
			// 			Storage::delete($newdata->file_scan);
			// 			unlink(storage_path('public/surat-masuk/'.$newdata->file_scan));
			// 			// File::delete($newdata->file_scan);
			// 		}
			// 	}
			// 	$file = $request->file('file_scan');
			// 	if($request->hasFile('file_scan')){
			// 		$filename = $file->getClientOriginalName();
			// 		$ext_foto = $file->getClientOriginalExtension();
			// 		$filename = $newdata->no_agenda."-".date('YmdHis').".".$ext_foto;
			// 		$file->storeAs('public/surat-masuk/',$filename);
			// 		$newdata->file_scan = $filename;
			// 	}
			// }
			// if (!empty($request->sampai_bkpsdm)) {
			// 	$newdata->sampai_bkpsdm = $request->sampai_bkpsdm;
			// }else {
			// 	$newdata->sampai_bkpsdm = 'N';
			// }
			$newdata->save();
			$data['data'] = SuratDisposisi::with(['suratMasukId'])->find($newdata->id_surat_disposisi);
	    	$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->pemberi_disposisi_id)->first();
	    	$data['penerima'] = MasterASN::where('id_mst_asn',$data['data']->pemberi_disposisi_id)->first();
	    	$data['dengan_harap'] = DenganHarap::get();
			$changeSDisposisi = str_replace("/", "-", strtolower($data['data']->suratMasukId->nomor_surat_masuk));
			$file_name_asli_surat_disposisi = str_replace(" ", "-", strtolower($data['asn']->nama_asn).'-'.$changeSDisposisi.'-'.date('Ymd His').'-surat_disposisi.pdf');
			$pdf = PDF::loadView('cetakan.surat_disposisi', $data)
				->setPaper([0, 0, 609.4488, 935.433], 'portrait');
			Storage::put('public/surat-disposisi/'.$file_name_asli_surat_disposisi, $pdf->output());

			// $data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));

			$update = SuratDisposisi::find($newdata->id_surat_disposisi);
			$update->file_disposisi = $file_name_asli_surat_disposisi;
			$update->save();
			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
			return response()->json($return);
		}catch(\Exception $e){
			DB::rollback();
			// report($e);
			Log::info(
				json_encode([
					'ERROR SYSTEM' => [
						// 'url'     => Request::url(),
						'file'    => $e->getFile(),
						'message' => $e->getMessage(),
						'line'    => $e->getLine(),
					]
				],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)
			);
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}
	}
	public function destroy(Request $request)
	{
		$do_delete = SuratDisposisi::find($request->id);
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
			$data['data'] = (!empty($request->id)) ? SuratDisposisi::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function getSuratMasuk(Request $request) {
		$id = $request->query('id');
		$data['surat_masuk'] = SuratMasuk::where('no_agenda', $id)
								->with('pengirim')
								->orderByDesc('no_agenda')
								->first();
		// $data['surat_masuk'] = SuratMasuk::where('id_surat_masuk', $id)->with('pengirim')->first();
		// return $data;
		return response()->json([
            'status_code' => 200,
            'data' => $data
        ]);
	}

	public function cetakSD(Request $request)
	{
		$data['data'] = SuratDisposisi::with(['suratMasukId'])->find(81);
		$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->pemberi_disposisi_id)->first();
		$data['penerima'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->penerima_disposisi_id)->first();
		$data['dengan_harap'] = DenganHarap::get();

		// $ttd = '1. TTD Pada Tanggal :'.$data['data']->tanggal_surat.' 2. Oleh :'.$data['asn']->nama_asn.'  3. NIP: '.$data['asn']->nip;
		// $data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
		// $data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));
		// return $data;
		// $dompdf = new PDF();
		$dompdf = PDF::loadView('cetakan.surat_disposisi', $data)
					->setPaper([0, 0, 609.4488, 935.433], 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		return  $dompdf->stream();
	}

	public function getId(Request $request) {
        return $request->arrSuratId;
		// $data = SuratDisposisi::pluck('id_surat_disposisi')->where($request->arrSuratId);
		// $data = SuratDisposisi::where('id_surat_disposisi',$request->arrSuratId)->pluck('id_surat_disposisi');
		// $data = ['1','2','3'];
		// return response()->json($data);
	}

	public function deleteAll(Request $request) {
		$dataId = $request->listId;
		// return $dataId;
		if (is_array($dataId)) {
			foreach ($dataId as $id) {
				$suratDispos = SuratDisposisi::find($id);
				if ($suratDispos) {
					$suratDispos->delete();
				}
			}
		}
		return response()->json(['message' => 'Data berhasuil dihapus']);
	}

    public function getNoAgenda(Request $request) {
      $data['agenda'] = SuratMasuk::with('pengirim')
          ->where('no_agenda', 'like', "%$request->search%")
          ->whereNull('deleted_at')
          ->orderBy('id_surat_masuk', 'desc')
          ->get();

      // $data['agenda'] = SuratMasuk::where('no_agenda', 'Ilike', "%{$request->search}%")
      //         ->orderBy('id_surat_masuk', 'desc')
      //         // ->distinct('no_agenda')
      //         ->get();

      return response()->json($data);
    }
}
