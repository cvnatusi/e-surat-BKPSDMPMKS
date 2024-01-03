<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
// use App\Http\Libraries\Activitys;
use Validator;

class AuthController extends Controller
{
    // protected $redirectTo = '/home';
    protected $redirectTo = '/login';

    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }

    public function home(){
          return view('auth.home');
  
      }
    public function login(Request $request){
        $this->data['title'] = 'Login';
        $this->data['next_url'] = empty($request->next_url) ? '' : $request->next_url;
        return view('auth.login')->with('data', $this->data);

    }
    public function doLogin(Request $request){

      // return $request->all();

      $rules = [
        'username' => ['required'],
        'password' => ['required'],
        // 'captcha' => ['required','captcha'],
      ];
      $messages = [
        'required' => 'kolom harus diisi',
        // 'captcha' => 'Captcha tidak sesuai'
      ];
      $valid = Validator::make($request->all(), $rules, $messages);
      if ($valid->fails()) {
        $pesan = "";
        foreach (json_decode($valid->messages()) as $k => $v) {
          $pesan .= $k.', ';
        }
        $pesan = rtrim($pesan, ", ");
        $pesan .= " harus diisi.";
        return ['status' => 'error', 'code' => 400, 'message' => $pesan];
      }

        $cekUsername = Users::where('email',$request->username)->first();
        if (empty($cekUsername)) {
          $cekEmail = Users::where('email',$request->username)->first();
          if (empty($cekEmail)) {
            $message = 'Akun Tidak Ditemukan, Silahkan Cek Kembali Email / Username / Password Anda !!';
            if ($request->try_login >= $request->max_failed_login) {
              $message  = "Anda Gagal Masuk Sebanyak $request->max_failed_login kali.<br/>Tombol Signin akan buka dalam <b>$request->time_lock</b> detik.";
            }
            $return = [
              'status'=>'error',
              'message'=> $message,
            ];

            return response()->json($return);
          }else{
            $data['email'] = strip_tags($request->username);
            $userColumn = 'email';
          }
        }else{
          $data['email'] = strip_tags($request->username);
          $userColumn = 'email';
        }
        $data['password'] = strip_tags($request->password);
        $cek = Auth::attempt($data);

        if($cek){

          $return = [
            'status'=>'success',
            'message'=>'Login Berhasil',
            'role'=>$cekUsername->level_user
          ];
          // $requestActivity = [
          //   'action_type'   => 'Login',
          //   'message'       => 'User '.Auth::user()->name.' Melakukan Login ke Sistem',
          // ];
          //   $saveActivity = Activitys::add($requestActivity);
        }else{
            $return = [
                'status'=>'error',
                'message'=>'Akun Tidak Ditemukan, Silahkan Cek Kembali Email / Username / Password Anda !!'
              ];
        }
        return response()->json($return);
    }
    public function logout(Request $request)
    {
        $logout = Auth::logout();
  	    return Redirect::route('dashboard')->with('title', 'Logout !')->with('message', 'Anda Berhasil Keluar.')->with('type', 'success');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
