<?php

namespace App\Http\Controllers;
use App\Models\MasterASN;
use App\Models\Bidang;
use Illuminate\Http\Request;
use DataTables,Validator,DB,Hash,Auth;

class BidangController extends Controller
{
    private $title = "Data Bidang BKPSDM";
	private $menuActive = "bidang";
	private $submnActive = "";

    public function index(Request $request)
    {
		if ($request->ajax()) {
            $data = Bidang::whereNull('deleted_at')->orderBy('id_bidang', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('namaAsn', function($row){
                	$text = MasterASN::where('id_mst_asn', $row->mst_asn_id)->first()->nama_asn;
                    return $text;
                })
                ->addColumn('check', function($row){
					$btn = '<input class="form-check-input" id="check_('.$row->id_bidang.')" name="check[]" value="'.$row->id_bidang.'" type="checkbox"></a>';
					return $btn;
				})
                ->addColumn('action', function($row){
                   $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="editData('.$row->id_bidang.')"><i class="bx bx-pencil me-0"></i></a>';
                   $btn = $btn.' <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteData('.$row->id_bidang.')"><i class="bx bx-trash me-0"></i></a>';
                   return $btn;
                })
                ->rawColumns(['action','check'])
                ->make(true);
        }
        $this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		$this->data['asn'] = MasterASN::where('status_aktif', 'Y')->get();
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
    }
	public function edit(Request $request){
		return $request->get('id');
	}
    public function store(Request $request)
    {
    	try {
    		if ($request->id) {
	    		$bidang = Bidang::where('id_bidang', $request->id)->first();
	    	} else {
	    		$bidang = new Bidang;
	    	}
	    	$bidang->nama_bidang = $request->nama_bidang;
	    	$bidang->mst_asn_id  = $request->nama_kepala_bidang;
	    	$bidang->save();

	    	if ($bidang) {
	    		return ['code'=>'200', 'status'=>'success', 'message'=>'Berhasil'];
	    	} else {
	    		return ['code'=>'201', 'status'=>'error', 'message'=>'Error'];
	    	}
    	} catch (Exception $e) {
    		$return = ['status'=>'error', 'code'=>'500', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
				return response()->json($return);
    	}
    	
    }
}
