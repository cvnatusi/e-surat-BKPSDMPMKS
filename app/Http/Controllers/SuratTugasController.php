<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\MasterASN;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use App\Models\FileSuratTugas;
use App\Models\TujuanSuratTugas;

use DataTables,Validator,DB,Hash,Auth,File,Storage, PDF, QrCode;

class SuratTugasController extends Controller
{
	private $title = "Surat Tugas";
	private $menuActive = "surat-tugas";
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
				$data = SuratTugas::whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir])
				->orderBy('id_surat_perjalanan_dinas','desc')
				->get();
				// $data = SuratTugas::orderBy('id_surat_perjalanan_dinas','desc')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="showSuratTugas('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					if ($row->verifikasi_kaban == 'N') {
						$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					}else {
						$btn .= '<button disabled onclick"sudahVerif()" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></button>';
					}
                    if($row->verifikasi_kaban == 'N') {
                        $btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
                    } else {
                        $btn .= '<button disabled onclick="sudafVerif()" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></button>';
                    }
					$btn .='</div></div>';
					return $btn;
				})
				->addColumn('namaPenerima',function($row){
					// return $row->penerimaan_request_pramubakti;
					// return$data = $row->penerimaan_request_pramubakti;
						$ins = explode(",",$row->asn_id);
						$arrMst = [];
						if(count($ins)>0){
							foreach($ins as $key => $val){
								$cekInst = MasterASN::find($val);
								if(!empty($cekInst->nama_asn)){
									array_push($arrMst,$cekInst->nama_asn);
								}else{
									array_push($arrMst,'-');
								}
								// dd()
								// if(!empty($val->mst_pramubakti)){
								// }
							}
							$join = "ada";
						}else{
							$join = "kosong";
						}
					if(count($arrMst)>0){
						$join = join(", ",$arrMst);
					}else{
						$join = "-";
					}
					return $join;
				})
				->addColumn('verifikasi', function($row){
					// if ($row->verifikasi_kaban == 'N') {
					// 	if (Auth::user()->level_user == 1) {
					// 		$btn = '<a href="javascript:void(0)" id="verif_'.$row->id_surat_perjalanan_dinas.'" onclick="verif('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-success "><i class="bx bx-check-shield me-0"></i></a>';
					// 	}else {
					// 		$btn = '<span class="badge bg-danger">Belum di Verifikasi</span>';
					// 	}
					// }else {
					// 	$btn = '<span class="badge bg-success">Sudah di Verifikasi</span>';
					// }
					// return $btn;

					if ($row->verifikasi_kaban == 'N') {
						if (Auth::user()->level_user == 2 || Auth::user()->level_user == 1) {
							$btn = '<a href="javascript:void(0)" id="verif_'.$row->id_surat_perjalanan_dinas.'" onclick="verif('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-success "><i class="bx bx-check-shield me-0"></i></a>';
						}else {
							$btn = '<span class="badge bg-danger">Belum di Verifikasi</span>';
						}
					}else {
						$btn = '<span class="badge bg-success">Sudah di Verifikasi</span>';
					}
					return $btn;
				})
				->addColumn('check', function($row){
					$btn = '<input class="form-check-input select-checkbox" onchange="checkedRow(this)" data-id="'.$row->id_surat_perjalanan_dinas.'" id="check_'.$row->id_surat_perjalanan_dinas.'" name="check" value="'.$row->id_surat_perjalanan_dinas.'" type="checkbox"></a>';
					return $btn;
				})
				->rawColumns(['action','namaPenerima','verifikasi', 'check'])
				->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratTugas::with('penandatangan')->find($request->id) : "";
			$data['jenis_surat'] = JenisSurat::get();
			$data['sifat_surat'] = SifatSurat::orderBy('id_sifat_surat','ASC')->get();
			$data['instansi'] = MasterASN::get();
			$data['tanda_tangan'] = MasterASN::whereIn('jabatan', [0,1])->get(); # 0=Sekda, 1=Kepala badan
			if (!empty($request->id)) {
				$data['tujuan_tugas'] = TujuanSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
				$data['file_tugas'] = FileSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
			}
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			throw($e);
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function store(Request $request)
	{
		// return $request->all();
        // return $request->tujuan_surat_id;
		// $vr=implode($request->tujuan_surat_id,",");
		$validator = Validator::make(
			$request->all(),
			[
				// 'nomor_surat_keluar' => 'required',
				'yang_bertanda_tangan' => 'required',
				'tujuan_surat_id' => 'required',
				'tanggal_surat' => 'required',
				'perihal_surat' => 'required',
				'isi_ringkas_surat' => 'required',
				'surat_pendukung' => 'mimes:pdf'
			],
			[
				'required' => ':attribute Wajib diisi',
				'mimes' => 'Surat pendukung hanya boleh pdf'
			]
		);
		if ($validator->fails()) {
			$pesan = $validator->errors();
			$pakai_pesan = join(',',$pesan->all());
			$return = ['status'=>'warning', 'code'=>201, 'message'=>$pakai_pesan];
			return response()->json($return);
		}



		DB::beginTransaction();
		$findAgendaTerakhir = SuratTugas::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->count();
		if ($findAgendaTerakhir == 0) {
			$findAgendaTerakhir = 1;
		}else {
			$findAgendaTerakhir = $findAgendaTerakhir+1;
		}
		try{
			$newdata = (!empty($request->id)) ? SuratTugas::find($request->id) : new SuratTugas;
			// CEK NO AGENDA BERDASARKAN AGENDA TERAKHIR ATAU SEDANG DI EDIT
			if (!empty($request->id)) {
				$newdata->no_agenda = $newdata->no_agenda;
			}else {
				$newdata->no_agenda = $findAgendaTerakhir;
			}
			$newdata->asn_id = implode(',', $request->tujuan_surat_id);

				// CEK KETIKA USER TIDAK BUAT SURAT MANUAL, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
				if (empty($request->id)) {
					$findJenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);
					$kodeJenisSurat = $findJenisSurat->kode_jenis_surat;
					$noUrutSurat = 	SuratTugas::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_perjalanan_dinas','DESC')->count(); // 0
					if ($noUrutSurat == 0) {
						$noUrutSurat = 1;
					}else {
						$noUrutSurat = $noUrutSurat+1;
					}
					// CEK KETIKA USER BUAT SURAT ELEKTRONIK, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
					// $noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.date('Y');
					$noSurat = $kodeJenisSurat.'/XXX/432.403/'.date('Y');
					$newdata->nomor_surat_perjalanan_dinas = $noSurat;
				}

			$newdata->yang_bertanda_tangan_asn_id = $request->yang_bertanda_tangan;
			$newdata->tanggal_surat = $request->tanggal_surat;
			$newdata->tanggal_mulai = $request->tanggal_mulai;
			$newdata->tanggal_akhir = $request->tanggal_akhir;
			$newdata->perihal_surat = $request->perihal_surat;
			$newdata->isi_ringkas_surat = $request->isi_ringkas_surat;
			$newdata->alat_angkut = $request->alat_angkut;
			if (!empty($request->surat_pendukung)) {
				if (!empty($newdata->surat_pendukung)) {
					Storage::delete($newdata->surat_pendukung);

					unlink(public_path('storage'.DIRECTORY_SEPARATOR.'surat-pendukung'.DIRECTORY_SEPARATOR .$newdata->surat_pendukung));
				}
				$file = $request->file('surat_pendukung');
				if($request->hasFile('surat_pendukung')){
					$filename = $file->getClientOriginalName();
					$ext_foto = $file->getClientOriginalExtension();
					$filename = "432.403-".date('YmdHis').".".$ext_foto;
					$file->storeAs('public/surat-pendukung/',$filename);
					$newdata->surat_pendukung = $filename;
				}
			}
			$newdata->save();
			if ($newdata) {
				if ($request->jenis_surat_id == '150' || $request->jenis_surat_id == '151' || $request->jenis_surat_id == '152' || $request->jenis_surat_id == '153' || $request->jenis_surat_id == '154' || $request->jenis_surat_id == '155') {
					$asn = $request->tujuan_surat_id;
					// return $request->tujuan;
					foreach ($request->tujuan as $key => $value) {
						$v = explode(",",$value);
						$newTujuanSuratTugas = (!empty($v[5])) ? TujuanSuratTugas::find($v[5]) : new TujuanSuratTugas;
						$newTujuanSuratTugas->surat_tugas_id = $newdata->id_surat_perjalanan_dinas;
						$newTujuanSuratTugas->tanggal_mulai_tugas = $v[0];
						$newTujuanSuratTugas->tanggal_akhir_tugas = $v[1];
						$newTujuanSuratTugas->tempat_tujuan_bertugas = html_entity_decode($v[2]);
						$newTujuanSuratTugas->provinsi_tujuan_bertugas = $v[3];
						$newTujuanSuratTugas->alamat_tujuan_bertugas = $v[4];
						$newTujuanSuratTugas->save();
					}


					// foreach ($asn as $key) {
						// $newTujuanSuratTugas = (!empty($request->id_surat_tugas)) ? TujuanSuratTugas::find($request->id_surat_tugas) : new TujuanSuratTugas;
						// $newTujuanSuratTugas->asn_id = $key;


						if ($newTujuanSuratTugas) {
							// $data['data'] = TujuanSuratTugas::find($newdata->id_surat_perjalanan_dinas);
							// $data['asn'] = MasterASN::with('jabatan_asn')->where('jabatan',1)->orderBy('id_mst_asn','DESC')->first();
							// $data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas','pegawai'])->find($newTujuanSuratTugas->id_surat_perjalanan_dinas);
							// $data['data'] = SuratTugas::with('pegawai')->find($newdata->id_surat_perjalanan_dinas);
							// $data['value'] = SuratTugas::find($newdata['file']->surat_tugas_id);
							$data['data'] = SuratTugas::find($newdata->id_surat_perjalanan_dinas);
							$asnId = explode(',', $data['data']->asn_id);
							// return $request->tujuan_surat_id;
							$data['pegawai'] = MasterASN::with('jabatan_asn')->whereIn('id_mst_asn',$request->tujuan_surat_id)->get();
							// $data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
							$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
							$data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
							$ttd = '1. TTD Pada Tanggal :'.$data['data']->tanggal_surat.' 2. Oleh :'.$data['asn']->nama_asn.'  3. NIP: '.$data['asn']->nip;

							$data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));

							// DELETE DULU FILE YANG LAMA KALAU ADA
							if (!empty($data['surat_tugas']->file_surat_tugas)) {
								// if (is_file($data['surat_tugas']->file_scan)) {
									Storage::delete($data['surat_tugas']->file_surat_tugas);
									unlink(storage_path('app/public/surat-tugas/'.$data['surat_tugas']->file_surat_tugas));
								// }
							}
							$changeSTugas = str_replace("/", "-", strtolower($data['data']->nomor_surat_perjalanan_dinas));
							// $file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['data']->pegawai->nama_asn).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_tugas.pdf');
							$file_name_asli_surat_tugas = str_replace(" ", "-", $data['asn']->nama_asn.'-'.$changeSTugas.'-'.date('Ymd His').'-surat_tugas.pdf');
							$pdf = PDF::loadView('cetakan.surat_tugas', $data)
								->setPaper([0, 0, 609.4488, 935.433], 'portrait');
							Storage::put('public/surat-tugas/'.$file_name_asli_surat_tugas, $pdf->output());

                            file_put_contents(public_path('storage/surat-tugas/' . $file_name_asli_surat_tugas), $pdf->output());


							// foreach($request->tujuan_surat_id as $k => $val){
								// $suratTugas = FileSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->where('asn_id',$val)->first();
                                $suratTugas = FileSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->first();
								$updateST = (!empty($request->id) && $suratTugas) ? $suratTugas : new FileSuratTugas;
								$updateST->surat_tugas_id = !empty($data['data']) ? $data['data']->id_surat_perjalanan_dinas : null;
								// $updateST->surat_tugas_id = $data['data']->id_surat_perjalanan_dinas;
								// $updateST->asn_id = $val;
								$updateST->asn_id = implode($request->tujuan_surat_id,",");
								$updateST->file_surat_tugas = $file_name_asli_surat_tugas;
								$updateST->save();
							// }
							// return 'tes';
						// }
					}
				}
			}

			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
			return response()->json($return);
		}catch(\Exception $e){
			DB::rollback();
			throw($e);
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}
	}
	// public function store(Request $request)
	// {
	// 	// return $request->all();
	// 	// $vr=implode($request->tujuan_surat_id,",");
	// 	$validator = Validator::make(
	// 		$request->all(),
	// 		[
	// 			// 'nomor_surat_keluar' => 'required',
	// 			'yang_bertanda_tangan' => 'required',
	// 			'tujuan_surat_id' => 'required',
	// 			'tanggal_surat' => 'required',
	// 			'perihal_surat' => 'required',
	// 			'isi_ringkas_surat' => 'required',
	// 			'surat_pendukung' => 'mimes:pdf'
	// 		],
	// 		[
	// 			'required' => ':attribute Wajib diisi',
	// 			'mimes' => 'Surat pendukung hanya boleh pdf'
	// 		]
	// 	);
	// 	if ($validator->fails()) {
	// 		$pesan = $validator->errors();
	// 		$pakai_pesan = join(',',$pesan->all());
	// 		$return = ['status'=>'warning', 'code'=>201, 'message'=>$pakai_pesan];
	// 		return response()->json($return);
	// 	}

	// 	DB::beginTransaction();
	// 	$findAgendaTerakhir = SuratTugas::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->count();
	// 	if ($findAgendaTerakhir == 0) {
	// 		$findAgendaTerakhir = 1;
	// 	}else {
	// 		$findAgendaTerakhir = $findAgendaTerakhir+1;
	// 	}
	// 	try{
	// 		$newdata = (!empty($request->id)) ? SuratTugas::find($request->id) : new SuratTugas;
	// 		// CEK NO AGENDA BERDASARKAN AGENDA TERAKHIR ATAU SEDANG DI EDIT
	// 		if (!empty($request->id)) {
	// 			$newdata->no_agenda = $newdata->no_agenda;
	// 		}else {
	// 			$newdata->no_agenda = $findAgendaTerakhir;
	// 		}
	// 		$newdata->asn_id = implode($request->tujuan_surat_id,",");

	// 			// CEK KETIKA USER TIDAK BUAT SURAT MANUAL, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
	// 			if (empty($request->id)) {
	// 				$findJenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);
	// 				$kodeJenisSurat = $findJenisSurat->kode_jenis_surat;
	// 				$noUrutSurat = 	SuratTugas::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_perjalanan_dinas','DESC')->count(); // 0
	// 				if ($noUrutSurat == 0) {
	// 					$noUrutSurat = 1;
	// 				}else {
	// 					$noUrutSurat = $noUrutSurat+1;
	// 				}
	// 				// CEK KETIKA USER BUAT SURAT ELEKTRONIK, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
	// 				// $noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.date('Y');
	// 				$noSurat = $kodeJenisSurat.'/XXX/432.403/'.date('Y');
	// 				$newdata->nomor_surat_perjalanan_dinas = $noSurat;
	// 			}

	// 		$newdata->yang_bertanda_tangan_asn_id = $request->yang_bertanda_tangan;
	// 		$newdata->tanggal_surat = $request->tanggal_surat;
	// 		$newdata->tanggal_mulai = $request->tanggal_mulai;
	// 		$newdata->tanggal_akhir = $request->tanggal_akhir;
	// 		$newdata->perihal_surat = $request->perihal_surat;
	// 		$newdata->isi_ringkas_surat = $request->isi_ringkas_surat;
	// 		$newdata->alat_angkut = $request->alat_angkut;
	// 		if (!empty($request->surat_pendukung)) {
	// 			if (!empty($newdata->surat_pendukung)) {
	// 				Storage::delete($newdata->surat_pendukung);
	// 				unlink(public_path('storage'.DIRECTORY_SEPARATOR.'surat-pendukung'.DIRECTORY_SEPARATOR .$newdata->surat_pendukung));
	// 			}
	// 			$file = $request->file('surat_pendukung');
	// 			if($request->hasFile('surat_pendukung')){
	// 				$filename = $file->getClientOriginalName();
	// 				$ext_foto = $file->getClientOriginalExtension();
	// 				$filename = "432.403-".date('YmdHis').".".$ext_foto;
	// 				$file->storeAs('public/surat-pendukung/',$filename);
	// 				$newdata->surat_pendukung = $filename;
	// 			}
	// 		}
	// 		$newdata->save();
	// 		if ($newdata) {
	// 			if ($request->jenis_surat_id == '150' || $request->jenis_surat_id == '151' || $request->jenis_surat_id == '152' || $request->jenis_surat_id == '153' || $request->jenis_surat_id == '154' || $request->jenis_surat_id == '155') {
	// 				$asn = $request->tujuan_surat_id;
	// 				// return $request->tujuan;
	// 				foreach ($request->tujuan as $key => $value) {
	// 					$v = explode(",",$value);
	// 					$newTujuanSuratTugas = (!empty($v[5])) ? TujuanSuratTugas::find($v[5]) : new TujuanSuratTugas;
	// 					$newTujuanSuratTugas->surat_tugas_id = $newdata->id_surat_perjalanan_dinas;
	// 					$newTujuanSuratTugas->tanggal_mulai_tugas = $v[0];
	// 					$newTujuanSuratTugas->tanggal_akhir_tugas = $v[1];
	// 					$newTujuanSuratTugas->tempat_tujuan_bertugas = html_entity_decode($v[2]);
	// 					$newTujuanSuratTugas->provinsi_tujuan_bertugas = $v[3];
	// 					$newTujuanSuratTugas->alamat_tujuan_bertugas = $v[4];
	// 					$newTujuanSuratTugas->save();
	// 				}
	// 				// return $asn;
	// 				foreach ($asn as $key) {
	// 					// $newTujuanSuratTugas = (!empty($request->id_surat_tugas)) ? TujuanSuratTugas::find($request->id_surat_tugas) : new TujuanSuratTugas;
	// 					// $newTujuanSuratTugas->asn_id = $key;

	// 					// return $newdata;
	// 					if ($newTujuanSuratTugas) {

	// 						// $data['data'] = TujuanSuratTugas::find($newdata->id_surat_perjalanan_dinas);
	// 						// $data['asn'] = MasterASN::with('jabatan_asn')->where('jabatan',1)->orderBy('id_mst_asn','DESC')->first();
	// 						// $data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas','pegawai'])->find($newTujuanSuratTugas->id_surat_perjalanan_dinas);
	// 						// return $newdata->id_surat_perjalanan_dinas;
	// 						// return $data['data'] = SuratTugas::with('pegawai')->find($newdata->id_surat_perjalanan_dinas);
	// 						// return $data['data'] = SuratTugas::leftJoin('mst_asn as asn', 'asn.id_mst_asn', 'tr_surat_perjalanan_dinas.asn_id')
	// 						// 	->where('id_surat_perjalanan_dinas', $newdata->id_surat_perjalanan_dinas)->first();
	// 						// return $newdata->id_surat_perjalanan_dinas;
	// 						// return $data['data'] = SuratTugas::select(
	// 						// 	'asn.*',
	// 						// 	// 'tr_surat_perjalanan_dinas.*',
	// 						// 	// 'asn.nama_asn as nama_asn'
	// 						// // )->join('mst_asn as asn', DB::raw('asn.id_mst_asn::varchar'), '=','tr_surat_perjalanan_dinas.asn_id')
	// 						// )->join('mst_asn as asn',fn($join)=>
	// 						// // $join->on("tr_surat_perjalanan_dinas.asn_id",'LIKE',"%".DB::raw('asn.id_mst_asn::varchar')."%")
	// 						// $join->on('tr_surat_perjalanan_dinas.asn_id','LIKE',DB::raw("'%'|| asn.id_mst_asn::varchar ||'%'"))
	// 						// )->where('id_surat_perjalanan_dinas', $newdata->id_surat_perjalanan_dinas)->first();

	// 						return MasterASN::select(
	// 							'mst_asn.*',
	// 						)->join('tr_surat_perjalanan_dinas as jalan',fn($join)=>
	// 						// $join->on(DB::raw('jalan.asn_id'),'LIKE',DB::raw("'%'|| mst_asn.id_mst_asn::varchar ||'%'"))
	// 						$join->on('jalan.asn_id','LIKE',DB::raw("'%'|| mst_asn.id_mst_asn::varchar ||'%'"))
	// 						)->where('jalan.id_surat_perjalanan_dinas', $newdata->id_surat_perjalanan_dinas)->get();


	// 						$data['data'] = SuratTugas::with('pegawai')->find($newdata->id_surat_perjalanan_dinas);
	// 						$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
	// 						$data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
	// 						$ttd = '1. TTD Pada Tanggal :'.$data['data']->tanggal_surat.' 2. Oleh :'.$data['asn']->nama_asn.'  3. NIP: '.$data['asn']->nip;

	// 						$data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));

	// 						// DELETE DULU FILE YANG LAMA KALAU ADA
	// 						if (!empty($data['surat_tugas']->file_surat_tugas)) {
	// 							// if (is_file($data['surat_tugas']->file_scan)) {
	// 								Storage::delete($data['surat_tugas']->file_surat_tugas);
	// 								unlink(storage_path('app/public/surat-tugas/'.$data['surat_tugas']->file_surat_tugas));
	// 							// }
	// 						}
	// 						$changeSTugas = str_replace("/", "-", strtolower($data['data']->nomor_surat_perjalanan_dinas));
	// 						$file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['data']->pegawai->nama_asn).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_tugas.pdf');
	// 						$pdf = PDF::loadView('cetakan.surat_tugas', $data)
	// 							->setPaper([0, 0, 609.4488, 935.433], 'portrait');
	// 						Storage::put('public/surat-tugas/'.$file_name_asli_surat_tugas, $pdf->output());


	// 						$updateST = (!empty($request->id)) ? FileSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->where('asn_id',$key)->first() : new FileSuratTugas;
	// 						$updateST->surat_tugas_id = $data['data']->id_surat_perjalanan_dinas;
	// 						$updateST->asn_id = $key;
	// 						$updateST->file_surat_tugas = $file_name_asli_surat_tugas;
	// 						$updateST->save();

	// 				}
	// 				}
	// 			}
	// 		}

	// 		DB::commit();
	// 		$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
	// 		return response()->json($return);
	// 	}catch(\Exception $e){
	// 		DB::rollback();
	// 		throw($e);
	// 		$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
	// 		return response()->json($return);
	// 	}
	// }
	public function destroy(Request $request)
	{
		$do_delete = SuratTugas::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}
	public function destroyTujuan(Request $request)
	{
		$do_delete = TujuanSuratTugas::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}

	public function listSuratTugas(Request $request)
	{
        // return $request->all();
		try {
			// $data['data'] = FileSuratTugas::with(['surattugas.pegawai'])->where('surat_tugas_id',$request->id)->get();
			$data['data'] = FileSuratTugas::with(['surattugas','pegawai.jabatan_asn'])->where('surat_tugas_id',$request->id)->get();
            $allAsnId='';
			foreach ($data['data'] as $key => $v) {
				$v->asnId = $v->surattugas->asn_id;
                $allAsnId .= $key?','.$v->surattugas->asn_id:$v->surattugas->asn_id;
			}
			// $asn_id = explode(',', $data['data'][0]->asnId);
			// $data['pegawai'] = MasterASN::with('jabatan_asn')->whereIn('id_mst_asn', $asn_id)->get();
            $data['pegawai'] = MasterASN::with('jabatan_asn')->whereIn('id_mst_asn', explode(',',$allAsnId))->get();
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
            // return $data;
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'modal_surat_tugas', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'error', 'content' => '','errMsg'=>$e->getMessage()];
		}
	}
	public function listSPPD(Request $request)
	{
		try {
			$data['data'] = SuratTugas::with(['suratkeluar','pegawai'])->where('surat_keluar_id',$request->id)->get();
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'modal_list_sppd', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			throw($e);
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function cetakST(Request $request)
	{
		$data['data'] = SuratTugas::with('pegawai')->find(27);
		$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
		$ttd = '1. TTD Pada Tanggal :'.$data['data']->tanggal_surat.' 2. Oleh :'.$data['asn']->nama_asn.'  3. NIP: '.$data['asn']->nip;
		$data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
		$data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));
		// return $data;
		// $dompdf = new PDF();
	  $dompdf = PDF::loadView('cetakan.surat_tugas', $data)
	                ->setPaper([0, 0, 609.4488, 935.433], 'portrait');
	  // Render the HTML as PDF
	  $dompdf->render();
	  // Output the generated PDF to Browser
	return  $dompdf->stream();
	}
	public function cetakSPPD(Request $request)
	{
		$data['data'] = SuratTugas::find(14);
		$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
		$data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();

		// $dompdf = new PDF();
		$dompdf = PDF::loadView('cetakan.surat_sppd', $data)
									->setPaper([0, 0, 609.4488, 935.433], 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
	return  $dompdf->stream();
	}
	public function buatSPPD(Request $request)
	{
        // return $request;
		try {
			DB::beginTransaction();
			// $data['data'] = SuratTugas::find($request->id);
			// $data['file'] = FileSuratTugas::where([
			// 	['asn_id',$request->id],
			// 	['surat_tugas_id',$request->surat_tugas_id]
			// ])->first();
            $data['file'] = FileSuratTugas::find($request->id);
			// return $data;
			$data['data'] = SuratTugas::find($data['file']->surat_tugas_id);
			$data['pegawai'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$request->id)->first();
			$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
			// $data['asn'] = MasterASN::with('jabatan_asn')->where('jabatan',$request->id)->first();
			$data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
			// return $data['data']->pegawai->nama_asn;
			// return $data;
			// $asn = explode(",",$data['data']->asn_id);
			// return $asn;
			if (!empty($data['file']->file_surat_sppd)) {
				// if (is_file($data['file']->file_scan)) {
					Storage::delete($data['file']->file_surat_sppd);
					unlink(storage_path('app/public/surat-sppd/'.$data['file']->file_surat_sppd));
				// }
			}
			$changeSTugas = str_replace("/", "-", strtolower($data['data']->nomor_surat_perjalanan_dinas));
			// $file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['data']->pegawai->nama_asn).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_sppd.pdf');
			// $file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['file']->file_surat_tugas).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_sppd.pdf');
			$file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['pegawai']->nama_asn).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_sppd.pdf');
			$pdf = PDF::loadView('cetakan.surat_sppd', $data)
			->setPaper([0, 0, 609.4488, 935.433], 'portrait');
			Storage::put('public/surat-sppd/'.$file_name_asli_surat_tugas, $pdf->output());
			$updateST = $data['file'];
			$updateST->file_surat_sppd = $file_name_asli_surat_tugas;
			$updateST->save();
			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
			return response()->json($return);
		} catch (\Exception $e) {
			DB::rollback();
			throw($e);
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}
	}
	public function previewST(Request $request)
	{
		// return $request->all();
		$data = array();
		$arr_data = array(
			'nomor_surat_perjalanan_dinas' => '094/XXX/432.403/'.date('Y')
		);
		$data['data'] = $arr_data;
		$data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',1)->first();
		// $data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
		// return $data;
		// $dompdf = new PDF();
        // return view('cetakan.preview_surat_tugas', $data);
		$dompdf = PDF::loadView('cetakan.preview_surat_tugas', $data)
						->setPaper([0, 0, 609.4488, 935.433], 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
	    return  $dompdf->stream();
	}

	public function verifikasiST(Request $request)
	{
		try {
			// return $request->id;
			DB::beginTransaction();
			if ($request->ps != '123456') {
				$return = ['status'=>'error', 'code'=>'201', 'message'=>'Gagal Verifikasi, Passphrase tidak sesuai !!'];
				return response()->json($return);
			}

			$cekdata = SuratTugas::find($request->id);
				$kodeJenisSurat= explode("/",$cekdata->nomor_surat_perjalanan_dinas);
					$noUrutSurat = 	SuratTugas::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_perjalanan_dinas','DESC')->count(); // 0
					// $noUrutSurat = 	SuratTugas::whereNull('deleted_at')->orderBy('id_surat_perjalanan_dinas','DESC')->count(); // 0
					if ($noUrutSurat == 0) {
						$noUrutSurat = 1;
					}else {
						$noUrutSurat = $noUrutSurat+1;
					}
					// CEK KETIKA USER BUAT SURAT ELEKTRONIK, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
					$noSurat = $kodeJenisSurat[0].'/'.$noUrutSurat.'/432.403/'.date('Y');
					// $noSurat = $kodeJenisSurat.'/XXX/432.403/'.date('Y');
				$cekdata->nomor_surat_perjalanan_dinas = $noSurat;
                $cekdata->verifikasi_kaban = 'Y';
                $cekdata->save();
                $asn = explode(",",$cekdata->asn_id);

                foreach ($asn as $key) {
                    // $data['data'] = SuratTugas::with('pegawai')->find($cekdata->id_surat_perjalanan_dinas);
                    $data['data'] = SuratTugas::find($cekdata->id_surat_perjalanan_dinas);
                    $data['pegawai'] = MasterASN::with('jabatan_asn')->whereIn('id_mst_asn', $asn)->get();
                    $data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->yang_bertanda_tangan_asn_id)->first();
                    $data['surat_tugas'] = TujuanSuratTugas::with(['suratTugas'])->where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->get();
                    $ttd = '1. TTD Pada Tanggal :'.$data['data']->tanggal_surat.' 2. Oleh :'.$data['asn']->nama_asn.'  3. NIP: '.$data['asn']->nip;

                    $data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));

                    // DELETE DULU FILE YANG LAMA KALAU ADA
                    if (!empty($data['surat_tugas']->file_surat_tugas)) {
                        // if (is_file($data['surat_tugas']->file_scan)) {
                            Storage::delete($data['surat_tugas']->file_surat_tugas);
                            unlink(storage_path('app/public/surat-tugas/'.$data['surat_tugas']->file_surat_tugas));
                        // }
                    }
                    $changeSTugas = str_replace("/", "-", strtolower($data['data']->nomor_surat_perjalanan_dinas));
                    // $file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['data']->pegawai->nama_asn).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_tugas.pdf');
                    $file_name_asli_surat_tugas = str_replace(" ", "-", strtolower($data['asn']->nama_asn).'-'.$changeSTugas.'-'.date('Ymd His').'-surat_tugas.pdf');
                    $pdf = PDF::loadView('cetakan.surat_tugas', $data)
                        ->setPaper([0, 0, 609.4488, 935.433], 'portrait');
                    Storage::put('public/surat-tugas/'.$file_name_asli_surat_tugas, $pdf->output());
                    file_put_contents(public_path('storage/surat-tugas/' . $file_name_asli_surat_tugas), $pdf->output());
                #    // $updateST = (!empty($request->id)) ? FileSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->where('asn_id',$key)->first() : new FileSuratTugas;
                    // if (isset($request->id)) {
                    //     $updateST = FileSuratTugas::where('surat_tugas_id',$data['data']->id_surat_perjalanan_dinas)->where('asn_id',$key)->first();
                    // } else {
                    //     $updateST = new FileSuratTugas;
                    // }
                    $updateST = FileSuratTugas::where('surat_tugas_id', $data['data']->id_surat_perjalanan_dinas)->first();
                    if (!$updateST) {
                        $updateST = new FileSuratTugas;
                    }
                    // return $data['data']->id_surat_perjalanan_dinas;
                    $updateST->surat_tugas_id = $data['data']->id_surat_perjalanan_dinas;
                    $updateST->asn_id = $key;
                    $updateST->file_surat_tugas = $file_name_asli_surat_tugas;
                    $updateST->save();
                }

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
	public function dateRange(Request $request)
    {
     if(request()->ajax())
     {
      if(!empty($request->from_date))
      {
       $data = SuratTugas::table('tbl_order')
         ->whereBetween('order_date', array($request->from_date, $request->to_date))
         ->get();
      }
      else
      {
       $data = SuratTugas::table('tbl_order')
         ->get();
      }
      return datatables()->of($data)->make(true);
     }
     return view('daterange');
    }

	public function getId() {
		$data = SuratTugas::get()->pluck('id_surat_perjalanan_dinas');
		return response()->json($data);
	}

    public function stKosong() {
        // return PDF::loadView('cetakan.surat_tugas_kosongan');

        $pdf = PDF::loadView('cetakan.surat_tugas_kosongan');
        $html = view('cetakan.surat_tugas_kosongan')->render();
        return PDF::loadHTML($html, 'utf-8')->setOption('page-size', 'A4')->stream();
        // return view('cetakan.surat_tugas_kosongan');
    }
}
