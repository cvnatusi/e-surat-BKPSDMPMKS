<?php

namespace App\Http\Controllers\DataMaster;
use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\SuratMasuk;

use Illuminate\Http\Request;
use DataTables,Validator,DB,Hash,Auth;
class InstansiController extends Controller
{
	private $title = "Instansi";
	private $menuActive = "data-master";
	private $submnActive = "instansi";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$data = Instansi::orderBy('id_instansi','desc')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="editForm('.$row->id_instansi.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_instansi.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					$btn .='</div></div>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);;
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}

	public function form(Request $request)
	{
		try {
			$data['data'] = (!empty($request->id)) ? Instansi::find($request->id) : "";
			$data['provinsi'] = Provinsi::get();
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			// return $data;
			return ['status' => 'success', 'content' => $content];
		} catch (\Exception $e) {
			return ['status' => 'error', 'content' => '','errMsg'=>$e];
		}

	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'kode_instansi' => 'required',
				'nama_instansi' => 'required',
				'alamat' => 'required',
				'nama_kota' => 'required',
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

		try{
			// Step 1 : Create User
			$newdata = (!empty($request->id)) ? Instansi::find($request->id) : new Instansi;
			$newdata->kode_instansi = $request->kode_instansi;
			$newdata->nama_instansi = $request->nama_instansi;
			$newdata->alamat = $request->alamat;
			$newdata->nama_kota = $request->nama_kota;
			$newdata->no_telepon = $request->no_telepon;
			$newdata->no_fax = $request->no_fax;
			$newdata->save();

			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
			return response()->json($return);
		}catch(\Exception $e){
			DB::rollback();
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}
	}
	public function destroy(Request $request)
	{
		// $sr = SuratMasuk::find($request->id);
		$sr = SuratMasuk::where('pengirim_surat_id', $request->id)->get();
		if(count($sr) > 0){
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
		$do_delete = Instansi::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}
}