<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif Surat BAST</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_surat_bast}}">
      @endif
      {{-- <div class="col-md-6">
        <label for="nomor_surat_bast" class="form-label">Nomor Surat (Ketik tanpa menggunakan spasi)</label>
        <input type="text" class="form-control" style="#" name="nomor_surat_bast" id="nomor_surat_bast" @if(!empty($data)) value="{{$data->nomor_surat_bast}}" @endif>
      </div> --}}
      <div class="col-md-6">
        <label for="penyedia_jasa" class="form-label">Penyedia Jasa *</label>
        {{-- <select class="form-select instansi" name="penyedia_jasa" id="penyedia_jasa">
          <option value="">Pilih Instansi</option>
          @if (!empty($instansi))
            @foreach ($instansi as $inst)
              <option value="{{$inst->id_instansi}}" @if(!empty($data)) @if ($data->penyedia_jasa == $inst->id_instansi) selected="selected" @endif @endif>{{$inst->nama_instansi}}</option>
            @endforeach
          @endif
        </select> --}}
        <input type="text" class="form-control" style="#" name="penyedia_jasa" id="penyedia_jasa" @if(!empty($data)) value="{{$data->penyedia_jasa}}" @endif placeholder="Penyedia Jasa">
      </div>
      <div class="col-md-6">
        <label for="jenis_pekerjaan" class="form-label">Jenis Pekerjaan *</label>
        <input type="text" class="form-control" style="#"  name="jenis_pekerjaan" id="jenis_pekerjaan" @if(!empty($data)) value="{{$data->jenis_pekerjaan}}" @endif placeholder="Jenis Pekerjaan">
      </div>
      <div class="col-md-12">
        <label for="kegiatan" class="form-label">Kegiatan *</label>
          <textarea rows="3" cols="80" class="form-control" name="kegiatan" id="kegiatan" placeholder="Tuliskan keterangan / kegiatan">@if(!empty($data)){{$data->kegiatan}}@endif</textarea>
      </div>
      <div class="col-md-4">
        <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
        <input type="date" @if(!empty($data)) value="{{date('Y-m-d',strtotime($data->tanggal_surat))}}" @else value="{{date('Y-m-d')}}" @endif class="form-control tanggal_surat" name="tanggal_surat" id="tanggal_surat">
      </div>
      <div class="col-md-4">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" @if(!empty($data)) value="{{$data->jumlah}}" @else value="" @endif class="form-control jumlah" name="jumlah" id="jumlah" placeholder="Rp">
      </div>
      <div class="col-md-4">
        <label for="file_scan" class="form-label">Upload Scan / Foto Surat</label>
        <input class="form-control" type="file" id="file_scan" name="file_scan">
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
        url: "{{ route('store-surat-bast') }}",
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

// $('#nomor_surat_bast').keyup(function(){
//   let no = this.value;
//   const myArray = no.split("/");
//   if (myArray[1] != null) {
//     if (myArray[1].length >2) {
//       $.post("{!! route('getJenisSurat') !!}", {
//         id: myArray[1]
//       }).done(function(data) {
//         if (data != null) {
//           console.log(data);
//           var ins = '<option selected value="' + data.id_mst_jenis_surat + '">' + data.kode_jenis_surat + ' - ' + data.nama_jenis_surat +'</option>';
//           // $.each(data, function(k, v) {
//           //     ins += '<option value="' + v.id_instansi + '">' + v.nama_instansi +'</option>';
//           // });
//
//           $('.jenis_surat').html(ins);
//           $('.jenis_surat').removeAttr('disabled');
//           $('.jenis_surat').select2({
//             theme: 'bootstrap4',
//             width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
//             placeholder: $(this).data('placeholder'),
//             allowClear: Boolean($(this).data('allow-clear')),
//           });
//         }else {
//           var ins = '<option>- Jenis Surat Tidak Ditemukan! -</option>';
//         }
//       });
//     }
//   }
//   if (myArray[2] != null) {
//     if (myArray[2].length >2) {
//       $.post("@{!! route('getInstansi') !!}", {
//         id: myArray[2]
//       }).done(function(data) {
//         if (data.length > 0) {
//           var ins = '<option>- Pilih Instansi -</option>';
//           $.each(data, function(k, v) {
//             ins += '<option selected value="' + v.id_instansi + '">' + v.nama_instansi +
//             '</option>';
//           });
//
//           $('.instansi').html(ins);
//           $('.instansi').removeAttr('disabled');
//           $('.instansi').select2({
//             theme: 'bootstrap4',
//             width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
//             placeholder: $(this).data('placeholder'),
//             allowClear: Boolean($(this).data('allow-clear')),
//           });
//         }else {
//           var ins = '<option>- Instansi Tidak Ditemukan! -</option>';
//         }
//       });
//     }
//   }
// });
</script>
