{{-- @foreach ($surat as $data) --}}

<!DOCTYPE html>
<html lang="en" dir="ltr">
@php
  date_default_timezone_set('Asia/Jakarta');
@endphp
{{-- {{ setlocale(LC_ALL, 'id_ID', 'id', 'ID') }} --}}
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title></title>
  <style type="text/css" media="print">
  @page {
      margin: 60px 20px;
  }
  .page-break {
    page-break-before: always;
  }
  @media print {
    body {
      page-break-after: always;
    }
  }
  .column {
    float: left;
    width: 50%;
    padding: 10px;
    height: 300px; /* Should be removed. Only for demonstration */
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }
  </style>
</head>

<body>
    @php
        $logo = public_path('assets/images/logo-icon.png');
        $check = public_path('assets/images/check.png');
        $barcode = public_path('gambar/QR.png');
    @endphp
   @foreach ($listData as $data)
    <table width="100%" cellpadding="0" cellspacing="0">
      <thead>
          <tr>
              <td rowspan="5">
                  <img src="{{asset('assets/images/logo-icon.png')}}" style="width: 2.50cm !important; height: 2.56cm !important;">
              </td>
              <td align="center">
                  <p style=" margin:0 !important">PEMERINTAHAN KABUPATEN PAMEKASAN</p>
              </td>
          </tr>
          <tr>
              <td align="center">
                  <p style="font-size:18px; margin:0 !important;"><b>BADAN KEPEGAWAIAN DAN PENGEMBANGAN</b></p>
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
{{-- HEADER TULISAN SURAT TUGAS --}}
<div style="text-align:center">
    <h2 style="margin:0 !important">SURAT DISPOSISI</h2>
