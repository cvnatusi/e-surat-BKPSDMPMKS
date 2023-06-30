
  <table id="head_excel">
      <thead>
        <tr>
          <td colspan="8" align="center"><b>{{ $judul }}</b></td>
        </tr>
        <tr>
          <td colspan="8" align="center">BKPSDM PAMEKASAN</td>
        </tr>
        <tr>
          <td colspan="8"align="center" >{{ $periode }}</td>
        </tr>
      </thead>
  </table>
  <table id="body_excel" style="table-layout:fixed; width: 100%;border:1px solid black;" >
    <thead>
       <tr>
        <th style="font-weight:bold;text-align:center;"><b>NO</b></th>
        <th style="font-weight:bold;text-align:center;"><b>NO AGENDA</b></th>
        <th style="font-weight:bold;text-align:center;"><b>NO BERKAS</b></th>
        <th style="font-weight:bold;text-align:center;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;"><b>PENGIRIM SURAT</b></th>
        <th style="font-weight:bold;text-align:center;"><b>JENIS SURAT</b></th>
        <th style="font-weight:bold;text-align:center;"><b>SIFAT SURAT</b></th>
        <th style="font-weight:bold;text-align:center;"><b>PERIHAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;"><b>SUDAH DI VERIFIKASI KABAN?</b></th>
        <th style="font-weight:bold;text-align:center;"><b>TANDA TANGAN ELEKTRONIK?</b></th>
        <th style="font-weight:bold;text-align:center;"><b>PEMBUATAN SURAT MANUAL</b></th>
        <th style="font-weight:bold;text-align:center;"><b>PEMBUATAN SURAT ELEKTRONIK</b></th>
      </tr>
    </thead>
     @php
        $no = 1;
        $jumlah = 0;
    @endphp
    <tbody id='panelHasil' style="table-layout:fixed; width: 100%;border:2px solid black;">
        @foreach ($lap as $key => $item)
          <tr>
            <td style="padding: 5px;" align="center" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->no_agenda)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->nomor_surat_keluar)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->tanggal_surat)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->penerima->nama_instansi ?? '-')}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->jenis->nama_jenis_surat)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->sifat->nama_sifat_surat)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->perihal_surat)}}</td>
            @if ($item->is_verif == false)
              <td style="padding: 5px;" align="center" valign="middle">Belum di Verifikasi</td>
            @else
              <td style="padding: 5px;" align="center" valign="middle">Sudah di Verifikasi</td>
            @endif
            @if ($item->ttd == false)
              <td style="padding: 5px;" align="center" valign="middle">Tanda Tangan Manual</td>
            @else
              <td style="padding: 5px;" align="center" valign="middle">Tanda Tangan Elektronik</td>
            @endif
            @if ($item->surat_manual == 'N')
              <td style="padding: 5px;" align="center" valign="middle">Tidak</td>
            @else
              <td style="padding: 5px;" align="center" valign="middle">Ya</td>
            @endif
            @if ($item->surat_elektronik == 'N')
              <td style="padding: 5px;" align="center" valign="middle">Tidak</td>
            @else
              <td style="padding: 5px;" align="center" valign="middle">Ya</td>
            @endif
          </tr>
        @endforeach

    </tbody>

  </table>
