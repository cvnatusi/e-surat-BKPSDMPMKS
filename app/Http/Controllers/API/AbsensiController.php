<?php

namespace App\Http\Controllers\API;

use App\Models\TAPMAN\Pegawai;
use App\Models\TAPMAN\UsersAndroid;
use App\Models\TAPMAN\Absensi;
use App\Models\TAPMAN\Roster;
use App\Models\TAPMAN\MasterShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Validator,Hash,DB;

class ObjectEmpty{};

class AbsensiController extends Controller
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
  public function index(Request $request)
  {
    try {
      if (!empty($request->date_shift)) {
        $date = date('Y-m-d',strtotime($request->date_shift));
      }else {
        $date = date('Y-m-d');
      }
      $cekAbsen = Absensi::where('userid', $request->nip)->where('date_shift', $request->date_shift)->first();
      if (!empty($cekAbsen)) {
        return Controller::custom_response(200, "success", 'Ok!', $cekAbsen);
      }else {
        return Controller::custom_response(201, "error", 'Anda Belum Melakukan Absensi!', New ObjectEmpty());
      }
    } catch (\Throwable $e) {
      return Controller::custom_response(500, "error", $e->getMessage(), []);
    }
  }

  // public function create_absen(Request $request)
  // {
  //   try {
  //     DB::beginTransaction();
  //     $cekAbsen = Absensi::where('userid', $request->nip)
  //                         ->where('date_shift', $request->date_shift)
  //                         ->first();
  //     if (empty($cekAbsen)) {
  //       $insert_absen = New Absensi;
  //       $insert_absen->userid = $request->nip;
  //       $insert_absen->date_shift = $request->date_shift;
  //       $insert_absen->shift_in = $request->jam_mulai_shift;
  //       $insert_absen->shift_out = $request->jam_akhir_shift;
  //       $insert_absen->tanggal_masuk = $request->tanggal_masuk;
  //       $insert_absen->jam_masuk = $request->jam_masuk;
  //       $insert_absen->latitude_masuk = $request->latitude_masuk;
  //       $insert_absen->longitude_masuk = $request->longitude_masuk;
  //       // $insert_absen->absensi_id_tapman = $request->absensi_id_tapman; // ganti nanti kalau sudah konek sama tapman
  //       $insert_absen->save();
  //       DB::commit();
  //       return Controller::custom_response(200, "success", 'Berhasil Absen Masuk!', $insert_absen);
  //     }else {
  //       if (!empty($cekAbsen->tanggal_keluar)) {
  //         return Controller::custom_response(201, "error", 'Anda Sudah Melakukan Absensi!', '');
  //       }else {
  //         if (empty($request->tanggal_keluar)) {
  //           return Controller::custom_response(201, "error", 'Silahkan Cek Inputan Anda!', '');
  //         }
  //         $update_absen = $cekAbsen;
  //         $update_absen->nip = $request->nip;
  //         $update_absen->date_shift = $request->date_shift;
  //         $update_absen->tanggal_keluar = $request->tanggal_keluar;
  //         $update_absen->jam_keluar = $request->jam_keluar ?? date('H:i:s');
  //         $update_absen->latitude_keluar = $request->latitude_keluar;
  //         $update_absen->longitude_keluar = $request->longitude_keluar;
  //         $update_absen->save();
  //         if ($update_absen) {
  //           DB::commit();
  //           return Controller::custom_response(200, "success", 'Berhasil Absen Keluar!', $update_absen);
  //         }
  //       }
  //     }
  //   } catch (\Throwable $e) {
  //     DB::rollback();
  //     return Controller::custom_response(500, "error", $e->getMessage(), '');
  //   }
  // }
  public function create_absen(Request $request)
  {
    DB::beginTransaction();
    try {
      $cekPegawai = Pegawai::where('userid', $request->nip)->first();
      $cekRoster = Roster::where('userid', $request->nip)->where('rosterdate',date('Y-m-d'))->first();
      if (!empty($cekRoster)) {
        $cekShift = MasterShift::where('code_shift',$cekRoster->absence)->first();
        $cekAbsen = Absensi::where('userid', $cekPegawai->userid)->whereDate('date_shift', $cekRoster->rosterdate)->first();
        if (empty($cekAbsen)) {
          if ($cekRoster <= $request->check_in) {
            return Controller::custom_response(201, "error", 'Jam Check In Kurang Dari Jam Shift', New ObjectEmpty());
          }
          $insert_absen = New Absensi;
          $insert_absen->userid = $request->nip;
          $insert_absen->date_shift = $cekRoster->rosterdate;
          $insert_absen->shift_in = $cekShift->start_in;
          $insert_absen->shift_out = $cekShift->start_out;
          $insert_absen->date_in = $request->date_in;
          $insert_absen->check_in = $request->check_in;
          $insert_absen->latitude_masuk = $request->latitude_masuk;
          $insert_absen->longitude_masuk = $request->longitude_masuk;
          $insert_absen->save();
          DB::commit();
          return Controller::custom_response(200, "success", 'Berhasil Absen Masuk!', $insert_absen);
        }else {
          $update_absen = $cekAbsen;
          $update_absen->date_out = $request->date_out;
          $update_absen->check_out = $request->check_out ?? date('H:i:s');
          $update_absen->latitude_keluar = $request->latitude_keluar;
          $update_absen->longitude_keluar = $request->longitude_keluar;
          $update_absen->save();
          if ($update_absen) {
            DB::commit();
            return Controller::custom_response(200, "success", 'Berhasil Absen Keluar!', $update_absen);
          }
        }
      }else {
        return Controller::custom_response(201, "error", 'Jadwal Tidak Tersedia', '');
      }
      $cekAbsen = Absensi::where('userid', $request->nip)->first();
    } catch (\Throwable $e) {
        DB::rollback();
        return Controller::custom_response(500, "error", $e->getMessage(), '');
      }
  }

  public function list_absen(Request $request)
  {
    try {
      if (!empty($request->date)) {
        $month = date('m',strtotime($request->date));
        $year = date('Y',strtotime($request->date));
      }else {
        $month = date('m');
        $year = date('Y');
      }
      $cekAbsen = Absensi::where('userid', $request->nip)
      ->whereMonth('date_shift', $month)
      ->whereYear('date_shift', $year)
      ->get();
      if (count($cekAbsen) > 0) {
        return Controller::custom_response(200, "success", 'Ok!', $cekAbsen);
      }else {
        return Controller::custom_response(201, "error", 'Tidak Ada Absensi!', []);
      }
    } catch (\Throwable $e) {
      return Controller::custom_response(500, "error", $e->getMessage(), '');
    }
  }
}
