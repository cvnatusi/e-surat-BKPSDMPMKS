
@extends('component.app')
@section('css')

@endsection
@section('content')
  <h6 class="mb-0 text-uppercase">{{$data['title']}}</h6>
  <hr>
  <div class="card main-page">
    <div class="card-body">
      <div class="table-responsive">
        <button type="button" class="btn btn-primary px-5 mb-1 btn-add"><i class="bx bx-plus me-1"></i>Tambah</button>
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            <td>NO</td>
            <td>NAMA ROLE</td>
            {{-- <td>NAMA JENIS SURAT</td> --}}
            {{-- <td>MASUK / KELUAR</td> --}}
            <td>AKSI</td>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal"></div>
  <div class="other-page"></div>
@endsection
@section('js')
  <script type="text/javascript">
  $(function() {
    var table = $('#datagrid').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('role-permission') }}",

      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'name',
        name: 'name',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      // {
      //   data: 'nama_jenis_surat',
      //   name: 'nama_jenis_surat',
      //   render: function(data, type, row) {
      //     return '<p style="color:black">' + data + '</p>';
      //   }
      // },
      // {
      //   data: 'klasifikasi_jenis_surat',
      //   name: 'klasifikasi_jenis_surat',
      //   render: function(data, type, row) {
      //     return '<p style="color:black">' + data + '</p>';
      //   }
      // },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      },
      ]
    });
  });

  $('.btn-add').click(function(){
      // $('.preloader').show();
      $('.main-page').hide();
      $.post("{!! route('form-role-permission') !!}").done(function(data){
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
      $.post("{!! route('form-role-permission') !!}",{id:id}).done(function(data){
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
         $.post("{{route('destroy-role-permission')}}",{id:id}).done(function(data){
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
          } else {
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
</script>
@endsection
