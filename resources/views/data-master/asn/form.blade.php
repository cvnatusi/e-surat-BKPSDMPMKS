<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif ASN</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_mst_asn}}">
      @endif
      <div class="col-md-6">
        <label for="nama_asn" class="form-label">Nama ASN *)</label>
        <input type="text" class="form-control" name="nama_asn" id="nama_asn" @if(!empty($data)) value="{{$data->nama_asn}}" @endif placeholder="Nama ASN">
      </div>
      <div class="col-md-6">
        <label for="nip" class="form-label">NIP *)</label>
        <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "18" name="nip" id="nip" @if(!empty($data)) value="{{$data->nip}}" @endif placeholder="NIP">
      </div>
      <div class="col-md-6">
        <label for="jabatan" class="form-label">JABATAN *)</label>
        <select class="form-select jabatan" name="jabatan_id" id="jabatan_id">
          <option value="">-- Pilih Jabatan --</option>
          @if (!empty($jabatan))
            @foreach ($jabatan as $jab)
              <option value="{{$jab->id_mst_jabatan}}" @if(!empty($data)) @if ($data->jabatan == $jab->id_mst_jabatan) selected="selected" @endif @endif>{{$jab->nama_jabatan}}</option>
            @endforeach
          @endif
        </select>
        {{-- <input type="text" class="form-control" name="jabatan" id="jabatan" @if(!empty($data)) value="{{$data->jabatan}}" @endif> --}}
      </div>
      <div class="col-md-6">
        <label for="pangkat_golongan" class="form-label">PANGKAT / GOLONGAN *)</label>
        <input type="text" class="form-control" name="pangkat_golongan" id="pangkat_golongan" @if(!empty($data)) value="{{$data->pangkat_golongan}}" @endif placeholder="Pangkat / Golongan">
      </div>
      <div class="col-md-6">
        <label for="eselon" class="form-label">Eselon</label>
        <input type="text" class="form-control" name="eselon" id="eselon" @if(!empty($data)) value="{{$data->eselon}}" @endif placeholder="Eselon">
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
  $('.jabatan').select2({
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
    $('#datagrid').DataTable().ajax.reload();
  });
});

$('.btn-submit').click(function(e){
 e.preventDefault();
    // $('.btn-submit').html('Please wait...').attr('disabled', true);
    $('.btn-submit');
    var data  = new FormData($('.form-save')[0]);
    $.ajax({
        url: "{{ route('store-asn') }}",
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
