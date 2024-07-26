
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
        {{-- <div class="col-md-4"></div> --}}
        <div class="col-md-2 mb-3" >
          <label class="form-label">Export</label>
          <button type="button" onclick="CetakExcel()" class="btn form-control" style="background-color: #1E6E42; color: white">
            <i class="bx bx-spreadsheet mr-1"></i>to Excel
          </button>
        </div>

        <div class="col-md-4"></div>
          <div class="col-md-3 mb-3 panelTanggal">
            <label class="form-label">Tanggal Awal</label>
            <input type="date" id="min" class="form-control datepickertanggal">
          </div>
          <div class="col-md-3 mb-3 panelTanggal">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" id="max" class="form-control datepickertanggal">
          </div>
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
      </div>
    </div>
  </div>
  <div class="card main-page">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            {{-- <td>NO</td> --}}
            <td>NO SURAT</td>
            <td>NAMA ASN</td>
            <td>TANGGAL MULAI</td>
            <td>TANGGAL SELESAI</td>
            <td>TUJUAN</td>
            <td>PERIHAL</td>
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
  // $( document ).ready(function() {
  //   var range = $('#rangeBy').val();
  //   var paramTanggal = $('.datepickertanggal').val();
  // });
  $('#min').change(()=>{
    var start = $('#min').val()
    var end = $('#max').val()
    $('#datagrid').DataTable().destroy();
		loadTable(start, end);
  })
  $('#max').change(()=>{
    var start = $('#min').val()
    var end = $('#max').val()
    $('#datagrid').DataTable().destroy();
		loadTable(start, end);
  })

  $(document).ready(function () {
    loadTable()
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();

		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;

		var today = year + "-" + month + "-" + day ;
		$("#min").attr("value", today);
		$("#max").attr("value", today);

		//initial run
    $('#datagrid').DataTable().destroy();
		loadTable(today , today);
	});

  // // $(".datepickertanggal").flatpickr({
  // //   defaultDate: "{{date('Y-m-d')}}"
  // // });
  // // $(".datepickerbulan").flatpickr(
  // //   {
  // //     dateFormat: "Y-m",
  // //     plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y-m", altFormat: "M Y"})],
  // //     defaultDate: "{{date('Y-m')}}"
  // //   }
  // // );
  // // $(".datepickertahun").flatpickr(
  // //   {
  // //     dateFormat: "Y",
  // //     plugins: [new monthSelectPlugin({shorthand: false, dateFormat: "Y", altFormat: "Y"})],
  // //     defaultDate: "{{date('Y')}}"
  // //   }
  // // );
  // //   $('#rangeBy').select2({
  // //       theme: 'bootstrap4',
  // //       width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
  // //       placeholder: $(this).data('placeholder'),
  // //       allowClear: Boolean($(this).data('allow-clear')),
  // //       tags: true,
  // //     });
  // //     // var range = $('#rangeBy').val();
  // //     // var paramTanggal = $('.datepickertanggal').val();
  // //     var range = '';
  // //     var paramTanggal = '';
  // //     $('#rangeBy').on('select2:selecting', function (e) {
  // //       if (e.params.args.data.id == 'tanggal') {
  // //         range = e.params.args.data.id;
  // //         paramTanggal = $('.datepickertanggal').val();
  // //         $('.panelTanggal').show();
  // //         $('.panelTahun').hide();
  // //         $('.panelBulan').hide();
  // //          // table.draw();
  // //       }else if (e.params.args.data.id == 'bulan') {
  // //         range = e.params.args.data.id;
  // //         paramTanggal = $('.datepickerbulan').val();
  // //         $('.panelBulan').show();
  // //         $('.panelTanggal').hide();
  // //         $('.panelTahun').hide();
  // //          // table.draw();
  // //       }else {
  // //         range = e.params.args.data.id;
  // //         paramTanggal = $('.datepickertahun').val();
  // //         $('.panelTahun').show();
  // //         $('.panelTanggal').hide();
  // //         $('.panelBulan').hide();
  // //          // table.draw();
  // //       }
  // //       // table.draw();
  // //     });

  // function initializeDatePicker() {
  //     var date = new Date();
  //     var day = date.getDate();
  //     var month = date.getMonth() + 1;
  //     var year = date.getFullYear();

  //     if (month < 10) month = "0" + month;
  //     if (day < 10) day = "0" + day;

  //     var today = year + "-" + month + "-" + day;
  //     $("#min").val(today);
  //     $("#max").val(today);
  //   }

  //   function applyDateFilter() {
  //     var start = $('#min').val();
  //     var end = $('#max').val();
  //     loadTable(start, end);
  //   }

  //   $("#min, #max").change(function () {
  //     applyDateFilter();
  //   });

  //   $(document).ready(function () {
  //     initializeDatePicker();
  //     applyDateFilter();
  //   });


  // function loadTable(dateStart, dateEnd) {

  //     var table = $('#datagrid').DataTable({
  //     processing: true,
  //     serverSide: true,
  //     language: {
  //       searchPlaceholder: "Ketikkan yang dicari"
  //     },
  //     ajax: {
  //         url:"{{ route('laporan-surat-tugas') }}",
  //         data:{
  //           dateStart: dateStart,
  //           dateEnd: dateEnd
  //           // paramTanggal: paramTanggal
  //         },
  //         // data: function(d) {
  //         //     d.range = range;
  //         //     d.paramTanggal = paramTanggal;
  //         // },
  //       },

  //     columns: [{
  //       data: 'DT_RowIndex',
  //       name: 'DT_RowIndex',
  //       render: function(data, type, row) {
  //         return '<p style="color:black">' + data + '</p>';
  //       }
  //     },
  //     {
  //       data: 'nomor_surat_perjalanan_dinas',
  //       name: 'nomor_surat_perjalanan_dinas',
  //       render: function(data, type, row) {
  //         return '<p style="color:black">' + data + '</p>';
  //       }
  //     },
  //     {
  //       data: 'namaPenerima',
  //       name: 'namaPenerima',
  //       orderable: false,
  //       searchable: false
  //     },
  //     {
  //       data: 'tanggal_mulai',
  //       name: 'tanggal_mulai',
  //       render: function(data, type, row) {
  //         return '<p style="color:black">' + data + '</p>';
  //       }
  //     },
  //     {
  //       data: 'tanggal_akhir',
  //       name: 'tanggal_akhir',
  //       render: function(data, type, row) {
  //         return '<p style="color:black">' + data + '</p>';
  //       }
  //     },
  //     {
  //       data: 'tujuan',
  //       name: 'tujuan',
  //       render: function(data, type, row) {
  //         return '<p style="color:black">' + data + '</p>';
  //       }
  //     },

  //     {
  //       data: 'perihal_surat',
  //       name: 'perihal_surat',
  //       render: function(data, type, row) {
  //         return '<p style="color:black">' + result + '</p>';
  //       }
  //     },

  //     ]

  //   });
  // }

  // $(document).ready(function () {
  // var dataTable;

  function loadTable(dateStart, dateEnd) {
    // if ($.fn.DataTable.isDataTable('#datagrid')) {
    //   dataTable.destroy();
    // }

    dataTable = $('#datagrid').DataTable({
      processing: true,
      serverSide: true,
      language: {
            searchPlaceholder: "Ketikkan yang dicari"
        },
      ajax: {
        url: "{{ route('laporan-surat-tugas') }}",
        data: {
          dateStart: dateStart,
          dateEnd: dateEnd
        }
      },
      columns: [
      //   {
      //   data: 'DT_RowIndex',
      //   name: 'DT_RowIndex',
      //   render: function(data, type, row) {
      //     return '<p style="color:black">' + data + '</p>';
      //   }
      // },
      {
        data: 'nomor_surat_perjalanan_dinas',
        name: 'nomor_surat_perjalanan_dinas',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'namaPenerima',
        name: 'namaPenerima',
        orderable: false,
        searchable: false
      },
      {
        data: 'tanggalMulai',
        name: 'tanggalMulai',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'tanggalAkhir',
        name: 'tanggalAkhir',
        render: function(data, type, row) {
          return '<p style="color:black">' + data + '</p>';
        }
      },
      {
        data: 'tujuan',
        name: 'tujuan',
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
      },
      ]
    });
  }


