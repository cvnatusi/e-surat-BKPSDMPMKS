<?php

namespace App\Http\Controllers\DataMaster;
use App\Http\Controllers\Controller;
use App\Models\MasterASN;
use App\Models\Jabatan;
use App\Models\SuratDisposisi;
use App\Models\SuratTugas;

use Illuminate\Http\Request;
use DataTables,Validator,DB,Hash,Auth;

class MasterASNController extends Controller
{
	private $title = "Master ASN";
	private $menuActive = "data-master";
	private $submnActive = "asn";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$data = MasterASN::with('jabatan_asn')->orderBy('id_mst_asn','desc')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="editForm('.$row->id_mst_asn.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_mst_asn.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
					$btn .='</div></div>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}

		public function form(Request $request)
		{
			try {
				$data['data'] = (!empty($request->id)) ? MasterASN::find($request->id) : "";
				$data['jabatan'] = Jabatan::get();
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
					'nama_asn' => 'required',
					'nip' => 'required',
					'jabatan_id' => 'required',
					'pangkat_golongan' => 'required',
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
				$jabatan = $request->jabatan_id;
				if (is_numeric($jabatan)) {
					$request->jabatan = $jabatan;
				}else {
					$newJabatan = New Jabatan;
					$newJabatan->nama_jabatan = $jabatan;
					$newJabatan->save();
					$request->jabatan = $newJabatan->id_mst_jabatan;
				}

				$newdata = (!empty($request->id)) ? MasterASN::find($request->id) : new MasterASN;
				$newdata->nama_asn = $request->nama_asn;
				$newdata->nip = $request->nip;
				$newdata->jabatan = $request->jabatan;
				$newdata->pangkat_golongan = $request->pangkat_golongan;
				$newdata->eselon = $request->eselon;
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
			// return $request->all();
			// $sr = SuratDisposisi::where('pemberi_disposisi_id', $request->id)
			// 	->orWhere('penerima_disposisi_id', $request->id)->get();
			// $st = SuratTugas::where('asn_id', $request->id)->get();
			// if(count($sr) > 0 || count($st) > 0){
			// 	return ['status'=>'error','message' => 'Data Gagal Dihapus, Hubungi Tim IT !','title' => 'Whoops'];
			// }

			$do_delete = MasterASN::find($request->id);
			if(!empty($do_delete)){
				$do_delete->delete();
				return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
			}else{
				return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
			}
		}
}
