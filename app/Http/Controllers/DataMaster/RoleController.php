<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\LevelPengguna;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    private $title = "Level Pengguna";
	private $menuActive = "data-master";
	private $submnActive = "level-pengguna";

    public function index(Request $request)
    {
        $this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
        if ($request->ajax()) {
			$data = LevelPengguna::orderBy('id_level_user','desc')->get();
			return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" onclick="editForm('.$row->id_level_user.')" style="margin-right: 5px;" class="btn btn-warning "><i class="bx bx-pencil me-0"></i></a>';
					$btn .= '<a href="javascript:void(0)" onclick="deleteForm('.$row->id_level_user.')" style="margin-right: 5px;" class="btn btn-danger "><i class="bx bx-trash me-0"></i></a>';
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
            $data['data'] = (!empty($request->id)) ? LevelPengguna::find($request->id) : "";
            $content = view($this->menuActive.'.'.$this->submnActive.'.'.'form', $data)->render();
            return ['status' => 'success', 'content' => $content];
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_level_pengguna' => 'required',
                'singkatan' => 'required',
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

        try {
            $newdata = (!empty($request->id)) ? LevelPengguna::find($request->id) : new LevelPengguna;

            $newdata->name = $request->nama_level_pengguna;
            $newdata->singkatan = $request->singkatan;
            $newdata->save();
            DB::commit();

            $return = ['status'=>'success', 'code'=>'200', 'message'=>'Data Berhasil Disimpan !!'];
			return response()->json($return);
        } catch(\Exception $e) {
            DB::rollback();
            $return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
            return response()->json($return);
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $do_delete = LevelPengguna::find($request->id);
        if(!empty($do_delete)){
            $do_delete->delete();
            return ['status' => 'success','message' => 'Anda Berhasil Menghapus Data','title' => 'Success'];
        }else{
            return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
        }
    }
}
