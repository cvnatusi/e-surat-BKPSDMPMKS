@extends('component.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
@endsection
@section('content')
    <h6 class="mb-0 text-uppercase">{{ $data['title'] }}</h6>
    <hr>
    <div class="card main-page">
        <div class="card-body">
            {{-- filter tanggal --}}
            <div class="col-md-12" style="margin-bottom: 20px;">
                <div class="row">
                    <div class="col-md-2">              
                        <label class="form-label">Tambah Surat Keluar</label>
                        <button type="button" class="btn btn-primary btn-add form-control"><i
                                class="bx bx-plus me-1"></i>Surat Baru</button>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-3 mb-3 panelTanggal">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" id="min" class="form-control datepickertanggal" value="{{date('Y-m-01')}}">
                    </div>
                    <div class="col-md-3 mb-3 panelTanggal">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" id="max" class="form-control datepickertanggal" value="{{date('Y-m-t')}}">
                    </div>
                    
                </div>
                <hr>
            </div>
            <div class="table-responsive">
                <!-- <button type="button" class="btn btn-primary btn-add" style="width: 170px;"><i class="bx bx-plus me-1"></i>Tambah</button>
                <p></p> -->
                <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
                    <thead>
                        {{-- <td>NO</td> --}}
                        <td>NO</td>
                        <td>NO SURAT</td>
                        {{-- <td>JENIS SURAT</td> --}}
                        <td>TANGGAL SURAT</td>
                        <td>TUJUAN</td>
                        <td>PERIHAL</td>
                        <!-- <td>VERIF KABAN</td> -->
                        <td>AKSI</td>
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
        // filter tanggal awal akhir
        $('#min').change(() => {
            var start = $('#min').val()
            var end = $('#max').val()
            loadTable(start, end);
        })
        $('#max').change(() => {
            var start = $('#min').val()
            var end = $('#max').val()
            loadTable(start, end);
        })

        $(document).ready(function() {
            // var date = new Date();
            // var day = date.getDate();
            // var month = date.getMonth() + 1;
            // var year = date.getFullYear();

            // if (month < 10) month = "0" + month;
            // if (day < 10) day = "0" + day;

            // var today = year + "-" + month + "-" + day;
            // $("#min").attr("value", today);
            // $("#max").attr("value", today);

            //initial run
            // loadTable(today, today);
            var start = $('#min').val()
            var end = $('#max').val()
            loadTable(start, end);
        });

        function loadTable(dateStart, dateEnd) {
            var table = $('#datagrid').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                "pageLength": 25,
                scrollX: true,
                scrollY: 350,
                language: {
                    searchPlaceholder: "Ketikkan yang dicari"
                },
                ajax: {
                    url: "{{ route('surat-keluar') }}",
                    type: 'get',
                    data: {
                        tglAwal: dateStart,
                        tglAkhir: dateEnd
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [
                    //   {
                    //   data: 'DT_RowIndex',
                    //   name: 'DT_RowIndex',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
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
                            return '<button type="button" class="btn btn-sm btn-info">' + data + '</button>'
                            // return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    // {
                    //     data: 'jenis.nama_jenis_surat',
                    //     name: 'jenis.nama_jenis_surat',
                    //     render: function(data, type, row) {
                    //         return '<p style="color:black">' + data + '</p>';
                    //     }
                    // },
                    {
                        data: 'tanggal_surat',
                        name: 'tanggal_surat',
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
                        data: 'perihal_surat',
                        name: 'perihal_surat',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    // {
                    //   data: 'verifKABAN',
                    //   name: 'verifKABAN',
                    //   orderable: false,
                    //   searchable: false
                    // },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }




        // $(function() {
        //   var table = $('#datagrid').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     language: {
        //       searchPlaceholder: "Ketikkan yang dicari"
        //     },
        //     ajax: "{{ route('surat-keluar') }}",
        //     order: [[0, 'desc']],
        //     columns: [
        //     //   {
        //     //   data: 'DT_RowIndex',
        //     //   name: 'DT_RowIndex',
        //     //   render: function(data, type, row) {
        //     //     return '<p style="color:black">' + data + '</p>';
        //     //   }
        //     // },
        //     {
        //       data: 'no_agenda',
        //       name: 'no_agenda',
        //       render: function(data, type, row) {

        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'nomor_surat_keluar',
        //       name: 'nomor_surat_keluar',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'jenis.nama_jenis_surat',
        //       name: 'jenis.nama_jenis_surat',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'tanggal_surat',
        //       name: 'tanggal_surat',
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
        //       data: 'perihal_surat',
        //       name: 'perihal_surat',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'verifKABAN',
        //       name: 'verifKABAN',
        //       orderable: false,
        //       searchable: false
        //     },
        //     {
        //       data: 'action',
        //       name: 'action',
        //       orderable: false,
        //       searchable: false
        //     },
        //     ]
        //   });
        // });

        $('.btn-add').click(function() {
            // $('.preloader').show();
            $('.main-page').hide();
            $.post("{!! route('form-surat-keluar') !!}").done(function(data) {
                if (data.status == 'success') {
                    // $('.preloader').hide();
                    $('.other-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        });

        function editForm(id) {
            $('.main-page').hide();
            $.post("{!! route('form-surat-keluar') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.other-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }

        function showForm(id) {
            // $('.main-page').hide();
            $.post("{!! route('show-surat-keluar') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.modal-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }

        function editDisabledForm(id) {
            swal('Whoops!', 'Data Sudah di Verifikasi, Tidak Bisa di Edit!', 'warning');
        }

        function deleteForm(id) {
            swal({
                title: "Apakah Anda yakin akan menghapus data ini ?",
                text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus Data!',
            }).then((result) => {
                if (result.value) {
                    $.post("{!! route('destroy-surat-keluar') !!}", {
                        id: id
                    }).done(function(data) {
                        Lobibox.notify('success', {
                            pauseDelayOnHover: true,
                            size: 'mini',
                            rounded: true,
                            delayIndicator: false,
                            icon: 'bx bx-check-circle',
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            sound: false,
                            msg: data.message
                        });
                        $('.preloader').show();
                        $('#datagrid').DataTable().ajax.reload();
                    }).fail(function() {
                        Lobibox.notify('error', {
                            pauseDelayOnHover: true,
                            size: 'mini',
                            rounded: true,
                            delayIndicator: false,
                            icon: 'bx bx-x-circle',
                            continueDelayOnInactiveTab: false,
                            position: 'top right',
                            sound: false,
                            msg: "Data Gagal Dihapus, Silahkan Hubungi IT Anda!"
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
                        sound: false,
                        msg: "Data batal di hapus!"
                    });
                    $('#datagrid').DataTable().ajax.reload();
                }
            });
        };
        // function namaPenerima(row){
        //   let data = row.tujuan_surat_id
        //   const myArray = data.split(",");
        //   var arrDat = []
        //   if(myArray.length>0){
        //     // $.each(myArray,(i,v)=>{
        //     //   $.post("{!! route('getInstansiById') !!}",{id:v}).done(function(result){
        //     //     console.log(result.kode_instansi);
        //     //       if(result.status == 'success'){
        //     //         arrDat.push(result.kode_instansi)
        //     //       }
        //     //   });
        //     // })
        //     // // console.log(arrDat);
        //     // // return "<p style='color:black'>"+arrDat.join(', ')+"</p>"
        //     // return "<p style='color:black'>-</p>"
        //   }else{
        //     return "-"
        //   }
        // }
        function showSuratTugas(id) {
            // $('.main-page').hide();
            $.post("{!! route('list-surat-tugas') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.modal-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }

        function showSuratSPPD(id) {
            $.post("{!! route('list-sppd') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.modal-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }
        // disini tambahkan pengecekan dia tte atau TTD
        // semisal dia tte pakai format yang dibawah ini
        // // // title: "Verifikasi TTE!",
        // // // text: "Masukkan Passphrase :",
        // // // input: 'password',
        // semisal dia ttd tanpa memasukkan verif tte

        function verifKABAN(id, ttd) {
            // console.log(ttd)
            if (ttd) {

                Swal.fire({
                    title: "Verifikasi TTE!",
                    text: "Masukkan Passphrase :",
                    input: 'password',
                    showCancelButton: true
                }).then((result) => {
                    if (result.value) {
                        // console.log("Result: " + result.value);
                        $.post("{!! route('verifKABAN') !!}", {
                            async: false,
                            beforeSend: function() {
                                $('#' + id).html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                                ).attr('disabled', true);
                            },
                            // complete: function(){
                            //   $('.loader').hide();
                            // }
                            id: id,
                            ps: result.value
                        }).done(function(data) {
                            if (data.status == 'success') {
                                Lobibox.notify('success', {
                                    pauseDelayOnHover: true,
                                    size: 'mini',
                                    rounded: true,
                                    delayIndicator: false,
                                    icon: 'bx bx-check-circle',
                                    continueDelayOnInactiveTab: false,
                                    position: 'top right',
                                    sound: false,
                                    msg: data.message
                                });
                            } else {
                                Lobibox.notify('error', {
                                    pauseDelayOnHover: true,
                                    size: 'mini',
                                    rounded: true,
                                    delayIndicator: false,
                                    icon: 'bx bx-x-circle',
                                    continueDelayOnInactiveTab: false,
                                    position: 'top right',
                                    sound: false,
                                    msg: data.message
                                });
                            }
                            $('.preloader').show();
                            $('#datagrid').DataTable().ajax.reload();
                        }).fail(function() {
                            Lobibox.notify('error', {
                                pauseDelayOnHover: true,
                                size: 'mini',
                                rounded: true,
                                delayIndicator: false,
                                icon: 'bx bx-x-circle',
                                continueDelayOnInactiveTab: false,
                                position: 'top right',
                                sound: false,
                                msg: "Data Gagal di Verifikasi, Silahkan Hubungi IT Anda!"
                            });
                        });
                    }
                });

            } else {

                $.post("{!! route('verifKABAN') !!}", {
                    //  async: false,
                    //  beforeSend: function(){
                    //    $('#'+id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
                    //  },
                    id: id,
                    ttd: false
                }).done(function(data) {
                    console.log(data)
                })
            }


        }
    </script>
@endsection
