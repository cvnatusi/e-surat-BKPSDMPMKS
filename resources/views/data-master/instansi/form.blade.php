<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body p-5">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Tambah Instansi</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_instansi}}">
      @endif
      <div class="col-md-6">
        <label for="kode_instansi" class="form-label">Kode Instansi *)</label>
        <input type="text" class="form-control" name="kode_instansi" id="kode_instansi" @if(!empty($data)) value="{{$data->kode_instansi}}" @endif placeholder="Kode Instansi">
      </div>
      <div class="col-md-6">
        <label for="nama_instansi" class="form-label">Nama Instansi *)</label>
        <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" @if(!empty($data)) value="{{$data->nama_instansi}}" @endif placeholder="Nama Instansi">
      </div>
      <div class="col-md-6">
        <label for="provinsi_id" class="form-label">Provinsi *)</label>
        <select class="form-select provinsi" name="provinsi_id" id="provinsi_id">
          <option selected >-- Pilih Provinsi --</option>
          @foreach ($provinsi as $prov)
            <option value="{{$prov->id_provinsi}}{{(!empty($data)) ? $data->provinsi_id : ''}}">{{$prov->nama_provinsi}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label for="kabupaten_id" class="form-label">Kota / Kabupaten *)</label>
        <select class="form-select kabupaten" name="nama_kota" id="kabupaten_id">
        <option selected disabled>-- Pilih Kabupaten --</option>
          @if (!empty($data))
            <option value="{{(!empty($data)) ? $data->nama_kota : ''}}" selected>{{(!empty($data)) ? $data->kabupaten->nama_kabupaten : '-'}}</option>
          @endif
        </select>
      </div>
      <div class="col-md-12">
        <label for="alamat" class="form-label">Alamat *)</label>
        <input type="text" class="form-control" name="alamat" id="alamat" @if(!empty($data)) value="{{$data->alamat}}" @endif placeholder="Alamat">
      </div>
      <div class="col-md-6">
        <label for="no_telepon" class="form-label">No Telepon *)</label>
        <input type="text" class="form-control" name="no_telepon" id="no_telepon" @if(!empty($data)) value="{{$data->no_telepon}}" @endif placeholder="No Telepon">
      </div>
      <div class="col-md-6">
        <label for="no_fax" class="form-label">Singkatan Nama Intansi *)</label>
        <input type="text" class="form-control" name="no_fax" id="no_fax" @if(!empty($data)) value="{{$data->no_fax}}" @endif placeholder="No Fax">
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
  $('.provinsi').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
  $('.kabupaten').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
    $('.provinsi').val(['35']);
    $('.provinsi').trigger('change')
    var data = {
      id: 3528,
      text: 'KABUPATEN PAMEKASAN'
    };
    var newOption = new Option(data.text, data.id, false, false);
    $('.kabupaten').append(newOption).trigger('change');
})();
$('.provinsi').change(function() {
    var id = $('.provinsi').val();
    $.post("{!! route('getKabupaten') !!}", {
        id: id
    }).done(function(data) {
        if (data.length > 0) {
            var kab = '<option>- Pilih Kabupaten -</option>';
            $.each(data, function(k, v) {
                kab += '<option value="' + v.id_kabupaten + '">' + v.nama_kabupaten +
                    '</option>';
            });

            $('.kabupaten').html(kab);
            $('.kabupaten').removeAttr('disabled');
            $('.kabupaten').select2({
          			theme: 'bootstrap4',
          			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          			placeholder: $(this).data('placeholder'),
          			allowClear: Boolean($(this).data('allow-clear')),
          		});
        }
    });
});
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
        url: "{{ route('store-instansi') }}",
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
