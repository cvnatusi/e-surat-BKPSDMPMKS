@extends('component.app')
@section('css')
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-3d.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style media="screen">
    /* #container {
        height: 100%;
    } */
    .chart-wrapper {
      position: relative;
      padding-bottom: 40%;
      width:45%;
      float:left;
    }

    .chart-inner {
      position: absolute;
      width: 50%; height: 100%;
    }
</style>
@endsection
@section('content')
<h6 class="mb-0 text-uppercase">{{ $data['title'] }}</h6>
<hr>
<div class="card main-page">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <label for="">Pilih Tahun</label>
                <input type="month" id="filterMonth" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-bottom:10px"></div>
        <figure class="highcharts-figure">
          <div id="container"></div>
          <div id="sliders">
            <table style="display:none">
              <tr>
                <td><label for="alpha">Alpha Angle</label></td>
                <td><input id="alpha" type="range" min="0" max="45" value="0"/> <span id="alpha-value" class="value"></span></td>
              </tr>
              <tr>
                <td><label for="beta">Beta Angle</label></td>
                <td><input id="beta" type="range" min="-45" max="45" value="0"/> <span id="beta-value" class="value"></span></td>
              </tr>
              <tr>
                <td><label for="depth">Depth</label></td>
                <td><input id="depth" type="range" min="20" max="100" value="20"/> <span id="depth-value" class="value"></span></td>
              </tr>
            </table>
          </div>
        </figure>
      </div>
</div>
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4" style="display:none">
    <div class="col">
        <h3>SURAT MASUK</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratMasuk" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-ohhappiness">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratMasuk">{{$data['surat_masuk']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT MASUK</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT KELUAR</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratKeluar" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-ibiza">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratKeluar">{{$data['surat_keluar']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT KELUAR</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT DISPOSISI</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratDisposisi" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-deepblue">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratDisposisi">{{$data['surat_disposisi']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT DISPOSISI</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT TUGAS</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratTugas" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-moonlit">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratTugas">{{$data['surat_tugas']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT TUGAS</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT SPPD</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratSPPD" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-kyoto">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratSPPD">{{$data['surat_tugas']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT SPPD</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT KEPUTUSAN</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratKeputusan" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-orange">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratKeputusan">{{$data['surat_keputusan']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT KEPUTUSAN</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT BAST</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratBAST" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-cosmic">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratBAST">{{$data['surat_bast']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT BAST</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <h3>SURAT TTE</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="month" id="monthSuratKeluar" class="form-control" value="{{date('Y-m')}}">
            </div>
        </div>
        <div class="clearfix" style="margin-top:10px"></div>
        <div class="card radius-10 bg-gradient-ibiza">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h1 class="mb-0 text-white" id="countSuratKeluar">{{$data['surat_keluar']}}</h1>
                </div>
                <div class="d-flex align-items-center text-white">
                    <p class="mb-0">SURAT TTE</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="card">
      <div class="card-header">
        <h2>Dashboard</h2>
      </div>
        <div class="card-body">
          <div class="row">
              <div class="col-md-12">
                  <input type="month" id="filterMonth" class="form-control" value="{{date('Y-m')}}">
              </div>
          </div>
          <div class="clearfix" style="margin-bottom:10px"></div>
          <figure class="highcharts-figure">
            <div id="container"></div>
            <div id="sliders">
              <table style="display:none">
                <tr>
                  <td><label for="alpha">Alpha Angle</label></td>
                  <td><input id="alpha" type="range" min="0" max="45" value="0"/> <span id="alpha-value" class="value"></span></td>
                </tr>
                <tr>
                  <td><label for="beta">Beta Angle</label></td>
                  <td><input id="beta" type="range" min="-45" max="45" value="0"/> <span id="beta-value" class="value"></span></td>
                </tr>
                <tr>
                  <td><label for="depth">Depth</label></td>
                  <td><input id="depth" type="range" min="20" max="100" value="20"/> <span id="depth-value" class="value"></span></td>
                </tr>
              </table>
            </div>
          </figure>
        </div>
    </div>
</div> --}}
@endsection
@section('js')
<script type="text/javascript">
    $('#monthSuratMasuk').change(function(e) {
        var param = $('#monthSuratMasuk').val();
        $.post("{!! route('getCountSuratMasuk') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratMasuk').text(data);
            var masuk = data;
        });
    });
    $('#monthSuratKeluar').change(function(e) {
        var param = $('#monthSuratKeluar').val();
        $.post("{!! route('getCountSuratKeluar') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratKeluar').text(data);
        });
    });
    $('#monthSuratDisposisi').change(function(e) {
        var param = $('#monthSuratDisposisi').val();
        $.post("{!! route('getCountSuratDisposisi') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratDisposisi').text(data);
        });
    });
    $('#monthSuratTugas').change(function(e) {
        var param = $('#monthSuratTugas').val();
        $.post("{!! route('getCountSuratTugas') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratTugas').text(data);
        });
    });
    $('#monthSuratKeputusan').change(function(e) {
        var param = $('#monthSuratKeputusan').val();
        $.post("{!! route('getCountSuratKeputusan') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratKeputusan').text(data);
        });
    });
    $('#monthSuratBAST').change(function(e) {
        var param = $('#monthSuratBAST').val();
        $.post("{!! route('getCountSuratBAST') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratBAST').text(data);
        });
    });
    $('#monthSuratSPPD').change(function(e) {
        var param = $('#monthSuratSPPD').val();
        $.post("{!! route('getCountSuratSPPD') !!}", {
            id: param
        }).done(function(data) {
            $('#countSuratSPPD').text(data);
        });
    });

