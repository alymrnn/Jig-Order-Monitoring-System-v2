<div class="modal fade" id="import_po" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Import PO</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../process/import/import_po.php"  enctype="multipart/form-data" method="POST">
                    <label>File:</label>
                    <input type="file" name="file" class="form-control-lg" accept=".csv">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="upload" value="Upload" id = "po_btn" onclick ="import_po_btn()">
      </div>
         </form>
    </div>
  </div>
</div>
