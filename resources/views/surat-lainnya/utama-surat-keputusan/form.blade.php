<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif Surat Keputusan</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_surat_keputusan}}">
      @endif

      <div class="col-md-6">
        <label for="perihal" class="form-label">Perihal</label>
        <input type="text" @if(!empty($data))  style="#"  value="{{$data->perihal}}" @else value="" @endif class="form-control perihal" name="perihal" id="perihal" placeholder="Perihal">
      </div>
      <div class="col-md-6">
        <label for="tujuan" class="form-label">Tujuan</label>
        <input type="text" class="form-control" style="#" name="tujuan" id="tujuan" @if(!empty($data)) value="{{$data->tujuan}}" @endif  placeholder="Tujuan">
      </div>
      <div class="col-md-12">
          <div class="form-check">
              <input class="form-check-input" type="checkbox" name="chkSisipkanSurat"
                  @if (!empty($data)) @if ($data->surat_manual == 'Y') checked @endif
                  @endif value="Y" id="chkSisipkanSurat" >
              <label class="form-check-label" for="chkSisipkanSurat">Sisipkan Surat?</label>
          </div>
      </div>
      <div class="col-md-6">
        <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
        <input type="date" @if(!empty($data)) value="{{date('Y-m-d',strtotime($data->tanggal_surat))}}" @else value="{{date('Y-m-d')}}" @endif class="form-control tanggal_surat" name="tanggal_surat" id="tanggal_surat">
      </div>

      <div class="col-md-6">
        <label for="file_scan" class="form-label">Upload Scan / Foto Surat</label>
        <input class="form-control" type="file" id="file_scan" name="file_scan">
      </div>
      <div class="col-md-12 panelSuratKeluar" style="display:none">
        <label for="jenis_pekerjaan" class="form-label">Pilih Surat Keluar *</label>
        <select class="form-select suratKeluar" name="surat_keputusan" id="surat_keputusan">
          {{-- <option value="">Pilih Instansi</option>
          @if (!empty($instansi))
            @foreach ($instansi as $inst)
              <option value="{{$inst->id_instansi}}" @if(!empty($data)) @if ($data->penyedia_jasa == $inst->id_instansi) selected="selected" @endif @endif>{{$inst->nama_instansi}}</option>
            @endforeach
          @endif --}}
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
        url: "{{ route('store-surat-keputusan') }}",
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
    }).fail(function() {
      $('.btn-submit').html('Simpan <i class="fa fa-save fs-14 m-l-5"></i>').removeAttr('disabled');
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

// $('#nomor_surat_keputusan').keyup(function(){
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
// $("#tanggal_surat").change(function(){
//   var tanggal = $('.tanggal_surat').val();
//   var today = new Date();
//   var dd = String(today.getDate()).padStart(2, '0');
//   var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
//   var yyyy = today.getFullYear();
//   today = yyyy + '-' + mm + '-' + dd;
//   if (tanggal < today) {
//     $('.panelSuratKeluar').show();
//     $.post("{!! route('getSuratSKByDate') !!}", {
//       tanggal: tanggal
//     }).done(function(data) {
//       if (data.length > 0) {
//         var ins = '<option>- Pilih Surat Keluar -</option>';
//         $.each(data, function(k, v) {
//           ins += '<option value="' + v.id_surat_keputusan + '">' + v.nomor_surat_keputusan + '</option>';
//         });
//
//         $('.suratKeluar').html(ins);
//         $('.suratKeluar').removeAttr('disabled');
//         $('.suratKeluar').select2({
//           theme: 'bootstrap4',
//           width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
//           placeholder: $(this).data('placeholder'),
//           allowClear: Boolean($(this).data('allow-clear')),
//         });
//       }else {
//         var ins = '<option>- Surat Keluar Tidak Ditemukan! -</option>';
//       }
//     });
//     // $.post("{!! route('checkSuratKeluarByDate') !!}", {
//     //   tanggal: tanggal
//     // }).done(function(data) {
//     //
//     // });
//   }else {
//     $('.panelSuratKeluar').hide();
//
//   }
// });
$("#chkSisipkanSurat").change(function(){
  if (this.checked) {
    $('.panelSuratKeluar').show();
      $("#tanggal_surat").change(function(){
        var tanggal = $('.tanggal_surat').val();
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
         today = yyyy + '-' + mm + '-' + dd;
         $.post("{!! route('getSuratSKByDate') !!}", {
           tanggal: tanggal
         }).done(function(data) {
           if (data.length > 0) {
             var ins = '<option>- Pilih Surat Keluar -</option>';
             $.each(data, function(k, v) {
               ins += '<option value="' + v.id_surat_keputusan + '">' + v.nomor_surat_keputusan + '</option>';
             });

             $('.suratKeluar').html(ins);
             $('.suratKeluar').removeAttr('disabled');
             $('.suratKeluar').select2({
               theme: 'bootstrap4',
               width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
               placeholder: $(this).data('placeholder'),
               allowClear: Boolean($(this).data('allow-clear')),
             });
           }else {
             var ins = '<option>- Surat Keluar Tidak Ditemukan! -</option>';
           }
         });
      });
  }else {
    $('.panelSuratKeluar').hide();
  }
});
</script>
