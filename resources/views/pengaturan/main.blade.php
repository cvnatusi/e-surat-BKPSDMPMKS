@extends('component.app')
@section('css')

@endsection
@section('content')
<div class="card border-top border-0 border-4 border-primary panel-form">
  <div class="card-body p-5">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bx-cog me-1 font-22 text-primary"></i>
      </div>
      <h5 class="mb-0 text-primary">Pengaturan</h5>
    </div>
    <hr>
    <form class="row g-3 form-save" action="{{ url('pengaturan/store') }}" enctype="multipart/form-data" method="POST">
    @csrf
    @if (!empty($data['tanda_tangan']))
        @foreach ($data['tanda_tangan'] as $ttd)
        <input class="form-control" hidden value="{{$ttd->id}}" name="id" id="id" type="text">
        @endforeach
    @endif
      <div class="col-md-6">
          <label for="pengguna" class="form-label">Pengguna</label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-check-input" value="Badan" name="pengguna" id="pengguna" type="radio">
                  <label for="pengguna" class="form-label">Badan</label>
                </div>
                <div class="col-md-6">
                  <input class="form-check-input" value="Bidang" name="pengguna" id="pengguna" type="radio">
                  <label for="pengguna" class="form-label">Bidang</label>
                </div>
              </div>
      </div>
      <div class="col-md-6">
        <label for="kode_surat" class="form-label">Kode Surat <span style="color:red;">*)</span></label>
        <input type="text" class="form-control" name="kode_surat" value="432.403">
      </div>
     
      <div class="col-md-24">
        <label for="nama_badan" class="form-label">NAMA BADAN <span style="color:red;">*)</span></label>
        <input type="text" id="nama_badan" name="nama_badan" class="form-control" value="BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA KABUPATEN PAMEKASAN">
      </div>
      
      <div class="col-md-8">
        <label for="nama_kepala_badan" class="form-label">NAMA KEPALA BADAN <span style="color:red;">*)</span></label>
        <input type="text" name="nama_kepala_badan" class="form-control" value="">

      </div>
      <div class="col-md-4">
        <label for="jabatan" class="form-label">JABATAN / GOLONGAN <span style="color:red;">*)</label>
        <input type="text" name="jabatan" class="form-control" value="">
      </div>

      <div class="col-md-8">
        <label for="nip" class="form-label">NIP <span style="color:yellow;">*)</span></label>
        <input type="text" name="nip" class="form-control" value="">

      </div>
      <div class="col-md-4">
      <label for="file_scan" class="form-label">TANDA TANGAN DIGITAL <span style="color:red;">*)</label>
        <input class="form-control" type="file" id="gambar" name="gambar">
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary px-5 btn-submit">Simpan</button>
        <button type="button" class="btn btn-secondary px-5 btn-cancel">Kembali</button>
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




</script>
@endsection