// });



    // table.destroy();
      function change(e) {

        var range = $('#rangeBy').val();
        if (range == 'tanggal') {
          var paramTanggal = $('.datepickertanggal').val();
        }else if (range == 'bulan') {
          var paramTanggal = $('.datepickerbulan').val();
        }else if (range == 'tahun') {
          var paramTanggal = $('.datepickertahun').val();
        }
        // table.ajax.url("?range="+range+"&paramTanggal="+paramTanggal).draw();
    //     var table = $('#datagrid').DataTable({
    //   processing: true,
    //   serverSide: true,
    //   language: {
    //     searchPlaceholder: "Ketikkan yang dicari"
    //   },
    //   ajax: {
    //       url:"{{ route('laporan-surat-tugas') }}",
    //       data:{
    //         range: range,
    //         paramTanggal: paramTanggal
    //       },
    //       // data: function(d) {
    //       //     d.range = range;
    //       //     d.paramTanggal = paramTanggal;
    //       // },
    //     },

    //     columns: [{
    //     data: 'DT_RowIndex',
    //     name: 'DT_RowIndex',
    //     render: function(data, type, row) {
    //       return '<p style="color:black">' + data + '</p>';
    //     }
    //   },
    //   {
    //     data: 'nomor_surat_perjalanan_dinas',
    //     name: 'nomor_surat_perjalanan_dinas',
    //     render: function(data, type, row) {
    //       return '<p style="color:black">' + data + '</p>';
    //     }
    //   },
    //   {
    //     data: 'namaPenerima',
    //     name: 'namaPenerima',
    //     orderable: false,
    //     searchable: false
    //   },
    //   {
    //     data: 'tanggal_mulai',
    //     name: 'tanggal_mulai',
    //     render: function(data, type, row) {
    //       return '<p style="color:black">' + data + '</p>';
    //     }
    //   },
    //   {
    //     data: 'tanggal_akhir',
    //     name: 'tanggal_akhir',
    //     render: function(data, type, row) {
    //       return '<p style="color:black">' + data + '</p>';
    //     }
    //   },
    //   {
    //     data: 'tujuan',
    //     name: 'tujuan',
    //     render: function(data, type, row) {
    //       return '<p style="color:black">' + data + '</p>';
    //     }
    //   },

    //   {
    //     data: 'perihal_surat',
    //     name: 'perihal_surat',
    //     render: function(data, type, row) {
    //       return '<p style="color:black">' + result + '</p>';
    //     }
    //   },
    //   ]

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
        // console.log(range);
        window.open("{{ url('laporan/laporan-surat-tugas/excel') }}?rangeAwal=" + rangeAwal + "&rangeAkhir=" + rangeAkhir);
  }
</script>
@endsection
