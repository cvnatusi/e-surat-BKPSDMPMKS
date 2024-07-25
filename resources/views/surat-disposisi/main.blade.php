@extends('component.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.6/css/select.dataTables.min.css"> --}}
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
                    <div class="col-md-2" style="display: none" id="delete_all">
                        <label class="form-label">Hapus Semua Surat</label>
                        <button type="button" class="btn btn-danger form-control" onclick="deleteAll()" ><i
                                class="bx bx-trash me-1"></i>Hapus</button>
                    </div>
                    <div class="col-md-6" id="span"></div>
                    <div class="col-md-2 mb-3 panelTanggal">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" id="min" class="form-control datepickertanggal" value="{{date('Y-m-01')}}">
                    </div>
                    <div class="col-md-2 mb-3 panelTanggal">
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
                        <td><input type="checkbox" id="check_" onchange="checkAll()" class="form-check-input"></td>
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
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.6/js/dataTables.select.min.js"></script> --}}
    <script type="text/javascript">
        // var arrSuratId = new Array([103]);
        var arrSuratId = [];
        function showButtonDelete() {
            // console.log(listCheked.length);
            if (listCheked.length >= 1) {
                $('#delete_all').css('display', 'block');
                $('#span').removeClass('col-md-6').addClass('col-md-4');
            } else {
                $('#delete_all').css('display', 'none');
                $('#span').removeClass('col-md-4').addClass('col-md-6');
            }
        }
        function checkedRow(ini) {
            var statusChecked = $(ini).is(":checked");
            // console.log($(ini).is(":checked"));
            if(statusChecked) {
                listCheked.push(parseInt($(ini).val()));
            } else {
                let index = listCheked.indexOf($(ini).val());
                listCheked.splice(index, 1);
            }
            showButtonDelete()
        }

        function checkAll() {
            if ($('#check_').prop('checked')) {
                arrSuratId = [];
                $('.row_surat').each(function(i, v) {
                    arrSuratId.push($(v).data('id'));
                });
                $('.row_surat').prop('checked', true);
                $.post("{!! route('get-id') !!}", {
                    arrSuratId: arrSuratId,
                    _token: '{{ csrf_token() }}'
                }).done(function(data) {
                    listCheked = data;
                    console.log(listCheked);
                    showButtonDelete();
                });
            } else {
                $('.row_surat').prop('checked', false);
                arrSuratId = [];
                listCheked = [];
                showButtonDelete();
            }
        }

        // function checkAll() {
        //     if($('#check_').prop('checked')) {

        //       $.each($('.row_surat'),function (i,v) {
        //         if ($(v).is(':checked')) {
        //             arrSuratId.push($(v).data('id'))
        //         }
        //       })
        //       $('.row_surat').prop('checked',true)
        //         // $.post("{!! route('get-id') !!}", {
        //         //     id: arrSuratId.join(',')
        //         // }).done(function(data) {
        //         //     listCheked = [];
        //         //     listCheked = data;
        //         //     listCheked.forEach(element => {
        //         //         $('#check_' + element).prop('checked', true);
        //         //     });
        //         //     showButtonDelete()
        //         //     // console.log(data);
        //         // })
        //     } else {
        //       $('.row_surat').prop('checked',false)
        //         listCheked.forEach(element => {
        //             $('#check_' + element).prop('checked', false);
        //         });
        //         listCheked = [];
        //         showButtonDelete()
        //         // console.log('false');
        //     }
        //       console.log(arrSuratId);
        // }

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
            const getQueryString = window.location.search;
            const urlParams = new URLSearchParams(getQueryString);
            const product = urlParams.get('redirect')
            // console.log(product);

            if(product == 'buat-baru'){
                $('.btn-add').trigger('click');
            }
            // var date = new Date();
            // var day = date.getDate();
            // var day1 = date.getDate() + 1;
            // var month = date.getMonth() + 1;
            // var year = date.getFullYear();

            // if (month < 10) month = "0" + month;
            // if (day < 10) day = "0" + day;

            // var today = year + "-" + month + "-" + day;
            // // var today1 = year + "-" + month + "-" + day1;
            // var today1 = year + "-" + month + "-" + day;
            // console.log(today)
            // console.log(today1)
            // $("#min").attr("value", today);
            // $("#max").attr("value", today1);

            //initial run
            var start = $('#min').val()
            var end = $('#max').val()
            loadTable(start, end);
            // loadTable(today, today1);
        });

        function deleteAll() {
          swal({
            title: "Apakah Anda yakin akan menghapus data ini ?",
            text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, Hapus Data!',
          }).then((result) => {
            if (result.value) {
              $.post("{!! route('delete-all-surat-disposisi') !!}",{listId: arrSuratId}).done(function(data){
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
                    sound:false,
                    msg: "Data Gagal Dihapus, Silahkan Hubungi IT Anda!"
                  });
                });
              }else if (result.dismiss === Swal.DismissReason.cancel) {
                Lobibox.notify('error', {
                  pauseDelayOnHover: true,
                  size: 'mini',
                  rounded: true,
                  delayIndicator: false,
                  icon: 'bx bx-error',
                  continueDelayOnInactiveTab: false,
                  position: 'top right',
                  sound:false,
                  msg: "Data batal di hapus!"
                });
                $('#datagrid').DataTable().ajax.reload();
              }
            });
        }

        let listCheked = [];
        var table = $('#datagrid');

        function loadTable(dateStart, dateEnd) {
            table.DataTable({
                processing: true,
                serverSide: true,
                // stateSave: true,
                // destroy: true,
                "pageLength": 25,
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
                // 'columnDefs': [
                //   {
                //     'targets': 0,
                //     'checkboxes': {
                //       'selectRow': true
                //     }
                //   }
                // ],
                // 'select': {
                //   'style': 'multi'
                // },

                columns: [
                    {
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if(listCheked.includes(row.id_surat_disposisi)) {
                                // console.log('asndas');
                                if (arrSuratId.includes(row.id_surat_disposisi)) {
                                    return `<input class="form-check-input select-checkbox row_surat" onchange="checkedRow(this)" data-id="${row.id_surat_disposisi}" id="check_${row.id_surat_disposisi}" name="check" value="${row.id_surat_disposisi}" type="checkbox" checked></a>`;
                                  }
                                  return `<input class="form-check-input select-checkbox row_surat" onchange="checkedRow(this)" data-id="${row.id_surat_disposisi}" id="check_${row.id_surat_disposisi}" name="check" value="${row.id_surat_disposisi}" type="checkbox"></a>`;
                            } else {
                                return data;
                            }
                        },
                        // targets: 0,
                        // data: null,
                        // // defaultContent: "",
                        // orderable:false,
                        // checkboxes: {
                        //     selectRow: true,
                        //     selectAllPages: false
                        // },
                    },
                    // {
                    //   targets: 0,
                    //   data: null,
                    //   defaultContent: "",
                    //   orderable:false,
                    //   className: "select-checkbox"
                    // },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'surat_masuk_id.no_agenda',
                        name: 'surat_masuk_id.no_agenda',
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
        table.on('click', 'tbody tr', function (e) {
            e.currentTarget.classList.toggle('selected');
        });
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

        function previewSuratMasuk(id) {
            // $('.main-page').hide();
            $.post("{!! route('show-surat-masuk') !!}", {
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
