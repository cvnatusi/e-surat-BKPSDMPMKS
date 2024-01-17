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
                    <div class="col-md-3 mb-3 panelTanggal">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" id="min" class="form-control datepickertanggal" value="{{date('Y-m-01')}}">
                    </div>
                    <div class="col-md-3 mb-3 panelTanggal">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" id="max" class="form-control datepickertanggal" value="{{date('Y-m-t')}}">
                    </div>
                </div>
                {{-- <hr> --}}
            </div>
            <div class="table-responsive">
                {{-- <button type="button" class="btn btn-primary px-5 mb-1 btn-add"><i class="bx bx-plus me-1"></i>Tambah</button> --}}
                <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
                    <thead>
                        <td>PILIH</td>
                        <!-- <td>NO</td>
                <td>NO AGENDA</td> -->
                        <td>NO SURAT</td>
                        <td>TANGGAL SURAT</td>
                        <td style="width: 100%">ASN</td>
                        {{-- <td>PERIHAL</td> --}}
                        {{-- <td>SURAT TUGAS & SPPD</td> --}}
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

            // //initial run
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
                language: {
                    searchPlaceholder: "Ketikkan yang dicari"
                },
                ajax: {
                    url: "{{ route('surat-perjalanan-dinas') }}",
                    type: 'get',
                    data: {
                        tglAwal: dateStart,
                        tglAkhir: dateEnd
                    }
                },

                columns: [
                    {
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false,
                    },
                    //   {
                    //   data: 'DT_RowIndex',
                    //   name: 'DT_RowIndex',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    // {
                    //   data: 'surattugas.no_agenda',
                    //   name: 'surattugas.no_agenda',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    {
                        data: 'surattugas.nomor_surat_perjalanan_dinas',
                        name: 'surattugas.nomor_surat_perjalanan_dinas',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'surattugas.tanggal_surat',
                        name: 'surattugas.tanggal_surat',
                        // data: 'created_at',
                        // name: 'created_at',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'pegawai.nama_asn',
                        name: 'pegawai.nama_asn',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //   data: 'surattugas.perihal_surat',
                    //   name: 'surattugas.perihal_surat',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    // {
                    //   data: 'suratTugasSppd',
                    //   name: 'suratTugasSppd',
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
        //     ajax: "{{ route('surat-perjalanan-dinas') }}",

        //     columns: [{
        //       data: 'DT_RowIndex',
        //       name: 'DT_RowIndex',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'surattugas.no_agenda',
        //       name: 'surattugas.no_agenda',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'surattugas.nomor_surat_perjalanan_dinas',
        //       name: 'surattugas.nomor_surat_perjalanan_dinas',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'surattugas.tanggal_surat',
        //       name: 'surattugas.tanggal_surat',
        //       render: function(data, type, row) {
        //         return '<p style="color:black">' + data + '</p>';
        //       }
        //     },
        //     {
        //       data: 'pegawai.nama_asn',
        //       name: 'pegawai.nama_asn',
        //       orderable: false,
        //       searchable: false
        //     },
        //     // {
        //     //   data: 'surattugas.perihal_surat',
        //     //   name: 'surattugas.perihal_surat',
        //     //   render: function(data, type, row) {
        //     //     return '<p style="color:black">' + data + '</p>';
        //     //   }
        //     // },
        //     // {
        //     //   data: 'suratTugasSppd',
        //     //   name: 'suratTugasSppd',
        //     //   orderable: false,
        //     //   searchable: false
        //     // },
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
            $.post("{!! route('form-surat-tugas') !!}").done(function(data) {
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
            $.post("{!! route('form-surat-tugas') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.other-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
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
                    $.post("{!! route('destroy-surat-perjalanan-dinas') !!}", {
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
        function showSuratSPPD(id) {
            $.post("{!! route('show-surat-perjalanan-dinas') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.modal-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }
    </script>
@endsection
