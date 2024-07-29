<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function index() {
        $data = Bidang::whereNull('deleted_at')->orderBy('id_bidang', 'DESC')->get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }
}
