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

        {{-- <div class="col-md-2 mb-3" >
          <label class="form-label">Export</label>
          <button type="button" onclick="CetakExcel()" class="btn btn-info form-control">
            <i class="bx bx-spreadsheet mr-1"></i>to Excel
          </button>
        </div>
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

        <div class="col-md-2 mb-3" >
          <label class="form-label">Export</label>
          <button type="button" onclick="CetakExcel()" class="btn btn-info form-control" style="color: white">
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
      </div>
    </div>
  </div>
  <div class="card main-page">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
          <thead>
            <td>NO AGENDA</td>
            <td>NO BERKAS</td>
            <td style="width: 100%">PENGIRIM SURAT</td>
            <td>TANGGAL SURAT</td>
            <td>PERIHAL SURAT</td>
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


  function loadTable(dateStart, dateEnd) { 

      var table = $('#datagrid').DataTable({
        processing: true,
        serverSide: true,
        language: {
        searchPlaceholder: "Ketikkan yang dicari"
      },
        ajax: {
          url:"{{ route('laporan-surat-masuk') }}",
          data:{
            dateStart: dateStart,
            dateEnd: dateEnd,
            // paramTanggal: paramTanggal
          },
          // data: function(d) {
          //     d.range = range;
          //     d.paramTanggal = paramTanggal;
          // },
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
          data: 'nomor_surat_masuk',
          name: 'nomor_surat_masuk',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'pengirim',
          name: 'pengirim',
          render: function(data, type, row) {
            return '<p style="color:black">' + data + '</p>';
          }
        },
        {
          data: 'tanggal_terima_surat',
          name: 'tanggal_terima_surat',
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
       table = $('#datagrid').DataTable({
          processing: true,
          serverSide: true,
          language: {
          searchPlaceholder: "Ketikkan yang dicari"
          },
          ajax: {
            url:"{{ route('laporan-surat-masuk') }}",
            data:{
              range: range,
              paramTanggal: paramTanggal
            },
            // data: function(d) {
            //     d.range = range;
            //     d.paramTanggal = paramTanggal;
            // },
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
            data: 'nomor_surat_masuk',
            name: 'nomor_surat_masuk',
            render: function(data, type, row) {
              return '<p style="color:black">' + data + '</p>';
            }
          },
          {
            data: 'pengirim',
            name: 'pengirim',
            render: function(data, type, row) {
              return '<p style="color:black">' + data + '</p>';
            }
          },
          {
            data: 'tanggal_terima_surat',
            name: 'tanggal_terima_surat',
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
        window.open("{{ url('laporan/laporan-surat-masuk/excel') }}?rangeAwal=" + rangeAwal + "&rangeAkhir=" + rangeAkhir);
      }
  </script>
@endsection
