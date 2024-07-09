<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthSuratController extends Controller
{
  public function login(Request $request) {
    $validator = Validator::make($request->all(), [
        'nip' => 'required',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
      return Controller::custom_response(422, "validation_error", 'Input tidak valid', $validator->errors());
    }

    if(Auth::attempt(['email' => $request->nip, 'password' => $request->password])) {
        $auth = Users::where('email', $request['nip'])->first();
        $data['token'] = $auth->createToken('auth_token')->plainTextToken;
        $data['name'] = $auth->name;
        $data['nip'] = $auth->email;
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data
        ]);
    } else {
      return response()->json([
      'success' => false,
      'code' => 401,
      'message' => 'Username atau Password salah'
    ]);
    }
  }
}
