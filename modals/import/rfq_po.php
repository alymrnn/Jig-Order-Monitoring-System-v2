<div class="modal fade" id="import_rfq_po" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><b>Import Request Data + RFQ + PO</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mb-0 pb-0">
        <div class="row">
          <div class="col-lg-4 col-6">

            <div class="small-box bg-info text-center">
              <div class="inner">
                <h4>Import Req + Initial RFQ</h4>
                <br>
                <br>
              </div>
              <div class="icon">
                <i class="fas fa-upload fa-sm" class="close" data-dismiss="modal" type="button"
                  onclick="setTimeout(() => {$('#import_rfq').modal('show');}, 400);"></i>
              </div>
              <a class="small-box-footer" type="button" class="close" data-dismiss="modal"
                onclick="setTimeout(() => {$('#import_rfq').modal('show');}, 400);">
                Import Initial RFQ <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-danger text-center">
              <div class="inner">
                <h4>Import Req + Initial RFQ + RFQ</h4>
                <br>
              </div>
              <div class="icon">
                <i class="fas fa-upload fa-sm" class="close" data-dismiss="modal" type="button"
                  onclick="setTimeout(() => {$('#full_rfq').modal('show');}, 400);"></i>
              </div>
              <a class="small-box-footer" type="button" class="close" data-dismiss="modal"
                onclick="setTimeout(() => {$('#full_rfq').modal('show');}, 400);">
                Import RFQ <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-6">

            <div class="small-box bg-success text-center">
              <div class="inner">
                <h4>Import Req + Complete RFQ + PO </h4>
                <br>
              </div>
              <div class="icon">
                <i class="fas fa-upload fa-sm" type="button" class="close" data-dismiss="modal"
                  onclick="setTimeout(() => {$('#import_po').modal('show');}, 400);"></i>
              </div>
              <a class="small-box-footer" type="button" class="close" data-dismiss="modal"
                onclick="setTimeout(() => {$('#import_po').modal('show');}, 400);">
                Import PO <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- <div class="col-sm-4">

            <div class="form-group">
              <label>Import Req + Initial RFQ</label>
              <button type="button" class="btn btn-info" class="close" data-dismiss="modal"
                onclick="setTimeout(() => {$('#import_rfq').modal('show');}, 400);">Import Initial RFQ</button>
            </div>
          </div>
          <div class="col-sm-4">

            <div class="form-group">
              <label>Import Req + Initial RFQ + RFQ</label>
              <button type="button" class="btn btn-warning" class="close" data-dismiss="modal"
                onclick="setTimeout(() => {$('#full_rfq').modal('show');}, 400);">Import RFQ</button>
            </div>
          </div>
          <div class="col-sm-4">

            <div class="form-group">
              <label>Import Req + Complete RFQ + PO </label>
              <button type="button" class="btn btn-success" class="close" data-dismiss="modal"
                onclick="setTimeout(() => {$('#import_po').modal('show');}, 400);">Import PO</button>
            </div>
          </div> -->
        </div>
      </div>
      <div class="modal-footer m-0 p-1">
        <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>