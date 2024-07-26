
@extends('component.app')
@section('css')

@endsection
@section('content')
  <h6 class="mb-0 text-uppercase">{{$data['title']}}</h6>
  <hr>
  <div class="card main-page">
    <div class="card-body">
      <div class="col-md-12" style="margin-bottom: 20px;">
        <div class="row">
            <div class="col-md-2">
                <label class="form-label">Tambah SK</label>
                <button type="button" class="btn btn-primary btn-add form-control"><i
                        class="bx bx-plus me-1"></i>Surat Baru</button>
            </div>
            <div class="col-md-2" id="delete_all" style="display: none">
              <label class="form-label">Hapus Semua Surat</label>
              <button type="button" class="btn btn-danger form-control" onclick="deleteAll()"><i
                      class="bx bx-trash me-1"></i>Hapus</button>
            </div>
            <div class="col-md-4" id="span"></div>
            <div class="col-md-3 mb-3 panelTanggal">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" id="min" class="form-control datepickertanggal" value="{{date('Y-m-01')}}">
            </div>
            <div class="col-md-3 mb-3 panelTanggal">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" id="max" class="form-control datepickertanggal" value="{{date('Y-m-t')}}">
            </div>

        </div>
        <hr>
    </div>
      <div class="table-responsive">
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            <td><input type="checkbox" id="check_" onchange="checkAll()" class="form-check-input"></td>
            <td>NO</td>
            <td>NO SURAT</td>
            <td style="width: 100%">PERIHAL</td>
            <td>TANGGAL SURAT</td>
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
  <script src="{{asset('assets/js/number_format.js')}}"></script>
  <script type="text/javascript">
        let listCheked = [];
        var arrSuratId = [];
        function showDeleteAll() {
          if (arrSuratId.length >= 1) {
            $('#delete_all').css('display', 'block');
            $('#span').removeClass('col-md-4').addClass('col-md-2');
          } else {
            $('#delete_all').css('display', 'none');
            $('#span').removeClass('col-md-2').addClass('col-md-4');
          }
        }

        function checkedRow(ini) {
            var statusChecked = $(ini).is(":checked");
            console.log($(ini).is(":checked"));
            if(statusChecked) {
                arrSuratId.push(parseInt($(ini).val()));
            } else {
                let index = arrSuratId.indexOf($(ini).val());
                arrSuratId.splice(index, 1);
            }
            // console.log(listCheked);
            showDeleteAll();
        }

        function checkAll() {
            if ($('#check_').prop('checked')) {
                arrSuratId = [];
                $('.row_surat').each(function(i, v) {
                    arrSuratId.push($(v).data('id'));
                });
                $('.row_surat').prop('checked', true);
                $.post("{!! route('get-id-surat-keputusan') !!}", {
                    arrSuratId: arrSuratId,
                    _token: '{{ csrf_token() }}'
                }).done(function(data) {
                    listCheked = data;
                    console.log(listCheked);
                    showDeleteAll();
                });
            } else {
                $('.row_surat').prop('checked', false);
                arrSuratId = [];
                listCheked = [];
                showDeleteAll();
            }
        }

        // function checkAll() {
        //     if($('#check_').prop('checked')) {
        //         $.post("{!! route('get-id-surat-keputusan') !!}", {
        //             // id: id
        //         }).done(function(data) {
        //             listCheked = [];
        //             listCheked = data;
        //             listCheked.forEach(element => {
        //                 $('#check_' + element).prop('checked', true);
        //             });
        //             showDeleteAll();
        //             // console.log(data);
        //         })
        //     } else {
        //       listCheked.forEach(element => {
        //           $('#check_' + element).prop('checked', false);
        //       });
        //       listCheked = [];
        //       showDeleteAll();
        //       // console.log('false');
        //     }
        // }

        function deleteAll() {
          swal({
            title: "Apakah Anda yakin akan menghapus data ini ?",
            text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Hapus Data!',
          }).then((result) => {
            if (result.value) {
              $.post("{!! route('delete-all-surat-keputusan') !!}",{listId: arrSuratId}).done(function(data){
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
        }

    $('#min').change(() => {
    var start = $('#min').val()
    var end = $('#max').val()
    loadTable(start, end);
  })
  $('#max').change(() => {
      var start = $('#min').val()
      var end = $('#max').val()
      loadTable(start, end);
  })

  $(document).ready(function() {
      var start = $('#min').val()
      var end = $('#max').val()
      loadTable(start, end);
      //initial run
      // loadTable(start, end);
  });
  function loadTable(dateStart, dateEnd){
    var table = $('#datagrid').DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      "pageLength": 25,
      scrollX: true,
      scrollY: 350,
      language: {
        searchPlaceholder: "Ketikkan yang dicari"
      },
      // ajax: "{{ route('utama-surat-keputusan') }}",
      ajax: {
        url: "{{ route('utama-surat-keputusan') }}",
        type: 'get',
        data: {
            tglAwal: dateStart,
            tglAkhir: dateEnd
        }
    },
      columns: [
      {
        data: 'check',
        name: 'check',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
            if(listCheked.includes(row.id_surat_keputusan)) {
                return `<input class="form-check-input select-checkbox row_surat" onchange="checkedRow(this)" data-id="${row.id_surat_keputusan}" id="check_${row.id_surat_keputusan}" name="check" value="${row.id_surat_keputusan}" type="checkbox" checked></a>`;
            } else {
                return data;
            }
        }
      },
      {
        data: 'DT_RowIndex',
        name: 'DT_RowIndex',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'nomor_surat_keputusan',
        name: 'nomor_surat_keputusan',
        render: function(data, type, row) {
          return '<button type="button" class="btn btn-sm btn-info">' + data + '</button>'
          // return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'perihal',
        name: 'perihal',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'tanggalSurat',
        name: 'tanggalSurat',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
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
      $.post("{!! route('form-surat-keputusan') !!}").done(function(data){
          if(data.status == 'success'){
              // $('.preloader').hide();
              $('.other-page').html(data.content).fadeIn();
          } else {
              $('.main-page').show();
          }
      });
  });
  function showForm(id) {
    // $('.main-page').hide();
      $.post("{!! route('show-surat-keputusan') !!}",{id:id}).done(function(data){
          if(data.status == 'success'){
            $('.modal-page').html(data.content).fadeIn();
          } else {
            $('.main-page').show();
          }
      });
   }
  function editForm(id) {
    $('.main-page').hide();
      $.post("{!! route('form-surat-keputusan') !!}",{id:id}).done(function(data){
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
         $.post("{!! route('destroy-surat-keputusan') !!}",{id:id}).done(function(data){
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
</script>
@endsection
