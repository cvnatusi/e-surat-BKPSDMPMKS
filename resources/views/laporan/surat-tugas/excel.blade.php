
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
        <th style="font-weight:bold;text-align:center;"><b>NO SURAT</b></th>
        <th style="font-weight:bold;text-align:center;"><b>NAMA ASN</b></th>
        <th style="font-weight:bold;text-align:center;"><b>TANGGAL MULAI</b></th>
        <th style="font-weight:bold;text-align:center;"><b>TANGGAL AKHIR</b></th>
        <th style="font-weight:bold;text-align:center;"><b>KOTA TUJUAN</b></th>
        <th style="font-weight:bold;text-align:center;"><b>PERIHAL</b></th>
      </tr>
    </thead>
     @php
        $no = 1;
        $jumlah = 0;
        $arrTjn=[];
    @endphp
    <tbody id='panelHasil' style="table-layout:fixed; width: 100%;border:2px solid black;">
        @foreach ($lap as $key => $item)
          @foreach ($item->tujuan as $k)
            @php
              if(!empty($k['tempat_tujuan_bertugas'])){
                array_push($arrTjn,ucwords($k['tempat_tujuan_bertugas']));
              }
              $dataTempat= implode(",",$arrTjn);
            @endphp
          @endforeach
          <tr>
            <td style="padding: 5px;" align="center" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->nomor_surat_perjalanan_dinas)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->pegawai->nama_asn)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->tanggal_mulai)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->tanggal_akhir)}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{$dataTempat}}</td>
            <td style="padding: 5px;" align="center" valign="middle">{{ucwords($item->perihal_surat)}}</td>
          </tr>
        @endforeach

    </tbody>

  </table>
