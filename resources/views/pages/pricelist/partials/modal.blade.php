
<div id="moda_import" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <form id="form-import" method="POST" action="{{ route('pricelist.import') }}" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-role">Import Excel</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="">Files</label>
                    <input type="file" name="files" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" id="submit_import" class="btn bg-primary">Submit</button>
            </div>
        </div>
    </form>
  </div>
</div>