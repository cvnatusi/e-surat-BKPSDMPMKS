
  {{-- <table id="head_excel">
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
  </table> --}}
  <table id="head_excel" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <thead>
            <tr>
                <td colspan="6" style="text-align: center; font-weight: bold;">{{ $judul }}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">BKPSDM PAMEKASAN</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: center;">{{ $periode }}</td>
            </tr>
        </thead>
    </table>
  <table id="body_excel" style="table-layout:fixed; width: 100%;border:1px solid black;" >
    <thead>
       <tr>
        {{-- <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO SURAT/SPK</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>JENIS PEKERJAAN</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>KEGIATAN</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PENYEDIA</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>JUMLAH</b></th> --}}
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO SURAT/SPK</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PENYEDIA</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>JENIS PEKERJAAN</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>KEGIATAN</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>JUMLAH</b></th>
      </tr>
    </thead>
     @php
        $no = 1;
        $jumlah = 0;
    @endphp
    <tbody id='panelHasil' style="table-layout:fixed; width: 100%;border:2px solid black;">
        @foreach ($lap as $key => $item)
          <tr>
            {{-- <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->nomor_surat_bast)}}</td>
            <td style="padding: 5px; border: 1px solid black;" align="center" class="cap" valign="middle">{{ date('d-m-Y', strtotime($item->tanggal_surat)) }}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->jenis_pekerjaan )?? '-'}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->kegiatan)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->penyedia_jasa)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ is_numeric($item->jumlah) ? 'Rp. ' . number_format($item->jumlah, 0, ',', '.') : '-' }}</td> --}}
            <td style="padding: 5px; border: 1px solid black;" align="center" class="cap" valign="middle">{{ date('d-m-Y', strtotime($item->tanggal_surat)) }}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->nomor_surat_bast)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->penyedia_jasa)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->jenis_pekerjaan )?? '-'}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ucwords($item->kegiatan)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" valign="middle">{{ is_numeric($item->jumlah) ? 'Rp. ' . number_format($item->jumlah, 0, ',', '.') : '-' }}</td>
          </tr>
        @endforeach

    </tbody>

  </table>
