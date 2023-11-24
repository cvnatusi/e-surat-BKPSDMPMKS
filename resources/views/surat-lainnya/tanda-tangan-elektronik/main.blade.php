@extends('component.app')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
@endsection
@section('content')
  <h6 class="mb-0 text-uppercase">{{$data['title']}}</h6>
  <hr>
  <div class="card main-page">
    <div class="card-body">
      <div class="row">
        <div class="col-md-2 mb-3" >
          <label class="form-label">Tambah</label>
          <button type="button" class="btn btn-primary btn-add form-control"><i class="bx bx-plus me-1"></i>Tambah</button>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-3 mb-3">
          <label class="form-label">Pilih Opsi</label>
          <select class="form-control select2" id="rangeBy"  onchange="change(this)" selected name="rangeBy">
            <option selected value="tanggal">Tanggal</option>
            <option value="bulan">Bulan</option>
            <option value="tahun">Tahun</option>
          </select>
        </div>
        <div class="col-md-3 mb-3 panelTanggal">
          <label class="form-label">Tanggal</label>
          <input id="tanggal" type="date" class="form-control datepickertanggal" onchange="change(this)" value="{{ date('Y-m-d') }}" >
        </div>
        <div class="col-md-3 mb-3 panelBulan" style="display:none">
          <label class="form-label">Bulan</label>
          <input id="bulan" type="month" class="form-control datepickerbulan" onchange="change(this)" value="{{ date('Y-m') }}">
        </div>
        <div class="col-md-3 mb-3 panelTahun" style="display:none">
          <label class="form-label">Tahun</label>
          <input id="tahun" type="text" class="form-control datepickertahun" onchange="change(this)" readonly="readonly" >
        </div>
      </div>
    </div>
  </div>
  <div class="card main-page">
    <div class="card-body">
      <div class="table-responsive">
        <!-- <button type="button" class="btn btn-primary btn-add" style="width: 170px;"><i class="bx bx-plus me-1"></i>Tambah</button>
        <p></p> -->
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            <td>NO</td>
            <td>NAMA SURAT</td>
            <td>TANGGAL TTD</td>
            <td>PENANDA TANGAN</td>
            <td>VERIF SURAT</td>
            <td>AKSI</td>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-page"></div>
  <div class="other-page"></div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script> 
  <script type="text/javascript">
  $(function() {
    load_data('tanggal',"{{date('Y-m-d')}}"); 
  });
  $(".datepickerbulan").flatpickr(
    {
      dateFormat: "Y-m",
      plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y-m", altFormat: "M Y"})],
      defaultDate: "{{date('Y-m')}}"
    }
  );
  $(".datepickertahun").flatpickr(
    {
      dateFormat: "Y",
      plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y", altFormat: "Y"})],
      defaultDate: "{{date('Y')}}"
    }
  );

  function load_data(rangeBy, date) { 
    var table = $('#datagrid').DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      language: {
        searchPlaceholder: "Ketikkan yang dicari"
      },
      ajax: {
				url:"{{ route('tanda-tangan-elektronik') }}",
				type: 'get',
				data: {
					date : date,
          range_by : rangeBy
				}
			},
      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'nama_surat',
        name: 'nama_surat',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'tanggal_surat',
        name: 'tanggal_surat',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        // data: 'users.name',
        // name: 'users.name',
        name: 'penanda_tangan.nama_asn',
        data: 'penanda_tangan.nama_asn',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'verifSurat',
        name: 'verifSurat',
        orderable: false,
        searchable: false
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      },
      ]
    });
  }

  $('.btn-add').click(function(){
      // $('.preloader').show();
      $('.main-page').hide();
      $.post("{!! route('form-tanda-tangan-elektronik') !!}").done(function(data){
          if(data.status == 'success'){
              // $('.preloader').hide();
              $('.other-page').html(data.content).fadeIn();
          } else {
              $('.main-page').show();
          }
      });
  });
  function editForm(id) {
    $('.main-page').hide();
      $.post("{!! route('form-tanda-tangan-elektronik') !!}",{id:id}).done(function(data){
          if(data.status == 'success'){
            $('.other-page').html(data.content).fadeIn();
          } else {
            $('.main-page').show();
          }
      });
   }
   function deleteForm(id) {
     swal({
       title: "Apakah Anda yakin akan menghapus data ini ?",
       text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
       type: "warning",
       showCancelButton: true,
       cancelButtonText: 'Batal',
       confirmButtonText: 'Ya, Hapus Data!',
     }).then((result) => {
       if (result.value) {
         $.post("{!! route('destroy-tanda-tangan-elektronik') !!}",{id:id}).done(function(data){
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
           $('.preloader').show();
           $('#datagrid').DataTable().ajax.reload();
           }).fail(function() {
             Lobibox.notify('error', {
               pauseDelayOnHover: true,
               size: 'mini',
               rounded: true,
               delayIndicator: false,
               icon: 'bx bx-x-circle',
               continueDelayOnInactiveTab: false,
               position: 'top right',
               sound:false,
               msg: "Data Gagal Dihapus, Silahkan Hubungi IT Anda!"
             });
           });
         }else if (result.dismiss === Swal.DismissReason.cancel) {
           Lobibox.notify('error', {
             pauseDelayOnHover: true,
             size: 'mini',
             rounded: true,
             delayIndicator: false,
             icon: 'bx bx-error',
             continueDelayOnInactiveTab: false,
             position: 'top right',
             sound:false,
             msg: "Data batal di hapus!"
           });
           $('#datagrid').DataTable().ajax.reload();
         }
       });
   };
   // function namaPenerima(row){
   //   let data = row.tujuan_surat_id
   //   const myArray = data.split(",");
   //   var arrDat = []
   //   if(myArray.length>0){
   //     // $.each(myArray,(i,v)=>{
   //     //   $.post("{!! route('getInstansiById') !!}",{id:v}).done(function(result){
   //     //     console.log(result.kode_instansi);
   //     //       if(result.status == 'success'){
   //     //         arrDat.push(result.kode_instansi)
   //     //       }
   //     //   });
   //     // })
   //     // // console.log(arrDat);
   //     // // return "<p style='color:black'>"+arrDat.join(', ')+"</p>"
   //     // return "<p style='color:black'>-</p>"
   //   }else{
   //     return "-"
   //   }
   // }
   function showSuratTugas(id) {
     // $('.main-page').hide();
     $.post("{!! route('list-surat-tugas') !!}",{id:id}).done(function(data){
       if(data.status == 'success'){
         $('.modal-page').html(data.content).fadeIn();
       } else {
         $('.main-page').show();
       }
     });
   }

   function show(id) {
     $.post("{!! route('show-tanda-tangan-elektronik') !!}",{id:id}).done(function(data){
       if(data.status == 'success'){
         $('.modal-page').html(data.content).fadeIn();
       } else {
         $('.main-page').show();
       }
     });
   }
   // Using the on() method
  function change(params) { 
    var rangeBy = $('#rangeBy').val();
    if (rangeBy == 'tanggal') {
      
      $('.panelTanggal').show();
      $('.panelBulan').hide();
      $('.panelTahun').hide();
      tanggal = $('#tanggal').val();
      load_data(rangeBy, tanggal);
    }else if(rangeBy == 'bulan'){
      $('.panelTanggal').hide();
      $('.panelBulan').show();
      $('.panelTahun').hide();
      bulan = $('#bulan').val();
      load_data(rangeBy, bulan);
    }else{
      $('.panelTanggal').hide();
      $('.panelBulan').hide();
      $('.panelTahun').show();
      tahun = $('#tahun').val();
      load_data(rangeBy, tahun);
    }
  }
