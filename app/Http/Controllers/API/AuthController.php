<?php

namespace App\Http\Controllers\API;

use App\Models\TAPMAN\Pegawai;
use App\Models\TAPMAN\UsersAndroid;
use App\Models\EKINERJA\PegawaiEKINERJA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Validator,Hash;

class AuthController extends Controller
{
  public function getPegawai(Request $request)
  {
    try {
      if (!empty($request->userid) && !empty($request->birthdate)) {
        // $pegawai = Pegawai::leftjoin('departments','departments.deptid','userinfo.deptid')
        //                   ->where('userid',$request->userid)
        //                   ->where('birthdate',$request->birthdate)->first();
        $pegawai = Pegawai::with(['dept.finger'])
                          ->where('userid',$request->userid)
                          ->where('birthdate',$request->birthdate)->first();
        if (!empty($pegawai)) {
          if (empty($pegawai->dept)) {
            return Controller::custom_response(201, "error", 'Department Pegawai Tidak Ditemukan, Silahkan Update Data Terlebih Dahulu', '');
          }
          $pegawaiEKINERJA = PegawaiEKINERJA::where('nip',$request->userid)->first();
          if (!empty($pegawaiEKINERJA)) {
            $user = UsersAndroid::where('email',$request->userid)->first();
            if (empty($user)) {
              $newuser = New UsersAndroid;
              $newuser->name = $pegawai->name;
              $newuser->email = $request->userid;
              $newuser->password = Hash::make($request->userid);
              $newuser->save();
              $user = $newuser;
              // $token = $user->createToken('auth_token')->plainTextToken;
            }else {
              $user = $user;
            }
            $data = [
              'data' => $pegawai,
              'user' => $user,
              // 'access_token' => $token ?? '',
              // 'token_type' => 'Bearer'
            ];
            return Controller::custom_response(200, "success", 'Ok', $data);
          }else {
            return Controller::custom_response(201, "error", 'Pegawai Tidak Ditemukan di Database EKINERJA', '');
          }
        }else {
          return Controller::custom_response(201, "error", 'NIP / Tanggal Lahir Tidak Ditemukan', '');
        }
      }else {
        return Controller::custom_response(201, "error", 'Mohon periksa kembali NIK, Tanggal Lahir, dan NIP anda', '');
      }
    } catch (\Throwable $e) {
      return Controller::custom_response(500, "error", $e->getMessage(), '');
    }
  }
  public function login(Request $request)
  {

    $user = UsersAndroid::where('email', $request['nip'])->first();
    if (!empty($user)) {
      $pegawai = Pegawai::where('userid',$request->nip)->first();
      if (!empty($pegawai)) {
        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
          'pegawai'=>$pegawai,
          'access_token' => $token,
          'token_type' => 'Bearer'
        ];
        return Controller::custom_response(200, "success", 'Ok', $data);
      }else {
        return Controller::custom_response(201, "error", 'Pegawai Tidak Ditemukan', '');
      }
    }else {
      return response()->json(['message' => 'Unauthorized'], 401);
    }
  }
}
