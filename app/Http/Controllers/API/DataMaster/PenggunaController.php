<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index() {
        $data = Users::get();
        return response()->json(['status' => 'success', 'code' => 200, 'data' => $data]);
    }
}
