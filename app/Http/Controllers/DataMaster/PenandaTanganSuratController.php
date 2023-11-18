<?php

namespace App\Http\Controllers\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\MasterASN;
use App\Models\PenandaTanganSurat;
use DataTables,Validator,DB,Hash,Auth,Storage;

class PenandaTanganSuratController extends Controller
{
    private $title = "Penanda Tangan Surat";
	private $menuActive = "data-master";
	private $submnActive = "penanda-tangan-surat";

	public function index(Request $request)
	{
		if ($request->ajax()) {
            $data = PenandaTanganSurat::with('pengguna')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('nama', function($row){
                // 	$text = Users::where('id', $row->pengguna_id)->first()->name;
                //     return $text;
                // })
                ->addColumn('level', function($row){
                	if ($row->level_pengguna=='0') {
                		$text = 'SEKRETARIS DAERAH (SEKDA)';
                	} else {
                		$text = 'KABAN';
                	}
                    return $text;
                })
                ->addColumn('action', function($row){
                   $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="editData('.$row->id_penanda_tangan_surat.')"><i class="bx bx-pencil me-0"></i></a>';
                   $btn = $btn.' <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteData('.$row->id_penanda_tangan_surat.')"><i class="bx bx-trash me-0"></i></a>';
                   return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
        $this->data['user'] = Users::whereIn('level_user', ['0', '2'])->get();
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}

	public function edit(Request $request){
        $penandaTangan = PenandaTanganSurat::leftJoin('users as u', 'u.id', 'penanda_tangan_surat.pengguna_id')
            ->where('id_penanda_tangan_surat', $request->id)->first();
        return response()->json($penandaTangan);
	}

    public function store(Request $request)
    {
        // return $request->all();
		// return $request->id;
        try {
    		if($request->id) {
                $pts = PenandaTanganSurat::find($request->id);
            } else{
                $pts = new PenandaTanganSurat;
            }
	    	$pts->level_pengguna = $request->level_pengguna;
	    	$pts->pengguna_id  = $request->user_id;
            if (!empty($request->tte)) {
					// $getUser = Users::find($request->id); // benar
					// return	$getUser = Users::where('level_user', 1)->get();
				if (!empty($pts->tte)) {
                    Storage::delete($pts->tte);
                    // unlink(public_path('tte-penanda-tangan/'.$pts->tte));
				}
				$file = $request->file('tte');
				if($request->hasFile('tte')){
					$filename = $file->getClientOriginalName();
					$ext_foto = $file->getClientOriginalExtension();
					$filename = "-".date('YmdHis').".".$ext_foto;
					$file->storeAs('public/tte-penanda-tangan/',$filename);
					$pts->tte = $filename;
				}
			}
	    	$pts->save();

	    	if ($pts) {
	    		return ['code'=>'200', 'status'=>'success', 'message'=>'Berhasil'];
	    	} else {
	    		return ['code'=>'201', 'status'=>'error', 'message'=>'Error'];
	    	}
    	} catch (Exception $e) {
    		$return = ['status'=>'error', 'code'=>'500', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
    	}
    }

    public function destroy(Request $request)
    {
        try {
        	$do_delete = PenandaTanganSurat::find($request->id_penanda_tangan_surat);
			if(!empty($do_delete)){
				$do_delete->delete();
				return ['status' => 'success','message' => 'Data Berhasil Menghapus Data','title' => 'Success'];
			}else{
				return ['status'=>'error','message' => 'Data Gagal Dihapus','title' => 'Whoops'];
			}
		} catch (Exception $e) {
    		$return = ['status'=>'error', 'code'=>'500', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
    	}
    }

	
	public function getPengguna(Request $request)
	{
		// return $request->all();
		return $data = MasterASN::where('jabatan',$request->level)->get();
	}
}
