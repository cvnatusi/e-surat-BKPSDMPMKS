
  <table id="head_excel" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
    <thead>
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold;">{{ $judul }}</td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">BKPSDM PAMEKASAN</td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">{{ $periode }}</td>
        </tr>
    </thead>
</table>

<table id="body_excel" style="width: 100%; border:1px solid black; font-size: 11px; border-collapse: collapse;">
    <colgroup>
        <col style="width: 40px;">
        <col style="width: 30px;">
        <col style="width: 100px;">
        <col style="width: 65px;">
        <col style="width: 100px;">
        <col style="width: 150px;">
        <col style="width: 100px;">
        <col style="width: 150px;">
    </colgroup>
    <thead>
       <tr>
        <th style="font-weight:bold;border:1px solid black;"><b>NO</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>NO AGENDA</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>NO BERKAS</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>TUJUAN SURAT</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>JENIS SURAT</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>SIFAT SURAT</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>PERIHAL SURAT</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>SUDAH DI VERIFIKASI KABAN?</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>TANDA TANGAN ELEKTRONIK?</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>PEMBUATAN SURAT MANUAL</b></th>
        <th style="font-weight:bold;border:1px solid black;"><b>PEMBUATAN SURAT ELEKTRONIK</b></th>
      </tr>
    </thead>
    {{-- @php
        $no = 1;
        $jumlah = 0;
        $arrTjn=[];
    @endphp --}}
    <tbody id='panelHasil'>
        @foreach ($lap as $key => $item)
          {{-- @foreach ($item as $k)
            @php
              if(!empty($k['tempat_tujuan_bertugas'])){
                array_push($arrTjn,ucwords($k['tempat_tujuan_bertugas']));
              }
              $dataTempat= implode(",",$arrTjn);
              $asn_id = explode(",",$item->asn_id);
              $resNamaPetugas = [];
              foreach ($asn_id as $key => $value) {
                $petugas = DB::table('mst_asn')->where('id_mst_asn', $value)->first();
                array_push($resNamaPetugas, $petugas->nama_asn);
              }
            @endphp
          @endforeach --}}
          <tr>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->no_agenda)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->nomor_surat_keluar)}}</td>
            <td style="padding: 5px; border: 1px solid black;" align="center" class="cap" valign="middle">{{ date('d-m-Y', strtotime($item->tanggal_surat)) }}</td>
            {{-- <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->tanggal_surat)}}</td> --}}
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->penerima->nama_instansi ?? '-')}}</td>
            {{-- <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">NAMA INSTANSI</td> --}}
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->jenis->nama_jenis_surat)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->sifat->nama_sifat_surat)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->perihal_surat)}}</td>
            @if ($item->is_verif == false)
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Belum di Verifikasi</td>
            @else
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Sudah di Verifikasi</td>
            @endif
            @if ($item->ttd == false)
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Tanda Tangan Manual</td>
            @else
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Tanda Tangan Elektronik</td>
            @endif
            @if ($item->surat_manual == 'N')
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Tidak</td>
            @else
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Ya</td>
            @endif
            @if ($item->surat_elektronik == 'N')
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Tidak</td>
            @else
              <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">Ya</td>
            @endif
          </tr>
        @endforeach
    </tbody>
</table>

<div style="position: relative; height: 200px;">
    <table style="position: absolute; right: 10px; bottom: 30px; text-align: center; line-height: 1; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td style="padding: 0; margin: 0;"><p style="margin: 0;">Pamekasan, {{ \Carbon\Carbon::now()->format('d F Y') }}</p></td>
            </tr>
            <tr>
                <td style="padding: 0; margin: 0;"><p style="margin: 0;">KEPALA BADAN KEPEGAWAIAN DAN</p></td>
            </tr>
            <tr>
                <td style="padding: 0; margin: 0;"><p style="margin: 0;">PENGEMBANGAN SUMBER DAYA MANUSIA</p></td>
            </tr>
            <tr>
                <td style="padding: 0; margin: 0;"><p style="margin: 0;">KABUPATEN PAMEKASAN</p></td>
            </tr>
            <tr>
                <td style="padding: 60px 0 0 0; margin: 0;"><p style="margin: 0;"><b>Drs. SAUDI RAHMAN, M.Si</b></p></td>
            </tr>
            <tr>
                <td style="padding: 0; margin: 0;"><p style="margin: 0;">Pangkat/Golongan</p></td>
            </tr>
            <tr>
                <td style="padding: 0; margin: 0;"><p style="margin: 0;">NIP. 196802021988091001</p></td>
            </tr>
        </thead>
    </table>
</div>
