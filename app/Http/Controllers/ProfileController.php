<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Users;
use Validator, DB, Hash;

class ProfileController extends Controller
{
    private $title = "Profile";
	private $menuActive = "Profile";
	private $submnActive = "";

    public function index()
    {
        $this->data['title'] = $this->title;
		$this->data['menuActive'] = $this->menuActive;
		$this->data['submnActive'] = $this->submnActive;
		$this->data['smallTitle'] = "";

		// return view($this->menuActive.'.'.$this->submnActive.'main')->with('data',$this->data);
		return view('profile.main')->with('data',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        return $request->all();
        $validator = Validator::make(
			$request->all(),
			[
				'foto'=>'mimes:png,jpg',
			],
			[
				'foto.mimes' => ':foto Wajib diisi',
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

			$newdata = (!empty($request->id)) ? Users::find($request->id) : new Users;

            if(!empty($request->password)){
                $newdata->password = Hash::make($request->password);
            }
            $file = $request->file('foto');
			if (!empty($file)) {
                $img = $newdata->foto;
                $checkfile= public_path()."/foto/".$img;
                if($img && file_exists($checkfile)){
                    unlink(public_path('foto/'.$img));
                }

                $file_name = $file->getClientOriginalName();
                $request->foto->move(public_path('foto/'), $file_name);
                $newdata->foto = $file_name;
			}

			DB::commit();
			$newdata->save();
            // return 'berhasil';
            return redirect()->back()->with('alert', 'Berhasil !');

			$return = ['status'=>'success', 'code'=>'200', 'message'=>'User Berhasil di Buat!!<br> untuk LOGIN gunakan NIP'];
			return response()->json($return);
		}catch(\Exception $e){
			DB::rollback();
			throw($e);
			$return = ['status'=>'error', 'code'=>'201', 'message'=>'Terjadi Kesalahan di Sistem, Silahkan Hubungi Tim IT Anda!!','errMsg'=>$e];
			return response()->json($return);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