</script>
<script type="text/javascript">
var month = $('#filterMonth').val();
var options = {month: 'long', year: 'numeric' };
var today  = new Date(month);
$(function() {
  var param = $('#filterMonth').val();
  $.post("{!! route('getChart') !!}", {
      id: param
  }).done(function(data) {
    console.log(data);
    // const chart = new Highcharts.Chart({
    //   chart: {
    //     renderTo: 'container',
    //     type: 'column',
    //     options3d: {
    //       enabled: true,
    //       alpha: 0,
    //       beta: 0,
    //       depth: 20,
    //       viewDistance: 25
    //     }
    //   },
    //   xAxis: {
    //     categories: ['Surat Masuk', 'Surat Keluar', 'Surat Disposisi', 'Surat Tugas', 'Surat SPPD', 'Surat Keputusan',
    //     'Surat BAST', 'Surat TTE']
    //   },
    //   yAxis: {
    //     title: {
    //       enabled: false
    //     }
    //   },
    //   tooltip: {
    //     headerFormat: '<b>{point.key}</b><br>',
    //     pointFormat: 'Jumlah Surat: {point.y}'
    //   },
    //   title: {
    //     text: 'Grafik Surat',
    //     align: 'center'
    //   },
    //   subtitle: {
    //     text: 'Bulan: '+today.toLocaleDateString("id-ID", options),
    //     align: 'center'
    //   },
    //   legend: {
    //     enabled: false
    //   },
    //   plotOptions: {
    //     column: {
    //       depth: 25
    //     }
    //   },
    //   series: [{
    //     data: [data.surat_masuk, data.surat_keluar, data.surat_disposisi, data.surat_tugas, data.surat_sppd, data.surat_keputusan, data.surat_bast, data.surat_tte],
    //     colorByPoint: true
    //   }]
    // });
    Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Grafik Bulan: '+today.toLocaleDateString("id-ID", options),
        align: 'left'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.0f} Surat</b>'
    },
    accessibility: {
        point: {
            valueSuffix: 'Surat'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.0f} Surat'
            }
        }
    },
    series: [{
        name: 'Surat',
        colorByPoint: true,
        data: [{
            name: 'Surat Masuk',
            y: data.surat_masuk,
            sliced: true,
            selected: true
        }, {
            name: 'Surat Keluar',
            y: data.surat_keluar
        },  {
            name: 'Surat Disposisi',
            y: data.surat_disposisi
        }, {
            name: 'Surat Tugas',
            y: data.surat_tugas
        }, {
            name: 'Surat SPPD',
            y: data.surat_sppd
        },  {
            name: 'Surat Keputusan',
            y: data.surat_keputusan
        }, {
            name: 'Surat BAST',
            y: data.surat_bast
        }, {
            name: 'SURAT TTE',
            y: data.surat_tte
        }]
    }]
});







  });
});
$('#filterMonth').change(function(e) {
    var param = $('#filterMonth').val();
    var options = {month: 'long', year: 'numeric' };
    var today  = new Date(param);
    $.post("{!! route('getChart') !!}", {
        id: param
    }).done(function(data) {
      Highcharts.chart('container', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      title: {
          text: 'Grafik Bulan: '+today.toLocaleDateString("id-ID", options),
          align: 'left'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.0f} Surat</b>'
      },
      accessibility: {
          point: {
              valueSuffix: 'Surat'
          }
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.0f} Surat'
              }
          }
      },
      series: [{
          name: 'Surat',
          colorByPoint: true,
          data: [{
              name: 'Surat Masuk',
              y: data.surat_masuk,
              sliced: true,
              selected: true
          }, {
              name: 'Surat Keluar',
              y: data.surat_keluar
          },  {
              name: 'Surat Disposisi',
              y: data.surat_disposisi
          }, {
              name: 'Surat Tugas',
              y: data.surat_tugas
          }, {
              name: 'Surat SPPD',
              y: data.surat_sppd
          },  {
              name: 'Surat Keputusan',
              y: data.surat_keputusan
          }, {
              name: 'Surat BAST',
              y: data.surat_bast
          }, {
              name: 'SURAT TTE',
              y: data.surat_tte
          }]
      }]
  });
    });
});
</script>


