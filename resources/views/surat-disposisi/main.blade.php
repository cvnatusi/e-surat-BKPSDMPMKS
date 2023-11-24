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
                        <label class="form-label">Tambah Disposisi</label>
                        <button type="button" class="btn btn-primary btn-add form-control"><i
                                class="bx bx-plus me-1"></i>Buat Baru</button>
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
                <hr>
            </div>
            <div class="table-responsive">
                <!-- <button type="button" class="btn btn-primary btn-add" style="width: 170px;"><i class="bx bx-plus me-1"></i>Tambah</button>
            <p></p> -->
                <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
                    <thead>
                        <td>NO</td>
                        <td>NO AGENDA</td>
                        {{-- <td>NO SURAT</td> --}}
                        <td>PERIHAL SURAT</td>
                        <td>PEMBERI DISPOSISI</td>
                        <td>PENERIMA DISPOSISI</td>
                        <td>TANGGAL DISPOSISI</td>
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
            var date = new Date();
            var day = date.getDate();
            var day1 = date.getDate() + 1;
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            if (month < 10) month = "0" + month;
            if (day < 10) day = "0" + day;

            var today = year + "-" + month + "-" + day;
            // var today1 = year + "-" + month + "-" + day1;
            var today1 = year + "-" + month + "-" + day;
            console.log(today)
            console.log(today1)
            $("#min").attr("value", today);
            $("#max").attr("value", today1);

            //initial run
            loadTable(today, today1);
        });

        function loadTable(dateStart, dateEnd) {
            var table = $('#datagrid').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                language: {
                    searchPlaceholder: "Ketikkan yang dicari"
                },
                ajax: {
                    url: "{{ route('surat-disposisi') }}",
                    type: 'get',
                    data: {
                        tglAwal: dateStart,
                        tglAkhir: dateEnd
                    }
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'surat_masuk_id.id_surat_masuk',
                        name: 'surat_masuk_id.id_surat_masuk',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    // {
                    //   data: 'no_agenda_disposisi',
                    //   name: 'no_agenda_disposisi',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    // {
                    //     data: 'surat_masuk_id.nomor_surat_masuk',
                    //     name: 'surat_masuk_id.nomor_surat_masuk',
                    //     render: function(data, type, row) {
                    //         return '<p style="color:black">' + data + '</p>';
                    //     }
                    // },
                    {
                        data: 'surat_masuk_id.perihal_surat',
                        name: 'surat_masuk_id.perihal_surat',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },

                    {
                        data: 'pemberi.nama_asn',
                        name: 'pemberi.nama_asn',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'penerima.nama_asn',
                        name: 'penerima.nama_asn',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            let date = new Date(data);
                            const day = date.toLocaleString('default', {
                                day: '2-digit'
                            });
                            const month = date.toLocaleString('default', {
                                month: 'short'
                            });
                            const year = date.toLocaleString('default', {
                                year: 'numeric'
                            });
                            return '<p style="color:black">' + day + ' ' + month + ' ' + year + '</p>';
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]

            });
        }
        $('.btn-add').click(function() {
            // $('.preloader').show();
            $('.main-page').hide();
            $.post("{!! route('form-surat-disposisi') !!}").done(function(data) {
                if (data.status == 'success') {
                    // $('.preloader').hide();
                    $('.other-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        });

        function showForm(id) {
            // $('.main-page').hide();
            $.post("{!! route('show-surat-disposisi') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.modal-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }

        function editForm(id) {
            $('.main-page').hide();
            $.post("{!! route('form-surat-disposisi') !!}", {
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
                title: "Apakah anda yakin?",
                text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus Data!',
            }).then((result) => {
                if (result.value) {
                    $.post("{!! route('destroy-surat-disposisi') !!}", {
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
    </script>
@endsection
