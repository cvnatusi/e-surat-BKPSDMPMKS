<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DenganHarap;
use App\Models\MasterASN;
use App\Models\SuratDisposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use DB, Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

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
        $newdata = (!empty($request->id)) ? SuratDisposisi::find($request->id) : new SuratDisposisi;
        if (!empty($request->id)) {
            $newdata->no_agenda_disposisi = $newdata->no_agenda_disposisi;
        }else {
            $suratMasuk = SuratMasuk::findOrFail($request->surat_masuk_id);
            if (Auth::user()->level_user == '2') {
                $suratMasuk->status_disposisi = 'Disposisi Kaban';
                $suratMasuk->save();
            }
            $newdata->no_agenda_disposisi = $suratMasuk->no_agenda;
            $cekDisposisi = SuratDisposisi::where('surat_masuk_id',$request->surat_masuk_id)->first();
            if (!empty($cekDisposisi)) {
                $return = ['status'=>'error', 'code'=>'201', 'message'=>'Surat Disposisi Sudah Dibuat!!','errMsg'=>'Duplikasi Data'];
                return response()->json($return);
            }
        }
        if (empty($request->id)) {
            $newdata->surat_masuk_id = $request->surat_masuk_id;
            $newdata->pemberi_disposisi_id = $request->pemberi_disposisi_id;
            $newdata->penerima_disposisi_id = $request->penerima_disposisi_id;
            $newdata->catatan_disposisi = $request->catatan_disposisi;
        }else {
            $newdata->pemberi_disposisi2_id = $request->pemberi_disposisi_id;
            $newdata->penerima_disposisi2_id = $request->penerima_disposisi_id;
            $newdata->catatan_disposisi_sekretaris = $request->catatan_disposisi_sekretaris;
        }
        $newdata->dengan_hormat_harap = implode(",",$request->dengan_hormat_harap);
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

  public function diteruskanKepada(Request $request) {
    // $data['data'] = SuratDisposisi::with(['suratMasukId'])->find(15);
    $data['penerima'] = MasterASN::whereIn('id_mst_asn', [1,5,6])->get();
    // return $data['penerima'];
    if(!empty($data)) {
      return response()->json(['status' => 'success', 'code' => 200, 'data' => $data]);
    } else {
      return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
    }
  }

  public function denganHarap() {
    $data = DenganHarap::get();
    if(!empty($data)) {
      return response()->json(['status' => 'success', 'code' => 200, 'data' => $data]);
    } else {
      return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
    }
  }

  public function storeSuratDisposisi(Request $request) {
    try {
      DB::beginTransaction();

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
