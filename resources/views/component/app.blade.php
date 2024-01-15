<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--favicon-->
  <link rel="icon" href="{{asset('assets/images/logo-icon.png')}}" type="image/png" />
  <!--plugins-->
  <link href="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.')}}css" rel="stylesheet"/>
  <link href="{{asset('assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
  <!-- loader-->
  <link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
  <script src="{{asset('assets/js/pace.min.js')}}"></script>

  <!-- Bootstrap CSS -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/bootstrap-extended.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/plugins/notifications/css/lobibox.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- Theme Style CSS -->
  {{-- <link rel="stylesheet" href="{{asset('assets/css/dark-theme.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/semi-dark.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/header-colors.css')}}" /> --}}
  <title>E-SURAT | BKPSDM KAB. PAMEKASAN</title>
  @yield('css')
</head>

<body>
  <!--wrapper-->
  <div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
      <div class="sidebar-header">
        <div>
          <img src="{{asset('assets/images/logo-icon.png')}}" style="width: 45px !important;" class="logo-icon" alt="logo icon">
        </div>
        <div>
          <h4 class="logo-text">BKPSDM</h4>
          <h4 class="text" style="font-size: 13px; margin-left: 11px; color: #0d6efd; ">Pamekasan</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
      </div>
      <!--navigation-->
      @include('component.sidebar')
      <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
    <!--start header -->
    @include('component.top')
    <!--end header -->
    <!--start page wrapper -->
    <div class="page-wrapper">
      <div class="page-content">
        @yield('content')
      </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <footer class="page-footer">
      <p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script>.All right reserved.</p>
      <!-- <p class="mb-0">Copyright © 2023 @<a href="natusi.co.id">CV. NATUSI</a>. All right reserved.</p> -->
    </footer>
  </div>
  <!--end wrapper-->
  <!--start switcher-->
  {{-- <div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>
    <div class="switcher-body">
      <div class="d-flex align-items-center">
        <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
        <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
      </div>
      <hr/>
      <h6 class="mb-0">Theme Styles</h6>
      <hr/>
      <div class="d-flex align-items-center justify-content-between">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
          <label class="form-check-label" for="lightmode">Light</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
          <label class="form-check-label" for="darkmode">Dark</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
          <label class="form-check-label" for="semidark">Semi Dark</label>
        </div>
      </div>
      <hr/>
      <div class="form-check">
        <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
        <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
      </div>
      <hr/>
      <h6 class="mb-0">Header Colors</h6>
      <hr/>
      <div class="header-colors-indigators">
        <div class="row row-cols-auto g-3">
          <div class="col">
            <div class="indigator headercolor1" id="headercolor1"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor2" id="headercolor2"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor3" id="headercolor3"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor4" id="headercolor4"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor5" id="headercolor5"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor6" id="headercolor6"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor7" id="headercolor7"></div>
          </div>
          <div class="col">
            <div class="indigator headercolor8" id="headercolor8"></div>
          </div>
        </div>
      </div>

      <hr/>
      <h6 class="mb-0">Sidebar Backgrounds</h6>
      <hr/>
      <div class="header-colors-indigators">
        <div class="row row-cols-auto g-3">
          <div class="col">
            <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
          </div>
          <div class="col">
            <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
          </div>
        </div>
      </div>

    </div>
  </div> --}}
  <!--end switcher-->
  <!-- Bootstrap JS -->
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--plugins-->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
  <script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
  <script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
  <script src="{{asset('assets/plugins/chartjs/js/Chart.min.js')}}"></script>
  <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
  <script src="{{asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
  <script src="{{asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery-knob/excanvas.js')}}"></script>
  <script src="{{asset('assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
  <script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
  <script src="{{asset('assets/plugins/animate/animate.js')}}"></script>
  <script src="{{asset('assets/plugins/sweetalert/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/plugins/validate/jquery.validate.js')}}"></script>
  {{-- <script src="{{asset('assets/js/index.js')}}"></script> --}}
  <!--notification js -->
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script src="{{asset('assets/plugins/notifications/js/lobibox.min.js')}}"></script>
  <script src="{{asset('assets/plugins/notifications/js/notifications.min.js')}}"></script>
  <script src="{{asset('assets/plugins/notifications/js/notification-custom-script.js')}}"></script>
  <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
  <!--app JS-->
  <script src="{{asset('assets/js/app.js')}}"></script>
  {{-- Preview file --}}
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function kosong(){
      swal({
        title: "MAAF !",
        text: "Fitur Belum Bisa Digunakan !!",
        type: "warning",
        timer: 2000,
        showConfirmButton: false
      });
    };


    $(function() {
      $(".knob").knob();
    });
    flatpickr.localize(flatpickr.l10ns.id);
    Pusher.logToConsole = false;

    var pusher = new Pusher('{{env("PUSHER_APP_KEY")}}', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('notif');
  </script>

  @yield('js')
  {{--@stack('scripts')--}}
</body>

</html>
