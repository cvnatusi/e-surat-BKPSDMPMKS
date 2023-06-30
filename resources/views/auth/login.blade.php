
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<!--favicon-->
	<link rel="icon"  href="{{asset('assets/images/logo-icon.png')}}" type="image/png" />
	<!--plugins-->
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
	<title>E-SURAT | BKPSDM KAB. PAMEKASAN</title>
<style media="screen">
.section-authentication-signin {
  height: 85vh !important;
}
</style>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<header class="login-header shadow">
			<nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
				<div class="container-fluid">
					<a class="navbar-brand" href="#">
						<img src="{{asset('assets/images/logo-icon.png')}}" style="width: 45px !important;" class="logo-icon" alt="logo icon">
					</a>
          <div>
            <h4 class="logo-text">BKPSDM</h4>
          </div>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent1">
						<ul class="navbar-nav ms-auto mb-2 mb-lg-0">

							<li class="nav-item" style="text-color:red"> <a class="nav-link" href="#"><i class='lni lni-question-circle'></i> Bantuan</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-4">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card shadow-none mt-5">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center mb-4">
										<h3 class="">Masuk</h3>
                    <p class="mb-0">Tidak Bisa Masuk? <a href="https://wa.me/6282188456997">Hubungi Admin</a>
									</div>
									<div class="login-separater text-center mb-4"> <span>Silahkan Masuk Menggunakan NIP</span>
										<hr/>
									</div>
									<div class="form-body">
										<form class="row g-4 form-login">
											<div class="col-12">
												<label for="username" class="form-label">NIP Pegawai</label>
												<input type="text" class="form-control" id="username" name="username" placeholder="NIP">
											</div>
											<div class="col-12">
												<label for="password" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" class="form-control border-end-0" value="" name="password" id="password" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<div class="col-12">
												<div class="d-grid">
													{{-- <input onclick="login()" class="btn btn-primary"><i class="bx bxs-lock-open" id="btn-login"></i>Masuk --}}
                          <input onclick="login()" class="btn btn-block btn-primary" type="button" style="margin-top: 10px" value="Sign In" id="btn-login">
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
		<footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
			<p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script>. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	<script src="{{asset('assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
  <script src="{{asset('assets/plugins/sweetalert/sweetalert2.js')}}"></script>
  <script src="{{asset('assets/plugins/validate/jquery.validate.js')}}"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>
  <script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var try_login = 0;
  var max_failed_login = 3;
  var time_lock = 10;
  function login(){
      try_login ++; // INCREMENT TRY LOGIN

      var data  = new FormData($('.form-login')[0]);
      data.append('try_login', try_login);
      data.append('max_failed_login', max_failed_login);
      data.append('time_lock', time_lock);
      $.ajax({
          url: "{{ route('doLogin') }}",
          type: 'POST',
          data: data,
          async: true,
          cache: false,
          contentType: false,
          processData: false
      }).done(function(data){
          $('.form-login').validate(data, 'has-error');
          if(data.status == 'success'){
						swal('Selamat Datang !', data.message, 'success');
            window.location.replace("{!! url($data['next_url']) !!}");
          } else if(data.status == 'error') {
              $('#btn-login').html('Login').removeAttr('disabled');
              swal('Whoops !', data.message, 'warning');
              if (try_login >= max_failed_login) {
                  signin_locked();
              }
          } else {
              var n = 0;
              for(key in data){
              if (n == 0) {var dt0 = key;}
              n++;
          }
          $('#btn-login').html('Login').removeAttr('disabled');
          swal('Whoops !', 'Kolom '+dt0+' Tidak Boleh Kosong !!', 'error');
      }
      }).fail(function() {
              swal("MAAF !","Terjadi Kesalahan, Silahkan Ulangi Kembali !!", "warning");
              $('#btn-login').html('Login').removeAttr('disabled');
      });
  }

  function signin_locked() {
      $('#btn-login').attr('disabled', true);
      $('#btn-login').val(`Terbuka dalam ${time_lock} detik`);

      // Update the count down every 1 second
      var count = time_lock
      var x = setInterval(function() {

          count -= 1;

          $('#btn-login').val(`Terbuka dalam ${count} detik`);

          // If the count down is over, write some text
          if (count <= 0) {
              clearInterval(x);
              try_login = 0;

              $('#btn-login').attr('disabled', false);
              $('#btn-login').val(`Sign In`);

          }
      }, 1000);
  }
  </script>
</body>

</html>
