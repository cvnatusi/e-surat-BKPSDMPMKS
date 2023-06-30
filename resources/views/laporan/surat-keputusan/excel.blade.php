<style media="screen">
  .cap{ text-transform: capitalize; }
</style>
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
        <th style="font-weight:bold;text-align:center;"><b>TUJUAN</b></th>
        <th style="font-weight:bold;text-align:center;"><b>PERIHAL</b></th>
        <th style="font-weight:bold;text-align:center;"><b>TANGGAL SURAT</b></th>
      </tr>
    </thead>
     @php
        $no = 1;
        $jumlah = 0;
    @endphp
    <tbody id='panelHasil' style="table-layout:fixed; width: 100%;border:2px solid black;">
        @foreach ($lap as $key => $item)
          <tr>
            <td style="padding: 5px;" align="center" class="cap" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;" align="center" class="cap" valign="middle">{{ucwords($item->nomor_surat_keputusan)}}</td>
            <td style="padding: 5px;" align="center" class="cap" valign="middle">{{ucwords($item->tujuan)}}</td>
            <td style="padding: 5px;" align="center" class="cap" valign="middle">{{ucwords($item->perihal)}}</td>
            <td style="padding: 5px;" align="center" class="cap" valign="middle">{{ucwords($item->tanggal_surat)}}</td>

          </tr>
        @endforeach

    </tbody>

  </table>
