<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/closed_request_historybar.php'; ?>
<!-- Main Sidebar Container -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><b>Closed Request History</b></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Closed Request History</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-lg-2 col-6">
                    <label>History Date From</label>
                    <input type="datetime-local" class="form-control" id="history_date_from">
                  </div>
                  <div class="col-lg-2 col-6">
                    <label>History Date To</label>
                    <input type="datetime-local" class="form-control" id="history_date_to">
                  </div>
                  <div class="col-lg-1 col-6">
                    <label>RFQ #</label>
                    <input type="text" class="form-control" id="search_rfq">
                  </div>
                  <div class="col-lg-2 col-6">
                    <label>Jig Name</label>
                    <input type="text" class="form-control" id="search_jigname">
                  </div>
                  <div class="col-lg-2 col-6">
                    <label>Car Maker</label>
                    <input type="text" class="form-control" id="search_carmaker">
                  </div>
                  <div class="col-lg-1 col-6">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-secondary btn-block" onclick="get_closed_request_history()"><i
                        class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-lg-2 col-12">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-secondary btn-block"
                      onclick="export_closed_request_history()"><i class="fas fa-download"></i> Export History</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">List of Closed Request Data</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
              <div class="card-body">
                <div class="container-fluid">
                  <div class="row mb-0">
                    <div class="col-sm-1 text-center">
                      <b><span class="h3" id="count_view">0</span></b><br>
                      <label>Count</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="card-body table-responsive p-0" style="height: 500px; overflow-y: auto;">
                        <table class="table table-head-fixed text-nowrap table-bordered table-hover"
                          id="list_of_uploaded_request_with_po_table">
                          <thead
                            style="text-align:center; position: sticky;top: 0; z-index: 1;  background-color: #f8f9fa;">
                            <th colspan="17" class="bg-secondary">Request</th>
                            <th colspan="20" class="bg-light">RFQ Process</th>
                            <th colspan="13" class="bg-secondary">PO Process</th>
                            <th colspan="4" class="bg-light">Delivery</th>
                            <tr>
                              <th>#</th>
                              <th>Status </th>
                              <th>Car Maker </th>
                              <th>Car Model </th>
                              <th>Product </th>
                              <th>Jig Name </th>
                              <th>Drawing No </th>
                              <th>Type </th>
                              <th>Qty </th>
                              <th>Purpose </th>
                              <th>Kigyo Budget </th>
                              <th>Date Requested </th>
                              <th>Requested By </th>
                              <th>Required Delivery Date </th>
                              <th>Order Destination </th>
                              <th>Shipping Method </th>
                              <th>Upload By </th>

                              <th>Date of Issuance of RFQ </th>
                              <th>RFQ No </th>
                              <th>RFQ Remarks </th>
                              <th>Target Date of Reply Quotation </th>
                              <th>Item Code </th>
                              <th>Upload By </th>
                              <th>Date of Reply Quotation </th>
                              <th>Validity of Quotation </th>
                              <th>LEADTIME(based on quotation)</th>
                              <th>Quotation No </th>
                              <th>Unit Price JPY </th>
                              <th>Unit Price USD </th>
                              <th>Unit Price PHP </th>
                              <th>Total Amount </th>
                              <th>FSIB No. </th>
                              <th>FSIB Code </th>
                              <th>Date sent to Internal Signatories </th>
                              <th>Target Approval date of quotation </th>
                              <th>RFQ Status </th>
                              <th>Upload By </th>

                              <th>Approval date of quotation </th>
                              <th>Target Date Submission to Purchasing </th>
                              <th>Actual Date of Submission to Purchasing </th>
                              <th>Target PO Date</th>
                              <th>Date Received PO Doc from Purchasing</th>
                              <th>Date Issued to Requestor</th>
                              <th>Issued To</th>
                              <th>Date Returned by Requestor</th>
                              <th>PO Date </th>
                              <th>PO No. </th>
                              <!-- <th>Ordering Additional Details </th> -->
                              <th>Supplier </th>
                              <th>ETD </th>
                              <th>ETA </th>
                              <th>Invoice No </th>
                              <th>Remarks </th>
                              <th>Actual Arrival Date </th>
                              <th>Upload By </th>
                            </tr>
                          </thead>
                          <tbody id="list_of_uploaded_request_with_po" style="text-align:center;"></tbody>
                        </table>
                        <div class="row">
                          <div class="col-6"></div>
                          <div id="spinner" style="display: none; text-align: center; margin-top: 10px;">
                            <img src="../../dist/img/pin-wheel.gif" alt="Loading..." style="width: 50px; height: 50px;">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end container -->
              </div>
              <!-- /.card-body -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'plugins/footer.php'; ?>
<?php include 'plugins/javascript/notification_script.php'; ?>
<?php include 'plugins/javascript/closed_request_history_script.php'; ?>