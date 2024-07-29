<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\LevelPengguna;
use Illuminate\Http\Request;

class LevelPenggunaController extends Controller
{
    public function index() {
        $data = LevelPengguna::orderBy('id_level_user','desc')->get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }
}
