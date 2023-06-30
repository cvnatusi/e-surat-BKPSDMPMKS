<div class="modal fade show" id="modal-list-surat-tugas" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-xl modal-list-surat-tugas">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">List Surat Tugas</h5>
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
              <th>Surat Tugas</th>
              <th>Buat SPPD</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $key => $value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->pegawai->nama_asn}}</td>
                <td>{{$value->pegawai->nip}}</td>
                <td>{{$value->surattugas->nomor_surat_perjalanan_dinas ?? '-'}}</td>
                <td>{{$value->file_surat_tugas}}</td>
                @if (!empty($value->file_surat_tugas))
                  <td><a href="{{asset('storage/surat-tugas/'.$value->file_surat_tugas)}}" target="_blank" type="button"  class="btn btn-sm  btn-info px-5"><i class="bx bx-cloud-download me-1"></i>Preview Surat Tugas</a></td>
                  @else
                    <td><a href="javascript:void(0)" type="button" onclick="(function(){ swal('Whoops!','Berkas Tidak Ditemukan!','warning');return false;})();return false;" class="btn btn-info px-5"><i class="bx bx-cloud-download me-1"></i>Preview Surat Tugas</a></td>
                @endif
                @if (!empty($value->file_surat_sppd))
                  <td>SPPD Sudah di Buatkan!</td>
                  @else
                    <td><a href="javascript:void(0)" type="button" onclick="buatSPPD({{$value->id_file_perjalanan_dinas}})" class="btn btn-sm btn-success px-5"><i class="bx bxs-file-plus me-1"></i>Buat SPPD</a></td>
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

function buatSPPD(id) {
  $.post("{!! route('buatSPPD') !!}",{id:id}).done(function(data){
    if(data.status == 'success'){
      Lobibox.notify('success', {
        pauseDelayOnHover: true,
        size: 'mini',
        rounded: true,
        delayIndicator: false,
        icon: 'bx bx-check-circle',
        continueDelayOnInactiveTab: false,
        position: 'top right',
        sound:false,
        msg: data.message
      });
        $('#modal-list-surat-tugas').modal('hide');
        $('.modal-list-surat-tugas').html('');
        
    } else if(data.status == 'error') {
        $('.btn-submit').html('Simpan <i class="fa fa-save fs-14 m-l-5"></i>').removeAttr('disabled');
        Lobibox.notify('error', {
          pauseDelayOnHover: true,
          size: 'mini',
          rounded: true,
          delayIndicator: false,
          icon: 'bx bx-x-circle',
          continueDelayOnInactiveTab: false,
          position: 'top right',
          sound:false,
          msg: data.message
        });
        swal('Error :'+data.errMsg.errorInfo[0], data.errMsg.errorInfo[2], 'warning');
    } else {
        var n = 0;
        for(key in data){
        if (n == 0) {var dt0 = key;}
        n++;
        }
        $('.btn-submit').html('Simpan <i class="fa fa-save fs-14 m-l-5"></i>').removeAttr('disabled');
        Lobibox.notify('warning', {
          pauseDelayOnHover: true,
          size: 'mini',
          rounded: true,
          delayIndicator: false,
          icon: 'bx bx-error',
          continueDelayOnInactiveTab: false,
          position: 'top right',
          sound:false,
          msg: data.message
        });
    }
  });
}
</script>
