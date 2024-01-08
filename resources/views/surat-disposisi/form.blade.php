<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Tambah Surat Disposisi</h5>
    </div>
    <hr>
    <form class="row g-3 form-save">
      @if(!empty($data))
          <input type="hidden" class="form-control" name="id" value="{{$data->id_surat_disposisi}}">
      @endif
      <div class="col-md-4">
        <label for="surat_masuk_id" class="form-label">No. Agenda Surat / Berkas *)</label>
        {{-- <label for="surat_masuk_id" class="form-label">No. Agenda Surat / Berkas *)</label>
        <select class="form-select surat_masuk" name="surat_masuk_id" id="surat_masuk_id">
          <option value="">-- Pilih No Agenda --</option>
          @if (!empty($surat_masuk))
            @foreach ($surat_masuk as $sm)
              <option value="{{$sm->id_surat_masuk}}" @if(!empty($data)) @if ($data->surat_masuk_id == $sm->id_surat_masuk) selected="selected" @endif @endif>{{$sm->nomor_surat_masuk}} {{ $sm->perihal_surat }}</option>
            @endforeach
          @endif
        </select> --}}
        <input type="hidden" name="surat_masuk_id" id="surat_masuk_id">
        @if (Auth::user()->level_user == 2) 
          <input type="text" onchange="trigger_suratMasuk(this)" class="form-control" value="" id="nomor_agenda">
          {{-- <select class="form-select surat_masuk" onchange="trigger_suratMasuk(this)" name="surat_masuk_id" id="surat_masuk_id">
             <option value="">-- Pilih No Agenda --</option>
             @if (!empty($surat_masuk))
               @foreach ($surat_masuk as $sm)
                 <option value="" @if(!empty($data)) @if ($data->surat_masuk_id == $sm->id_surat_masuk) selected="selected" @endif @endif>{{$sm->nomor_surat_masuk}} {{ $sm->perihal_surat }}</option>
               @endforeach
             @endif
           </select> --}}
        @else 
          <select class="form-select surat_masuk" onchange="trigger_suratMasuk(this)" name="surat_masuk_id" id="surat_masuk_id">
             <option value="">-- Pilih No Agenda --</option>
             @if (!empty($surat_masuk))
               @foreach ($surat_masuk as $sm)
                 <option value="" @if(!empty($data)) @if ($data->surat_masuk_id == $sm->id_surat_masuk) selected="selected" @endif @endif>{{$sm->nomor_surat_masuk}} {{ $sm->perihal_surat }}</option>
               @endforeach
             @endif
           </select>
        @endif
      </div>
      <div class="col-md-4">
        <label for="" class="form-label">No Surat *)</label>
        <input type="text" class="form-control" readonly name="no_surat_masuk" id="no_surat_masuk" value="">
      </div>
      <div class="col-md-4">
        <label for="" class="form-label">Nama Pengirim *)</label>
        <input type="text" class="form-control" readonly name="nama_pengirim" id="nama_pengirim" value="">
      </div>
      <div class="col-md-12">
        <label for="" class="form-label">Isi Ringkas *)</label>
        <input type="text" class="form-control" readonly name="isi_ringkas" id="isi_ringkas" value="">
      </div>
      <div class="col-md-6">
        <label for="pemberi_disposisi_id" class="form-label">Pemberi Disposisi *)</label>
        <select class="form-select pemberi_disposisi" name="pemberi_disposisi_id" id="pemberi_disposisi_id">
        <option value="">-- Pilih Pemberi Disposisi --</option>
        {{-- <option value="{{$beri->id_mst_asn}}" @if(!empty($data)) @if ($data->pemberi_disposisi_id == $beri->id_mst_asn) selected="selected" @endif @endif>{{$beri->nama_asn}}</option> --}}
          @if (!empty($pemberi))
            @foreach ($pemberi as $beri)
              {{-- <option value="{{$beri->id_mst_asn}}" @if ($data->pemberi_disposisi_id == $beri->id_mst_asn) selected="selected" @endif>{{$beri->nama_asn}}</option> --}}
              {{-- <option value="{{ $beri->id_mst_asn }}" @if(Auth::user()->id == $beri->id_mst_asn) selected="selected" @endif>
                {{ $beri->nama_asn }}
            </option> --}}
            <option value="{{ $beri->id_mst_asn }}" @if(!empty($data) && Auth::user()->id == $beri->id_mst_asn) selected="selected" @endif>
                {{ $beri->nama_asn }}
            </option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-6">
        <label for="penerima_disposisi_id" class="form-label">Diteruskan kepada *)</label>
        <select class="form-select penerima_disposisi" name="penerima_disposisi_id" id="penerima_disposisi_id">
        <option value="">-- Pilih Diteruskan Kepada --</option>
          @if (!empty($penerima))
            @foreach ($penerima as $terima)
              <option value="{{$terima->id_mst_asn}}" @if(!empty($data)) @if ($data->penerima_disposisi_id == $terima->id_mst_asn) selected="selected" @endif @endif>{{$terima->nama_asn}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-md-12">
      <label for="dengan_harap" class="form-label">Dengan Hormat Harap *)</label>
      <br>

      <?php
      //Columns must be a factor of 12 (1,2,3,4,6,12)
      $numOfCols = 4;
      $rowCount = 0;
      $bootstrapColWidth = 12 / $numOfCols;
      foreach ($dengan_harap as $key){
        if (!empty($data->dengan_hormat_harap)){
            $dhh = explode(";",$data->dengan_hormat_harap);
        }
        if($rowCount % $numOfCols == 0) { ?> <div class="row"> <?php }
        $rowCount++; ?>
        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="dengan_harap[]" @if (!empty($data->dengan_hormat_harap)) @foreach ($dhh as $dt) @if ($dt == $key->id_mst_dengan_harap) checked @endif @endforeach @endif value="{{$key->id_mst_dengan_harap}}" id="dengan_harap_{{$key->id_mst_dengan_harap}}">
            <label class="form-check-label" for="dengan_harap_{{$key->id_mst_dengan_harap}}">{{$key->nama_dengan_harap}}</label>
          </div>
        </div>
        <?php
        if($rowCount % $numOfCols == 0) { ?> </div> <?php } } ?>
      </div>
      <div class="col-md-12">
        <label for="catatan_disposisi" class="form-label">Catatan Disposisi</label>
          <textarea rows="2" cols="80" class="form-control" placeholder="Ketikkan catatan penting" name="catatan_disposisi" id="catatan_disposisi">@if(!empty($data)){{$data->catatan_disposisi}}@endif</textarea>
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
  $('.surat_masuk').select2({ 
      // $('#surat_masuk_id').
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
      tags: true,
    });
    $('.pemberi_disposisi').select2({
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
      tags: true,
    });
    $('.penerima_disposisi').select2({
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
        url: "{{ route('store-surat-disposisi') }}",
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

// $("#surat_masuk_id").select2(
//   {
//     theme: 'bootstrap4',
//     width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
//     placeholder: $(this).data('placeholder'),
//     allowClear: Boolean($(this).data('allow-clear')),
//     tags: true,
//     ajax: {
//       url: "{{route('getSuratMasukByAgenda')}}",
//       dataType: 'json',
//       type: "POST",
//       // delay: 250,
//       data: function (params) {
//         return {
//           id: params.term
//         };
//       },
//       processResults: function (data) {
//         return {
//           results: $.map(data, function (item) {
//             return {
//               id: item.id_surat_masuk,
//               text: item.nomor_surat_masuk,
//             }
//           })
//         };
//       }
//     },
//   });
  var pemberi = "{{Auth::user()->level_user}}";
// 1	Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten  Pamekasan
// 2	Sekretaris Badan Kepegawaian dan Pengembangan Sumber Daya Manusia
// 3	Kasubbag Perencanaan , Umum dan Kepegawaian
// 4	Kasubbag keuangan dan Aset
// 5	Kepala Bidang Mutasi dan Promosi
// 6	Kepala Bidang Pengembangan Aparatur
// 7	Kepala Bidang Pengadaan, Pembinaan dan Informasi Kepegawaian
// 8	Analis SDM Aparatur Muda
// 9	Kepala Sub Bidang Pengadaan dan Pemberhentian
// 10	Analis Kepegawaian Ahli Pertama
// 11	Staf
  if (pemberi == 1 || pemberi == 2|| pemberi == 5) {
    var pem = 2;
    var pen = 3;
  }else if (pemberi == 3) {
    var pem = 3;
    var pen = 4;
  }else if (pemberi == 4) {
    var pem = 4;
    var pen = 5;
  }
  $(".pemberi_disposisi").select2(
    {
      theme: 'bootstrap4',
      width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
      placeholder: $(this).data('placeholder'),
      allowClear: Boolean($(this).data('allow-clear')),
      // tags: true,
      ajax: {
        url: "{{route('getAsnByLevel')}}",
        // url: "{{route('getAsnByKategori')}}",
        dataType: 'json',
        type: "POST",
        // delay: 250,
        data: function (params) {
          return {
            id: pem
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
    $(".penerima_disposisi").select2(
      {
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        // tags: true,
        ajax: {
          url: "{{route('getAsnByLevel')}}",
          // url: "{{route('getAsnByKategori')}}",
          dataType: 'json',
          type: "POST",
          // delay: 250,
          data: function (params) {
            return {
              id: pen
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

      function trigger_suratMasuk(ini) {
        // let id = $(ini).find(':selected').val();
        let id = $(ini).val();
        getSuratMasuk(id);
      }

      function getSuratMasuk(id) {
        $.ajax({
          type: 'GET',
          url: "{{ route('get-surat-masuk') }}",
          data: {
                id: id,
                _token: '{{ csrf_token() }}' 
            },
          success: function(data){
            if (data && data.data && data.data.surat_masuk) {
                $('#no_surat_masuk').val(data.data.surat_masuk.nomor_surat_masuk);
                $('#nama_pengirim').val(data.data.surat_masuk.pengirim.nama_instansi);
                $('#isi_ringkas').val(data.data.surat_masuk.isi_ringkas_surat);
            } else {
                $('#no_surat_masuk').val('undefined');
                $('#nama_pengirim').val('undefined');
                $('#isi_ringkas').val('undefined');
            }
          }
        })
      }

$(document).ready(function () {
    const getQueryString = window.location.search;
    const urlParams = new URLSearchParams(getQueryString);
    const idSurat = urlParams.get('idsurat')
    $('#surat_masuk_id').val(idSurat);
    const noSurat = urlParams.get('nosurat')
    $('#nomor_agenda').val(noSurat);
    const noSuratMasuk = urlParams.get('nosuratmasuk')
    $('#no_surat_masuk').val(noSuratMasuk);
    const namaPengirim = urlParams.get('namapengirim');
    $('#nama_pengirim').val(namaPengirim);
    const isiRingkas = urlParams.get('isiringkas');
    $('#isi_ringkas').val(isiRingkas);
})
</script>
