<?php

namespace App\Http\Controllers\Pengaturan;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

use Illuminate\Http\Request;
use DataTables,Validator,DB,Hash,Auth;

class RolePermissionsController extends Controller
{
	private $title = "Role Permissions";
	private $menuActive = "pengaturan";
	private $submnActive = "role-permission";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		// $this->data['levelName'] = 'Halaman '.$this->level_name(Auth::user()->level_user);
		$this->data['smallTitle'] = "";
		if ($request->ajax()) {
			$data = Role::orderBy('id','desc')->get();
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
			$data['data'] = (!empty($request->id)) ? Role::find($request->id) : "";
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
				'name' => 'required',
				// 'singkatan_sifat_surat' => 'required',
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
			// $newdata = (!empty($request->id)) ? SifatSurat::find($request->id) : new SifatSurat;
			// $newdata->nama_sifat_surat = $request->nama_sifat_surat;
			// // $newdata->singkatan = $request->singkatan_sifat_surat;
			// $newdata->save();
			Permission::firstOrCreate(['name' => 'pengguna']);
			Permission::firstOrCreate(['name' => 'instansi']);
			Permission::firstOrCreate(['name' => 'asn']);
			Permission::firstOrCreate(['name' => 'master-surat']);
			Permission::firstOrCreate(['name' => 'jenis-surat']);
			Permission::firstOrCreate(['name' => 'sifat-surat']);
			$adminRole = Role::create(['name' => $request->name]);
			if ($request->name == 'admin') {
				$adminRole->givePermissionTo('pengguna');
        $adminRole->givePermissionTo('instansi');
        $adminRole->givePermissionTo('asn');
				$adminRole->givePermissionTo('master-surat');
				$adminRole->givePermissionTo('jenis-surat');
        $adminRole->givePermissionTo('sifat-surat');
			}else {
				$adminRole->givePermissionTo('instansi');
        $adminRole->givePermissionTo('asn');
				$adminRole->givePermissionTo('master-surat');
				$adminRole->givePermissionTo('jenis-surat');
        $adminRole->givePermissionTo('sifat-surat');
			}
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
		$do_delete = Role::find($request->id);
		if(!empty($do_delete)){
			$do_delete->delete();
			return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
		}else{
			return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
		}
	}
}
