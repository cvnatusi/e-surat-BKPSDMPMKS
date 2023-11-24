@extends('component.app')
@section('css')

@endsection
@section('content')
<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bx-cog me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Profile</h5>
    </div>
    <hr>
    @if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
    </div>
    @endif
    <form class="row g-3 form-save" action="{{ url('profile/update') }}" enctype="multipart/form-data" method="POST">
    @csrf
    
        <input class="form-control" hidden value="{{Auth::user()->id}}" name="id" id="id" type="text">
      <div class="col-md-8">
        <label for="nama_kepala_badan" class="form-label">NAMA PENGGUNA</label>
        <input type="text" readonly name="" class="form-control" value="{{Auth::user()->name}}">

      </div>
      <div class="col-md-4">
        <label for="jabatan" class="form-label">NIP</label>
        <input type="text" readonly name="email" class="form-control" value="{{Auth::user()->email}}">
      </div>

      <div class="col-md-8">
        <label for="nip" class="form-label">PASSWORD</label>
        <input type="password" name="password" id="password"class="form-control" value="" placeholder="Masukkan Password Baru">
        <br>
        <input type="checkbox" onclick="myFunction()"> Tampilkan Password

      </div>
      <div class="col-md-4">
      <label for="file_scan" class="form-label">FOTO PROFIL</label>
        <input class="form-control" type="file" id="foto" name="foto">
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary px-5 btn-submit">Simpan</button>
        <!-- <button type="button" class="btn btn-secondary px-5 btn-cancel">Kembali</button> -->
      </div>
    </form>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">

$("body").on("click",".upload-image",function(e){
    $(this).parents("form").ajaxForm(options);
  });

  var options = { 
    complete: function(response) 
    {
      
        if($.isEmptyObject(response.responseJSON.error)){
            $("input[name='pengguna']").val('');
            $("input[name='kode_surat']").val('');
            $("input[name='nama_badan']").val('');
            $("input[name='nama_kepala_badan']").val('');
            $("input[name='jabatan']").val('');
            $("input[name='nip']").val('');
            alert('You clicked the button!');
        }else{
            printErrorMsg(response.responseJSON.error);
            
        }
    }
  };

  function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
  }
document.getElementById('nama_badan').readOnly = true;
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
$('.btn-submit').click(function(e){
 e.preventDefault();
    // $('.btn-submit').html('Please wait...').attr('disabled', true);
    $('.btn-submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').attr('disabled', true);
    var data  = new FormData($('.form-save')[0]);
    $.ajax({
        // url: "{{ route('store-surat-keluar') }}",
        type: 'POST',
        data: data,
        async: true,
        cache: false,
        contentType: false,
        processData: false
    }).done(function(data){
    $('.form-save').validate(data, 'has-error');
    if(data.status == 'success'){
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
        $('.other-page').fadeOut(function(){
        $('.other-page').empty();
        $('.card').fadeIn();
        $('#datagrid').DataTable().ajax.reload();
        });
    } else if(data.status == 'error') {
        $('.btn-submit').html('Simpan <i class="fa fa-save fs-14 m-l-5"></i>').removeAttr('disabled');
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
        swal('Error :'+data.errMsg.errorInfo[0], data.errMsg.errorInfo[2], 'warning');
    } else {
        var n = 0;
        for(key in data){
        if (n == 0) {var dt0 = key;}
        n++;
        }
        $('.btn-submit').html('Simpan <i class="fa fa-save fs-14 m-l-5"></i>').removeAttr('disabled');
        Lobibox.notify('warning', {
          pauseDelayOnHover: true,
          size: 'mini',
          rounded: true,
          delayIndicator: false,
          icon: 'bx bx-error',
          continueDelayOnInactiveTab: false,
          position: 'top right',
          sound:false,
          msg: data.message
        });
    }
    }).fail(function() {
      $('.btn-submit').html('Simpan <i class="fa fa-save fs-14 m-l-5"></i>').removeAttr('disabled');
      Lobibox.notify('warning', {
        title: 'Maaf!',
        pauseDelayOnHover: true,
        size: 'mini',
        rounded: true,
        delayIndicator: false,
        icon: 'bx bx-error',
        continueDelayOnInactiveTab: false,
        position: 'top right',
        sound:false,
        msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
      });
    });
});
</script>
@endsection