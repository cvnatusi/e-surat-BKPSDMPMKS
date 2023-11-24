
@extends('component.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
@endsection
@section('content')
    <h6 class="mb-0 text-uppercase">{{ $data['title'] }}</h6>
    <hr>
    <div class="card main-page">
        <div class="card-body">

            <div class="col-md-12" style="margin-bottom: 20px;">
                <form id="postForm">
                    <div class="row mb-3">
                        <input type="hidden" name="id" id="id">
                        <div class="col-md-4">
                            <label>Pilih Level Pengguna <small>*)</small></label>
                            <select name="level_pengguna" id="level_pengguna" class="form-control level_pengguna" onchange="getPengguna(this.value)">
                              <option value="">Pilih Level Pengguna</option>
                              <option value="0">SEKRETARIS DAERAH (SEKDA)</option>
                              <option value="1">KABAN</option>
                            </select>
                        </div>
                        <div class="col-md-4" >
                            <label>Pilih Pengguna <small>*)</small></label>
                            <select name="user_id" id="user_id" class="form-control user_id">
                                {{-- <option value="">Pilih Pengguna</option>
                                <option value="0" >Ir. TOTOK HARTONO</option> --}}
                                {{-- <option value="2" >Drs. SAUDI RAHMAN, M.Si</option> --}}
                                {{-- @if (count($data['user']) > 0)
                                    @foreach ($data['user'] as $a)
                                        <option value="{{$a->id}}">{{$a->name}}</option>
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>
			<div class="col-md-4">
                            <label><i>TTE</i> <small>*)</small></label>
                            <input class="form-control" type="file" id="tte" accept="image/png" name="tte">
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-4">
			<button type="button" class="btn btn-primary px-4 btn-submit" id="saveData" >Tambahkan</button>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card main-page">
        <div class="card-body">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped dataTable" id="datatable" style="width: 100%">
                        <thead>
                            <td>NO</td>
                            <td>NAMA PENADATANGAN</td>
                            <td>LEVEL PENGGUNA</td>
                            <td class="text-center">AKSI</td>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
<script type="text/javascript">

    const levelUser = document.getElementById('level_pengguna');
    const userId = document.getElementById('user_id');

    $('.level_pengguna').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        tags: true,
    });
    // $('.user_id').select2('destroy'); 
    $('.user_id').css('display', 'block');
    $('.user_id').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        tags: true,
    });

    function getPengguna(level, selected = '') {
        console.log('testt');
        $.get("{{ route('get-pengguna-bylevel') }}", {
            level: level
        }).done(function(result) {
            let opt = "<option value='' selected disabled>- Pilih -</option> ";
            $.each(result, function(c, v) {
                selct = (selected == v.id_mst_asn) ? 'selected' : '';
                opt += "<option value='" + v.id_mst_asn + "' " + selct + ">" + v.nama_asn +
                    "</option>";
            });
            $('select[name=user_id]').html(opt);
        });
    }

    $(function () {
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('penandaTanganSurat') }}",
            columns: [
                {
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex',
                    
                },
                {
                    data: 'pengguna.nama_asn', 
                    name: 'pengguna.nama_asn'
                },
                {
                    data: 'level', 
                    name: 'level'
                },
                {
                    data: 'action', 
                    name: 'action', 
                    class: 'text-center', 
                    orderable: false, 
                    searchable: false},
            ]
        });

        $('#saveData').click(function (e) {
            console.log('abvsjhbdasduh');
            e.preventDefault();
            var level = $('#level_pengguna').val();
            var pengguna = $('#user_id').val();
            var data  = new FormData($('#postForm')[0]);
            if (!level) {
                swal('Peringatan!', 'Level Pengguna Wajib Diisi', 'warning')
            } else if(!pengguna) {
                swal('Peringatan!', 'Pengguna Wajib Diisi', 'warning')
            } else {
                $.ajax({
                    data: data,
                    url: "{{ route('penandaTanganSuratStore') }}",
                    type: "POST",
                    dataType: 'json',
                    processData: false, 
                    contentType: false,
                    success: function (data) {
                        if (data.code=='200') {
                            location.reload()
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
                        } else{
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
                        }
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        Lobibox.notify('error', {
                            title: 'Maaf!',
                            pauseDelayOnHover: true,
                            size: 'mini',
                            rounded: true,
                            delayIndicator: false,
                            icon: 'bx bx-error',
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            sound:false,
                            msg: data,
                        });
                        $('#savedata').html('Sending...');
                        $('#savedata').attr("disabled", 'disabled');
                    }
                });
            }
        });
    });

    function editData(id) {
        $.get("{{ route('penandaTanganSuratEdit') }}",{'id':id}).done(function(result){
            console.log(result)
            $('#id').val(result.id_penanda_tangan_surat);
            $('#level_pengguna').val(result.level_pengguna).change();
            $("#user_id").val(result.pengguna_id).change();
        });
        $('#saveData').html('UPDATE');
    }

    function deleteData(id) {
            var data  = new FormData($('#postForm')[0]);
            data.append("id_penanda_tangan_surat", id);
            // swal({
            // title: "Apakah Anda yakin akan menghapus data ini ?",
            // text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
            // type: "warning",
            // showCancelButton: true,
            // cancelButtonText: 'Batal',
            // confirmButtonText: 'Ya, Hapus Data!',
            // }).then((result) => {
            // if (result.value) {
            //     $.post("{!! route('penandaTanganSuratDestroy') !!}",{id:id}).done(function(data){
            //     if (data.status == 'success') {
            //         Lobibox.notify('success', {
            //         pauseDelayOnHover: true,
            //         size: 'mini',
            //         rounded: true,
            //         delayIndicator: false,
            //         icon: 'bx bx-check-circle',
            //         continueDelayOnInactiveTab: false,
            //         position: 'top right',
            //         sound:false,
            //         msg: data.message
            //     });
            //     } else {
            //         Lobibox.notify('error', {
            //         pauseDelayOnHover: true,
            //         size: 'mini',
            //         rounded: true,
            //         delayIndicator: false,
            //         icon: 'bx bx-x-circle',
            //         continueDelayOnInactiveTab: false,
            //         position: 'top right',
            //         sound:false,
            //         msg: data.message
            //         });
            //     }
            //     $('.preloader').show();
            //     $('#datagrid').DataTable().ajax.reload();
            //     }).fail(function() {
            //         Lobibox.notify('error', {
            //         pauseDelayOnHover: true,
            //         size: 'mini',
            //         rounded: true,
            //         delayIndicator: false,
            //         icon: 'bx bx-x-circle',
            //         continueDelayOnInactiveTab: false,
            //         position: 'top right',
            //         sound:false,
            //         msg: "Data Gagal Dihapus, Silahkan Hubungi IT Anda!"
            //         });
            //     });
            //     }else if (result.dismiss === Swal.DismissReason.cancel) {
            //     Lobibox.notify('error', {
            //         pauseDelayOnHover: true,
            //         size: 'mini',
            //         rounded: true,
            //         delayIndicator: false,
            //         icon: 'bx bx-error',
            //         continueDelayOnInactiveTab: false,
            //         position: 'top right',
            //         sound:false,
            //         msg: "Data batal di hapus!"
            //     });
            //     $('#datagrid').DataTable().ajax.reload();
            //     }
            // });


            swal({
        title: "Apakah Anda yakin akan menghapus data ini ?",
        text: "Data akan dihapus dan tidak dapat diperbaharui kembali !",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus Data!',
    }).then((result) => {
        if (result.value) {
            // Permintaan penghapusan hanya dieksekusi jika pengguna memilih "Ya, Hapus Data!"
            $.ajax({
                url: "{{ route('penandaTanganSuratDestroy') }}",
                type: 'POST',
                data: data,
                async: true,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(data){
                if (data.status == 'success') {
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
                    location.reload();
                } else {
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
                }
            }).fail(function() {
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
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Lobibox.notify('error', {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                delayIndicator: false,
                icon: 'bx bx-error',
                continueDelayOnInactiveTab: false,
                position: 'top right',
                sound:false,
                msg: 'Data Batal Dihapus !!'
            });
        }
    // });



        //     swal({
        //         title: "Apakah Anda yakin akan menghapus data ini ?",
        //         text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
        //         type: "warning",
        //         showCancelButton: true,
        //         cancelButtonText: 'Batal',
        //         confirmButtonText: 'Ya, Hapus Data!',
        //     }).then((result) => {
        //         $.ajax({
        //         url: "{{ route('penandaTanganSuratDestroy') }}",
        //         type: 'POST',
        //         data: data,
        //         async: true,
        //         cache: false,
        //         contentType: false,
        //         processData: false
        //     }).done(function(data){
        //     if(data.status == 'success'){
        //         Lobibox.notify('success', {
        //             pauseDelayOnHover: true,
        //             size: 'mini',
        //             rounded: true,
        //             delayIndicator: false,
        //             icon: 'bx bx-check-circle',
        //             continueDelayOnInactiveTab: false,
        //             position: 'top right',
        //             sound:false,
        //             msg: data.message
        //         });
        //         location.reload()
        //     } else {
        //         Lobibox.notify('error', {
        //             pauseDelayOnHover: true,
        //             size: 'mini',
        //             rounded: true,
        //             delayIndicator: false,
        //             icon: 'bx bx-x-circle',
        //             continueDelayOnInactiveTab: false,
        //             position: 'top right',
        //             sound:false,
        //             msg: data.message
        //         });
        //     }
        // }).fail(function() {
        //     Lobibox.notify('warning', {
        //         title: 'Maaf!',
        //         pauseDelayOnHover: true,
        //         size: 'mini',
        //         rounded: true,
        //         delayIndicator: false,
        //         icon: 'bx bx-error',
        //         continueDelayOnInactiveTab: false,
        //         position: 'top right',
        //         sound:false,
        //         msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
        //     });
        // });
    });
    }
</script>
@endsection
