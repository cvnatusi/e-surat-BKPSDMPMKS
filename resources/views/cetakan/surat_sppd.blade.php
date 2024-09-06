<!DOCTYPE html>
<html lang="en" dir="ltr">
@php
  date_default_timezone_set('Asia/Jakarta');
@endphp
{{ setlocale(LC_ALL, 'id_ID', 'id', 'ID') }}

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <title></title>
    <style type="text/css" media="print">
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
        $logo = public_path('assets/images/logo-icon.png');
        $logo_bsre = public_path('assets/images/logo-bsre.png');
    @endphp
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: -15px;">
        <thead>
            <tr>
                <td rowspan="6">
                    {{-- <img src="{{asset('assets/images/logo-icon.png')}}" style="width: 2.56cm !important; height: 2.67cm !important;"> --}}
                    <img src="{{$logo}}" style="width: 3.10cm !important; height: 2.90cm !important;">
                </td>
                <td align="center">
                    <p style=" margin:0 !important">PEMERINTAHAN KABUPATEN PAMEKASAN</p>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <p style="font-size:18px; margin:0 !important"><b>BADAN KEPEGAWAIAN DAN PENGEMBANGAN</b></p>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <p style="font-size:18px; margin:0 !important"><b>SUMBER DAYA MANUSIA</b></p>
                </td>
            </tr>
            <tr>
                <td align="center">Jalan Bonorogo Nomor 80 Pamekasan</td>
            </tr>
            <tr>
                <td align="center">Telepon (0324) 322858 Faks (0324) 324319 E-mail Bkd.pamekasan@gmail.com</td>
            </tr>
        </thead>
    </table>
    <hr>
    <br>
    {{-- HEADER TULISAN SURAT TUGAS --}}
    <div style="text-align:center">
        <h3 style="margin:0 !important"><u>SURAT PERJALANAN DINAS</u></h3>
        <p style="margin:0 !important">Nomor : {{$data->nomor_surat_perjalanan_dinas}}</p>
    </div>
    {{-- END HEADER TULISAN SURAT TUGAS --}}
    {{-- START CONTENT --}}
    <div class="" style="margin-top:20px">
      <table width: "100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <tr>
          <td style="text-align:center">1.</td>
          <td>&nbsp;Pejabat berwenang yang memberi perintah</td>
          {{-- <td style="margin-left: 1em;">Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia</td> --}}
          <td style="padding: 5px;">Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia</td>
        </tr>
        <tr>
          <td style="text-align:center">2.</td>
          <td>&nbsp;Nama/NIP Pegawai yang diperintahkan</td>
          <td style="padding: 5px;">
            {{$pegawai->nama_asn}}
            <br>
            NIP. {{$pegawai->nip}}
          </td>
        </tr>
        <tr>
          <td style="text-align:center">3.</td>
          <td>
            <ol type="a">
              <li>Pangkat dan Golongan ruang gaji menurut PP Nomor 11 Tahun 2011</li>
              <li>Jabatan / Instansi</li>
              <li>Tingkat Biaya Perjalanan Dinas</li>
            </ol>
          </td>
          {{-- <td>
            <ol type="a">
              <li>{{$asn->pangkat_golongan}}</li>
              <li>{{$asn->jabatan_asn->nama_jabatan}}</li>
              <li>{{$asn->eselon ?? 'Staf'}}</li>
            </ol>
          </td> --}}
          <td>
            <ol type="a">
              <li>{{$pegawai->pangkat_golongan}}</li>
              <li>{{$pegawai->jabatan_asn->nama_jabatan}}</li>
              <li>{{$pegawai->eselon ?? 'Staf'}}</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td style="text-align:center">4.</td>
          <td style="padding: 5px;">&nbsp;Maksud Perjalanan Dinas</td>
          <td style="padding: 5px;">{{$data->isi_ringkas_surat}}</td>
        </tr>
        <tr>
          <td style="text-align:center">5.</td>
          <td style="padding: 5px;">&nbsp;Alat angkut yang dipergunakan</td>
          <td style="padding: 5px;">{{$data->alat_angkut}}</td>
        </tr>
        <tr>
          <td style="text-align:center">6.</td>
          <td>
            <ol type="a">
              <li>Tempat berangkat</li>
              <li>Tempat Tujuan</li>
            </ol>
          </td>
          <td>
            <ol type="a">
              <li>Pamekasan</li>
              <li>{{$surat_tugas[0]->provinsi_tujuan_bertugas}}</li>
              {{-- <li>@foreach ($surat_tugas as $key){{$key->provinsi_tujuan_bertugas}}@endforeach</li> --}}
            </ol>
          </td>
        </tr>
        <tr>
          <td style="text-align:center">7.</td>
          <td>
            <ol type="a">
              <li>Lamanya Perjalanan Dinas</li>
              <li>Tanggal berangkat</li>
              <li>Tanggal harus kembali/tiba ditempat baru</li>
            </ol>
          </td>
          <td>

            <ol type="a">
              @php
                $tgl = \Carbon\Carbon::parse( $data->tanggal_mulai )->diffInDays( $data->tanggal_akhir );

                  function penyebut($nilai) {
                      $nilai = abs($nilai);
                      $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                      $temp = "";
                      if ($nilai < 12) {
                        $temp = " ". $huruf[$nilai];
                      } else if ($nilai <20) {
                        $temp = penyebut($nilai - 10). " belas";
                      } else if ($nilai < 100) {
                        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
                      }
                      return $temp;
                    }
                    $tgl1 = new DateTime($data->tanggal_mulai);
                    $tgl2 = new DateTime($data->tanggal_akhir);
                    $jarak = $tgl2->diff($tgl1);
              @endphp
              <li>{{$jarak->d+1}} ({{penyebut($jarak->d+1)}}) hari</li>
              <li>{{Carbon\Carbon::parse($data->tanggal_mulai)->locale('id')->translatedFormat(' d F Y')}}</li>
              <li>{{Carbon\Carbon::parse($data->tanggal_akhir)->locale('id')->translatedFormat(' d F Y')}}</li>
            </ol>
          </td>
        </tr>
        <tr>
          <td style="text-align:center;">8.</td>
          <td style="padding: 5px;">&nbsp;Pengikut : N a m a</td>
          {{-- <td style="padding: 5px;">Tanggal Lahir : 01/04/1997 <span style="display: inline-block; text-align: center; width: 70%;margin-bottom: -0.2em;">Keterangan : {{$data ? $data->keterangan : '-'}}</span></td> --}}
          <td style="padding: 5px;">Tanggal Lahir <span style="display: inline-block; text-align: center; width: 55%;margin-bottom: -0.2em;">Keterangan </span></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding: 5px;">1. -</td>
          <td style="padding: 5px;"> 01/04/1997 <span style="display: inline-block; text-align: center; width: 70%;margin-bottom: -0.2em;">{{$data ? $data->keterangan : '-'}}</span></td>
        </tr>
        <tr>
          <td style="text-align:center">9.</td>
          <td>&nbsp;Pembebanan Anggaran
            <ol type="a">
              <li>Instansi</li>
              <li>Mata Anggaran</li>
            </ol>
          </td>
          <td>
            <ol type="a">
            <li>-</li>
            <li>-</li>
          </ol>
        </td>
        </tr>
        <tr>
          <td style="text-align:center">10.</td>
          <td style="padding: 5px;">&nbsp;Keterangan Lain lain</td>
          <td></td>
        </tr>
      </table>
      <br>
        <br>
        <table  width="100%" cellpadding="0" cellspacing="0" style="margin-left:12em">
            <thead>
                <tr>
                    <th rowspan="4"></th>
                    <td>
                      <p style="text-align:left; margin:0 !important;margin-left:17em !important">Dikeluarkan di : Pamekasan</p>
                      <p style="text-align:left; margin:0 !important;margin-left:17em !important">Pada Tanggal : {{Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat(' d F Y')}}</p>
                    </td>
                </tr>
                <tr>
                    <th>KEPALA BADAN KEPEGAWAIAN DAN</th>
                </tr>
                <tr>
                    <th>PENGEMBANGAN SUMBER DAYA MANUSIA</th>
                </tr>
                <tr>
                    <th>KABUPATEN PAMEKASAN</th>
                </tr>
            </thead>
        </table>
        <br>
        <br>
        <br>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:12em; text-align:center">
          <tbody>
              <tr>
                  <td colspan="2" rowspan="3"></td>
              </tr>
              <tr>
              </tr>
              <tr>
              </tr>
              <tr>
                  <td rowspan="3"></td>
                  <td><b><u>{{$asn->nama_asn}}</u></b></td>
              </tr>
              <tr>
                  {{-- <td>{{$asn->pangkat_golongan}}</td> --}}
                  <td>PEMBINA UTAMA MUDA</td>
              </tr>
              <tr>
                  <td>NIP.{{$asn->nip}}</td>
              </tr>
          </tbody>
        </table>
        <div class="" style="margin-top:1em">
        {{-- <footer> --}}
            <hr>
            <table width="100%" cellpadding="0" cellspacing="0" style="vertical-align:middle; width:100% !important">
            {{-- <thead> --}}
                <tr>
                <td>
                    <p style="font-size: 10px;margin:0 !important">- UU ITE No 11 Tahun 2008 Pasal 5 Ayat 1</p>
                </td>
                <td rowspan="3">
                    {{-- <img src="{{asset('assets/images/logo-bsre.png')}}" width="95" alt="logo-bsre"> --}}
                    <img src="{{$logo_bsre}}" width="95" alt="logo-bsre">
                </td>
                </tr>
                <tr>
                <td>
                    <p style="font-size: 10px;margin:0 !important">“Informasi Elektornik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah.”</p>
                </td>
                </tr>
                <tr>
                <td>
                    <p style="font-size: 10px;margin:0 !important">- Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan BSrE</p>
                </td>
                </tr>
            {{-- </thead> --}}
            </table>
        </div>
    </div>
    <div class="page-break"></div>
    <div class="">
      <table width: "100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
        <tr>
          <th width="50%"></th>
          <td>
            <p style="text-align:left; margin:0 !important;"><b> I.</b> Berangkat Dari : Pamekasan</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Ke : {{$surat_tugas[0]->provinsi_tujuan_bertugas}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Pada Tanggal : {{Carbon\Carbon::parse($surat_tugas[0]->tanggal_mulai_tugas)->locale('id')->translatedFormat(' d F Y') ?? ''}}</p>
            <br>
            <p style="text-align:center;margin:0 !important;margin-left:1em !important"><b>KEPALA BADAN KEPEGAWAIAN DAN <br> PENGEMBANGAN SUMBER DAYA MANUSIA</b></p>
            <br><br>
            <br><br>
            <p style="text-align:center;margin:0 !important;margin-left:1em !important"><b><u>{{$asn->nama_asn}}</u></b></p>
            {{-- <p style="text-align:center;margin:0 !important;margin-left:1em !important">{{$asn->pangkat_golongan}} <br />NIP. {{$asn->nip}}</p> --}}
            <p style="text-align:center;margin:0 !important;margin-left:1em !important">PEMBINA UTAMA MUDA <br />NIP. {{$asn->nip}}</p>
          </td>
        </tr>
        <tr>
          <td>
            {{-- <p style="text-align:left; margin:0 !important;"><b> II.</b> Tiba di : {{$surat_tugas[1]->provinsi_tujuan_bertugas ?? $surat_tugas[0]->provinsi_tujuan_bertugas}}</p> --}}
            <p style="text-align:left; margin:0 !important;"><b> II.</b> Tiba di : {{$surat_tugas[0]->provinsi_tujuan_bertugas ?? $surat_tugas[0]->provinsi_tujuan_bertugas}}</p>
            {{-- <p style="text-align:left; margin:0 !important;margin-left:1.4em !important">Pada Tanggal : @if (!empty($surat_tugas[1])) {{Carbon\Carbon::parse($surat_tugas[1]->tanggal_mulai_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}} @else {{Carbon\Carbon::parse($surat_tugas[0]->tanggal_mulai_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}} @endif</p> --}}
            <p style="text-align:left; margin:0 !important;margin-left:1.4em !important">Pada Tanggal : @if (!empty($surat_tugas[0])) {{Carbon\Carbon::parse($surat_tugas[0]->tanggal_mulai_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}} @else {{Carbon\Carbon::parse($surat_tugas[1]->tanggal_mulai_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}} @endif</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.4em !important">Kepala :</p>
            <br><br><br><br><br>
          </td>
          <td>
            {{-- <p style="text-align:left; margin:0 !important;margin-left:1em !important">Berangkat Dari :{{$surat_tugas[1]->provinsi_tujuan_bertugas ?? $surat_tugas[0]->provinsi_tujuan_bertugas}}</p> --}}
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Berangkat Dari :{{$surat_tugas[0]->provinsi_tujuan_bertugas ?? $surat_tugas[0]->provinsi_tujuan_bertugas}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Pada Tanggal : @if (!empty($surat_tugas[1])){{Carbon\Carbon::parse($surat_tugas[1]->tanggal_akhir_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}} @else {{Carbon\Carbon::parse($surat_tugas[0]->tanggal_akhir_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}} @endif</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Kepala :</p>
            <br><br><br><br><br>
          </td>
        </tr>
        <tr>
          <td>
            <p style="text-align:left; margin:0 !important;"><b> III.</b> Tiba di : {{$surat_tugas[1]->provinsi_tujuan_bertugas ?? ''}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.8em !important">Pada Tanggal : @if (!empty($surat_tugas[1])){{Carbon\Carbon::parse($surat_tugas[1]->tanggal_mulai_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}}@endif</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.8em !important">Kepala :</p>
            <br><br><br><br>
          </td>
          <td>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Berangkat Dari : {{$surat_tugas[1]->provinsi_tujuan_bertugas ?? ''}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Pada Tanggal : @if (!empty($surat_tugas[1])){{Carbon\Carbon::parse($surat_tugas[1]->tanggal_akhir_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}}@endif</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Kepala :</p>
            <br><br><br><br>
          </td>
        </tr>
        <tr>
          <td>
            <p style="text-align:left; margin:0 !important;"><b> IV.</b> Tiba di : {{$surat_tugas[3]->provinsi_tujuan_bertugas ?? ''}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.8em !important">Pada Tanggal : @if (!empty($surat_tugas[3])){{Carbon\Carbon::parse($surat_tugas[2]->tanggal_akhir_tugas ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}}@endif</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.8em !important">Kepala :</p>
            <br><br><br><br>
          </td>
          <td>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Berangkat Dari : {{$surat_tugas[3]->provinsi_tujuan_bertugas ?? ''}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Pada Tanggal : </p>
            <p style="text-align:left; margin:0 !important;margin-left:1em !important">Kepala :</p>
            <br><br><br><br>
          </td>
        </tr>
        <tr>
          <td>
            <p style="text-align:left; margin:0 !important;"><b> V.</b> Tiba di : Pamekasan</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.4em !important">Pada Tanggal : {{Carbon\Carbon::parse($data->tanggal_akhir ?? '')->locale('id')->translatedFormat(' d F Y') ?? ''}}</p>
            <p style="text-align:left; margin:0 !important;margin-left:1.4em !important">Kepala :</p>
            <br>
            <br>
            <p style="text-align:center;margin:0 !important;margin-left:1em !important"><b>KEPALA BADAN KEPEGAWAIAN DAN <br> PENGEMBANGAN SUMBER DAYA MANUSIA</b></p>
            <br><br>
            <br><br>
            <p style="text-align:center;margin:0 !important;margin-left:1em !important"><b><u>{{$asn->nama_asn}}</u></b></p>
            {{-- <p style="text-align:center;margin:0 !important;margin-left:1em !important">{{$asn->pangkat_golongan}} <br />NIP. {{$asn->nip}}</p> --}}
            <p style="text-align:center;margin:0 !important;margin-left:1em !important">PEMBINA UTAMA MUDA <br />NIP. {{$asn->nip}}</p>
          </td>
          <td>
            <p style="text-align:justify; text-justify: inter-word; margin-top: 0em; padding: 0.5em !important">Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas perintahnya dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.</p>
            {{-- <br>    --}}
            <p style="text-align:center;margin:0 !important;margin-left:1em !important"><b>KEPALA BADAN KEPEGAWAIAN DAN <br> PENGEMBANGAN SUMBER DAYA MANUSIA</b></p>
            <br><br>
            <br><br>
            <p style="text-align:center;margin:0 !important;margin-left:1em !important"><b><u>{{$asn->nama_asn}}</u></b></p>
            {{-- <p style="text-align:center;margin:0 !important;margin-left:1em !important">{{$asn->pangkat_golongan}} <br />NIP. {{$asn->nip}}</p> --}}
            <p style="text-align:center;margin:0 !important;margin-left:1em !important">PEMBINA UTAMA MUDA <br />NIP. {{$asn->nip}}</p>
          </td>
        </tr>
        <tr>
          <td>
            <p style="text-align:left; margin:0 !important;"><b> VI.</b> Lain-lain</p>
          </td>
          <td></td>
        </tr>
      </table>
      <p style="text-align:left;margin:0 !important">Perhatian :</p>
      <p style="text-align:justify; text-justify: inter-word; margin:0 !important; text-size:11px">Pejabat yang berwenang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendaharawan bertanggung jawab berdasarkan peraturan-peraturan keuangan Negara apabila Negara menderita rugi akibat kesalahan, kelalaian dan kesengajaan.</p>
    </div>
    {{-- END CONTENT --}}
</body>

</html>
