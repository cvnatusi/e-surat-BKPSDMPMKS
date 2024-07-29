<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\MasterASN;
use Illuminate\Http\Request;

class MasterASNController extends Controller
{
    public function getASN() {
        $data = MasterASN::with('jabatan_asn')->orderBy('id_mst_asn','desc')->get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }
}
