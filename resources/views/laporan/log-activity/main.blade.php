
@extends('component.app')
@section('css')

@endsection
@section('content')
  <h6 class="mb-0 text-uppercase">{{$data['title']}}</h6>
  <hr>
  <div class="card main-page">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            <td>NO</td>
            <td>NAMA USER</td>
            <td>TANGGAL / WAKTU</td>
            <td>LOG TYPE</td>
            <td>TABLE NAME</td>
            <td>ACTION</td>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-page"></div>
  <div class="other-page"></div>
@endsection
@section('js')
  <script type="text/javascript">
  $(function() {
    var table = $('#datagrid').DataTable({
      processing: true,
      serverSide: true,
      language: {
        searchPlaceholder: "Ketikkan yang dicari"
      },
      ajax: "{{ route('log-activity') }}",

      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'pengguna',
        name: 'pengguna',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'log_date',
        name: 'log_date',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'log_type',
        name: 'log_type',
        render: function(data, type, row) {
          if (data == 'create') {
            return '<span class="badge bg-primary">' + data + '</span>';
          }else if (data == 'edit') {
            return '<span class="badge bg-secondary">' + data + '</span>';
          }else if (data == 'delete') {
            return '<span class="badge bg-danger">' + data + '</span>';
          }else if (data == 'login') {
            return '<span class="badge bg-info">' + data + '</span>';
          }
        }
      },
      {
        data: 'table_name',
        name: 'table_name',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'action',
        name: 'action',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      ]
    });
  });

  $('.btn-add').click(function(){
      // $('.preloader').show();
      $('.main-page').hide();
      $.post("{!! route('form-asn') !!}").done(function(data){
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
      $.post("{!! route('form-asn') !!}",{id:id}).done(function(data){
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
         $.post("{!! route('destroy-asn') !!}",{id:id}).done(function(data){
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


   function showForm(id) {
     // $('.main-page').hide();
     // kosong();
       $.post("{!! route('show-log-activity') !!}",{id:id}).done(function(data){
           if(data.status == 'success'){
             $('.modal-page').html(data.content).fadeIn();
           } else {
             $('.main-page').show();
           }
       });
    }
</script>
@endsection
