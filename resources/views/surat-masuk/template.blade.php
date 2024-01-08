<div class="modal fade show" id="modal-berkas-surat-masuk" tabindex="-1" style="display: block;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-berkas-surat-masuk">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Berkas Surat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  var onLoad = (function() {
    $('#modal-berkas-surat-masuk').find('.modal-berkas-surat-masuk').css({
      // 'width': '100%'
    });
    $('#modal-berkas-surat-masuk').modal('show');
  })();
  $('#modal-berkas-surat-masuk').on('hidden.bs.modal', function() {
    $('.modal-berkas-surat-masuk').html('');
  });
  </script>
  