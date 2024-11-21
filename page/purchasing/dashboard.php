<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/dashboardbar.php'; ?>

<!-- Main Sidebar Container -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><b>Request Data</b></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Request Data</li>
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
                <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="small-box bg-secondary">
                      <div class="inner">
                        <a href="../../process/export/export_request_data.php" style="color:white;">
                          <h5>Export Request Data</h5><br><br>
                      </div>
                      <div class="icon">
                        <i class="fas fa-download"></i>
                      </div>
                      </a>
                      <a href="../../process/export/export_request_data.php" class="small-box-footer">Proceed <i
                          class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
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
          <div class="card card-info">
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
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="card-body table-responsive p-0" style="height: 550px; overflow-y: auto;">
                        <div id="spinner" style="display: none; text-align: center; margin-top: 10px;">
                          <img src="../../dist/img/pin-wheel.gif" alt="Loading..." style="width: 50px; height: 50px;">
                        </div>
                        <table class="table table-head-fixed text-nowrap table-bordered table-hover"
                          id="list_of_uploaded_request_table">
                          <thead
                            style="text-align:center; position: sticky;top: 0; z-index: 1;  background-color: #f8f9fa;">
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
                              <th style="background:#f8f9fa;">Date Requested </th>
                              <th style="background:#f8f9fa;">Requested By </th>
                              <th style="background:#f8f9fa;">Required Delivery Date </th>
                              <th style="background:#f8f9fa;">Order Destination</th>
                              <th style="background:#f8f9fa;">Shipping Method </th>
                              <th style="background:#f8f9fa;">Upload By</th>
                            </tr>
                          </thead>
                          <tbody id="list_of_uploaded_request" style="text-align:center;">
                            <!-- <tr>
                              <td colspan="15" style="text-align:center;">
                                <div class="spinner-border text-dark" role="status">
                                  <span class="sr-only">Loading...</span>
                                </div>
                              </td>
                            </tr> -->
                          </tbody>
                        </table>
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
<?php include 'plugins/javascript/dashboard_script.php'; ?>