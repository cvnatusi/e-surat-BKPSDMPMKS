<!DOCTYPE html>
<html lang="en" dir="ltr">
@php
  date_default_timezone_set('Asia/Jakarta');
@endphp
{{ setlocale(LC_ALL, 'id_ID', 'id', 'ID') }}
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title></title>
  <style type="text/css" media="print">
  @page {
      margin: 100px 25px;
  }
  .page-break {
    page-break-after: always;
  }
  .table {
    border-collapse: collapse;
    width: 100%;
  }
  .table td, .table th {
        border: 1px solid black;
        padding: 8px;
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
        <p style="margin:0 !important;">Nomor : {{$data->nomor_surat_perjalanan_dinas}}</p>
    </div>
    {{-- END HEADER TULISAN SURAT TUGAS --}}
    {{-- START CONTENT --}}
    <div class="" >
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
        {{-- @if (count($pegawai) > 1) --}}
        @if (count($pegawai) > 1)
        <table class="table" border="1" cellspacing="0" cellpadding="3" style="margin-left: 10px; font-size: 11px; ">
            <thead style="font-weight: 600; text-align: center;">
                <tr>
                    <td>No</td>
                     <td>Nama</td>
                     <td>NIP</td>
                     <td>Pangkat Golongan</td>
                     <td>Jabatan</td>
                </tr>
            </thead>
            <tbody style="border: 0.5px;">
                @foreach ($pegawai as $key => $i)
                <tr >
                    <td style="text-align: center">{{$key+1}}</td>
                    <td>{{$i->nama_asn}}</td>
                    <td>{{$i->nip}}</td>
                    <td>{{$i->pangkat_golongan}}</td>
                    <td>{{!empty($i->jabatan_asn->nama_jabatan)?$i->jabatan_asn->nama_jabatan:'-'}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
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
        @endif
        <br>
        <p>{{$data->isi_ringkas_surat}}, pada </p>
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
                    {{-- <td>{{$surat_tugas->tempat_tujuan_bertugas}} <br>{{$surat_tugas->alamat_tujuan_bertugas}}</td> --}}
                </tr>
            </tbody>
        </table>
        <br><br>
        <p>Demikian Surat tugas ini dibuat, untuk dipergunakan sebagaimana mestinya.</p>
        <br><br>
        <br>
        <table  width="100%" cellpadding="0" cellspacing="0" style="margin-left: 10em; vertical-align: middle">
        {{-- <table  width="100%" cellpadding="0" cellspacing="0" style="margin-left: 13em; vertical-align: middle"> --}}
            <thead>
                <tr>
                    <th rowspan="4"></th>
                    <td><p style="text-align:right; margin-right: 16.5rem; ">Pamekasan, {{Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat(' d F Y')}}</p></td>
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
        <div class="image">
          {{-- @php
            $data->verifikasi_kaban = 'N';
          @endphp --}}
          {{-- <img src="data:image/png;base64, {!! $qr !!}" style="margin-top:10px; margin-bottom: -60rem; margin-left: 38.3em" width="90"> --}}
          {{-- <img src="{{asset('gambar/QR.png')}}" style="margin-top:10px; margin-bottom: -50rem; margin-left:28.5em" width="90" alt=""> --}}
          @if ($data->verifikasi_kaban == 'Y')
          <img src="data:image/png;base64, {!! $qr !!}" style="margin-top:10px; margin-bottom: -60rem; margin-left:28.5em" width="90">
            @else
              <div class="square" style="width: 100px;height: 100px;"></div>
          @endif
        </div>
        {{-- <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:25.5em; vertical-align:middle; text-align: center;"> --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-left:10rem; margin-top: -10px; vertical-align:middle; text-align: center; ">
          <tbody>
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
    </div>
    {{-- END CONTENT --}}
    {{-- FOOTER --}}
    <div class="" style="margin-top:3em">
      {{-- <footer> --}}
        <hr>
        <table width="100%" cellpadding="0" cellspacing="0" style="vertical-align:middle; width:100% !important">
          {{-- <thead> --}}
            <tr>
              <td>
                <p style="font-size: 10px;margin:0 !important">- UU ITE No 11 Tahun 2008 Pasal 5 Ayat 1</p>
              </td>
              <td rowspan="3">
                  <img src="{{asset('assets/images/logo-bsre.png')}}" width="95">
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
    @if ($data->verifikasi_kaban != 'Y')
      <div style="position: fixed;
      bottom: 500px;
      left: 90px;
      z-index: 10000;
      font-size:150px;
      color: grey;
      transform:rotate(-45deg);
      opacity: 0.2;">
      DRAFT
    </div>
    @endif
</body>
</html>
