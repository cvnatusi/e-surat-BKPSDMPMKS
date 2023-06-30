<div class="modal fade show" id="modal-log-activity" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-log-activity">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Log Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table style="width: 100%;" class="table mb-0">
                    <thead class="table-dark">
                        <tr>
                            <td colspan="2">INFO</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="field_cell">Type</td>
                            <td>
                              @if ($data->log_type == 'login')
                                <button type="button" class="btn btn-sm btn-secondary login_badge" name="button">login</button>
                              @elseif ($data->log_type == 'edit')
                                  <button type="button" class="btn btn-sm btn-warning edit_badge" name="button">edit</button>
                                @elseif ($data->log_type == 'create')
                                  <button type="button" class="btn btn-sm btn-info create_badge" name="button">create</button>
                                @elseif ($data->log_type == 'delete')
                                  <button type="button" class="btn btn-sm btn-danger delete_badge" name="button">delete</button>
                              @endif
                            </td>
                        </tr>
                        <tr ng-show="['create','edit','delete'].includes(selected.log_type)" class="">
                            <td class="field_cell">Table</td>
                            <td class="ng-binding">{{$data->table_name}}</td>
                        </tr>
                        <tr>
                            <td class="field_cell">Time</td>
                            <td class="ng-binding">{{ Carbon\Carbon::parse($data->log_date)->diffForHumans()}} - {{$data->log_date}}</td>
                        </tr>
                        <tr>
                            <td class="field_cell">Done by</td>
                            <td class="ng-binding">{{$data->users->name}} - <span class="text_light ng-binding">{{$data->users->email}}</span></td>
                        </tr>
                        @php
                        $dataDetail = json_decode($data->data);
                        @endphp
                        {{-- <tr>
                          <td>IP</td>
                          <td></td>
                        </tr> --}}
                    </tbody>
                </table>
                <div class="table">
                    <table style="width: 100%;" class="table mb-0 table-striped">
                        <thead class="table-dark">
                        <tr>
                            <td>FIELD</td>
                            <td>DATA</td>
                            @if ($data->log_type == 'edit')
                              <td>CURRENT</td>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($dataDetail as $key => $node)
                            <tr>
                              <td>{{ $key }}</td>
                              <td>{{ $node }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var onLoad = (function() {
        $('#modal-log-activity').find('.modal-log-activity').css({
            // 'width': '100%'
        });
        $('#modal-log-activity').modal('show');
    })();
    $('#modal-log-activity').on('hidden.bs.modal', function() {
        $('.modal-log-activity').html('');
    });
</script>
