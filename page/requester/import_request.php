<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/import_requestbar.php'; ?>
<!-- Main Sidebar Container -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><b>Import Request Data</b></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Import Request Data</li>
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
            <!-- form start -->
            <form>
              <div class="card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="small-box bg-primary">
                        <div class="inner">
                          <a href="" style="color:white;" data-toggle="modal" data-target="#add_single_item_record">
                            <h5>Add Single Item</h5>
                            <br>
                            <br>
                        </div>
                        <div class="icon">
                          <i class="fas fa-plus"></i>
                        </div>
                        </a>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#add_single_item_record">Proceed
                          <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="small-box bg-info">
                        <div class="inner">
                          <a href="" style="color:white;" data-toggle="modal" data-target="#import_request">
                            <h5>Import Data</h5>
                            <br>
                            <br>
                        </div>
                        <div class="icon">
                          <i class="fas fa-upload"></i>
                        </div>
                        </a>
                        <a href="#" class="small-box-footer" data-toggle="modal" data-target="#import_request">Proceed
                          <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                      <div class="small-box bg-secondary">
                        <div class="inner">
                          <a href="../../template/template-for-request.csv" style="color:white;">
                            <h5>Download Template</h5>
                            <br>
                            <br>
                        </div>
                        <div class="icon">
                          <i class="fas fa-download"></i>
                        </div>
                        </a>
                        <a href="../../template/template-for-request.csv" class="small-box-footer">Proceed <i
                            class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end row -->
          </div>
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">List of Request Data</h3>
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
                          <b><span class="h3" id="count_view"></span></b><br>
                          <label>Count</label>
                        </div>
                        <div class="col-6 offset-5">
                          <p class="p-1" style="background: #FFFAD1; border-left: 3px solid #E89F4C; font-size: 14px;">
                            <span><i>Note:</i></span> Items
                            highlighted in <span style="color:red; font-weight: bold">RED</span> are those that are
                            delayed based on the <span style="color:red; font-weight: bold">REQUIRED DELIVERY
                              DATE</span>
                          </p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12">
                          <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap table-bordered table-hover"
                              id="list_of_uploaded_request_table">
                              <thead style="text-align:center;">
                                <tr>
                                  <th style="background:#f8f9fa;">#</th>
                                  <th style="background:#f8f9fa;">Status</th>
                                  <th style="background:#f8f9fa;">Car Maker</th>
                                  <th style="background:#f8f9fa;">Car Model</th>
                                  <th style="background:#f8f9fa;">Product </th>
                                  <th style="background:#f8f9fa;">Jig Name </th>
                                  <th style="background:#f8f9fa;">Drawing No </th>
                                  <th style="background:#f8f9fa;">Type </th>
                                  <th style="background:#f8f9fa;">Qty </th>
                                  <th style="background:#f8f9fa;">Purpose </th>
                                  <th style="background:#f8f9fa;">Kigyo Budget </th>
                                  <th style="background:#f8f9fa;">Shipping Method </th>
                                  <th style="background:#f8f9fa;">Date Requested </th>
                                  <th style="background:#f8f9fa;">Requested By </th>
                                  <th style="background:#f8f9fa;">Required Delivery Date </th>
                                  <th style="background:#f8f9fa;">Remarks (fill up if ECT jig is under new design, supplier) </th>
                                  <th style="background:#f8f9fa;">Uploaded By</th>
                                </tr>
                              </thead>
                              <tbody id="list_of_uploaded_request" style="text-align:center;"></tbody>
                            </table>
                            <div class="row">
                              <div class="col-6"></div>
                              <div class="col-6">
                                <div class="spinner" id="spinner" style="display:none;">
                                  <div class="loader float-sm-center"></div>
                                </div>
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
<?php include 'plugins/javascript/import_request_script.php'; ?>