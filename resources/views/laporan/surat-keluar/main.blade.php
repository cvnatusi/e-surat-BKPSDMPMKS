
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
        {{-- <div class="col-md-3 mb-3">
          <label class="form-label">Pilih Opsi</label>
          <select class="form-control select2" id="rangeBy"  onchange="change(this)" selected name="rangeBy">
            <option selected value="tanggal">Tanggal</option>
            <option value="bulan">Bulan</option>
            <option value="tahun">Tahun</option>
          </select>
        </div>
        <div class="col-md-3 mb-3 panelTanggal">
          <label class="form-label">Tanggal</label>
          <input type="text" class="form-control datepickertanggal" onchange="change(this)" readonly="readonly">
        </div>
        <div class="col-md-3 mb-3 panelBulan" style="display:none">
          <label class="form-label">Bulan</label>
          <input type="text" class="form-control datepickerbulan" onchange="change(this)" readonly="readonly">
        </div>
        <div class="col-md-3 mb-3 panelTahun" style="display:none">
          <label class="form-label">Tahun</label>
          <input type="text" class="form-control datepickertahun" onchange="change(this)" readonly="readonly">
        </div> --}}
        {{-- <div class="col-md-4"></div> --}}
        <div class="col-md-2 mb-3" >
          <label class="form-label">Export</label>
          <button type="button" onclick="CetakExcel()" class="btn btn-info cetakExcel form-control" style="color: white">
            <i class="bx bx-spreadsheet mr-1"></i>to Excel
          </button>
        </div>
        <div class="col-md-4"></div>
          <div class="col-md-3 mb-3 panelTanggal">
            <label class="form-label">Tanggal Awal</label>
            <input type="date" id="min" onchange="change(this)" class="form-control datepickertanggalawal">
          </div>
          <div class="col-md-3 mb-3 panelTanggal">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" id="max" onchange="change(this)" class="form-control datepickertanggalakhir">
          </div>
      </div>
    </div>
  </div>
  <div class="card main-page">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            <td>NO AGENDA</td>
            <td>NO SURAT</td>
            <td>JENIS SURAT</td>
            <td>TANGGAL SURAT</td>
            <td style="width: 100%">TUJUAN</td>
            <td>PERIHAL</td>
            {{-- <td>VERIF KABAN</td> --}}
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal"></div>
  <div class="other-page"></div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
  <script type="text/javascript">
//   $( document ).ready(function() {
// });
// var range = $('#min').val();
//   var paramTanggal = $('.datepickertanggalawal').val();
  // $('#min').change(()=>{
  //   var start = $('#min').val()
  //   var end = $('#max').val()
  //   $('#datagrid').DataTable().destroy();
	// 	loadTable(start, end);
  // })
  // $('#max').change(()=>{
  //   var start = $('#min').val()
  //   var end = $('#max').val()
  //   $('#datagrid').DataTable().destroy();
	// 	loadTable(start, end);
  // })

 // $(".datepickertanggal").flatpickr({
  //   defaultDate: "{{date('Y-m-d')}}"
  // });
  // $(".datepickerbulan").flatpickr(
  //   {
  //     dateFormat: "Y-m",
  //     plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y-m", altFormat: "M Y"})],
  //     defaultDate: "{{date('Y-m')}}"
  //   }
  // );
  // $(".datepickertahun").flatpickr(
  //   {
  //     dateFormat: "Y",
  //     plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y", altFormat: "Y"})],
  //     defaultDate: "{{date('Y')}}"
  //   }
  // );
  //   $('#rangeBy').select2({
  //       theme: 'bootstrap4',
  //       width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
  //       placeholder: $(this).data('placeholder'),
  //       allowClear: Boolean($(this).data('allow-clear')),
  //       tags: true,
  //     });
  //     // var range = $('#rangeBy').val();
  //     // var paramTanggal = $('.datepickertanggal').val();
  //     var range = '';
  //     var paramTanggal = '';
  //     $('#rangeBy').on('select2:selecting', function (e) {
  //       if (e.params.args.data.id == 'tanggal') {
  //         range = e.params.args.data.id;
  //         paramTanggal = $('.datepickertanggal').val();
  //         $('.panelTanggal').show();
  //         $('.panelTahun').hide();
  //         $('.panelBulan').hide();
  //          // table.draw();
  //       }else if (e.params.args.data.id == 'bulan') {
  //         range = e.params.args.data.id;
  //         paramTanggal = $('.datepickerbulan').val();
  //         $('.panelBulan').show();
  //         $('.panelTanggal').hide();
  //         $('.panelTahun').hide();
  //          // table.draw();
  //       }else {
  //         range = e.params.args.data.id;
  //         paramTanggal = $('.datepickertahun').val();
  //         $('.panelTahun').show();
  //         $('.panelTanggal').hide();
  //         $('.panelBulan').hide();
  //          // table.draw();
  //       }
  //       // table.draw();
  //     });



