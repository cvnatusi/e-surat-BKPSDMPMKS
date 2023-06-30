<?php

namespace App\Http\Controllers\API;

use App\Models\TAPMAN\Pegawai;
use App\Models\TAPMAN\UsersAndroid;
use App\Models\TAPMAN\Absensi;
use App\Models\TAPMAN\Pekerjaan;
use App\Models\EKINERJA\PegawaiEKINERJA;
use App\Models\EKINERJA\KegiatanJabatan;
use App\Models\EKINERJA\DetailKegiatanJabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Validator,Hash,DB;

class PekerjaanController extends Controller
{
  public function getKegiatanJabatan(Request $request)
  {
    try {
      $cekPegawai = PegawaiEKINERJA::where('nip',$request->nip)->first();
      if (!empty($cekPegawai)) {
        $cekKegiatan = KegiatanJabatan::where('kodejab',$cekPegawai->jabatan)->first();
        if (!empty($cekKegiatan)) {
            $cekDetailKegiatan = DetailKegiatanJabatan::where('id_opmt_kegiatan_jabatan',$cekKegiatan->id_opmt_kegiatan_jabatan)->get();
            if (count($cekDetailKegiatan) > 0) {
              return Controller::custom_response(200, "success", 'Ok', $cekDetailKegiatan);
            }else {
              return Controller::custom_response(201, "error", 'Detail Kegiatan Jabatan Tidak Ditemukan di Database EKINERJA', '');
            }
        }else {
          return Controller::custom_response(201, "error", 'Kegiatan Jabatan Tidak Ditemukan di Database EKINERJA', '');
        }
      }else {
        return Controller::custom_response(201, "error", 'Pegawai Tidak Ditemukan di Database EKINERJA', '');
      }
    } catch (\Throwable $e) {
      return Controller::custom_response(500, "error", $e->getMessage(), '');
    }
  }
  public function list_pekerjaan(Request $request)
  {
    try {
      $data = Pekerjaan::where('nip', $request->nip)->whereDate('created_at',$request->tanggal)->get();
      if (count($data) > 0) {
        return Controller::custom_response(200, "success", 'Ok!', $data);
      }else {
        return Controller::custom_response(201, "error", 'Belum Ada Pekerjaan!', '');
      }
    } catch (\Throwable $e) {
      return Controller::custom_response(500, "error", $e->getMessage(), '');
    }
  }
  public function create_pekerjaan(Request $request)
  {
    DB::beginTransaction();
    try {

      $cekAbsen = Absensi::find($request->absensi_id);
      if (!empty($cekAbsen)) {
        $new_pekerjaan = New Pekerjaan;
        $new_pekerjaan->nip = $request->nip;
        $new_pekerjaan->absensi_id = $request->absensi_id;
        $new_pekerjaan->nama_pekerjaan = $request->nama_pekerjaan;
        $new_pekerjaan->detail_pekerjaan = $request->detail_pekerjaan;
        if (!empty($request->foto_pekerjaan_1)) {
  				$file = $request->file('foto_pekerjaan_1');
  				if($request->hasFile('foto_pekerjaan_1')){
  					$filename = $file->getClientOriginalName();
  					$ext_foto = $file->getClientOriginalExtension();
  					$filename = $new_pekerjaan->nama_pekerjaan."_1-".date('YmdHis').".".$ext_foto;
  					$file->storeAs('public/absensi/pekerjaan/',$filename);
  					$new_pekerjaan->foto_pekerjaan_1 = $filename;
  				}
  			}
        if (!empty($request->foto_pekerjaan_2)) {
  				$file = $request->file('foto_pekerjaan_2');
  				if($request->hasFile('foto_pekerjaan_2')){
  					$filename = $file->getClientOriginalName();
  					$ext_foto = $file->getClientOriginalExtension();
  					$filename = $new_pekerjaan->nama_pekerjaan."_2-".date('YmdHis').".".$ext_foto;
  					$file->storeAs('public/absensi/pekerjaan/',$filename);
  					$new_pekerjaan->foto_pekerjaan_2 = $filename;
  				}
  			}
        if (!empty($request->foto_pekerjaan_3)) {
  				$file = $request->file('foto_pekerjaan_3');
  				if($request->hasFile('foto_pekerjaan_3')){
  					$filename = $file->getClientOriginalName();
  					$ext_foto = $file->getClientOriginalExtension();
  					$filename = $new_pekerjaan->nama_pekerjaan."_3-".date('YmdHis').".".$ext_foto;
  					$file->storeAs('public/absensi/pekerjaan/',$filename);
  					$new_pekerjaan->foto_pekerjaan_3 = $filename;
  				}
  			}
        $new_pekerjaan->save();
        if ($new_pekerjaan) {
          DB::commit();
          return Controller::custom_response(200, "success", 'Berhasil Menambahkan Pekerjaan!', $new_pekerjaan);
        }else {
          DB::rollback();
          return Controller::custom_response(201, "error", 'Gagal Menambahkan Pekerjaan!', '');
        }
      }else {
        return Controller::custom_response(201, "error", 'Anda Belum Melakukan Absensi!', '');
      }
    } catch(\Exception $e){
			DB::rollback();
			throw($e);
      return Controller::custom_response(500, "error", $e->getMessage(), '');
    }
  }
}
