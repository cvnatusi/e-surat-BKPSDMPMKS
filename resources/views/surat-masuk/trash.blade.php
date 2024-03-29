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
            <div class="table-responsive">
                <!-- <div>
                      <button type="button" class="btn btn-primary btn-add" style="width: 170px;"><i class="bx bx-plus me-1"></i>Tambah</button>
                      <button type="button" class="btn btn-info btn-print" style="width: 170px;"><i class="bx bx-printer me-1"></i>Cetak Disposisi</button>
                    </div> -->

                <p></p>

                <table class="table table-striped dataTable" id="datagrid" style="width: 100%">

                    <thead>
                        <td>PILIH</td>
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
        function checkedRow() {
            var selectedRow = 0;
            $("input:checkbox[name=check]:checked").each(function() {
                selectedRow++;
            });
            if (selectedRow >= 1) {
                $('#cetak_all').css('display', 'block');
                $('#span').removeClass('col-md-4').addClass('col-md-2');
            } else {
                $('#cetak_all').css('display', 'none');
                $('#span').removeClass('col-md-2').addClass('col-md-4');
            }
        }

        function printAll() {
            var selectedRow = 0;
            $("input:checkbox[name=check]:checked").each(function() {
                selectedRow++;
            });
            $.ajax({
                url: "{{ route('surat-dispos-kosong') }}",
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    var w = window.open();
                    for (var i = 0; i < selectedRow; i++) {
                        $(w.document.body).append(response.html + '<div style="page-break-after: always;"></div>');
                    }
                    w.print();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
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
                    url: "{{ route('show-trash-surat-masuk') }}",
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
                        searchable: false
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

        // $('.btn-add').click(function() {
        //     // $('.preloader').show();
        //     $('.main-page').hide();
        //     $.post("{!! route('form-surat-masuk') !!}").done(function(data) {
        //         if (data.status == 'success') {
        //             // $('.preloader').hide();
        //             $('.other-page').html(data.content).fadeIn();
        //         } else {
        //             $('.main-page').show();
        //         }
        //     });
        // });

        // function showForm(id) {
        //     // $('.main-page').hide();
        //     $.post("{!! route('show-surat-masuk') !!}", {
        //         id: id
        //     }).done(function(data) {
        //         if (data.status == 'success') {
        //             $('.modal-page').html(data.content).fadeIn();
        //         } else {
        //             $('.main-page').show();
        //         }
        //     });
        // }

        // function downloadTemplate() {
        //     $.ajax({
        //         url: "{{ route('surat-dispos-kosong') }}",
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function (response) {
        //             var w = window.open();
        //             $(w.document.body).html(response.html);
        //             w.print();
        //         },
        //         error: function (xhr, status, error) {
        //             console.error(error);
        //         }
        //     });
        // }

        // function editForm(id) {
        //     $('.main-page').hide();
        //     $.post("{!! route('form-surat-masuk') !!}", {
        //         id: id
        //     }).done(function(data) {
        //         if (data.status == 'success') {
        //             $('.other-page').html(data.content).fadeIn();
        //         } else {
        //             $('.main-page').show();
        //         }
        //     });
        // }

        function restoreSurat(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Data akan di restore dan akan berada di Surat Masuk !",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Restore Data!',
            }).then((result) => {
                if (result.value) {
                    $.post("{!! route('restoreSurat-surat-masuk') !!}", {
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
                            msg: "Data Gagal restore, Silahkan Hubungi IT Anda!"
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
                        msg: "Data batal di restore!"
                    });
                    $('#datagrid').DataTable().ajax.reload();
                }
            });
        };

        function deleteSurat(id) {
            swal({
                title: "Apakah anda yakin?",
                text: "Data akan di hapus dan tidak dapat diperbaharui kembali !",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus Data!',
            }).then((result) => {
                if (result.value) {
                    $.post("{!! route('deleteSurat-surat-masuk') !!}", {
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

        // $('.btn-print').click(function() {
        //     var idData = [];
        //     $('#datagrid input:checked').each(function(i) {
        //         idData[i] = $(this).val();
        //     });
        //     if (idData.length > 0) {
        //         // $.post('@{{ route('multiPrintDisposisi') }}',{id:idData}).done(function(response, status, xhr) {
        //         //   var win = window.open(response, '_blank');
        //         //   if (win) {
        //         //       //Browser has allowed it to be opened
        //         //       win.focus();
        //         //   } else {
        //         //       //Browser has blocked it
        //         //       alert('Please allow popups for this website');
        //         //   }
        //         // }).fail(function() {
        //         //   swal('','Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!',"error");
        //         // });
        //         $.ajax({
        //             type: "POST",
        //             url: '{{ route('multiPrintDisposisi') }}',
        //             data: {
        //                 "id": idData
        //             },
        //             xhrFields: {
        //                 responseType: 'blob' // to avoid binary data being mangled on charset conversion
        //             },
        //             success: function(blob, status, xhr) {
        //                 // check for a filename
        //                 var filename = "";
        //                 var disposition = xhr.getResponseHeader('Content-Disposition');
        //                 if (disposition && disposition.indexOf('attachment') !== -1) {
        //                     var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
        //                     var matches = filenameRegex.exec(disposition);
        //                     if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g,
        //                         '');
        //                 }
        //
        //                 if (typeof window.navigator.msSaveBlob !== 'undefined') {
        //                     // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
        //                     window.navigator.msSaveBlob(blob, filename);
        //                 } else {
        //                     var URL = window.URL || window.webkitURL;
        //                     var downloadUrl = URL.createObjectURL(blob);
        //
        //                     if (filename) {
        //                         // use HTML5 a[download] attribute to specify filename
        //                         var a = document.createElement("a");
        //                         // safari doesn't support this yet
        //                         if (typeof a.download === 'undefined') {
        //                             window.location.href = downloadUrl;
        //                         } else {
        //                             a.href = downloadUrl;
        //                             a.download = filename;
        //                             document.body.appendChild(a);
        //                             a.click();
        //                         }
        //                     } else {
        //                         var win = window.open(downloadUrl, '_blank');
        //                         if (win) {
        //                             //Browser has allowed it to be opened
        //                             win.focus();
        //                         } else {
        //                             //Browser has blocked it
        //                             alert('Please allow popups for this website');
        //                         }
        //                         // window.location.href = downloadUrl;
        //
        //                     }
        //
        //                     setTimeout(function() {
        //                         URL.revokeObjectURL(downloadUrl);
        //                     }, 100); // cleanup
        //                 }
        //             }
        //         });
        //     } else {
        //         swal("MAAF !", "Tidak Ada Data yang Dipilih !!", "warning");
        //     }
        // });

        // function timeLine(id) {
        //     $('.main-page').hide();
        //     $.post("{!! route('show-timeline-surat-masuk') !!}", {
        //         id: id
        //     }).done(function(data) {
        //         if (data.status == 'success') {
        //             $('.other-page').html(data.content).fadeIn();
        //         } else {
        //             $('.main-page').show();
        //         }
        //     });
        // }

        // function countChecked() {
        //     var arrPegawai = [];
        //     $("input:checkbox[name=check]:checked").each(function() {
        //         var pegawaiId = $(this).data('id');
        //         // checkedIds.push($(this).val());
        //         // arrPegawai.push(pegawaiId);
        //         console.log(pegawaiId);
        //     });
        // }

        $(function() {
            $('[data-toggle="popover"]').popover();
        });

    </script>
@endsection
