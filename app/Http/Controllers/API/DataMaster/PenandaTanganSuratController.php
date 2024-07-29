<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\PenandaTanganSurat;
use Illuminate\Http\Request;

class PenandaTanganSuratController extends Controller
{
    public function index() {
        $data = PenandaTanganSurat::with('pengguna')->get();
        if(!empty($data)) {
            return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
        }
    }
}