{{-- <script type="text/javascript">
var month = $('#filterMonth').val();
var options = {month: 'long', year: 'numeric' };
var today  = new Date(month);
$(function() {
  var param = $('#filterMonth').val();
  $.post("{!! route('getChart') !!}", {
      id: param
  }).done(function(data) {
    console.log(data);
    const chart = new Highcharts.Chart({
      chart: {
        renderTo: 'container',
        type: 'column',
        options3d: {
          enabled: true,
          alpha: 0,
          beta: 0,
          depth: 20,
          viewDistance: 25
        }
      },
      xAxis: {
        categories: ['Surat Masuk', 'Surat Keluar', 'Surat Disposisi', 'Surat Tugas', 'Surat SPPD', 'Surat Keputusan',
        'Surat BAST', 'Surat TTE']
      },
      yAxis: {
        title: {
          enabled: false
        }
      },
      tooltip: {
        headerFormat: '<b>{point.key}</b><br>',
        pointFormat: 'Jumlah Surat: {point.y}'
      },
      title: {
        text: 'Grafik Surat',
        align: 'center'
      },
      subtitle: {
        text: 'Bulan: '+today.toLocaleDateString("id-ID", options),
        align: 'center'
      },
      legend: {
        enabled: false
      },
      plotOptions: {
        column: {
          depth: 25
        }
      },
      series: [{
        data: [data.surat_masuk, data.surat_keluar, data.surat_disposisi, data.surat_tugas, data.surat_sppd, data.surat_keputusan, data.surat_bast, data.surat_tte],
        colorByPoint: true
      }]
    });
  });
});
$('#filterMonth').change(function(e) {
    var param = $('#filterMonth').val();
    var options = {month: 'long', year: 'numeric' };
    var today  = new Date(param);
    $.post("{!! route('getChart') !!}", {
        id: param
    }).done(function(data) {
      console.log(data);
      const chart = new Highcharts.Chart({
        chart: {
          renderTo: 'container',
          type: 'column',
          options3d: {
            enabled: true,
            alpha: 0,
            beta: 0,
            depth: 20,
            viewDistance: 25
          }
        },
        xAxis: {
          categories: ['Surat Masuk', 'Surat Keluar', 'Surat Disposisi', 'Surat Tugas', 'Surat SPPD', 'Surat Keputusan',
          'Surat BAST', 'Surat TTE']
        },
        yAxis: {
          title: {
            enabled: false
          }
        },
        tooltip: {
          headerFormat: '<b>{point.key}</b><br>',
          pointFormat: 'Jumlah Surat: {point.y}'
        },
        title: {
          text: 'Grafik Surat',
          align: 'center'
        },
        subtitle: {
          text: 'Bulan: '+today.toLocaleDateString("id-ID", options),
          align: 'center'
        },
        legend: {
          enabled: false
        },
        plotOptions: {
          column: {
            depth: 25
          }
        },
        series: [{
          data: [data.surat_masuk, data.surat_keluar, data.surat_disposisi, data.surat_tugas, data.surat_sppd, data.surat_keputusan, data.surat_bast, data.surat_tte],
          colorByPoint: true
        }]
      });
    });
});
</script> --}}
@endsection
