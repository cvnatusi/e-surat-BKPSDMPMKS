<div class="modal fade show" id="modal-list-surat-tugas" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-xl modal-list-surat-tugas">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">List Surat SPPD</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama ASN</th>
              <th>NIP ASN</th>
              <th>No Surat Keluar</th>
              <th>Nama Berkas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->pegawai->nama_asn}}</td>
                <td>{{$value->pegawai->nip}}</td>
                <td>{{$value->suratkeluar->nomor_surat_keluar}}</td>
                <td>{{$value->file_surat_sppd}}</td>
                @if (!empty($value->file_surat_sppd))
                  <td><a href="{{asset('storage/surat-sppd/'.$value->file_surat_sppd)}}" target="_blank" type="button"  class="btn btn-info px-5"><i class="bx bx-cloud-download me-1"></i>Downloads</a></td>
                  @else
                    <td><a href="javascript:void(0)" type="button" onclick="(function(){ swal('Whoops!','Berkas Tidak Ditemukan!','warning');return false;})();return false;" class="btn btn-info px-5"><i class="bx bx-cloud-download me-1"></i>Downloads</a></td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var onLoad = (function() {
  $('#modal-list-surat-tugas').find('.modal-list-surat-tugas').css({
    // 'width': '100%'
  });
  $('#modal-list-surat-tugas').modal('show');
})();
$('#modal-list-surat-tugas').on('hidden.bs.modal', function() {
  $('.modal-list-surat-tugas').html('');
});
</script>
