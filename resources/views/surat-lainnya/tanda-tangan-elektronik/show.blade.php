<div class="modal fade show" id="modal-berkas-surat-tte" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-xl modal-berkas-surat-tte">
    <div class="modal-content" style="height: 65rem">
      <div class="modal-header">
        <h5 class="modal-title">Berkas Surat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      @if ($data->is_verif==true)
        @if (!empty($data->file_surat))
          {{-- <iframe  width="100%" height="550px" src="{{asset('storage/surat-tte/'.$data->file_surat)}}"></iframe> --}}
          <iframe  width="100%" height="100%" src="{{asset('storage/surat-tte/'.$data->file_surat)}}"></iframe>
          @else
          <img style="display: block;margin-left: auto;margin-right: auto;width: 50%;" src="https://media.istockphoto.com/id/924949200/vector/404-error-page-or-file-not-found-icon.jpg?s=170667a&w=0&k=20&c=gsR5TEhp1tfg-qj1DAYdghj9NfM0ldfNEMJUfAzHGtU=" alt="">
        @endif
      @else
         @if (!empty($data->file_surat))
         <div style="position:absolute; top: 190px;right:280px; opacity:50%; font-size: 150px; color: grey; transform: rotate(-45deg);">SALINAN</div>
            {{-- <iframe  width="100%" height="550px" src="{{asset('storage/surat-tte-salinan/'.$data->file_surat_salinan)}}#toolbar=0&navpanes=0&scrollbar=0"></iframe> --}}
            <iframe  width="100%" height="100%" src="{{asset('storage/surat-tte-salinan/'.$data->file_surat_salinan)}}#toolbar=0&navpanes=0&scrollbar=0"></iframe>
            @else
            <img style="display: block;margin-left: auto;margin-right: auto;width: 50%;" src="https://media.istockphoto.com/id/924949200/vector/404-error-page-or-file-not-found-icon.jpg?s=170667a&w=0&k=20&c=gsR5TEhp1tfg-qj1DAYdghj9NfM0ldfNEMJUfAzHGtU=" alt="">
          @endif
      @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

var onLoad = (function() {
  $('#modal-berkas-surat-tte').find('.modal-berkas-surat-tte').css({
    // 'width': '100%'
  });
  // console.log(`{{$data->file_surat}}`)
  $('#modal-berkas-surat-tte').modal('show');
  // instance.setViewState((state) => state.set("allowPrinting", false));
})();
$('#modal-berkas-surat-tte').on('hidden.bs.modal', function() {
  $('.modal-berkas-surat-tte').html('');
});
</script>
