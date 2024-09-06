<div class="row">
  <div class="col-sm-12 col-md-5 col-12">
    <div class="card border-top border-0 border-4 border-primary panel-form">
      <div class="card-body p-3">
        <div class="card-title d-flex align-items-center">
          <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
          </div>
          <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif Surat Tugas</h5>
        </div>
        <hr>
        <form class="row g-3 form-save">
          @if(!empty($data))
            <input type="hidden" class="form-control" name="id" id="id" value="{{$data->id_surat_perjalanan_dinas}}">
          @endif
          <div class="col-md-12" style="display:none">
            <label for="jenis_surat_id" class="form-label">Jenis Surat *</label>
            <select class="form-select jenis_surat" name="jenis_surat_id" id="jenis_surat_id">
              <option value="154" selected>Pilih Jenis Surat</option>

            </select>
          </div>
          <div class="col-md-12">
            <label for="yang_bertanda_tangan" id="label_tujuan_surat" class="form-label">Penanda Tangan *</label>
            <select class="form-select bertanda_tangan" name="yang_bertanda_tangan" id="yang_bertanda_tangan">
            <option value="" selected disabled>Pilih penanda tangan</option>
                @if (!empty($tanda_tangan))
                  @foreach ($tanda_tangan as $ttd)
                    <option data-jabatan="{{$ttd->jabatan}}" value="{{$ttd->id_mst_asn}}"  @if(!empty($data)) @if ($data->yang_bertanda_tangan_asn_id == $ttd->id_mst_asn)  selected="selected" @endif @endif>{{$ttd->nama_asn}}</option>
                  @endforeach
                @endif
            </select>
          </div>
          <div class="col-md-12" id="content-surat-pendukung"  @if(empty($data)) style="display: none;" @else @if ($data->penandatangan->jabatan != 0) style="display: none;" @endif @endif >
            <label for="surat_pendukung" class="form-label">Surat Pendukung</label>
            <input class="form-control" type="file" id="surat_pendukung" name="surat_pendukung">
          </div>
          <div class="col-md-12">
            <label for="tujuan_surat_id" id="label_tujuan_surat" class="form-label">Pilih Pegawai *</label>
            <select class="form-select tujuan_surat" multiple="multiple" name="tujuan_surat_id[]" id="tujuan_surat_id">
                <option value="" disabled>Pilih Pegawai</option>
                @if (!empty($instansi))
                  @foreach ($instansi as $inst)
                    <option value="{{$inst->id_mst_asn}}" @if(!empty($data)) @php $ins = explode(",",$data->asn_id); @endphp @foreach ($ins as $key) @if ($inst->id_mst_asn == $key) selected @endif @endforeach @endif>{{$inst->nama_asn}}</option>
                  @endforeach
                @endif
            </select>
          </div>
          <div class="col-md-12">
            <label for="tanggal_surat" class="form-label">Tanggal Surat *</label>
            <input type="date" @if(!empty($data)) value="{{date('Y-m-d',strtotime($data->tanggal_surat))}}" @else value="{{date('Y-m-d')}}" @endif class="form-control tanggal_surat" name="tanggal_surat" id="tanggal_surat">
          </div>
          <div class="col-md-12">
            <label for="perihal_surat" class="form-label">Perihal Surat *</label>
            <input type="text" placeholder="Perihal surat" style="" class="form-control"  name="perihal_surat" id="perihal_surat" @if(!empty($data)) value="{{$data->perihal_surat}}" @endif >
          </div>
          <div class="col-md-12">
            <label for="isi_ringkas_surat" class="form-label">Isi Ringkas Surat *</label>
              <textarea rows="3" cols="80" class="form-control" name="isi_ringkas_surat" id="isi_ringkas_surat" placeholder="Isi ringkas surat">@if(!empty($data)){{$data->isi_ringkas_surat}}@endif</textarea>
          </div>
          <div class="col-md-12 panelSuratTugas">
            <div class="row">
              <div class="col-md-12">
                <label for="alat_angkut" class="form-label">Kendaraan *</label>
                <select class="form-control alat-angkut" name="alat_angkut" id="alat_angkut">
                <option value="" selected disabled>Pilih Kendaraan</option>
                  <option value="Kendaraan Umum" @if(!empty($data)) @if ($data->alat_angkut == 'Kendaraan Umum') selected="selected" @endif @endif>Kendaraan Umum</option>
                  <option value="Kendaraan Dinas" @if(!empty($data)) @if ($data->alat_angkut == 'Kendaraan Dinas') selected="selected" @endif @endif>Kendaraan Dinas</option>
                </select>
              </div>
            </div>
          </div>
          <div id="pengikut" style="display: none">
            <div class="col-md-12 mt-2">
              <label for="pengikut" class="form-label">Detail Pengikut *</label>
                <hr>
                <table class="table mb-0" width="100%" id="table_pengikut">
                  <thead>
                    <th>Nama Pengikut</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-2">
              <button type="button" class="btn btn-primary btn-sm form-control" data-bs-toggle="modal"
              data-bs-target="#listPengikut">
              <i class="bx plus-circle me-1"></i>
              Tambah Pengikut</button>
            </div>
          </div>
          <div class="col-md-12 panelSuratTugas">
            <div class="row">
              <div class="col-md-6">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai *</label>
                <input type="date" class="form-control"  name="tanggal_mulai" id="tanggal_mulai" @if(!empty($data)) value="{{$data->tanggal_mulai}}" @else value="{{date('Y-m-d')}}" @endif>
              </div>
              <div class="col-md-6">
                <label for="tanggal_akhir" class="form-label">Tanggal Selesai *</label>
                <input type="date" class="form-control"  name="tanggal_akhir" id="tanggal_akhir" @if(!empty($data)) value="{{$data->tanggal_akhir}}" @else value="{{date('Y-m-d')}}" @endif>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            {{-- BARU 23/06/23 --}}
            <label for="perihal_surat" class="form-label">Tempat Bertugas *</label>
            <input type="text" placeholder="Tempat bertugas" style="" class="form-control"  name="#" id="#" >
          </div>
          <div class="col-md-12">
            {{-- BARU 13/06/24 --}}
            <input class="form-check-input" type="checkbox" value="" {{$data ? 'checked' : ''}} id="keterangan">
            <label class="form-check-label" for="keterangan">
                Tambah Keterangan
            </label>
          </div>
          <div class="col-md-12" style="display: none" id="tambah_keterangan">
            <label for="keterangan" class="form-label">Keterangan *</label>
            <input type="text" placeholder="Keterangan" style="" class="form-control" @if (!empty($data))
                value="{{$data->keterangan}}"
            @endif name="keterangan">
          </div>
          <div class="col-md-12 panelSuratTugas">
            <div class="row">
              <div class="panelTujuanBertugas">
                <div class="col-md-12">
                  <label for="alat_angkut" class="form-label">Detail Perjalanan Bertugas *</label>
                  <hr>
                  <table class="table mb-0" width="100%" id="table_tujuan_bertugas">
                    <thead>
                      <th>Tanggal Mulai</th>
                      <th>Tanggal Akhir</th>
                      <th>Lokasi</th>
                      <th>Aksi</th>
                    </thead>
                    <tbody>
                      {{-- @if (!empty($tujuan_tugas))
                        @foreach ($tujuan_tugas as $key => $value)
                          <tr id="row{{ $value->id_tujuan_perjalanan_dinas }}">
                            <td>
                              <input type="hidden" name="id_tujuan_perjalanan_dinas[]" value="{{ $value->id_tujuan_perjalanan_dinas }}" />
                              <input type="hidden" name="tanggal_mulai_tugas[]" value="{{ $value->tanggal_mulai_tugas }}" />{{ $value->tanggal_mulai_tugas }}
                              <input type="hidden" name="tanggal_akhir_tugas[]" value="{{ $value->tanggal_akhir_tugas }}" />
                              <input type="hidden" name="tempat_tujuan_bertugas[]" value="{{ $value->tempat_tujuan_bertugas }}"/>
                              <input type="hidden" name="provinsi_tujuan_bertugas[]" value="{{ $value->provinsi_tujuan_bertugas }}" />
                              <input type="hidden" name="alamat_tujuan_bertugas[]" value="{{ $value->alamat_tujuan_bertugas }}" />
                            </td>
                            <td>{{ $value->tanggal_akhir_tugas }}</td>
                            <td>{{ $value->tempat_tujuan_bertugas }}</td>
                            <td><button type="button" style="height: 36px;width: 36px;color: #e91e63!important;" class="btn btn_remove_tujuan" name="remove" id="{{ $value->id_tujuan_perjalanan_dinas }}"><i class="bx bx-trash me-0"></button></td>
                          </tr>
                        @endforeach
                      @endif --}}
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                  <button type="button" class="btn btn-primary btn-sm form-control" data-bs-toggle="modal"
                  data-bs-target="#exampleLargeModal">
                  <i class="bx plus-circle me-1"></i>
                  Tambah Detail Perjalanan Bertugas</button>
                </div>
              </div>

            </div>
          </div>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">
                <button type="button" class="btn btn-secondary px-4 btn-cancel">Kembali</button>
              </div>
              <div class="col-md-4">
                {{-- <button type="button" class="btn btn-info px-3">Preview</button> --}}
              </div>
              <div class="col-md-4">
                <button type="button"  class="btn btn-primary px-4 btn-submit">Simpan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-md-7 col-12">
    <div class="card border-top border-0 border-4 border-primary panel-form">
      <div class="card-body p-3">
        <div class="card-title d-flex align-items-center">
          <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
          </div>
          <h5 class="mb-0 text-primary">Preview Surat Tugas</h5>
        </div>
        <hr>
        <form class="row g-3 form-save" style="height: 920px">
          <div class="col-md-12 panelPreview" id="panelPreview">
            @if (!empty($file_tugas[0]->file_surat_tugas))
              <iframe  width="100%" height="850px" src="{{asset('storage/surat-tugas/'.$file_tugas[0]->file_surat_tugas)}}"></iframe>
              @else
              <img style="display: block;margin-left: auto;margin-right: auto;width: 50%;" src="https://media.istockphoto.com/id/924949200/vector/404-error-page-or-file-not-found-icon.jpg?s=170667a&w=0&k=20&c=gsR5TEhp1tfg-qj1DAYdghj9NfM0ldfNEMJUfAzHGtU=" alt="">
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal-page">
  <div class="modal fade" id="exampleLargeModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tujuan Bertugas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label for="tanggal_mulai_tugas" class="form-label">Tanggal Berangkat *</label>
              <input type="date" class="form-control" name="tanggal_mulai_tugas" id="tanggal_mulai_tugas" value="{{date('Y-m-d')}}">
            </div>
            <div class="col-md-6">
              <label for="tanggal_akhir_tugas" class="form-label">Tanggal Tiba *</label>
              <input type="date" class="form-control"  name="tanggal_akhir_tugas" id="tanggal_akhir_tugas" value="{{date('Y-m-d')}}">
            </div>
            <div class="col-md-6">
              <label for="tempat_tujuan_bertugas" class="form-label">Berangkat Dari *</label>
              <input type="text" style="#" class="form-control"  name="tempat_tujuan_bertugas" id="tempat_tujuan_bertugas" value=""  placeholder="Berangkat Dari">
            </div>
            <div class="col-md-6">
              <label for="provinsi_tujuan_bertugas" class="form-label">Kota Tujuan Bertugas *</label>
              <input type="text" style="#" class="form-control"  name="provinsi_tujuan_bertugas" id="provinsi_tujuan_bertugas" value="" placeholder="Kota tujuan bertugas">
            </div>
            {{-- <div class="col-md-12">
              <label for="alamat_tujuan_bertugas" class="form-label">Alamat Tujuan Bertugas *</label>
                <textarea rows="3" cols="80" style="#" class="form-control" name="alamat_tujuan_bertugas" id="alamat_tujuan_bertugas" placeholder="Alamat tujuan bertugas"></textarea>
            </div> --}}
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="AddTujuan()">Tambah</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal-page">
  <div class="modal fade" id="listPengikut" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pengikut</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label for="tempat_tujuan_bertugas" class="form-label">Nama Pengikut *</label>
              <input type="text" style="#" class="form-control"  name="nama_pengikut[]" id="nama_pengikut" value=""  placeholder="Nama Pengikut">
            </div>
            <div class="col-md-6">
              <label for="provinsi_tujuan_bertugas" class="form-label">Jabatan *</label>
              <input type="text" style="#" class="form-control"  name="jabatan_pengikut[]" id="jabatan_pengikut" value="" placeholder="Jabatan">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="AddPengikut()">Tambah</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    if($('#keterangan').is(':checked')) {
        $('#tambah_keterangan').show();
    }
    $('#keterangan').on('change', function () {
        if ($(this).is(':checked')) {
            $('#tambah_keterangan').show();
        } else {
            $('#tambah_keterangan').hide();
        }
    });
    // $('#alat_angkut').on('change', function() {
    //     var selectedValue = $(this).val();
    //     if (selectedValue == 'Kendaraan Dinas') {
    //       $('#pengikut').show()
    //     } else {
    //       $('#pengikut').hide()
    //     }
    //     console.log(selectedValue);
    // });
})
var onLoad = (function() {
  $('.panel-form').animateCss('bounceInUp');
  // $('.panelSuratManual').hide();
  $('.tujuan_surat').select2({
    theme: 'bootstrap4',
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: "Pilih pegawai",
    allowClear: Boolean($(this).data('allow-clear')),
    tags: true,
  });

  $('.bertanda_tangan').select2({
    theme: 'bootstrap4',
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
    tags: true,
  });
  $('.alat-angkut').select2({
    theme: 'bootstrap4',
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
    tags: true,
  });

  var tanggal_mulai = $('#tanggal_mulai').val();
  var tanggal_akhir = $('#tanggal_akhir').val();
  var tanggal_mulai_tugas = $('#tanggal_mulai_tugas').attr({
    "max" : tanggal_akhir,        // substitute your own
    "min" : tanggal_mulai          // values (or variables) here
  });
  var tanggal_akhir_tugas = $('#tanggal_akhir_tugas').attr({
    "max" : tanggal_akhir,        // substitute your own
    "min" : tanggal_mulai          // values (or variables) here
  });
})();

