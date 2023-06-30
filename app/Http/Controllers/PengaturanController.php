<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratMasuk;
use App\Models\Instansi;
use App\Models\TandaTanganElektronik;

use DataTables,Validator,DB,Hash,Auth,File,Storage;

class PengaturanController extends Controller
{
    private $title = "Pengaturan";
	private $menuActive = "pengaturan";
	private $submnActive = "";

	public function index(Request $request)
	{
		$this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";
		$this->data['tanda_tangan'] = TandaTanganElektronik::get();	
			
		return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
	}
	
	public function store(Request $request)
    {
        //  return $request->all();
		$validator = Validator::make($request->all(), [
			'id' => 'required',
			'pengguna' => 'required',
			'kode_surat' => 'required',
			'nama_badan' => 'required',
			'nama_kepala_badan' => 'required',
			'jabatan' => 'required',
			'nip' => 'required',
			'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		  ]);
		  if ($validator->passes()) {
			$input = $request->except('_token');
			$input['gambar'] = time().'.'.$request->gambar->getClientOriginalExtension();
			$request->gambar->move(public_path('gambar'), $input['gambar']);


			if(!is_null($input['id'])){
                DB::table('tr_tandatangan_elektronik')->where('id', $input['id'])->update($input);
				
            }else{  
                TandaTanganElektronik::create($input);
            }


			$this->data['title'] = $this->title;
			$this->data['menuActive'] = $this->menuActive;
			$this->data['submnActive'] = $this->submnActive;
			$this->data['smallTitle'] = "";
			return view($this->menuActive.'.'.$this->submnActive.'.'.'main')->with('data',$this->data);
			
		  }
	
		  return response()->json(['error'=>$validator->errors()->all()]);
	}
 
    
}


