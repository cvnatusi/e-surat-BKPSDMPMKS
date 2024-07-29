<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DenganHarap;
use App\Models\Instansi;
use App\Models\JenisSurat;
use App\Models\SifatSurat;
use App\Models\SuratDisposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class SuratMasukController extends Controller
{
  public function indexSuratMasuk() {
    $data = SuratMasuk::with('pengirim', 'sifat')->orderByDesc('id_surat_masuk')->get();

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
        'data' => ''
      ];
    }
    return response()->json($return);
  }

  public function getSifatSurat(Request $request) {
    $data = SifatSurat::get();
    if(!empty($data)) {
        return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
    }
  }

  public function getJenisSurat(Request $request) {
    $data = JenisSurat::get();
    if(!empty($data)) {
        return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
    }
  }

  public function getPengirimSurat() {
    $data = Instansi::get();
    if(!empty($data)) {
        return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
    }
  }

  public function createSuratMasuk(Request $request) {
    DB::beginTransaction();
    try {
      $findAgendaTerakhir = SuratMasuk::whereYear('tanggal_terima_surat', '=', date('Y'))->whereNull('deleted_at')->orderBy('id_surat_masuk','DESC')->count();
      if ($findAgendaTerakhir == 0) {
          $findAgendaTerakhir = 0;
      }else {
          $findAgendaTerakhir = $findAgendaTerakhir+1;
      }

      $surat_masuk = new SuratMasuk;
      $surat_masuk->no_agenda = $findAgendaTerakhir;
      $surat_masuk->nomor_surat_masuk = $request->no_surat;
      $surat_masuk->pengirim_surat_id = $request->pengirim_surat;
      $surat_masuk->sifat_surat_id = $request->sifat_surat;
      $surat_masuk->jenis_surat_id = $request->jenis_surat;
      $surat_masuk->tanggal_surat = $request->tanggal_surat;
      $surat_masuk->tanggal_terima_surat = $request->tanggal_terima_surat;
      $surat_masuk->perihal_surat = $request->perihal_surat;
      $surat_masuk->isi_ringkas_surat = $request->isi_ringkas_surat;
      if (!empty($request->file_scan)) {
        if (!empty($surat_masuk->file_scan)) {
          if (is_file($surat_masuk->file_scan)) {
            Storage::delete($surat_masuk->file_scan);
            unlink(storage_path('public/surat-masuk/'.$surat_masuk->file_scan));
            // File::delete($surat_masuk->file_scan);
          }
        }
        $file = $request->file('file_scan');
        if($request->hasFile('file_scan')){
          $filename = $file->getClientOriginalName();
          $ext_foto = $file->getClientOriginalExtension();
          $filename = $surat_masuk->no_agenda."-".date('YmdHis').".".$ext_foto;
          $file->storeAs('public/surat-masuk/',$filename);
          $surat_masuk->file_scan = $filename;
        }
      }
      if (!empty($request->sampai_bkpsdm)) {
        $surat_masuk->sampai_bkpsdm = $request->sampai_bkpsdm;
      }else {
        $surat_masuk->sampai_bkpsdm = 'N';
      }
      // $surat_masuk->true;
      $surat_masuk->save();

      DB::commit();
      return response()->json([
        'status' => 'success',
        'code' => 200,
        'message' => 'Berhasil menyimpan data',
        'data' => $surat_masuk
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

  public function getDetailSuratMasuk($id) {
    $data = SuratMasuk::find($id);
    if(!empty($data)) {
        return response()->json(['status' => 'success', 'message' => 'data ditemukan', 'code' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 'error', 'code' => 400, 'message' => 'data tidak ditemukan !']);
    }
  }

  public function downloadFileSuratMasuk($id) {
    try {
        // $data['data'] = SuratDisposisi::with(['suratMasukId'])->find($id);
      $data['surat'] = SuratMasuk::with('pengirim')->whereIn('id_surat_masuk',[$id])->get();
      $data['dengan_harap'] = DenganHarap::get();
      $dompdf = PDF::loadView('cetakan.surat_disposisi_kosongan', $data)->setPaper('a4', 'portrait');
      // Render the HTML as PDF
      $dompdf->render();
      return  $dompdf->stream('my.pdf',array('Attachment'=>0));
    } catch(\Exception $e) {
      throw($e);
      return response()->json(['status' => 'error', 'code' => 500, 'message' => $e->getMessage()]);
    }
  }

  public function getRangeSuratMasuk(Request $request) {
    // return $request;
    $paramTglAwal = $request->tgl_awal;
	$paramTglAkhir = $request->tgl_akhir;
    // if($request->pengirim === 'all') {
    //     $pengirim = SuratMasuk::pluck('pengirim_surat_id');
    // } else {
    //     $pengirim = $request->pengirim;
    // }

    // return $paramTglAwal.' '. $paramTglAkhir;
    $data = SuratMasuk::with(['sifat', 'jenis', 'pengirim'])
        ->whereBetween('tanggal_surat', [$paramTglAwal, $paramTglAkhir])
        ->when($request->pengirim != 'all',function($q) use ($request){
            $q->where('pengirim_surat_id', $request->pengirim);
        })
        ->orderBy('tanggal_surat', 'DESC')->get();
        // return $data;
    // if (Auth::user()->level_user != 1) {
    //     $query->whereNull('status_disposisi');
    // }
    // $data = $query->get();

    if(!empty($data)) {
      return response()->json(['status' => 'success', 'code' => 200, 'data' => $data]);
    } else {
      return response()->json(['status' => 'error', 'code' => 500, 'data' => '']);
    }
  }
}