$('.btn-cancel').click(function(e){
  e.preventDefault();
  $('.panel-form').animateCss('bounceOutDown');
  $('.other-page').fadeOut(function(){
    $('.other-page').empty();
    $('.main-page').fadeIn();
    // $('#datagrid').DataTable().ajax.reload();
  });
});

$('#yang_bertanda_tangan').on('change', function() {
  var selectedOption = $(this).find('option:selected');
  var jabatan = selectedOption.attr('data-jabatan');
  if(jabatan == '0'){
    $('#content-surat-pendukung').show();
  }else{
    $('#content-surat-pendukung').hide();
  }

});
$('.btn-submit').click(function(e){
 e.preventDefault();
    // $('.btn-submit').html('Please wait...').attr('disabled', true);
    var btn = $(this);
    btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...').attr('disabled', true);
    $('.btn-submit');
    var data  = new FormData($('.form-save')[0]);
    array_tujuan.forEach(element => {
      data.append("tujuan[]",element);
    });
    $.ajax({
        url: "{{ route('store-surat-tugas') }}",
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
         btn.html('Simpan').attr('disabled', false);
        $('.btn-submit');
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
        btn.html('Simpan').attr('disabled', false);
        var n = 0;
        for(key in data){
        if (n == 0) {var dt0 = key;}
        n++;
        }
        $('.btn-submit');
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
        btn.html('Simpan').attr('disabled', false);
      $('.btn-submit');
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

$("#noSuratManual").change(function() {
    if(this.checked) {
        $('.panelSuratManual').show();
    }else {
      $('.panelSuratManual').hide();
    }
});

$('#jenis_surat_id').on("change", function(e) {
  var id = $("#jenis_surat_id :selected").val();
  $.post("{!! route('getJenisSuratById') !!}", {
    id: id
  }).done(function(data) {
    $('#no_surat2').val(data.kode_jenis_surat);
    if (data.kode_jenis_surat == 090 ||data.kode_jenis_surat == 091 || data.kode_jenis_surat == 092 || data.kode_jenis_surat == 093 || data.kode_jenis_surat == 094 || data.kode_jenis_surat == 095) {
      $('.panelSuratTugas').show();
      $(".tujuan_surat").select2(
        {
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
          // tags: true,
          ajax: {
            url: "{{route('getAsnByName')}}",
            dataType: 'json',
            type: "POST",
            // delay: 250,
            data: function (params) {
              return {
                id: params.term
              };
            },
            processResults: function (data) {
              return {
                results: $.map(data, function (item) {
                  return {
                    id: item.id_mst_asn,
                    text: item.nama_asn,
                  }
                })
              };
            }
          },
        });
        $('#label_tujuan_surat').text('Pilih Pegawai *')

    }else {
      $('.panelSuratTugas').hide();
      $(".tujuan_surat").select2(
        {
          theme: 'bootstrap4',
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
          allowClear: Boolean($(this).data('allow-clear')),
          // tags: true,
          ajax: {
            url: "{{route('getInstansiByName')}}",
            dataType: 'json',
            type: "POST",
            // delay: 250,
            data: function (params) {
              return {
                id: params.term
              };
            },
            processResults: function (data) {
              return {
                results: $.map(data, function (item) {
                  return {
                    id: item.id_instansi,
                    text: item.nama_instansi,
                  }
                })
              };
            }
          },
        });
        $('#label_tujuan_surat').text('Tujuan Surat Kepada *')
    }
  });
});

/**
* FUNCTION UNTUK CEK PERBEDAAN TANGGAL
*  KETIKA TANGGAL BEDA 1 HARI ATAU LEBIH MAKA TAMPILKAN FORM TABEL
*/


// $('#tanggal_akhir').change(function(){
//
//   let date_1 = new Date($('#tanggal_akhir').val());
//   let date_2 = new Date($('#tanggal_mulai').val());
//
//   const days = (date_1, date_2) =>{
//     let difference = date_1.getTime() - date_2.getTime();
//     let TotalDays = Math.ceil(difference / (1000 * 3600 * 24));
//     return TotalDays;
//   }
// });
var tujuan_sementara = [];
var array_tujuan = [];
var noTujuan = 1;
  @if (!empty($tujuan_tugas))
  @empty(!$tujuan_tugas)
  @foreach ($tujuan_tugas as $detailtujuan)
  var tujuan_sementara = [
    '{{ $detailtujuan->tanggal_mulai_tugas }}',
    '{{ $detailtujuan->tanggal_akhir_tugas }}',
    '{{ $detailtujuan->tempat_tujuan_bertugas }}',
    '{{ $detailtujuan->provinsi_tujuan_bertugas }}',
    '{{ $detailtujuan->alamat_tujuan_bertugas }}',
    {{ $detailtujuan->id_tujuan_perjalanan_dinas }},

  ]
  array_tujuan.push(tujuan_sementara);
  @endforeach
  // console.log(array_tujuan);
  array_tujuan.forEach(element => {
    $('#table_tujuan_bertugas tbody').before('<tr id="row'+element[5]+'"><td><input type="hidden" name="id_tujuan_perjalanan_dinas[]" value="'+element[5]+'" /><input type="hidden" name="tanggal_mulai_tugas[]" value="'+element[0]+'" id="tanggal_mulai_tugas'+element[5]+'" />' +element[0]+'<input type="hidden" name="tanggal_akhir_tugas[]" value="'+element[1]+'" id="tanggal_akhir_tugas'+element[5]+'" /><input type="hidden" name="tempat_tujuan_bertugas[]" value="'+element[2]+'" id="tempat_tujuan_bertugas'+element[5]+'" /><input type="hidden" name="provinsi_tujuan_bertugas[]" value="'+element[4]+'" id="provinsi_tujuan_bertugas'+element[5]+'" /><input type="hidden" name="alamat_tujuan_bertugas[]" value="'+element[5]+'" id="alamat_tujuan_bertugas'+element[5]+'" /></td><td> '+element[1]+' </td><td>'+element[2]+'</td><td><button type="button" style="height: 36px;width: 36px;color: #e91e63!important;" class="btn btn_remove_tujuan" name="remove" id="'+element[5]+'"><i class="bx bx-trash me-0"></button></td></tr>');
  });
  $('.unwrap-tbody').unwrap();
  @endempty
  @endif

function AddTujuan() {
  ++noTujuan;
  var tanggal_mulai_tugas = $("input[id='tanggal_mulai_tugas']").val();
  var tanggal_akhir_tugas = $("input[id='tanggal_akhir_tugas']").val();
  var tempat_tujuan_bertugas = $("input[id='tempat_tujuan_bertugas']").val();
  var provinsi_tujuan_bertugas = $("input[id='provinsi_tujuan_bertugas']").val();
  var alamat_tujuan_bertugas = $("#alamat_tujuan_bertugas").val();

  $('#table_tujuan_bertugas tbody').before('<tr id="row'+noTujuan+'"><td><input type="hidden" name="id_tujuan_perjalanan_dinas[]" value="0" /><input type="hidden" name="tanggal_mulai_tugas[]" value="'+tanggal_mulai_tugas+'" id="tanggal_mulai_tugas'+noTujuan+'" />' +tanggal_mulai_tugas+'<input type="hidden" name="tanggal_akhir_tugas[]" value="'+tanggal_akhir_tugas+'" id="tanggal_akhir_tugas'+noTujuan+'" /><input type="hidden" name="tempat_tujuan_bertugas[]" value="'+tempat_tujuan_bertugas+'" id="tempat_tujuan_bertugas'+noTujuan+'" /><input type="hidden" name="provinsi_tujuan_bertugas[]" value="'+provinsi_tujuan_bertugas+'" id="provinsi_tujuan_bertugas'+noTujuan+'" /><input type="hidden" name="alamat_tujuan_bertugas[]" value="'+alamat_tujuan_bertugas+'" id="alamat_tujuan_bertugas'+noTujuan+'" /></td><td> '+tanggal_akhir_tugas+' </td><td> '+tempat_tujuan_bertugas+' </td><td><button type="button" style="height: 36px;width: 36px;color: #e91e63!important;" class="btn btn_remove_tujuan" name="remove" id="'+noTujuan+'"><i class="bx bx-trash me-0"></button></td></tr>');
  var tujuan_sementara = [tanggal_mulai_tugas,tanggal_akhir_tugas,tempat_tujuan_bertugas,provinsi_tujuan_bertugas,alamat_tujuan_bertugas];
  array_tujuan.push(tujuan_sementara);
  tanggal_mulai_tugas = $("input[id='tanggal_mulai_tugas']").val("{{date('Y-m-d')}}");
  tanggal_akhir_tugas = $("input[id='tanggal_akhir_tugas']").val("{{date('Y-m-d')}}");
  tempat_tujuan_bertugas = $("input[id='tempat_tujuan_bertugas']").val('');
  provinsi_tujuan_bertugas = $("input[id='provinsi_tujuan_bertugas']").val('');
  alamat_tujuan_bertugas = $("#alamat_tujuan_bertugas").val('');
  $('#btnSave').click(function() {
   $('#StudentModal').modal('hide');
});
}

// let array_pengikut = [];
// function AddPengikut() {
//   ++noTujuan;
//   var nama_pengikut = $("input[id='nama_pengikut']").val();
//   var jabatan_pengikut = $("input[id='jabatan_pengikut']").val();

//   $('#table_pengikut tbody').before(
//     '<tr id="row' + noTujuan + '">' +
//         '<input type="hidden" name="nama_pengikut[]" value="' + nama_pengikut + '" id="nama_pengikut' + noTujuan + '" />' +
//         '<input type="hidden" name="jabatan_pengikut[]" value="' + jabatan_pengikut + '" id="jabatan_pengikut' + noTujuan + '" /></td>' +
//         '<td>' + nama_pengikut + '</td>' +
//         '<td>' + jabatan_pengikut + '</td>' +
//         '<td><button type="button" style="height: 36px; width: 36px; color: #e91e63!important;" class="btn btn_remove_pengikut" name="remove" id="' + noTujuan + '">' +
//         '<i class="bx bx-trash me-0"></i></button></td>' +
//     '</tr>'
// );
//   var pengikut = [nama_pengikut,jabatan_pengikut,];
//   array_pengikut.push(pengikut);
//   nama_pengikut = $("input[id='nama_pengikut']").val('');
//   jabatan_pengikut = $("input[id='jabatan_pengikut']").val('');
// }
$(document).on('click', '.btn_remove_pengikut', function(){
 // alert("yu");
     var button_id = $(this).attr("id");
     $('#row'+button_id+'').remove();
     array_pengikut = array_pengikut.filter(x=>x[0]!=button_id);

 });
 $(document).on('click', '.btn_remove_tujuan', function(){
     var button_id = $(this).attr("id");
     $('#row'+button_id+'').remove();
     array_tujuan = array_tujuan.filter(x=>x[0]!=button_id);

 });



 $('.btn-preview').click(function(){
   kosong();
   var data  = new FormData($('.form-save')[0]);
   array_tujuan.forEach(element => {
     data.append("tujuan[]",element);
   });
   $.ajax({
       url: "@{{ route('previewST') }}",
       type: 'GET',
       data: data,
       async: true,
       cache: false,
       contentType: false,
       processData: false
   }).done(function(data){
     console.log(data);
   });
 });
 $('#tanggal_mulai').change(function(){
   var tanggal_mulai = $('#tanggal_mulai').val();
   var tanggal_akhir = $('#tanggal_akhir').val();
   var tanggal_mulai_tugas = $('#tanggal_mulai_tugas').attr({
     "max" : tanggal_akhir,        // substitute your own
     "min" : tanggal_mulai          // values (or variables) here
   });
   var tanggal_akhir_tugas = $('#tanggal_akhir_tugas').attr({
     "max" : tanggal_akhir,        // substitute your own
     "min" : tanggal_mulai          // values (or variables) here
   });
 });
 $('#tanggal_akhir').change(function(){
   var tanggal_mulai = $('#tanggal_mulai').val();
   var tanggal_akhir = $('#tanggal_akhir').val();
   var tanggal_mulai_tugas = $('#tanggal_mulai_tugas').attr({
     "max" : tanggal_akhir,        // substitute your own
     "min" : tanggal_mulai          // values (or variables) here
   });
   var tanggal_akhir_tugas = $('#tanggal_akhir_tugas').attr({
     "max" : tanggal_akhir,        // substitute your own
     "min" : tanggal_mulai          // values (or variables) here
   });
 });

//  Ketika buat surat tugas otomatis buat SPPD
function buatSPPD(id, surat_tugas_id) {
  // console.log(id, surat_tugas_id)
  $.post("{!! route('buatSPPD') !!}",{id:id, surat_tugas_id:surat_tugas_id}).done(function(data){
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
        $('#modal-list-surat-tugas').modal('hide');
        $('.modal-list-surat-tugas').html('');

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
  });
}

</script>