</div>
{{-- END HEADER TULISAN SURAT TUGAS --}}
{{-- START CONTENT --}}
<div class="" style="margin-top:0.5em">
    <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse;table-layout: fixed; width: 100%;">
      <tbody>
        <tr>
          <td  style="vertical-align:top"height="3%" colspan="2" rowspan="2">
            <table border="0" width="100%">
              <tr>
                <td style="text-align: left !important;">Surat Dari :</td>
                <td style="text-align: right !important;">{{$data->pengirim->nama_instansi}}</td>
              </tr>
            </table>
          </td>
          <td  style="vertical-align:top"colspan="3">
            <table border="0" width="100%">
              <tr>
                <td style="text-align: left !important;">Terima Tanggal :</td>
                <td style="text-align: right !important;">{{Carbon\Carbon::parse($data->tanggal_terima_surat)->locale('id')->translatedFormat(' d F Y')}}</td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style="vertical-align:top"colspan="3">
            <table border="0" width="100%">
              <tr>
                <td style="text-align: left !important;">Nomor Agenda / Berkas :</td>
                <td style="text-align: right !important;">{{ $data->no_agenda }}</td>
              </tr>
            </table>
            </td>
        </tr>
        <tr>
          <td width="65%"style="vertical-align:top"height="3%" colspan="2">
            <table border="0" width="100%">
              <tr>
                <td style="text-align: left !important;">Tanggal Surat :</td>
                <td style="text-align: right !important;">{{ $data->tanggal_surat }}</td>
              </tr>
            </table>
          </td>
          <td width="10%"style="vertical-align:top"rowspan="4">&nbsp;Sifat : </td>
          <td width="28%">&nbsp; a. Rahasia</td>
          <td width="10%">
            @if ($data->sifat->nama_sifat_surat == 'Rahasia')
              <img src="{{asset('assets/images/check.png')}}" style="margin-left:65px" width="20px" alt="">
            @endif
          </td>
        </tr>
        <tr>
          <td width="65%" style="vertical-align:top"height="3%" colspan="2">
            <table border="0" width="100%">
              <tr>
                <td style="text-align: left !important;">Nomor Surat :</td>
                <td style="text-align: right !important;">{{ $data->nomor_surat_masuk }}</td>
              </tr>
            </table>
          </td>
          <td width="28%">&nbsp; b. Biasa</td>
          <td width="10%">
            @if ($data->sifat->nama_sifat_surat == 'Biasa')
              <img src="{{asset('assets/images/check.png')}}" style="margin-left:65px" width="20px" alt="">
            @endif
          </td>
        </tr>
        <tr >
          <td width="65%" style="vertical-align:top"height="8%"colspan="2" rowspan="2">
            <table border="0" width="100%">
              <tr>
                <td style="text-align: left !important;">Perihal :</td>
                <td style="text-align: right !important;">{{ $data->perihal_surat }}</td>
              </tr>
            </table>
          </td>
          <td width="28%">&nbsp; c. Segera</td>
          <td width="10%">
            @if ($data->sifat->nama_sifat_surat == 'Segera')
              <img src="{{asset('assets/images/check.png')}}" style="margin-left:65px" width="20px" alt="">
            @endif
          </td>
        </tr>
        <tr>
          <td width="28%">&nbsp; d. Penting</td>
          <td width="10%">
            @if ($data->sifat->nama_sifat_surat == 'Penting')
              <img src="{{asset('assets/images/check.png')}}" style="margin-left:65px" width="20px" alt="">
            @endif
          </td>
        </tr>
      </tbody>
    </table>
    <div class="">
      <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;table-layout: fixed; width: 100%;">
        <thead>
          <tr>
            <td><h3>DITERUSKAN KEPADA :</h3></td>
            <td><h3>DENGAN HORMAT HARAP :</h3></td>
          </tr>
        </thead>
      </table>
    </div>
    <div class="">
      <table  border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse;table-layout: fixed; width: 100%;">
        <tbody>
          <tr>
            <td width="42%">&nbsp;<b>Sekretaris</b></td>
            <td width="5%">
            </td>
            <td width="53%" rowspan="6">
              {{-- <table border="0" cellpadding="0" cellspacing="0"  style="border-collapse: collapse;margin-left: 10px;width: 100%;border: none !important;">
                @php
                $num = 1;
                @endphp
                <tr>
                  @foreach ($dengan_harap as $key)
                    @php
                    if (!empty($data->dengan_hormat_harap)) {
                      $dhh = explode(";",$data->dengan_hormat_harap);
                    }
                    $count = count($dengan_harap);
                    @endphp
                    @if ($count>0)
                      <td>
                        <input type="checkbox" name="dengan_harap[]" @if (!empty($data->dengan_hormat_harap)) @foreach ($dhh as $dt) @if ($dt == $key->id_mst_dengan_harap) checked @endif @endforeach @endif value="{{$key->id_mst_dengan_harap}}" id="dengan_harap_{{$key->id_mst_dengan_harap}}">
                          <label for="dengan_harap_{{$key->id_mst_dengan_harap}}">{{$key->nama_dengan_harap}}</label>
                        </td>
                        @if (($num%2)==0)
                        </tr>
                        <tr>
                        @endif
                      @endif
                      @php
                      $num++;
                      @endphp
                    @endforeach
                  </table> --}}
                </td>
              </tr>
          <tr>
            <td>&nbsp;&nbsp; &nbsp;&nbsp; a.) Kasubbag Perencanaan , Umum dan
              <br>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Kepegawaian
            </td>
            <td>
            </td>
          </tr>
          <tr>
            <td>  &nbsp;&nbsp; &nbsp;&nbsp;b.) Kasubbag keuangan dan Aset</td>
            <td>
          </td>
          </tr>
          <tr>
            <td>&nbsp;<b>Kepala Bidang Mutasi dan Promosi</b></td>
            <td>
            </td>
          </tr>
          <tr>
            <td>&nbsp;<b>Kepala Bidang Pengembangan Aparatur</b></td>
            <td>
            </td>
          </tr>
          <tr>
            <td>&nbsp;<b>Kepala Bidang Pengadaan, Pembinaan dan &nbsp;Informasi Kepegawaian</b></td>
            <td>
            </td>
          </tr>
          <tr>
            <td height="160" colspan="3" style="vertical-align:top">
              <p style="text-align:center"><b>CATATAN / ARAHAN PIMPINAN</b></p>
              <p></p>
            </td>
          </tr>
          <tr>
            <td height="160" colspan="3" style="vertical-align:top">
              <p style="text-align:center"><b>CATATAN / ARAHAN SEKRETARIS</b></p>
              <p></p>
            </td>
          </tr>
        </tbody>
      </table>
      <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;table-layout: fixed; width: 100%; margin-top: 2px;">
        <thead>
          <tr>
            <td>
                <img id='barcode'
                {{-- src="https://api.qrserver.com/v1/create-qr-code/?data=&amp;size=100x100"  --}}
                src="{{asset('assets/images/qr-code.png')}}"
                alt=""
                title=""
                width="100"
                height="100" onblur='generateBarCode();' />
                {{-- <label>CREATED BY : BKPSDM PAMEKASAN</label> --}}
            </td>
          </tr>
        </thead>
        </div>
      </table>
    </div>
</div>
{{-- END CONTENT --}}
{{-- FOOTER --}}
<div class="" style="">
  {{-- <footer> --}}
    {{-- <hr> --}}
    {{-- <table width="100%" cellpadding="0" cellspacing="0" style="vertical-align:middle; width:100% !important">
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
    </table> --}}
</div>
<div class="page-break"></div>
@endforeach
</body>
</html>
{{-- @endforeach --}}

