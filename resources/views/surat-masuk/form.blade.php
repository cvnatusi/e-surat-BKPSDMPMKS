<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif Surat Masuk</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_surat_masuk}}">
      @endif
      <div class="col-md-6">
        <label for="nomor_surat_masuk" class="form-label">Nomor Surat (Ketik tanpa menggunakan spasi) *</label>
        <input type="text" class="form-control" name="nomor_surat_masuk" id="nomor_surat_masuk" @if(!empty($data)) value="{{$data->nomor_surat_masuk}}" @endif placeholder="Nomor Surat Masuk">
      </div>
      <div class="col-md-4">
        <label for="pengirim_surat_id" class="form-label">Pengirim Surat *</label>
        <select class="form-select instansi" name="pengirim_surat_id" id="pengirim_surat_id">
          <option value="">-- Pilih Instansi --</option>
          @if (!empty($instansi))
            @foreach ($instansi as $inst)
              <option value="{{$inst->id_instansi}}" @if(!empty($data)) @if ($data->pengirim_surat_id == $inst->id_instansi) selected="selected" @endif @endif>{{$inst->nama_instansi}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-2">
        <label for="instansi_baru" class="form-label">&nbsp</label>
        <div class="form-check" style="padding-left: 2.5em !important; padding-top: 7px !important;">
          <input class="form-check-input" name="instansi_baru" value="Y" type="checkbox" style="transform: scale(2.0);" id="instansi_baru">
          <label class="form-check-label" for="instansi_baru" style="padding-left: 1em;">Instansi Baru</label>
        </div>
      </div>
      <div class="col-md-6">
        <label for="sifat_surat_id" class="form-label">Sifat Surat</label>
        <select class="form-select sifat_surat" name="sifat_surat_id" id="sifat_surat_id">
        <option value="">-- Pilih Sifat Surat --</option>
          @if (!empty($sifat_surat))
            @foreach ($sifat_surat as $ss)
              <option value="{{$ss->id_sifat_surat}}" @if(!empty($data)) @if ($data->sifat_surat_id == $ss->id_sifat_surat) selected="selected" @endif @endif>{{$ss->nama_sifat_surat}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-6">
        <label for="jenis_surat_id" class="form-label">Jenis Surat *</label>
        <select class="form-select jenis_surat" name="jenis_surat_id" id="jenis_surat_id">
        <option value="">-- Pilih Jenis Surat --</option>
          @if (!empty($jenis_surat))
            @foreach ($jenis_surat as $js)
              <option value="{{$js->id_mst_jenis_surat}}" @if(!empty($data)) @if ($data->jenis_surat_id == $js->id_mst_jenis_surat) selected="selected" @endif @endif>{{$js->kode_jenis_surat}} - {{$js->nama_jenis_surat}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-6">
        <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
        <input type="date" @if(!empty($data)) value="{{date('Y-m-d',strtotime($data->tanggal_surat))}}" @else value="{{date('Y-m-d')}}" @endif class="form-control tanggal_surat" name="tanggal_surat" id="tanggal_surat">

      </div>
      <div class="col-md-6">
        <label for="tanggal_terima_surat" class="form-label">Tanggal Terima Surat *</label>
        <input type="date" @if(!empty($data)) value="{{date('Y-m-d',strtotime($data->tanggal_terima_surat))}}" @else value="{{date('Y-m-d')}}" @endif class="form-control tanggal_terima_surat" name="tanggal_terima_surat" id="tanggal_terima_surat">
      </div>
      <div class="col-md-6">
        <label for="perihal_surat" class="form-label">Perihal Surat *</label>
        <input type="text" class="form-control"  name="perihal_surat" id="perihal_surat" @if(!empty($data)) value="{{$data->perihal_surat}}" @endif placeholder="Perihal Surat">
      </div>
      <div class="col-md-6">
        <label for="file_scan" class="form-label">Upload Scan / Foto Surat</label>
        <input class="form-control" type="file" id="file_scan" name="file_scan">
      </div>
      <div class="col-md-12">
        <label for="isi_ringkas_surat" class="form-label">Isi Ringkas Surat *</label>
          <textarea rows="3" cols="80" class="form-control" placeholder="Ketikkan isi surat dengan ringkas" name="isi_ringkas_surat" id="isi_ringkas_surat">@if(!empty($data)){{$data->isi_ringkas_surat}}@endif</textarea>
      </div>
      <!-- <div class="col-md-12">
        <label for="catatan_tambahan" class="form-label">Catatan Tambahan</label>
          <textarea rows="2" cols="80" class="form-control" name="catatan_tambahan" id="catatan_tambahan">@if(!empty($data)){{$data->catatan_tambahan}}@endif</textarea>
      </div> -->
      
      <div class="col-md-6">
        <div class="form-check" style="padding-left: 2em !important;">
        <label for="jenis_surat_id" class="form-label">&nbsp</label>

          <input class="form-check-input" checked name="sampai_bkpsdm" @if (!empty($data)) {{ ($data->sampai_bkpsdm ?? 'N') == 'Y' ? 'checked' : ''}} @endif value="Y" type="checkbox" style="transform: scale(2.0);" value="" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault" style="padding-left: 1em;">Dispo</label>
        </div>
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
  $('.instansi').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
      tags: true,
    });
    $('.jenis_surat').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        tags: true,
      });
      $('.sifat_surat').select2({
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
          tags: true,
        });
})();

$('.btn-cancel').click(function(e){
  e.preventDefault();
  $('.panel-form').animateCss('bounceOutDown');
  $('.other-page').fadeOut(function(){
    $('.other-page').empty();
    $('.main-page').fadeIn();
    // $('#datagrid').DataTable().ajax.reload();
  });
});

$('.btn-submit').click(function(e){
 e.preventDefault();
    // $('.btn-submit').html('Please wait...').attr('disabled', true);
    $('.btn-submit');
    var data  = new FormData($('.form-save')[0]);
    $.ajax({
        url: "{{ route('store-surat-masuk') }}",
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

$('#nomor_surat_masuk').keyup(function(){
  let no = this.value;
  const myArray = no.split("/");
  if (myArray[0] != null) {
    if (myArray[0].length >2) {
      $.post("{!! route('getJenisSurat') !!}", {
        id: myArray[0]
      }).done(function(data) {
        if (data != null) {
          console.log(data);
          var ins = '<option selected value="' + data.id_mst_jenis_surat + '">' + data.kode_jenis_surat + ' - ' + data.nama_jenis_surat +'</option>';
          // $.each(data, function(k, v) {
          //     ins += '<option value="' + v.id_instansi + '">' + v.nama_instansi +'</option>';
          // });

          $('.jenis_surat').html(ins);
          $('.jenis_surat').removeAttr('disabled');
          $('.jenis_surat').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
          });
        }else {
          var ins = '<option>- Jenis Surat Tidak Ditemukan! -</option>';
        }
      });
    }
  }
  if (myArray[2] != null) {
    if (myArray[2].length >2) {
      $.post("{!! route('getInstansi') !!}", {
        id: myArray[2]
      }).done(function(data) {
        if (data.length > 0) {
          var ins = '<option>- Pilih Instansi -</option>';
          $.each(data, function(k, v) {
            ins += '<option selected value="' + v.id_instansi + '">' + v.nama_instansi +
            '</option>';
          });

          $('.instansi').html(ins);
          $('.instansi').removeAttr('disabled');
          $('.instansi').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
          });
        }else {
          var ins = '<option>- Instansi Tidak Ditemukan! -</option>';
        }
      });
    }
  }
});
</script>
