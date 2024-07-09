<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuratDisposisi;
use Illuminate\Http\Request;
use DB;

class SuratDisposisiController extends Controller
{
  public function indexSuratDisposisi() {
    $data = SuratDisposisi::orderByDesc('id_surat_disposisi')->get();

    if($data) {
      $return = [
        'status' => 'success',
        'code' => 200,
        'message' => 'Data Berhasil Ditemukan !',
        'data' => $data,
      ];
    } else {
      $return = [
        'status' => 'error',
        'code' => 500,
        'message' => 'Data Gagal Ditemukan !',
        'data' => '',
      ];
    }
    return response()->json($return);
  }

  public function disposisiSurat(Request $request) {
    DB::beginTransaction();
    try {

      DB::commit();
      return response()->json([
        'status' => 'success',
        'code' => 200,
        'message' => 'Berhasil menyimpan data',
        'data' => ''
      ]);
    } catch(\Exception $e) {
      throw($e);
      DB::rollback();
      return response()->json([
        'status' => 'error',
        'code' => 500,
        'message' => $e->getMessage()
      ]);
    }
  }
}
