<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DenganHarap;
use App\Models\MasterASN;
use App\Models\SuratDisposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use DB, Auth, Storage, PDF;
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
    $data['penerima'] = MasterASN::whereIn('id_mst_asn', [1,5,6])->get();
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
            $newdata->catatan_disposisi_sekretaris = $request->catatan_disposisi_sekretaris ;
        }
        $newdata->dengan_hormat_harap = implode(",",$request->dengan_harap);
        $newdata->save();
        $data['data'] = SuratDisposisi::with(['suratMasukId'])->find($newdata->id_surat_disposisi);
        $data['asn'] = MasterASN::with('jabatan_asn')->where('id_mst_asn',$data['data']->pemberi_disposisi_id)->first();
        $data['penerima'] = MasterASN::where('id_mst_asn',$data['data']->pemberi_disposisi_id)->first();
        $data['dengan_harap'] = DenganHarap::get();
        $changeSDisposisi = str_replace("/", "-", strtolower($data['data']->suratMasukId->nomor_surat_masuk));
        $file_name_asli_surat_disposisi = str_replace(" ", "-", strtolower($data['asn']->nama_asn).'-'.$changeSDisposisi.'-'.date('Ymd His').'-surat_disposisi.pdf');
        $pdf = PDF::loadView('cetakan.surat_disposisi', $data)
            ->setPaper([0, 0, 609.4488, 935.433], 'portrait');
        Storage::put('public/surat-disposisi/'.$file_name_asli_surat_disposisi, $pdf->output());

        // $data['qr'] = base64_encode(QrCode::format('png')->size(200)->merge('/public/assets/images/logo-icon.png', .4)->errorCorrection('H')->generate($ttd));

        $update = SuratDisposisi::find($newdata->id_surat_disposisi);
        $update->file_disposisi = $file_name_asli_surat_disposisi;
        $update->save();
      DB::commit();
      return response()->json([
        'status' => 'success',
        'code' => 200,
        'message' => 'Berhasil menyimpan data',
        'data' => $newdata
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
