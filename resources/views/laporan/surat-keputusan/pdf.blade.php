
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
    </colgroup>
    <thead>
       <tr>
        {{-- <th style="font-weight:bold;text-align:center;border:1px solid black;"><b>NO</b></th>
        <th style="font-weight:bold;text-align:center;border:1px solid black;"><b>NO SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border:1px solid black;"><b>TUJUAN</b></th>
        <th style="font-weight:bold;text-align:center;border:1px solid black;"><b>PERIHAL</b></th>
        <th style="font-weight:bold;text-align:center;border:1px solid black;"><b>TANGGAL SURAT</b></th> --}}
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PERIHAL</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TUJUAN</b></th>
      </tr>
    </thead>
    <tbody id='panelHasil'>
        @foreach ($lap as $key => $item)
          <tr>
            {{-- <td style="padding: 5px;border:1px solid black;" align="center" class="cap" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;border:1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->nomor_surat_keputusan)}}</td>
            <td style="padding: 5px;border:1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tujuan)}}</td>
            <td style="padding: 5px;border:1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->perihal)}}</td>
            <td style="padding: 5px; border: 1px solid black;" align="center" class="cap" valign="middle">{{ date('d-m-Y', strtotime($item->tanggal_surat)) }}</td> --}}
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tanggal_surat)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->nomor_surat_keputusan)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->perihal)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tujuan)}}</td>
          </tr>
        @endforeach
    </tbody>
</table>

<div style="position: relative; height: 200px; bottom: 0;">
    <table style="position: absolute; right: 0; bottom: 0; text-align: center; line-height: 1; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
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


  {{-- <table id="body_excel" style="width: 100%; border:1px solid black; font-size: 11px; border-collapse: collapse;">
    <thead>
       <tr>
        <th style="font-weight:bold; border:1px solid black;" width="50"><b>NO</b></th>
        <th style="font-weight:bold; border:1px solid black;" width="50"><b>NO <br> AGENDA</b></th>
        <th style="font-weight:bold; border:1px solid black;"><b>NO BERKAS</b></th>
        <th style="font-weight:bold; border:1px solid black;" width="70"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold; border:1px solid black;"><b>TANGGAL TERIMA</b></th>
        <th style="font-weight:bold; border:1px solid black;"><b>PENGIRIM SURAT</b></th>
        <th style="font-weight:bold; border:1px solid black;"><b>JENIS SURAT</b></th>
        <th style="font-weight:bold; border:1px solid black;"><b>PERIHAL SURAT</b></th>
      </tr>
    </thead>
    @php
        $no = 1;
        $jumlah = 0;
    @endphp
    <tbody id='panelHasil' style="width: 100%; border:1px solid black;">
        @foreach ($lap as $key => $item)
          <tr>
            <td style="padding: 3px; border:1px solid black;">{{$key+1}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->no_agenda)}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->nomor_surat_masuk)}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->tanggal_surat)}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->tanggal_terima_surat)}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->pengirim->nama_instansi ?? '-')}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->jenis->nama_jenis_surat)}}</td>
            <td style="padding: 3px; border:1px solid black;">{{ucwords($item->perihal_surat)}}</td>
          </tr>
        @endforeach
    </tbody>
</table> --}}

