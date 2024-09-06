<style media="screen">
  .cap{ text-transform: capitalize; }
</style>
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
                <td colspan="4" style="text-align: center; font-weight: bold;">{{ $judul }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;">BKPSDM PAMEKASAN</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;">{{ $periode }}</td>
            </tr>
        </thead>
    </table>
  <table id="body_excel" style="table-layout:fixed; width: 100%;border:1px solid black;" >
    <thead>
       <tr>
        {{-- <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TUJUAN</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PERIHAL</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL SURAT</b></th> --}}
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TANGGAL SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>NO SURAT</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>PERIHAL</b></th>
        <th style="font-weight:bold;text-align:center;border: 1px solid black;"><b>TUJUAN</b></th>
      </tr>
    </thead>
     @php
        $no = 1;
        $jumlah = 0;
    @endphp
    <tbody id='panelHasil' style="table-layout:fixed; width: 100%;border:2px solid black;">
        @foreach ($lap as $key => $item)
          <tr>
            {{-- <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{$key+1}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->nomor_surat_keputusan)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tujuan)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->perihal)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tanggal_surat)}}</td> --}}
            {{-- <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tanggal_surat)}}</td> --}}
            <td style="padding: 5px; border: 1px solid black;" align="center" class="cap" valign="middle">{{ date('d-m-Y', strtotime($item->tanggal_surat)) }}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->nomor_surat_keputusan)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->perihal)}}</td>
            <td style="padding: 5px;border: 1px solid black;" align="center" class="cap" valign="middle">{{ucwords($item->tujuan)}}</td>
          </tr>
        @endforeach

    </tbody>

  </table>
