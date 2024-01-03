<div class="row">
    <div class="col-md-5">
        <div class="card border-top border-0 border-4 border-primary panel-form">
            <div class="card-body">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-primary">@if($data) Edit @else Tambah @endif Surat Keluar</h5>
                </div>
                <hr>
                <form class="row g-3 form-save">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    @if (!empty($data))
                        <input type="hidden" class="form-control" name="id" id="id"
                            value="{{ $data->id_surat_keluar }}">
                        @if (!empty($surat_tugas))
                            <input type="hidden" class="form-control" name="id_surat_tugas" id="id_surat_tugas"
                                value="{{ $surat_tugas->id_surat_perjalanan_dinas }}">
                        @endif
                    @endif

                    {{-- tanggal surat --}}
                    <div class="col-md-12">
                        <label for="tanggal_surat" class="form-label">Tanggal Surat *</label>
                        <input type="date"
                            @if (!empty($data)) value="{{ date('Y-m-d', strtotime($data->tanggal_surat)) }}" @else value="{{ date('Y-m-d') }}" @endif
                            class="form-control tanggal_surat" name="tanggal_surat" id="tanggal_surat">
                    </div>

                    {{-- jenis surat --}}
                    <div class="col-md-12">
                        <label for="jenis_surat_id" class="form-label">Jenis Surat *</label>
                        <select class="form-select jenis_surat" name="jenis_surat_id" id="jenis_surat_id">
                            <option value="" selected disabled>Pilih Jenis Surat</option>
                            @if (!empty($jenis_surat))
                                @foreach ($jenis_surat as $js)
                                    <option value="{{ $js->id_mst_jenis_surat }}"
                                        @if (!empty($data)) @if ($data->jenis_surat_id == $js->id_mst_jenis_surat) selected="selected" @endif
                                        @endif>{{ $js->kode_jenis_surat }} -
                                        {{ $js->nama_jenis_surat }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- checkbox --}}
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="buatSuratElektronik"
                                        @if (!empty($data)) @if ($data->surat_elektronik == 'Y') checked @endif
                                        @endif value="Y" id="buatSuratElektronik" >
                                    <label class="form-check-label" for="buatSuratElektronik">Buat Surat
                                        Elektronik</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="noSuratManual"
                                        @if (!empty($data)) @if ($data->surat_manual == 'Y') checked @endif
                                        @endif value="Y" id="noSuratManual" >
                                    <label class="form-check-label" for="noSuratManual">Nomor Surat Manual</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- nomor surat --}}
                    <div class="col-md-12 panelSuratManual">
                        <label for="perihal_surat" class="form-label">Nomor Surat *</label>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control col-md-1" name="no_surat2" id="no_surat2"
                                    @if (!empty($data)) value="{{ $data->no_surat2 }}" @endif>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control col-md-1" name="no_surat1" id="no_surat1"
                                    @if (!empty($data)) value="{{ $data->no_surat1 + 1}}" @endif>
                            </div>
                            <div class="col-md-3">
                                <input type="text" value="432.403" class="form-control col-md-1" name="no_surat3"
                                    id="no_surat3" @if (!empty($data)) value="432.403" @endif>
                            </div>
                            <div class="col-md-3">
                                <input type="year" value="{{ date('Y') }}" class="form-control col-md-1"
                                    name="no_surat4" id="no_surat4"
                                    @if (!empty($data)) value="{{ $data->no_surat4 }}" @endif>
                            </div>
                        </div>
                    </div>

                    {{-- sifat surat --}}
                    <div class="col-md-12">
                        <label for="sifat_surat_id" class="form-label">Sifat Surat</label>
                        <select class="form-select sifat_surat" name="sifat_surat_id" id="sifat_surat_id">
                            <option value="" selected disabled>-- Pilih Sifat Surat --</option>
                            @if (!empty($sifat_surat))
                                @foreach ($sifat_surat as $ss)
                                    <option value="{{ $ss->id_sifat_surat }}"
                                        @if (!empty($data)) @if ($data->sifat_surat_id == $ss->id_sifat_surat) selected="selected" @endif
                                        @endif>{{ $ss->nama_sifat_surat }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    {{-- tujuan surat --}}
                    <div class="col-md-12">
                        <label for="tujuan_surat_id" id="label_tujuan_surat" class="form-label">Tujuan Surat Kepada
                            *</label>
                        <select class="form-select tujuan_surat" multiple="multiple" name="tujuan_surat_id[]"
                            id="tujuan_surat_id">
                            <option value="">-- Pilih Tujuan --</option>
                            @if (!empty($instansi))
                                @foreach ($instansi as $inst)
                                    <option value="{{ $inst->id_instansi }}"
                                        @if (!empty($data)) @php $ins = explode(",",$data->tujuan_surat_id); @endphp @foreach ($ins as $key) @if ($inst->id_instansi == $key) selected @endif
                                        @endforeach
                                @endif>{{ $inst->nama_instansi }}</option>
                            @endforeach
                            @endif
                        </select>

                        <!-- <select class="form-select tujuan_surat" multiple="multiple" name="tujuan_surat_id[]" id="tujuan_surat_id">
              @if (!empty($data))
                @if (
                    $data->jenis_surat_id == '150' ||
                        $data->jenis_surat_id == '151' ||
                        $data->jenis_surat_id == '152' ||
                        $data->jenis_surat_id == '153' ||
                        $data->jenis_surat_id == '154' ||
                        $data->jenis_surat_id == '155')
                  @if (!empty($instansi))
                    @foreach ($instansi as $inst)
                      <option value="{{ $inst->id_mst_asn }}" @if (!empty($data)) @php $ins = explode(",",$data->tujuan_surat_id); @endphp @foreach ($ins as $key) @if ($inst->id_mst_asn == $key) selected @endif @endforeach @endif>{{ $inst->nama_asn }}</option>
                      @endforeach
                    @endif
                    @else
                    @if (!empty($instansi))
                      @foreach ($instansi as $inst)
                        <option value="{{ $inst->id_instansi }}" @if (!empty($data)) @php $ins = explode(",",$data->tujuan_surat_id); @endphp @foreach ($ins as $key) @if ($inst->id_instansi == $key) selected @endif @endforeach @endif>{{ $inst->nama_instansi }}</option>
                        @endforeach
                      @endif
                    @endif
              @endif -->
                        </select>
                    </div>

                    {{-- perihal surat --}}
                    <div class="col-md-12">
                        <label for="perihal_surat" class="form-label">Perihal Surat *</label>
                        <input type="text" class="form-control" name="perihal_surat" id="perihal_surat"
                            @if (!empty($data)) value="{{ $data->perihal_surat }}" @endif
                            placeholder="Perihal Surat">
                    </div>

                    {{-- isi ringkas --}}
                    <div class="col-md-12">
                        <label for="isi_ringkas_surat" class="form-label">Isi Ringkas Surat *</label>
                        <textarea rows="3" cols="80" class="form-control" placeholder="Ketikkan isi ringkas surat"
                            name="isi_ringkas_surat" id="isi_ringkas_surat">
                            @if (!empty($data)){{ $data->isi_ringkas_surat }}@endif
                        </textarea>
                    </div>

                    <div class="col-md-12">
                        <label for="file_scan" class="form-label">Upload Scan / Foto Surat</label>
                        <input class="form-control" type="file" id="file_scan" name="file_scan">
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="button" class="btn btn-secondary px-4 btn-cancel">Kembali</button>
                            <button type="button" class="btn btn-primary px-4 btn-submit">Simpan</button>
                        </div>
                    </div>

                    <div class="col-md-12 panelSuratTugas" style="display:none">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tanggal_mulai"  class="form-label">Tanggal Mulai *</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    @if (!empty($surat_tugas)) value="{{ $surat_tugas->tanggal_mulai }}" @else value="{{ date('Y-m-d') }}" @endif>
                            </div>
                            <div class="col-md-6">
                                <label for="tanggal_akhir" class="form-label">Tanggal Selesai *</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir"
                                    @if (!empty($surat_tugas)) value="{{ $surat_tugas->tanggal_akhir }}" @else value="{{ date('Y-m-d') }}" @endif>
                            </div>
                            <div class="col-md-6">
                                <label for="eselon" class="form-label">Eselon *</label>
                                <input type="text" class="form-control" name="eselon" id="eselon"
                                    @if (!empty($surat_tugas)) value="{{ $surat_tugas->eselon }}" @endif>
                            </div>
                            <div class="col-md-6">
                                <label for="alat_angkut" class="form-label">Kendaraan *</label>
                                <input type="text" class="form-control" name="alat_angkut" id="alat_angkut"
                                    @if (!empty($surat_tugas)) value="{{ $surat_tugas->alat_angkut }}" @endif>
                            </div>
                            <div class="col-md-12">
                                <label for="tempat_tujuan_bertugas" class="form-label">Tempat Tujuan Bertugas
                                    *</label>
                                <input type="text" class="form-control" name="tempat_tujuan_bertugas"
                                    id="tempat_tujuan_bertugas"
                                    @if (!empty($surat_tugas)) value="{{ $surat_tugas->tempat_tujuan_bertugas }}" @endif>
                            </div>
                            <div class="col-md-12">
                                <label for="alamat_tujuan_bertugas" class="form-label">Alamat Tujuan Bertugas
                                    *</label>
                                <textarea rows="3" cols="80" class="form-control" name="alamat_tujuan_bertugas"
                                    id="alamat_tujuan_bertugas">
@if (!empty($surat_tugas)){{ $surat_tugas->alamat_tujuan_bertugas }}@endif
</textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card border-top border-0 border-4 border-primary panel-form">
            <div class="card-body">
                <div class="card-title d-flex align-items-center">
                    <div><i class="bx bx-envelope me-1 font-22 text-primary"></i>
                    </div>
                    <h5 class="mb-0 text-primary">Preview Surat Keluar</h5>
                </div>
                <hr>
                <form class="row g-3 form-save" style="height: 750px">
                    <div class="col-md-12">
                        @if (!empty($data->file_scan))
                            <iframe width="100%" height="100%"
                                src="{{ asset('storage/surat-tugas/' . $data->file_scan) }}"></iframe>
                        @else
                            <img style="display: block;margin-left: auto;margin-right: auto;width: 50%;"
                                src="https://media.istockphoto.com/id/924949200/vector/404-error-page-or-file-not-found-icon.jpg?s=170667a&w=0&k=20&c=gsR5TEhp1tfg-qj1DAYdghj9NfM0ldfNEMJUfAzHGtU="
                                alt="">
                        @endif
                        {{-- <iframe width="100%"height="550px" src="{{asset('storage/surat-masuk/0003-20230206113144.jpeg')}}"></iframe> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var onLoad = (function() {
        $('.panel-form').animateCss('bounceInUp');
        // $('.panelSuratManual').hide();

        $('.tujuan_surat').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
            tags: true,
        });
        $('.jenis_surat').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
            tags: true,
        });
        $('.sifat_surat').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
            tags: true,
        });
        var id_surat_keluar = $('#id').val();
        var cek = $('input[name="noSuratManual"]:checked').val();
        // if (id_surat_keluar != null || undefined) {
        if (id_surat_keluar != undefined) {
            if ($('input[name="noSuratManual"]').is(':checked')) {
                $('.panelSuratManual').show();
            } else {
                $('.panelSuratManual').hide();
            }
            // PENGECEKAN SURAT KELUAR ITU SURAT TUGAS ATAU YANG LAIN
            var sifat_surat_id = $('#jenis_surat_id').find(":selected").val();
            if (sifat_surat_id == 150 || sifat_surat_id == 151 || sifat_surat_id == 152 || sifat_surat_id ==
                153 || sifat_surat_id == 154 || sifat_surat_id == 155) {
                $('.panelSuratTugas').show();
            } else {
                $('.panelSuratTugas').hide();
            }
        } else {
            $('.panelSuratManual').hide();
        }
    })();

    $('.btn-cancel').click(function(e) {
        e.preventDefault();
        $('.panel-form').animateCss('bounceOutDown');
        $('.other-page').fadeOut(function() {
            $('.other-page').empty();
            $('.main-page').fadeIn();
            // $('#datagrid').DataTable().ajax.reload();
        });
    });

    $('.btn-submit').click(function(e) {
        e.preventDefault();
        // $('.btn-submit').html('Please wait...').attr('disabled', true);
        $('.btn-submit');
        var data = new FormData($('.form-save')[0]);
        $.ajax({
            url: "{{ route('store-surat-keluar') }}",
            type: 'POST',
            data: data,
            async: true,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data) {
            $('.form-save').validate(data, 'has-error');
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
                $('.other-page').fadeOut(function() {
                    $('.other-page').empty();
                    $('.card').fadeIn();
                    $('#datagrid').DataTable().ajax.reload();
                });
            } else if (data.status == 'error') {
                $('.btn-submit');
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
                swal('Error :' + data.errMsg.errorInfo[0], data.errMsg.errorInfo[2], 'warning');
            } else {
                var n = 0;
                for (key in data) {
                    if (n == 0) {
                        var dt0 = key;
                    }
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
                    sound: false,
                    msg: data.message
                });
            }
        }).fail(function() {
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
                sound: false,
                msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
            });
        });
    });

    $("#noSuratManual").change(function() {
        if (this.checked) {
            $('.panelSuratManual').show();
        } else {
            $('.panelSuratManual').hide();
        }
    });

    $('#jenis_surat_id').on("change", function(e) {
        var id = $("#jenis_surat_id :selected").val();
        $.post("{!! route('getJenisSuratById') !!}", {
            id: id
        }).done(function(data) {
            $('#no_surat2').val(data.kode_jenis_surat);
            if (data.kode_jenis_surat == 090 || data.kode_jenis_surat == 091 || data.kode_jenis_surat ==
                092 || data.kode_jenis_surat == 093 || data.kode_jenis_surat == 094 || data
                .kode_jenis_surat == 095) {
                $('.panelSuratTugas').show();
                $(".tujuan_surat").select2({
                    theme: 'bootstrap4',
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                        'w-100') ? '100%' : 'style',
                    placeholder: $(this).data('placeholder'),
                    allowClear: Boolean($(this).data('allow-clear')),
                    // tags: true,
                    ajax: {
                        url: "{{ route('getAsnByName') }}",
                        dataType: 'json',
                        type: "POST",
                        // delay: 250,
                        data: function(params) {
                            return {
                                id: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
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

            } else {
                $('.panelSuratTugas').hide();
                $(".tujuan_surat").select2({
                    theme: 'bootstrap4',
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass(
                        'w-100') ? '100%' : 'style',
                    placeholder: $(this).data('placeholder'),
                    allowClear: Boolean($(this).data('allow-clear')),
                    // tags: true,
                    ajax: {
                        url: "{{ route('getInstansiByName') }}",
                        dataType: 'json',
                        type: "POST",
                        // delay: 250,
                        data: function(params) {
                            return {
                                id: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
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
</script>
