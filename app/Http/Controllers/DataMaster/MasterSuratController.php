<?php

namespace App\Http\Controllers\DataMaster;
use App\Http\Controllers\Controller;
use App\Models\MasterSurat;
use App\Models\JenisSurat;

use Illuminate\Http\Request;
use DataTables,Validator,DB,Hash,Auth;

class MasterSuratController extends Controller
{
	private $title = "Master Surat";
	private $menuActive = "data-master";
	private $submnActive = "master-surat";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$data = MasterSurat::with('jenisSurat')->orderBy('id_mst_surat','desc')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="editForm('.$row->id_mst_surat.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_mst_surat.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
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
				$data['data'] = (!empty($request->id)) ? MasterSurat::find($request->id) : "";
				$data['jenis_surat'] = JenisSurat::get();
				$content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
				return ['status' => 'success', 'content' => $content];
			} catch (\Exception $e) {
				return ['status' => 'success', 'content' => '','errMsg'=>$e];
			}

		}

		public function store(Request $request)
		{
			$validator = Validator::make(
				$request->all(),
				[
					'jenis_surat' => 'required',
					'template_surat' => 'required',
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
				$newdata = (!empty($request->id)) ? MasterSurat::find($request->id) : new MasterSurat;
				$newdata->jenis_surat_id = $request->jenis_surat;
				$newdata->template_surat = $request->template_surat;
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
			$do_delete = MasterSurat::find($request->id);
			if(!empty($do_delete)){
				$do_delete->delete();
				return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
			}else{
				return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
			}
		}
}