$(document).ready(function () {
  var dataTable;

  function loadTable(dateStart, dateEnd) {
    if ($.fn.DataTable.isDataTable('#datagrid')) {
      dataTable.destroy();
    }

    dataTable = $('#datagrid').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('laporan-surat-keluar') }}",
        data: {
          dateStart: dateStart,
          dateEnd: dateEnd
        }
      },
      columns: [
        {
          data: 'no_agenda',
          name: 'no_agenda',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'nomor_surat_keluar',
          name: 'nomor_surat_keluar',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'jenis.nama_jenis_surat',
          name: 'jenis.nama_jenis_surat',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'formatDate',
          name: 'formatDate',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'penerima',
          name: 'penerima',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'perihal_surat',
          name: 'perihal_surat',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        }
      ]
    });
  }

  function initializeDatePicker() {
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;
    $("#min").val(today);
    $("#max").val(today);
  }

  function applyDateFilter() {
    var start = $('#min').val();
    var end = $('#max').val();
    loadTable(start, end);
  }

  $("#min, #max").change(function () {
    applyDateFilter();
  });

  $(document).ready(function () {
    initializeDatePicker();
    applyDateFilter();
  });
});

      // table.destroy();
      function change(e) {

        var range = $('#min').val();
        // if (range == 'tanggal') {
        //   var paramTanggal = $('.datepickertanggal').val();
        // }else if (range == 'bulan') {
        //   var paramTanggal = $('.datepickerbulan').val();
        // }else if (range == 'tahun') {
        //   var paramTanggal = $('.datepickertahun').val();
        // }
        if (range == 'tanggal') {
          var paramTanggal = $('.datepickertanggalawal').val();
        }else if (range == 'bulan') {
          var paramTanggal = $('.datepickertanggalakhir').val();
        }
        // table.ajax.url("?range="+range+"&paramTanggal="+paramTanggal).draw();
      //  table = $('#datagrid').DataTable({
      //     processing: true,
      //     serverSide: true,
      //     ajax: {
      //       url:"{{ route('laporan-surat-keluar') }}",
      //       data:{
      //         range: range,
      //         paramTanggal: paramTanggal
      //       },
      //       data: function(d) {
      //           d.range = range;
      //           d.paramTanggal = paramTanggal;
      //       },
      //     },

          // columns: [
          // {
          //   data: 'no_agenda',
          //   name: 'no_agenda',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // {
          //   data: 'nomor_surat_keluar',
          //   name: 'nomor_surat_keluar',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // {
          //   data: 'jenis.nama_jenis_surat',
          //   name: 'jenis.nama_jenis_surat',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // {
          //   data: 'tanggal_surat',
          //   name: 'tanggal_surat',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // {
          //   data: 'penerima',
          //   name: 'penerima',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // {
          //   data: 'perihal_surat',
          //   name: 'perihal_surat',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // {
          //   data: 'verifKABAN',
          //   name: 'verifKABAN',
          //   render: function(data, type, row) {
          //     return '<p style="color:black">' + data + '</p>';
          //   }
          // },
          // ]
        // });
        // table.destroy();
      }


      function CetakExcel(){
        var rangeAwal = $('#min').val();
        var rangeAkhir = $('#max').val();
        var range = rangeAwal + ' - ' + rangeAkhir;
        var paramTanggal = '';

        if (rangeAwal == 'tanggal') {
          paramTanggal = $('#min').val();
        } else if (rangeAkhir == 'bulan') {
          paramTanggal = $('#max').val();
        }
      //   $.ajax({
			// 	url: '{{route("excelLapSurKeluar")}}',
			// 	method: 'POST',
			// 	data: {
			// 		rangeAwal: rangeAwal,
			// 		rangeAkhir: rangeAkhir,
			// 	},

			// }).done(function(data){
			// 	console.log(data);
			// 	});


        // var url = '{{  url('') }}';
        // var urs = url+'/laporan/laporan-surat-keluar/excel/'+range+'/'+paramTanggal;
        window.open("{{ url('laporan/laporan-surat-keluar/excel') }}?rangeAwal=" + rangeAwal + "&rangeAkhir=" + rangeAkhir);
        // console.log(range);
        // // window.location.href = urs;
        // window.open(urs, '_blank');
      }

  </script>
@endsection
