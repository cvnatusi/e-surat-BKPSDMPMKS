<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\MasterASN;
use Illuminate\Http\Request;

class ASNController extends Controller
{
    public function getASN() {
        $data = MasterASN::get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }

    public function getJabatan() {
        $data = Jabatan::get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }
}
