
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
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO AGENDA</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO BERKAS</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL TERIMA</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PENGIRIM SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>JENIS SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PERIHAL SURAT</b></th>
      </tr>
    </thead>
     @php
        $no = 1;
        $jumlah = 0;
    @endphp
    <tbody id='panelHasil' style="table-layout:fixed; width: 100%;border:2px solid black;">
        @foreach ($lap as $key => $item)
          <tr>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->no_agenda)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->nomor_surat_masuk)}}</td>
            {{-- <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->tanggal_surat)}}</td> --}}
            <td style="padding: 5px; border: 1px solid black;" align="center" class="cap" valign="middle">{{ date('d-m-Y', strtotime($item->tanggal_surat)) }}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->tanggal_terima_surat)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->pengirim->nama_instansi ?? '-')}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->jenis->nama_jenis_surat)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->perihal_surat)}}</td>
          </tr>
        @endforeach
    </tbody>

  </table>
