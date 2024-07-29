<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index() {
        $data = Jabatan::orderBy('id_mst_jabatan','desc')->get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }
}
