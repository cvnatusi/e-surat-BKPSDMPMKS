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
                        <label class="form-label">Tambah Surat Masuk</label>
                        <button type="button" class="btn btn-primary btn-add form-control"><i class="bx bx-plus me-1"></i>Surat Baru</button>
                    </div>
                    <div class="col-md-2" id="cetak_all" style="display: none">
                        <label class="form-label">Cetak Semua Surat</label>
                        <button type="button" onclick="printAll()" class="btn btn-success btn-a form-control"><i
                            class="bx bx-printer me-1"></i>Cetak</button>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Arsip</label>
                        <a href="{{ route('show-trash-surat-masuk') }}" class="btn btn-danger form-control btn-trash"><i class="bx bx-trash me-1"></i>Trash</a>
                        {{-- <button type="button" class="btn btn-danger form-control btn-trash" href="{{ route('surat-keluar') }}"><i class="bx bx-trash me-1"></i>Trash</button> --}}
                    </div>
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
                <!-- <div>
                      <button type="button" class="btn btn-primary btn-add" style="width: 170px;"><i class="bx bx-plus me-1"></i>Tambah</button>
                      <button type="button" class="btn btn-info btn-print" style="width: 170px;"><i class="bx bx-printer me-1"></i>Cetak Disposisi</button>
                    </div> -->

                <p></p>

                <table class="table table-striped dataTable" id="datagrid" style="width: 100%">

                    <thead>
                        <td><input type="checkbox" id="check_" onchange="checkAll()" class="form-check-input"></td>
                        <td>NO AGENDA</td>
                        <td>NO SURAT</td>
                        <td>TANGGAL TERIMA</td>
                        <td>PERIHAL SURAT</td>
                        <td>PENGIRIM SURAT</td>
                        {{-- <td>INSTANSI</td> --}}
                        {{-- <td>JENIS SURAT</td> --}}
                        {{-- <td>SIFAT SURAT</td> --}}
                        {{-- <td>TANGGAL SURAT</td> --}}
                        <td class="text-center">AKSI</td>
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
        function checkedRow(ini) {
            var statusChecked = $(ini).is(":checked");
            // console.log($(ini).is(":checked"));
            if(statusChecked) {
                listCheked.push(parseInt($(ini).val()));
            } else {
                let index = listCheked.indexOf($(ini).val());
                listCheked.splice(index, 1);
            }
            // console.log(listCheked);

            // var selectedRow = 0;
            // var arrPegawai = [];
            // $("input:checkbox[name=check]:checked").each(function() {
            //     selectedRow++;
            //     var pegawaiId = $(this).data('id');
            //     arrPegawai.push(pegawaiId);
            // });
            // console.log(arrPegawai);
            showButtonPrint();
        }

        function showButtonPrint() {
            // console.log(listCheked.length);
            if (listCheked.length >= 1) {
                $('#cetak_all').css('display', 'block');
                $('#span').removeClass('col-md-4').addClass('col-md-2');
            } else {
                $('#cetak_all').css('display', 'none');
                $('#span').removeClass('col-md-2').addClass('col-md-4');
            }
        }

        function checkAll() {
            if($('#check_').prop('checked')) {
                $.post("{!! route('get-id-surat-masuk') !!}", {
                    // id: id
                }).done(function(data) {
                    listCheked = [];
                    listCheked = data;
                    listCheked.forEach(element => {
                        $('#check_' + element).prop('checked', true);
                    });
                    showButtonPrint();
                    // console.log(data);
                })
            } else {
                listCheked.forEach(element => {
                    $('#check_' + element).prop('checked', false);
                });
                listCheked = [];
                showButtonPrint();
                // console.log('false');
            }

        }

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
            // // var day = date.getDate();
            // // var month = date.getMonth() + 1;
            // // var year = date.getFullYear();
            // var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            // console.log(firstDay);
            // var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            // // if (month < 10) month = "0" + month;
            // // if (day < 10) day = "0" + day;

            // // var today = year + "-" + month + "-" + day;
            // $("#min").attr("value", firstDay);
            // $("#max").attr("value", lastDay);
            var start = $('#min').val()
            var end = $('#max').val()
            loadTable(start, end);
            //initial run
            // loadTable(start, end);
        });

        let listCheked = [];

        function loadTable(dateStart, dateEnd) {
            var table = $('#datagrid').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                "pageLength": 25,
                scrollX: true,
                scrollY: 350,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                // order: [
                //     [1, 'desc']
                // ],
                language: {
                    searchPlaceholder: "Ketikkan yang dicari"
                },
                ajax: {
                    url: "{{ route('surat-masuk') }}",
                    type: 'get',
                    data: {
                        tglAwal: dateStart,
                        tglAkhir: dateEnd
                    }
                },

                columns: [{
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            // console.log(listCheked, row.id_surat_masuk);
                            // console.log(listCheked.includes(row.id_surat_masuk.toString()));
                            if(listCheked.includes(row.id_surat_masuk)) {
                                // console.log('asndas');
                                return `<input class="form-check-input select-checkbox" onchange="checkedRow(this)" data-id="${row.id_surat_masuk}" id="check_${row.id_surat_masuk}" name="check" value="${row.id_surat_masuk}" type="checkbox" checked></a>`;
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'no_agenda',
                        name: 'no_agenda',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    // {
                    //   data: 'no_agenda',
                    //   name: 'no_agenda',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    {
                        data: 'nomor_surat_masuk',
                        name: 'nomor_surat_masuk',
                        render: function(data, type, row) {
                        return '<button type="button" class="btn btn-sm btn-info">' + data + '</button>'
                            // return '<p style="color:black">' + data + '</p>';
                        }
                    },

                    {
                        data: 'tanggal_terima_surat',
                        name: 'tanggal_terima_surat',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    {
                        data: 'perihal_surat',
                        name: 'perihal_surat',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    // {
                    //   data: 'pengirim.nama_instansi',
                    //   name: 'pengirim.nama_instansi',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    {
                        data: 'pengirim',
                        name: 'pengirim',
                        render: function(data, type, row) {
                            return '<p style="color:black">' + data + '</p>';
                        }
                    },
                    // {
                    //     data: 'singkatan',
                    //     name: 'singkatan',
                    //     render: function(data, type, row) {
                    //         return '<p style="color:black">' + data + '</p>';
                    //     }
                    // },
                    // {
                    //   data: 'sifat.nama_sifat_surat',
                    //   name: 'sifat.nama_sifat_surat',
                    //   render: function(data, type, row) {
                    //     return '<p style="color:black">' + data + '</p>';
                    //   }
                    // },
                    // {
                    //     data: 'tanggal_surat',
                    //     name: 'tanggal_surat',
                    //     render: function(data, type, row) {
                    //         return '<p style="color:black">' + data + '</p>';
                    //     }
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

        $('.btn-add').click(function() {
            // $('.preloader').show();
            $('.main-page').hide();
            $.post("{!! route('form-surat-masuk') !!}").done(function(data) {
                if (data.status == 'success') {
                    // $('.preloader').hide();
                    $('.other-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        });

        function showForm(id) {
            console.log(id);
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

        function printAll() {
            // var selectedRow = 0;
            // var arrPegawai = [];
            // $("input:checkbox[name=check]:checked").each(function() {
            //     selectedRow++;
            //     var pegawaiId = $(this).data('id');
            //     arrPegawai.push(pegawaiId);
            // });
            // var id = arrPegawai;
            $.ajax({
                url: "{{ route('multi-download') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    listId: listCheked
                },
                success: function (response) {
                    var w = window.open();
                    $(w.document.body).append(response.html + '<div style="page-break-after: always;"></div>');
                    setTimeout(function () {
                      w.focus();
                      w.print();
                      w.close();
                    }, 500);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function downloadTemplate(id) {
            $.ajax({
                url: "{{ route('surat-dispos-kosong') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (response) {

                    // console.log(id);
                    var w = window.open();
                    $(w.document.body).html(response.html);
                    setTimeout(function () {
                      // printWindow.focus();
                      // printWindow.print();
                      w.focus();
                      w.print();
                      w.close();
                    }, 500);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function editForm(id) {
            $('.main-page').hide();
            $.post("{!! route('form-surat-masuk') !!}", {
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
                    $.post("{!! route('destroy-surat-masuk') !!}", {
                        id: id
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

        $('.btn-print').click(function() {
            var idData = [];
            $('#datagrid input:checked').each(function(i) {
                idData[i] = $(this).val();
            });
            if (idData.length > 0) {
                // $.post('@{{ route('multiPrintDisposisi') }}',{id:idData}).done(function(response, status, xhr) {
                //   var win = window.open(response, '_blank');
                //   if (win) {
                //       //Browser has allowed it to be opened
                //       win.focus();
                //   } else {
                //       //Browser has blocked it
                //       alert('Please allow popups for this website');
                //   }
                // }).fail(function() {
                //   swal('','Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!',"error");
                // });
                $.ajax({
                    type: "POST",
                    url: '{{ route('multiPrintDisposisi') }}',
                    data: {
                        "id": idData
                    },
                    xhrFields: {
                        responseType: 'blob' // to avoid binary data being mangled on charset conversion
                    },
                    success: function(blob, status, xhr) {
                        // check for a filename
                        var filename = "";
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g,
                                '');
                        }

                        if (typeof window.navigator.msSaveBlob !== 'undefined') {
                            // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                            window.navigator.msSaveBlob(blob, filename);
                        } else {
                            var URL = window.URL || window.webkitURL;
                            var downloadUrl = URL.createObjectURL(blob);

                            if (filename) {
                                // use HTML5 a[download] attribute to specify filename
                                var a = document.createElement("a");
                                // safari doesn't support this yet
                                if (typeof a.download === 'undefined') {
                                    window.location.href = downloadUrl;
                                } else {
                                    a.href = downloadUrl;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click();
                                }
                            } else {
                                var win = window.open(downloadUrl, '_blank');
                                if (win) {
                                    //Browser has allowed it to be opened
                                    win.focus();
                                } else {
                                    //Browser has blocked it
                                    alert('Please allow popups for this website');
                                }
                                // window.location.href = downloadUrl;

                            }

                            setTimeout(function() {
                                URL.revokeObjectURL(downloadUrl);
                            }, 100); // cleanup
                        }
                    }
                });
            } else {
                swal("MAAF !", "Tidak Ada Data yang Dipilih !!", "warning");
            }
        });

        function timeLine(id) {
            $('.main-page').hide();
            $.post("{!! route('show-timeline-surat-masuk') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.other-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }

        $(function() {
            $('[data-toggle="popover"]').popover();
        });

    </script>
@endsection
