<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\Instansi;
use App\Models\DenganHarap;
use App\Models\TimelineSuratMasuk;
use Illuminate\Support\Facades\View;
use DataTables,Validator,DB,Hash,Auth,File,Storage,PDF;

class SuratMasukController extends Controller
{
	private $title = "Surat Masuk";
	private $menuActive = "surat-masuk";
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
				$data = SuratMasuk::with(['sifat','jenis','pengirim'])
				->whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir])
				->orderByDESC('tanggal_surat')
				->get();

				// $data = SuratMasuk::with(['sifat','jenis','pengirim'])->orderBy('id_surat_masuk','desc')->get();
			// return $data;
			// $data = SuratMasuk::with(['sifat','jenis','pengirim'])->where('tanggal_terima_surat','like',date('Y-m-d').'%')->orderBy('id_surat_masuk','desc')->get();
			// $data = SuratMasuk::onlyTrashed()->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('singkatan', function($row){
					if (!empty($row->pengirim->no_fax)) {
						$singkatan = $row->pengirim->no_fax;
					} else {
						$singkatan = '-';
					}
					return $singkatan;
				})
				->addColumn('pengirim', function($row){
					if (!empty($row->pengirim)) {
						$pengirim_surat = $row->pengirim->nama_instansi;
					} else {
						$pengirim_surat = '-';
					}
					return $pengirim_surat;
				})
				->addColumn('action', function($row){
					if (Auth::user()->level_user == 2 || Auth::user()->level_user == 1) { // matikan level user 1 nanti
						$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-info " data-toggle="popover" data-trigger="hover" title="Lihat File Surat" ><i class="bx bx-show me-0"></i></a>';
						if (Auth::user()->level_user == 1) {
							$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-warning" data-toggle="popover" data-trigger="hover" title="Edit"><i class="bx bx-pencil me-0"></i></a>';
						}else {
							$btn .= '<a href="surat-disposisi?redirect=buat-baru&idsurat='.$row->id_surat_masuk.'&nosurat='.$row->no_agenda.'&nosuratmasuk='.$row->nomor_surat_masuk.'&namapengirim='.$row->pengirim->nama_instansi.'&isiringkas='.$row->isi_ringkas_surat.'" style="margin-right: 5px;" class="btn btn-warning" data-toggle="popover" data-trigger="hover" title="Disposisi"><i class="bx bx-task-x me-0"></i></a>';
						}
						$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-danger " data-toggle="popover" data-trigger="hover" title="Hapus"><i class="bx bx-trash me-0"></i></a><br><br>';
						$btn .= '<a href="javascript:void(0)" onclick="timeLine('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-success " data-toggle="popover" data-trigger="hover" title="Timeline"><i class="bx bx-video-recording me-0"></i></a>';
						$btn .= '<a href="javascript:void(0)" onclick="downloadTemplate('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-secondary " data-toggle="popover" data-trigger="hover" title="Download"><i class="bx bx-download me-0"></i></a>';
						return $btn;
				   }else {
					$btn = '<a href="javascript:void(0)" onclick="showForm('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-info "><i class="bx bx-show me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="timeLine('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-success "><i class="bx bx-video-recording me-0"></i></a>';
					return $btn;
				}

				})
				->addColumn('check', function($row){
					$btn = '<input class="form-check-input select-checkbox" onchange="checkedRow(this)" data-id="'.$row->id_surat_masuk.'" id="check_'.$row->id_surat_masuk.'" name="check" value="'.$row->id_surat_masuk.'" type="checkbox"></a>';
					return $btn;
				})
				->rawColumns(['action','check'])
				->make(true);;

		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}
	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratMasuk::find($request->id) : "";
			$data['jenis_surat'] = JenisSurat::get();
			$data['sifat_surat'] = SifatSurat::get();
			$data['instansi'] = Instansi::get();
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
				'nomor_surat_masuk' => 'required',
				'pengirim_surat_id' => 'required',
				'sifat_surat_id' => 'required',
				'jenis_surat_id' => 'required',
				'tanggal_surat' => 'required',
				'tanggal_terima_surat' => 'required',
				'perihal_surat' => 'required',
				'isi_ringkas_surat' => 'required',
				'pengirim_surat_id' => 'required',
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


		$findAgendaTerakhir = SuratMasuk::whereYear('tanggal_terima_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_masuk','DESC')->count();
		if ($findAgendaTerakhir == 0) {
			$findAgendaTerakhir = 0;
		}else {
			$findAgendaTerakhir = $findAgendaTerakhir+1;
		}
		// if (empty($findAgendaTerakhir)) {
		// 	$count = 0001;
		// } else {
		// 	$count =  $findAgendaTerakhir->no_agenda;
		// 	$count += 1;
		// }
		// if ($count < 10) {
		// 	$count = '000'.$count;
		// }else if ($count < 100) {
		// 	$count = '00'.$count;
		// }else if ($count < 1000){
		// 	$count = '0'.$count;
		// }
		try{
			$newdata = (!empty($request->id)) ? SuratMasuk::find($request->id) : new SuratMasuk;
			$newtimeline = New TimelineSuratMasuk;
			if (!empty($request->id)) {
				$newdata->no_agenda = $newdata->no_agenda;
			}else {
				$newdata->no_agenda = $findAgendaTerakhir;
			}
			$newdata->nomor_surat_masuk = $request->nomor_surat_masuk;
			$instansi = $request->pengirim_surat_id;
			if(!is_numeric($request->pengirim_surat_id)) {
				$newinstansi = new Instansi;
				$newinstansi->nama_instansi = strtoupper($request->pengirim_surat_id);
				$newinstansi->kode_instansi = '-';
				$newinstansi->alamat = '-';
				$newinstansi->pimpinan_unit_kerja = '-';
				$newinstansi->nama_kota = '-';
				$newinstansi->no_fax = '-';
				$newinstansi->no_telepon = '-';
				$newinstansi->save();
				$newdata->pengirim_surat_id = $newinstansi->id_instansi;
			} else {
				$newdata->pengirim_surat_id = $request->pengirim_surat_id;
			}
			// if (empty($request->instansi_baru)) {
			// 	$newdata->pengirim_surat_id = $request->pengirim_surat_id;
			// }else {
			// 	$newInstansi = New Instansi;
			// 	$newInstansi->kode_instansi = '-';
			// 	$newInstansi->nama_instansi = $request->pengirim_surat_id;
			// 	$newInstansi->alamat = '-';
			// 	$newInstansi->nama_kota = 3528;
			// 	$newInstansi->no_telepon = '-';
			// 	$newInstansi->no_fax = '-';
			// 	$newInstansi->save();
			// 	$newdata->pengirim_surat_id = $newInstansi->id_instansi;
			// }
			$newdata->sifat_surat_id = $request->sifat_surat_id;
			$newdata->jenis_surat_id = $request->jenis_surat_id;
			$newdata->tanggal_surat = $request->tanggal_surat;
			$newdata->tanggal_terima_surat = $request->tanggal_terima_surat;
			$newdata->perihal_surat = $request->perihal_surat;
			$newdata->isi_ringkas_surat = $request->isi_ringkas_surat;
			$newdata->catatan_tambahan = $request->catatan_tambahan;
			if (!empty($request->file_scan)) {
				if (!empty($newdata->file_scan)) {
					if (is_file($newdata->file_scan)) {
						Storage::delete($newdata->file_scan);
						unlink(storage_path('public/surat-masuk/'.$newdata->file_scan));
						// File::delete($newdata->file_scan);
					}
				}
				$file = $request->file('file_scan');
				if($request->hasFile('file_scan')){
					$filename = $file->getClientOriginalName();
					$ext_foto = $file->getClientOriginalExtension();
					$filename = $newdata->no_agenda."-".date('YmdHis').".".$ext_foto;
					$file->storeAs('public/surat-masuk/',$filename);
					$newdata->file_scan = $filename;
				}
			}
			if (!empty($request->sampai_bkpsdm)) {
				$newdata->sampai_bkpsdm = $request->sampai_bkpsdm;
			}else {
				$newdata->sampai_bkpsdm = 'N';
			}
			$newdata->save();

            $newdata->load('pengirim');

			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!', 'data' => $newdata];
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
		$do_delete = SuratMasuk::find($request->id);
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
			$data['data'] = (!empty($request->id)) ? SuratMasuk::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'show', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'error', 'content' => '','errMsg'=>$e];
		}
	}

	public function showTimeline(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? SuratMasuk::find($request->id) : "";
			// $data['jenis_surat'] = JenisSurat::get();
			// $data['sifat_surat'] = SifatSurat::get();
			// $data['instansi'] = Instansi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'timeline', $data)->render();
			return ['status' => 'success', 'content' => $content, 'data' => $data];
		} catch (\Exception $e) {
			return ['status' => 'error', 'content' => '','errMsg'=>$e];
		}
	}

	public function getSuratMasukByAgenda(Request $request)
	{
		$data = SuratMasuk::where('no_agenda', $request->id)->get();
		return response()->json($data);
	}

	public function multiPrintDisposisi(Request $request)
	{
		$id = $request->id;
		try {

			$data['surat'] = SuratMasuk::with('pengirim')->whereIn('id_surat_masuk',$request->id)->get();
			$data['dengan_harap'] = DenganHarap::get();
			$dompdf = PDF::loadView('cetakan.surat_disposisi_kosongan', $data)
										->setPaper([0, 0, 609.4488, 935.433], 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
		return  $dompdf->stream('my.pdf',array('Attachment'=>0));
		} catch (\Exception $e) {
			throw($e);
			return ['status' => 'error','errMsg'=>$e];
		}

	}

	// TEMPLATE DISPOSISI KOSONGAN (MULTI FILE)
	public function multiDownload(Request $request) {
		$data['listData'] = SuratMasuk::whereIn('id_surat_masuk', $request->listId)->with('pengirim', 'sifat', 'jenis')->get();
		$html = View::make('cetakan.surat_disposisi_kosongan_multi', $data)->render();

    	return response()->json(['html' => $html]);
	}

	// TEMPLATE DISPOSISI KOSONGAN (SINGLE FILE)
    public function templateDisposisi(Request $request) {
		$data['data'] = SuratMasuk::where('id_surat_masuk', $request->id)->with('pengirim', 'sifat', 'jenis')->first();
		$html = View::make('cetakan.surat_disposisi_kosongan2', $data)->render();

    	return response()->json(['html' => $html]);
	}

	public function getId() {
		$data = SuratMasuk::get()->pluck('id_surat_masuk');
		return response()->json($data);
	}


	public function showTrash(Request $request)
	{
		$this->data['title'] = 'Arsip '.$this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$paramTglAwal = $request->tglAwal;
			$paramTglAkhir = $request->tglAkhir;
				$data = SuratMasuk::with(['sifat','jenis','pengirim'])
				// ->whereBetween('tanggal_surat',[$paramTglAwal,$paramTglAkhir])
				// ->orderBy('id_surat_masuk','desc')
				->onlyTrashed()
				->get();

				// $data = SuratMasuk::with(['sifat','jenis','pengirim'])->orderBy('id_surat_masuk','desc')->get();
			// return $data;
			// $data = SuratMasuk::with(['sifat','jenis','pengirim'])->where('tanggal_terima_surat','like',date('Y-m-d').'%')->orderBy('id_surat_masuk','desc')->get();
			// $data = SuratMasuk::onlyTrashed()->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('singkatan', function($row){
					if (!empty($row->pengirim->no_fax)) {
						$singkatan = $row->pengirim->no_fax;
					} else {
						$singkatan = '-';
					}
					return $singkatan;
				})
				->addColumn('pengirim', function($row){
					if (!empty($row->pengirim)) {
						$pengirim_surat = $row->pengirim->nama_instansi;
					} else {
						$pengirim_surat = '-';
					}
					return $pengirim_surat;
				})
				->addColumn('action', function($row){
					if (Auth::user()->level_user == 2 || Auth::user()->level_user == 1) { // matikan level user 1 nanti
						$btn = '<a href="javascript:void(0)" onclick="restoreSurat('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-info " data-toggle="popover" data-trigger="hover" title="Restore Surat Masuk" ><i class="bx bx-loader-alt me-0"></i></a>';
						$btn .= '<a href="javascript:void(0)" onclick="deleteSurat('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-danger " data-toggle="popover" data-trigger="hover" title="Hapus"><i class="bx bx-trash me-0"></i></a>';
						// $btn .= '<a href="javascript:void(0)" onclick="editForm('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-warning" data-toggle="popover" data-trigger="hover" title="Edit"><i class="bx bx-pencil me-0"></i></a>';
						// $btn .= '<a href="javascript:void(0)" onclick="timeLine('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-success " data-toggle="popover" data-trigger="hover" title="Timeline"><i class="bx bx-video-recording me-0"></i></a>';
						// $btn .= '<a href="javascript:void(0)" onclick="downloadTemplate('.$row->id_surat_masuk.')" style="margin-right: 5px;" class="btn btn-secondary " data-toggle="popover" data-trigger="hover" title="Download"><i class="bx bx-download me-0"></i></a>';
						return $btn;
				   }

				})
				->addColumn('check', function($row){
					$btn = '<input class="form-check-input " onchange="checkedRow()" id="check_('.$row->id_surat_masuk.')" name="check" value="'.$row->id_surat_masuk.'" type="checkbox"></a>';
					return $btn;
				})
				->rawColumns(['action','check'])
				->make(true);;

		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'trash')->with('data',$this->data);
	}

	public function restoreSurat(Request $request)
	{
		$data = SuratMasuk::onlyTrashed()->where('id_surat_masuk',$request->id);
		if(!empty($data)){
			$data->restore();
			return ['status' => 'success','message' => 'Anda Berhasil Restore Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Direstore','title' => 'Whoops'];
		}
	}
	public function deleteSurat(Request $request)
	{
		$data = SuratMasuk::onlyTrashed()->where('id_surat_masuk',$request->id);
		if(!empty($data)){
			$data->forceDelete();
			return ['status' => 'success','message' => 'Anda Berhasil Restore Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Direstore','title' => 'Whoops'];
		}
	}
}
