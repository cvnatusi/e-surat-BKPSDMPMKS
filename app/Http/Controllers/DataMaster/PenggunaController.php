<?php

namespace App\Http\Controllers\DataMaster;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\MasterASN;
use DataTables,Validator,DB,Hash,Auth;
class PenggunaController extends Controller
{
	private $title = "Pengguna";
	private $menuActive = "data-master";
	private $submnActive = "pengguna";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$data = Users::orderBy('id','desc')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="editForm('.$row->id.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
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
			$data['data'] = (!empty($request->id)) ? Users::find($request->id) : "";
			$data['data_asn'] = MasterASN::get();
			if (!empty($request->id)) {
				$data['dataasn'] = MasterASN::where('users_id',$request->id)->first();
			}
			$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
			return ['status' => 'success', 'content' => $content];
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
				'asn' => 'required',
				'level_user' => 'required',
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
			$cekASN = MasterASN::findOrFail($request->asn);
			$newdata = (!empty($request->id)) ? Users::find($request->id) : new Users;
			$newdata->name = $cekASN->nama_asn;
			$newdata->email = $cekASN->nip;
			$newdata->level_user = $request->level_user;
			$newdata->password = Hash::make($cekASN->nip);
			if (!empty($request->tanda_tangan)) {
				if (!empty($newdata->tanda_tangan)) {
					// if (is_file($newdata->tanda_tangan)) {
						Storage::delete($newdata->tanda_tangan);
						unlink(public_path('tanda-tangan/'.$newdata->tanda_tangan));
						// File::delete($newdata->tanda_tangan);
					// }
				}
				$file = $request->file('tanda_tangan');
				if($request->hasFile('tanda_tangan')){
					$filename = $file->getClientOriginalName();
					$ext_foto = $file->getClientOriginalExtension();
					$filename = $cekASN->nama_asn."-".date('YmdHis').".".$ext_foto;
					$file->storeAs('public/tanda-tangan/',$filename);
					$newdata->tanda_tangan = $filename;
				}
			}
			$newdata->save();
			// if ($request->level_user == 1) {
			// 	$newdata->assignRole('admin');
			// }
			$cekASN->users_id = $newdata->id;
			$cekASN->save();

			DB::commit();
			$return = ['status'=>'success', 'code'=>'200', 'message'=>'User Berhasil di Buat!!<br> untuk LOGIN gunakan NIP'];
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
		$do_delete = Users::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}
}
