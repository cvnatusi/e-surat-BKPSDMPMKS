<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif Jenis Surat</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_mst_jenis_surat}}">
      @endif
      <div class="col-md-4">
        <label for="kode_jenis_surat" class="form-label">Kode Jenis Surat *)</label>
        <input type="text" class="form-control" name="kode_jenis_surat" id="kode_jenis_surat" @if(!empty($data)) value="{{$data->kode_jenis_surat}}" @endif placeholder="Kode Jenis Surat">
      </div>
      <div class="col-md-8">
        <label for="nama_jenis_surat" class="form-label">Nama / Keterangan Jenis Surat *)</label>
        <input type="text" class="form-control" name="nama_jenis_surat" id="nama_jenis_surat" @if(!empty($data)) value="{{$data->nama_jenis_surat}}" @endif placeholder="Nama / Keterangan Jenis Surat">
      </div>
      <div class="col-md-4" style="display:none">
        <label for="kode_jenis_surat" class="form-label">Klasifikasi Masuk / Keluar *)</label>
        {{-- <input type="text" class="form-control" name="kode_jenis_surat" id="kode_jenis_surat" @if(!empty($data)) value="{{$data->kode_jenis_surat}}" @endif> --}}
        <select class="form-select klasifikasi_jenis_surat" name="klasifikasi_jenis_surat" id="klasifikasi_jenis_surat">
          <option value="Masuk" {{ (!empty($data)) ? (($data->klasifikasi_jenis_surat == 'Masuk') ? 'selected' : 'selected') : 'selected' }}>Masuk</option>
          <option value="Keluar" {{ (!empty($data)) ? (($data->klasifikasi_jenis_surat == 'Keluar') ? 'selected' : '') : '' }}>Keluar</option>
        </select>
      </div>
      <hr>
      <div class="col-md-12">
        <div class="d-md-flex d-grid align-items-center gap-3">
          <button type="button" class="btn btn-secondary px-4 btn-cancel">Kembali</button>
          <button type="button" class="btn btn-primary px-4 btn-submit">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
var onLoad = (function() {
  $('.panel-form').animateCss('bounceInUp');
  $('.klasifikasi_jenis_surat').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
    });
})();

$('.btn-cancel').click(function(e){
  e.preventDefault();
  $('.panel-form').animateCss('bounceOutDown');
  $('.other-page').fadeOut(function(){
    $('.other-page').empty();
    $('.main-page').fadeIn();
    $('#datagrid').DataTable().ajax.reload();
  });
});

$('.btn-submit').click(function(e){
 e.preventDefault();
    // $('.btn-submit').html('Please wait...').attr('disabled', true);
    $('.btn-submit');
    var data  = new FormData($('.form-save')[0]);
    $.ajax({
        url: "{{ route('store-jenis-surat') }}",
        type: 'POST',
        data: data,
        async: true,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
    $('.form-save').validate(data, 'has-error');
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
        $('.other-page').fadeOut(function(){
        $('.other-page').empty();
        $('.card').fadeIn();
        $('#datagrid').DataTable().ajax.reload();
        });
    } else if(data.status == 'error') {
        $('.btn-submit');
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
        $('.btn-submit');
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
    }).fail(function() {
      $('.btn-submit');
      Lobibox.notify('warning', {
        title: 'Maaf!',
        pauseDelayOnHover: true,
        size: 'mini',
        rounded: true,
        delayIndicator: false,
        icon: 'bx bx-error',
        continueDelayOnInactiveTab: false,
        position: 'top right',
        sound:false,
        msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
      });
    });
});
</script>
