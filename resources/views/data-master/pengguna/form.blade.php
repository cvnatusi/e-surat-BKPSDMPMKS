<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">@if($dataasn) Edit @else Tambah @endif Pengguna</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
      @endif
      <div class="col-md-6">
        <label for="asn_id" id="label_tujuan_surat" class="form-label">Pilih ASN *</label>
        <select class="form-select select-asn" name="asn" id="asn_id">
        <option value="" selected disabled>Pilih ASN</option>
            @if (!empty($data_asn))
              @foreach ($data_asn as $asn)
                <option value="{{$asn->id_mst_asn}}"  @if(!empty($dataasn)) @if ($dataasn->id_mst_asn == $asn->id_mst_asn) selected="selected" @endif @endif>{{$asn->nama_asn}}</option>
              @endforeach
            @endif
        </select>
      </div>
      <div class="col-md-6">
        <label for="level_user" class="form-label">Level User *</label>
        <select class="form-select select-level-user" name="level_user" id="level_user" onchange="lvUser()">
        <option value="">Pilih Level Pengguna</option>
          {{-- <option value="0" @if (!empty($data)) @if ($data->level_user == '0') selected @endif @endif>SEKRETARIS DAERAH (SEKDA)</option>
          <option value="1" @if (!empty($data)) @if ($data->level_user == '1') selected @endif @endif>ADMIN</option>
          <option value="2" @if (!empty($data)) @if ($data->level_user == '2') selected @endif @endif>KABAN</option>
          <option value="3" @if (!empty($data)) @if ($data->level_user == '3') selected @endif @endif>SEKRETARIS</option>
          <option value="4" @if (!empty($data)) @if ($data->level_user == '4') selected @endif @endif>KABID</option>
          <option value="5" @if (!empty($data)) @if ($data->level_user == '5') selected @endif @endif>OPERATOR SURAT</option> --}}
          @foreach ($level_pengguna as $role)
            <option value="{{$role->level_user}}" {{ ($data == $role->level_role ? 'selected' : '') }} >{{$role->singkatan}}</option>
          @endforeach

            {{-- @if (!empty($tanda_tangan))
              @foreach ($tanda_tangan as $ttd)
                <option value="{{$ttd->id_mst_asn}}"  @if(!empty($data)) @if ($data->yang_bertanda_tangan_asn_id == $ttd->id_mst_asn) selected="selected" @endif @endif>{{$ttd->nama_asn}}</option>
              @endforeach
            @endif --}}
        </select>
      </div>
      <div class="col-md-6">
        <label for="tanda_tangan" class="form-label">NIK</label>
        <input class="form-control" type="number" id="nik" name="nik" placeholder="Masukkan NIK" @if($dataasn) value="{{$dataasn->nip}}" @else value="" @endif>
      </div>
      <div class="col-md-6 inputTtd">
        <label for="tanda_tangan" class="form-label">Upload Tanda Tangan</label>
        <input class="form-control" type="file" id="tanda_tangan" accept="image/png" name="tanda_tangan">
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
  $('.select-level-user').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
  });
  $('.inputTtd').hide()
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
        url: "{{ route('store-pengguna') }}",
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

$(".select-asn").select2(
  {
    theme: 'bootstrap4',
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
    // tags: true,
    ajax: {
      url: "{{route('getAsnByName')}}",
      dataType: 'json',
      type: "POST",
      // delay: 250,
      data: function (params) {
        return {
          id: params.term
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (item) {
            return {
              id: item.id_mst_asn,
              text: item.nama_asn,
            }
          })
        };
      }
    },
});

function lvUser() {
  var lv_user = $('#level_user').find(":selected").val();
  if(lv_user=='0' || lv_user=='2'){
    $('.inputTtd').show()
  }else{
    $('.inputTtd').hide()
  }
}
</script>
