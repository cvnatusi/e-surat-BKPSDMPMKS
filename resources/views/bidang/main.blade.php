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
                        <input type="text" name="id" id="id">
                        <div class="col-md-6">
                            <label>Nama Bidang <small>*)</small></label>
                            <input type="text" name="nama_bidang" id="nama_bidang" class="form-control" placeholder="Nama Bidang" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label>Nama Kepala Bidang <small>*)</small></label>
                            <select name="nama_kepala_bidang" id="nama_kepala_bidang" class="form-control kepala_bidang">
                                <option value="">-Pilih-</option>
                                @if (count($data['asn']) > 0)
                                    @foreach ($data['asn'] as $a)
                                        <option value="{{$a->id_mst_asn}}">{{$a->nama_asn}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary text-white text-center" id="saveData" style="width: 100%">TAMBAHKAN</button>
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
                            <td>PILIH</td>
                            <td>NO</td>
                            <td>NAMA BIDANG</td>
                            <td>NAMA KEPALA BIDANG</td>
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
    $('.kepala_bidang').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
        tags: true,
    });
    $(function () {
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
        
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('bidang') }}",
            columns: [
                {data: 'check', name: 'check'},
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'namaAsn', name: 'namaAsn'},
                {data: 'nama_bidang', name: 'nama_bidang'},
                {data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false},
            ]
        });

        $('#saveData').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
        
            $.ajax({
              data: $('#postForm').serialize(),
              url: "{{ route('bidangStore') }}",
              type: "POST",
              dataType: 'json',
              success: function (data) {
                if (data.code=='200') {
                    $('#postForm').trigger("reset");
                    table.draw();
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
                  $('#savedata').html('Save Changes');
              }
          });
        });
    });
    function editData(id) {
        $('#id').val(id);
        // $('#nama_bidang').val();
        // $('#nama_kepala_bidang').val(id);
        $.ajax({
                'url': 'edit?id='+branchid,
                'type': 'GET',
                'data': {},

                success: function(response){ // What to do if we succeed
                    if(data == "success")
                        alert(response);
                },
                error: function(response){
                    alert('Error'+response);
                }



            });
    }
</script>
@endsection
