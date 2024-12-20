<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/dashboardbar.php'; ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><b>Request List</b></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Request List</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-lg-12 col-md-12 col-sm-12">
          <!-- jquery validation -->
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title"></h3>
              <div class="row">
                <div class="col-sm-2">
                  <button type="button" class="btn btn-danger ml-1 mr-2" style="width: 100%;" id="btnCancel"
                    data-toggle="modal" data-target="#cancel_request" disabled>
                    <i class="fas fa-times"></i> Cancel Request</button>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary mr-2" style="width: 100%;"
                    onclick="export_request_monitoring_record()">
                    <i class="fas fa-download"></i> Export Filtered Record</button>
                </div>
                <div class="col-sm-2">
                  <button type="button" class="btn btn-primary" style="width: 100%;" onclick="export_all_record()">
                    <i class="fas fa-download"></i> Export ALL Record</button>
                </div>
                <div class="col-sm-2 offset-4">
                  <div class="card-tools text-right">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                      <i class="fas fa-expand"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="container-fluid">
                <div class="row mb-3">
                  <div class="col-sm-2">
                    <label>Count:&ensp;</label><b><span class="h2" id="count_view"></span></b><br>
                  </div>

                  <div class="col-sm-2">
                    <label class="m-0 p-0">Car Maker</label>
                    <select class="form-control" id="request_car_maker_search" style="width: 100%;" required>
                      <option selected value="Please Select">Select car maker</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label class="m-0 p-0">Car Model</label>
                    <select class="form-control" id="request_car_model_search" style="width: 100%;" required>
                      <option selected value="Please Select">Select car model</option>
                    </select>
                  </div>
                  <div class="col-sm-2 offset-4">
                    <br>
                    <button class="btn btn-dark" style="width:100%;" onclick="clear_search_input()"><i
                        class="fas fa-trash"></i> Clear</button>
                  </div>
                  <!-- <div class="col-6 offset-4">
                    <p class="p-1" style="background: #FFFAD1; border-left: 3px solid #E89F4C; font-size: 14px;">
                      <span><i>Note:</i></span> Items
                      highlighted in <span style="color:red; font-weight: bold">RED</span> are those that are delayed
                      based on the <span style="color:red; font-weight: bold">REQUIRED DELIVERY DATE</span>
                    </p>
                  </div> -->
                </div>
                <div class="row mb-4">
                  <div class="col-sm-2 offset-2">
                    <label class="m-0 p-0">Section</label>
                    <!-- <label class="text-danger">*</label> -->
                    <select class="form-control" id="request_section_search" style="width: 100%;" required>
                      <option selected value="">Select section</option>
                      <option value="mppd1">MPPD1 - Request</option>
                      <option value="ame1req">AME1 - Request</option>
                      <option value="ame2req">AME2 - Request</option>
                      <option value="ame3req">AME3 - Request</option>
                      <option value="ame5req">AME5 - Request</option>
                    </select>
                  </div>
                  <div class="col-sm-2 ">
                    <label class="m-0 p-0">Status</label>
                    <label class="text-danger m-0 p-0">*</label>
                    <select class="form-control" id="request_status_search" style="width: 100%;" required>
                      <option selected value="pending">Pending</option>
                      <option value="open">Open</option>
                      <option value="ame3">Closed - AME3</option>
                      <option value="ame2">Closed - AME2</option>
                      <option value="cancelled">Cancelled</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label class="m-0 p-0">Date From <label class="m-0 p-0" style="font-size:13px;">(Date
                        Requested)</label></label>
                    <label class="text-danger m-0 p-0">*</label>
                    <input type="date" class="form-control" id="request_date_from_search">
                  </div>
                  <div class="col-sm-2">
                    <label class="m-0 p-0">Date To <label class="m-0 p-0" style="font-size:13px;">(Date
                        Requested)</label></label>
                    <label class="text-danger m-0 p-0">*</label>
                    <input type="date" class="form-control" id="request_date_to_search">
                  </div>
                  <div class="col-sm-2">
                    <br>
                    <button class="btn btn-primary" style="width: 100%" onclick="search_request()"><i
                        class="fas fa-search"></i> Search</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="card-body table-responsive p-0" style="height: 500px; overflow-y: auto;">
                      <div id="spinner" style="display: none; text-align: center; margin-top: 10px;">
                        <img src="../../dist/img/pin-wheel.gif" alt="Loading..."
                          style="width: 50px; height: 50px;">
                      </div>
                      <table class="table table-head-fixed text-nowrap table-bordered table-hover"
                        id="list_of_request_table">
                        <thead
                          style="text-align:center; position: sticky;top: 0; z-index: 1;  background-color: #f8f9fa;">
                          <tr>
                            <th colspan="18" class="bg-secondary">Request</th>
                            <th colspan="20" class="bg-light">RFQ Process</th>
                            <th colspan="13" class="bg-secondary">PO Process</th>
                            <th colspan="4" class="bg-light">Delivery</th>
                            <th colspan="3" class="bg-secondary">Installation</th>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="" id="cancel_check_all" onclick="select_all_func()">
                            </th>
                            <th>#</th>
                            <th>Status</th>
                            <th>Car Maker</th>
                            <th>Car Model</th>
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
                            <th>Uploaded By</th>

                            <th>Date of Issuance of RFQ </th>
                            <th>RFQ No </th>
                            <th>RFQ Remarks </th>
                            <th>Target Date of Reply Quotation </th>
                            <th>Item Code</th>
                            <th>Uploaded By</th>
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
                            <th>Uploaded By</th>

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
                            <th>Actual Arrival date </th>
                            <th>Uploaded By</th>
                            <!-- Installation -->
                            <th>Line Number</th>
                            <th>Installation Date</th>
                            <th>Uploaded By</th>
                          </tr>
                        </thead>
                        <tbody id="list_of_request" style="text-align:center;"></tbody>
                      </table>
                    </div>
                  </div>

                  <!-- end row -->
                </div>
                <!-- end container -->
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include 'plugins/footer.php'; ?>
<?php include 'plugins/javascript/dashboard_script.php'; ?>