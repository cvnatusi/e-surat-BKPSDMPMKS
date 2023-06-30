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
  @page {
      margin: 100px 25px;
  }
  .page-break {
    page-break-after: always;
  }
  </style>
</head>

<body style="margin-left:1cm">
    <table width="100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td rowspan="5">
                    <img src="{{asset('assets/images/logo-icon.png')}}" style="width: 2.56cm !important; height: 2.67cm !important;">
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
        <h3 style="margin:0 !important"><u>SURAT TUGAS</u></h3>
        <p style="margin:0 !important">Nomor : {{$data->nomor_surat_perjalanan_dinas}}</p>
    </div>
    {{-- END HEADER TULISAN SURAT TUGAS --}}
    {{-- START CONTENT --}}
    {{-- <div class="">
        <p>Yang bertanda tangan dibawah ini :</p>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:10px;">
            <thead>
                <tr>
                    <td width="20%">Nama</td>
                    <td width="2%">:</td>
                    <td width="78%" style="vertical-align: bottom;">{{$asn->nama_asn}}</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{$asn->nip}}</td>
                </tr>
                <tr>
                    <td>Pangkat/Golongan</td>
                    <td>:</td>
                    <td>{{$asn->pangkat_golongan}}</td>
                </tr>
                <tr>
                    <td style="vertical-align:top">Jabatan</td>
                    <td style="vertical-align:top">:</td>
                    <td>{{$asn->jabatan_asn->nama_jabatan}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <p>Menugaskan Saudara,</p>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:50px">
            <thead>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td width="78%" style="vertical-align: bottom;">{{$data->pegawai->nama_asn}}</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{$data->pegawai->nip}}</td>
                </tr>
                <tr>
                    <td>Pangkat/Golongan</td>
                    <td>:</td>
                    <td>{{$data->pegawai->pangkat_golongan}}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{$data->pegawai->jabatan_asn->nama_jabatan}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <p>{{$data->isi_ringkas_surat}}, Pada </p>
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:10px;">
            <thead>
                <tr>
                    <td width="20%">Hari</td>
                    <td width="2%">:</td>
                    <td width="78%">@if ($data->tanggal_mulai == $data->tanggal_akhir){{Carbon\Carbon::parse($data->tanggal_mulai)->locale('id')->formatLocalized('%A')}}@else{{Carbon\Carbon::parse($data->tanggal_mulai)->locale('id')->formatLocalized('%A')}} - {{Carbon\Carbon::parse($data->tanggal_akhir)->locale('id')->formatLocalized('%A')}}@endif</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>@if ($data->tanggal_mulai == $data->tanggal_akhir){{Carbon\Carbon::parse($data->tanggal_mulai)->locale('id')->translatedFormat(' d F Y')}}@else{{date('d',strtotime($data->tanggal_mulai))}} s/d {{Carbon\Carbon::parse($data->tanggal_akhir)->locale('id')->translatedFormat(' d F Y')}}@endif</td>
                </tr>
                <tr>
                    <td style="vertical-align:top">Tempat</td>
                    <td style="vertical-align:top">:</td>
                    <td width="78%" >
                        @foreach ($surat_tugas as $suratTugas)
                          {{$suratTugas->tempat_tujuan_bertugas}} ({{$suratTugas->alamat_tujuan_bertugas}}) <br>
                        @endforeach
                    </td>
                   
                </tr>
            </tbody>
        </table>
        <br><br>
        <p>Demikian Surat tugas ini dibuat, untuk dipergunakan sebagaimana mestinya.</p>
        <br><br>
        <br>
        <table  width="100%" cellpadding="0" cellspacing="0" style="margin-left:10em;vertical-align:middle">
            <thead>
                <tr>
                    <th rowspan="4"></th>
                    <td><p style="text-align:right; margin-right:14em !important">Pamekasan, {{Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat(' d F Y')}}</p></td>
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
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:25.5em">
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
                  <td>{{$asn->pangkat_golongan}}</td>
              </tr>
              <tr>
                  <td>NIP {{$asn->nip}}</td>
              </tr>
          </tbody>
        </table>
    </div> --}}
    {{-- END CONTENT --}}
</body>

</html>
