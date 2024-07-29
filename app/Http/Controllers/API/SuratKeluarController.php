<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
      $data = SuratKeluar::with(['sifat','jenis'])
            ->orderBy('tanggal_surat','DESC')->get();

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
}
