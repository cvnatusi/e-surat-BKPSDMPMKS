<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Instansi;
use App\Models\MasterASN;
use App\Models\SuratTugas;

use DataTables,Validator,DB,Hash,Auth,File,Storage, PDF;

class SuratKeluarController extends Controller
{
	private $title = "Surat Keluar";
	private $menuActive = "surat-keluar";
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
				$data = SuratKeluar::with(['sifat','jenis'])
				->whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir])
				->orderBy('tanggal_surat','DESC')
				// ->orderBy('nomor_surat_keluar','DESC')
				->get();
				// $data = SuratKeluar::with(['sifat','jenis'])->orderBy('id_surat_keluar','DESC')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					if (Auth::user()->level_user == 2 || Auth::user()->level_user == 1) { // matikan level user 1 nanti
						$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					if ($row->is_verif == true) {
						$btn .= '<a href="javascript:void(0)" onclick="editDisabledForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					}else {
						// $btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					}
					// $btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					if (Auth::user()->id == $row->user_id || Auth::user()->level_user == 1) {
						$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
						$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					} else {
					}
					$btn .='</div></div>';
					return $btn;
				   }else {
					$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					if ($row->is_verif == true) {
						$btn .= '<a href="javascript:void(0)" onclick="editDisabledForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					}else {
						// $btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_keluar.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					}

					$btn .='</div></div>';
					return $btn;
				}




					// $btn = '<a href="javascript:void(0)" onclick="showSuratTugas('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					// if ($row->verifikasi_kaban == 'N') {
					// 	$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					// }else {
					// 	$btn .= '<button disabled onclick"sudahVerif()" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></button>';
					// }
					// $btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_perjalanan_dinas.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					// $btn .='</div></div>';
					// return $btn;
				})
				->addColumn('namaPenerima',function($row){
					// if ($row->jenis_surat_id == '150' || $row->jenis_surat_id == '151' || $row->jenis_surat_id == '152' || $row->jenis_surat_id == '153' || $row->jenis_surat_id == '154' || $row->jenis_surat_id == '155') {
					// 	$ins = explode(",",$row->tujuan_surat_id);
					// 	$arrMst = [];
					// 	if(count($ins)>0){
					// 		foreach($ins as $key => $val){
					// 			$cekInst = MasterASN::findOrFail($val);
					// 			// dd()
					// 			// if(!empty($val->mst_pramubakti)){
					// 			array_push($arrMst,$cekInst->nama_asn);
					// 			// }
					// 		}
					// 		$join = "ada";
					// 	}else{
					// 		$join = "kosong";
					// 	}
					// }else {
						$ins = explode(",",$row->tujuan_surat_id);
						$arrMst = [];
						if(count($ins)>0){
							foreach($ins as $key => $val){
								$cekInst = Instansi::findOrFail($val);
								// dd()
								// if(!empty($val->mst_pramubakti)){
								array_push($arrMst,$cekInst->nama_instansi);
								// }
							}
							$join = "ada";
						}else{
							$join = "kosong";
						}
					// }
					if(count($arrMst)>0){
						$join = join(", ",$arrMst);
					}else{
						$join = "-";
					}
					return $join;
				})
				->addColumn('check', function($row){
					$btn = '<input class="form-check-input select-checkbox" onchange="checkedRow(this)" data-id="'.$row->id_surat_keluar.'" id="check_'.$row->id_surat_keluar.'" name="check" value="'.$row->id_surat_keluar.'" type="checkbox"></a>';
					return $btn;
				})
				// ->addColumn('verifKABAN', function($row){
				// 	if ($row->is_verif == false) {
				// 		if (Auth::user()->level_user == 2 || Auth::user()->level_user == 1) { // matikan level user 1 nanti
				// 			 // disini tambahkan 1 parameter lagi di onclick untuk dia ttd elektronik atau ttd manual
				// 			 // TTE parameternya t
				// 			 // TTD Manual parameternya f

				// 			// Lalu buat function baru namanya verifKABAN cek functionnya di bawah sendiri
				// 			$btn = '<a href="javascript:void(0)" id="verif_'.$row->id_surat_keluar.'" onclick="verifKABAN('.$row->id_surat_keluar.','.$row->ttd.')" style="margin-right: 5px;" class="btn btn-success "><i class="bx bx-check-shield me-0"></i></a>';
				// 		}else {
				// 			$btn = '<span class="badge bg-danger">Belum di Verifikasi</span>';
				// 		}
				// 	}else {
				// 		$btn = '<span class="badge bg-success">Sudah di Verifikasi</span>';
				// 	}
				// 	return $btn;
				// })
				->rawColumns(['action','namaPenerima','verifKABAN', 'check'])
				// ->rawColumns(['action','namaPenerima','verifKABAN'])
				->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratKeluar::find($request->id) : "";
			$data['jenis_surat'] = JenisSurat::get();
			$data['sifat_surat'] = SifatSurat::get();
			$data['instansi'] = Instansi::get();
			// $data['instansi'] = MasterASN::get();
			if (!empty($request->id)) {
				if ($data['data']->jenis_surat_id == '150' || $data['data']->jenis_surat_id == '151' || $data['data']->jenis_surat_id == '152' || $data['data']->jenis_surat_id == '153' || $data['data']->jenis_surat_id == '154' || $data['data']->jenis_surat_id == '155') {
					// $data['instansi'] = MasterASN::get();
					$data['surat_tugas'] = SuratTugas::with(['suratkeluar','pegawai'])->where('surat_keluar_id',$request->id)->first();
				}
				// return $data;
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
		$validator = Validator::make(
			$request->all(),
			[
				// 'nomor_surat_keluar' => 'required',
				'tujuan_surat_id' => 'required',
				'sifat_surat_id' => 'required',
				'jenis_surat_id' => 'required',
				'tanggal_surat' => 'required',
				'perihal_surat' => 'required',
				'isi_ringkas_surat' => 'required',
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

		// FUNGSI FILTER NUMERIK ATAU TIDAK
		// ketika tidak numerik, buat instansi baru, nama instansi di uppercase

		$id_tujuan = [];
		foreach($request->tujuan_surat_id as $tujuan_surat) {
			if (!is_numeric($tujuan_surat)) {
				$newinstansi = new Instansi;
				$newinstansi->nama_instansi = strtoupper($tujuan_surat);
				$newinstansi->kode_instansi = '-';
				$newinstansi->alamat = '-';
				$newinstansi->pimpinan_unit_kerja = '-';
				$newinstansi->nama_kota = '-';
				$newinstansi->no_fax = '-';
				$newinstansi->no_telepon = '-';
				$newinstansi->save();
				array_push($id_tujuan, $newinstansi->id_instansi);
			} else {
				array_push($id_tujuan, $tujuan_surat);
			}
		}

		// sekarang buat fungsi untuk menambahkan data baru ke array request->tujuan_surat_id
		// terserah mau di buatkan variabel baru atau tetap, pokok data baru yang sudah di insert ke database itu masuk ke array tujuan surat. pakai array_push
		// awal data : ["3","farid ilham al qorni"]
		// hasil data : ["3","4"]

		$findAgendaTerakhir = SuratKeluar::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_keluar','DESC')->count();
		if ($findAgendaTerakhir == 0) {
			$findAgendaTerakhir = 0;
		}else {
			$findAgendaTerakhir = $findAgendaTerakhir + 1;
		}
		try{
			$newdata = (!empty($request->id)) ? SuratKeluar::find($request->id) : new SuratKeluar;
			// CEK NO AGENDA BERDASARKAN AGENDA TERAKHIR ATAU SEDANG DI EDIT
			if (!empty($request->id)) {
				$newdata->no_agenda = $newdata->no_agenda;
			}else {
				$newdata->no_agenda = $findAgendaTerakhir;
			}
			// $newdata->tujuan_surat_id = implode(",",$request->tujuan_surat_id);
			$newdata->tujuan_surat_id = implode(",",$id_tujuan);
			// CEK BUAT SURAT ELEKTRONIK
			if (!empty($request->buatSuratElektronik)) {
				$newdata->surat_elektronik = $request->buatSuratElektronik;
			}else {
				$newdata->surat_elektronik = 'N';
			}
			// CEK KETIKA USER BUAT SURAT MANUAL
			if (!empty($request->noSuratManual)) {
				$newdata->surat_manual = $request->noSuratManual;
				if (!empty($request->no_surat1)) {
					$newdata->no_surat1 = $request->no_surat1;
					$newdata->no_surat2 = $request->no_surat2;
					$newdata->no_surat3 = $request->no_surat3;
					$newdata->no_surat4 = $request->no_surat4;
					// KETIKA BUAT SURAT MANUAL DAN SURAT ITU ELEKTRONIK
					if ($request->buatSuratElektronik == 'Y') {
						$noSurat = $request->no_surat2.'/E.'.$request->no_surat1.'/432.403/'.$request->no_surat4;
					}else {
						$noSurat = $request->no_surat2.'/'.$request->no_surat1.'/432.403/'.$request->no_surat4;
					}
				}
				$newdata->nomor_surat_keluar = $noSurat;
			}else {
				// CEK KETIKA USER TIDAK BUAT SURAT MANUAL, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
				$newdata->surat_manual = 'N';
				if (empty($request->id)) {
					$findJenisSurat = JenisSurat::findOrFail($request->jenis_surat_id);
					$kodeJenisSurat = $findJenisSurat->kode_jenis_surat;
					$noUrutSurat = 	SuratKeluar::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->where('surat_manual','N')->orderBy('id_surat_keluar','DESC')->count(); // 0
					if ($noUrutSurat == 0) {
						$noUrutSurat = 1;
					}else {
						$noUrutSurat = $noUrutSurat+1;
					}
					// CEK KETIKA USER BUAT SURAT ELEKTRONIK, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
					if ($request->buatSuratElektronik == 'Y') {
						// $noSurat = $kodeJenisSurat.'/E.XXX/432.403/'.$request->no_surat4;
						$noSurat = $kodeJenisSurat.'/E.'.$noUrutSurat.'/432.403/'.$request->no_surat4;
					}else {
						// $noSurat = $kodeJenisSurat.'/XXX/432.403/'.$request->no_surat4;
						$noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.$request->no_surat4;
					}
					$newdata->nomor_surat_keluar = $noSurat;
				}
			}
			$cekNoSurat = SuratKeluar::where('nomor_surat_keluar','ilike','%'.$noSurat.'%')->first(); // 0
			if (!empty($cekNoSurat)) {
				$cekTerakhir = SuratKeluar::where('tanggal_surat',$request->tanggal_surat)->latest()->first();
				if (!empty($cekTerakhir)) {
					$return = ['status'=>'error', 'code'=>'201', 'message'=>'Nomor Surat Duplikat!! Dengan Surat Pada Tanggal '.$cekNoSurat->tanggal_surat];
				}else {
					$return = ['status'=>'error', 'code'=>'201', 'message'=>'Nomor Surat Duplikat!!'];
				}
				DB::rollback();
				return response()->json($return);
			}
			$newdata->sifat_surat_id = $request->sifat_surat_id;
			$newdata->jenis_surat_id = $request->jenis_surat_id;
			$newdata->tanggal_surat = $request->tanggal_surat;
			$newdata->perihal_surat = $request->perihal_surat;
			$newdata->isi_ringkas_surat = $request->isi_ringkas_surat;
			$newdata->user_id = $request->user_id;
			if (!empty($request->ttd)) {
				$newdata->ttd = $request->ttd;
			}else {
				$newdata->ttd = 'f';
			}
			if (!empty($request->file_scan)) {
				if (!empty($newdata->file_scan)) {
					// if (is_file($newdata->file_scan)) {
						Storage::delete($newdata->file_scan);
						unlink(public_path('surat-keluar/'.$newdata->file_scan));
						// File::delete($newdata->file_scan);
					// }
				}
				$file = $request->file('file_scan');
				if($request->hasFile('file_scan')){
					$filename = $file->getClientOriginalName();
					$ext_foto = $file->getClientOriginalExtension();
					$filename = $newdata->no_agenda."-".date('YmdHis').".".$ext_foto;
					$file->storeAs('public/surat-keluar/',$filename);
                    file_put_contents(public_path('storage/surat-keluar/' . $filename), file_get_contents($file->getRealPath()));
					$newdata->file_scan = $filename;
				}
			}
			$newdata->save();
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
	public function destroy(Request $request)
	{
		$do_delete = SuratKeluar::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}

	public function listSuratTugas(Request $request)
	{
		try {
			$data['data'] = SuratTugas::with(['suratkeluar','pegawai'])->where('surat_keluar_id',$request->id)->get();
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'modal_surat_tugas', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
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
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function cetakST(Request $request)
	{
		$data['data'] = SuratKeluar::find(27);
		$data['asn'] = MasterASN::with('jabatan_asn')->where('jabatan',1)->first();
		$data['surat_tugas'] = SuratTugas::with(['suratkeluar','pegawai'])->find(9);
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
		$data['data'] = SuratKeluar::find(27);
		$data['asn'] = MasterASN::with('jabatan_asn')->where('jabatan',1)->first();
		$data['surat_tugas'] = SuratTugas::with(['suratkeluar','pegawai'])->find(9);
		// $dompdf = new PDF();
		$dompdf = PDF::loadView('cetakan.surat_sppd', $data)
									->setPaper([0, 0, 609.4488, 935.433], 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
	return  $dompdf->stream();
	}
	public function verifKABAN(Request $request)
	{
		try {
			DB::beginTransaction();
			if ($request->ps != '123456') {
				$return = ['status'=>'error', 'code'=>'201', 'message'=>'Gagal Verifikasi, Passphrase tidak sesuai !!'];
				return response()->json($return);
			}
			$suratKeluar= SuratKeluar::find($request->id);
			$findJenisSurat = JenisSurat::findOrFail($suratKeluar->jenis_surat_id);
			$kodeJenisSurat = $findJenisSurat->kode_jenis_surat;
			$noUrutSurat = 	SuratKeluar::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->where('surat_manual','Y')->orderBy('id_surat_keluar','DESC')->max('no_agenda'); // 0
			if ($noUrutSurat == 0) {
					$noUrutSurat = 1;
				}else {
					$noUrutSurat = $noUrutSurat+1;
				}
			// CEK KETIKA USER BUAT SURAT ELEKTRONIK, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
			if (!empty($suratKeluar->no_surat4)) {
				if ($suratKeluar->buatSuratElektronik == 'Y') {
					// $noSurat = $kodeJenisSurat.'/E.XXX/432.403/'.$request->no_surat4;
					$noSurat = $kodeJenisSurat.'/E.'.$noUrutSurat.'/432.403/'.$suratKeluar->no_surat4;
				}else {
					// $noSurat = $kodeJenisSurat.'/XXX/432.403/'.$request->no_surat4;
					$noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.$suratKeluar->no_surat4;
				}
			}else {
				if ($suratKeluar->buatSuratElektronik == 'Y') {
					// $noSurat = $kodeJenisSurat.'/E.XXX/432.403/'.$request->no_surat4;
					$noSurat = $kodeJenisSurat.'/E.'.$noUrutSurat.'/432.403/'.date('Y');
					// $noSurat = $kodeJenisSurat.'/E.'.$noUrutSurat.'/432.403/'.$suratKeluar->no_surat4;
				}else {
					// $noSurat = $kodeJenisSurat.'/XXX/432.403/'.$request->no_surat4;
					$noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.date('Y');
					// $noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.$suratKeluar->no_surat4;
				}
			}

				$suratKeluar->nomor_surat_keluar = $noSurat;
				$suratKeluar->is_verif=true;
				$suratKeluar->save();

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
	// public function verifKABAN(Request $request)
	// {
	// 	// return $request->all();

	// 				$suratKeluar= SuratKeluar::find($request->id);
	// 				$findJenisSurat = JenisSurat::findOrFail($suratKeluar->jenis_surat_id);
	// 				$kodeJenisSurat = $findJenisSurat->kode_jenis_surat;


	// 				$noUrutSurat = 	SuratKeluar::whereYear('tanggal_surat', '=', date('Y'))->whereNull('deleted_at')->where('surat_manual','Y')->orderBy('id_surat_keluar','DESC')->count(); // 0
	// 				if ($noUrutSurat == 0) {
	// 					$noUrutSurat = 1;
	// 				}else {
	// 					$noUrutSurat = $noUrutSurat+1;
	// 				}
	// 				// CEK KETIKA USER BUAT SURAT ELEKTRONIK, DISINI GENERATEKAN NOMOR SURAT OTOMATIS
	// 				if ($suratKeluar->buatSuratElektronik == 'Y') {
	// 					// $noSurat = $kodeJenisSurat.'/E.XXX/432.403/'.$request->no_surat4;
	// 					$noSurat = $kodeJenisSurat.'/E.'.$noUrutSurat.'/432.403/'.$suratKeluar->no_surat4;
	// 				}else {
	// 					// $noSurat = $kodeJenisSurat.'/XXX/432.403/'.$request->no_surat4;
	// 					$noSurat = $kodeJenisSurat.'/'.$noUrutSurat.'/432.403/'.$suratKeluar->no_surat4;
	// 				}

	// 				$suratKeluar->nomor_surat_keluar = $noSurat;
	// 				$suratKeluar->is_verif=true;
	// 				$suratKeluar->save();
	// 	// disini generate nomor tadi yang xxx
	// }
	public function show(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratKeluar::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'success', 'content' => '','errMsg'=>$e];
		}
	}

	public function checkSuratKeluarByDate(Request $request)
	{
	return	$data = SuratKeluar::where('tanggal_surat',$request->tanggal)->latest()->first();
	}

	public function getId() {
		$data = SuratKeluar::get()->pluck('id_surat_keluar');
		return response()->json($data);
	}

}