// disini tambahkan pengecekan dia tte atau TTD
// semisal dia tte pakai format yang dibawah ini
// // // title: "Verifikasi TTE!",
// // // text: "Masukkan Passphrase :",
// // // input: 'password',
// semisal dia ttd tanpa memasukkan verif tte

   function verifSurat(id) {
    // console.log(ttd)
    // if(ttd){

      Swal.fire({
       title: "Verifikasi TTE!",
       text: "Masukkan Passphrase :",
       input: 'password',
      //  showCancelButton: true
     }).then((result) => {
       if (result.value) {
         // console.log("Result: " + result.value);
         $.post("{!! route('verifSurat') !!}", {
           async: false,
           beforeSend: function(){
             $('#'+id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
           },
           // complete: function(){
           //   $('.loader').hide();
           // }
           id: id,
           ps: result.value
         }).done(function(data){
           if (data.status == 'success') {
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
           }else {
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
           }
           $('.preloader').show();
           $('#datagrid').DataTable().ajax.reload();
         }).fail(function() {
           Lobibox.notify('error', {
             pauseDelayOnHover: true,
             size: 'mini',
             rounded: true,
             delayIndicator: false,
             icon: 'bx bx-x-circle',
             continueDelayOnInactiveTab: false,
             position: 'top right',
             sound:false,
             msg: "Data Gagal di Verifikasi, Silahkan Hubungi IT Anda!"
           });
         });
       }
     });

    // }else{

    //   $.post("{!! route('verifSurat') !!}", {
    //       //  async: false,
    //       //  beforeSend: function(){
    //       //    $('#'+id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
    //       //  },
    //       id: id,
    //        ttd: false
    //      }).done(function(data){
    //       console.log(data)
    //      })
    // }


   }
</script>
@endsection
