<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/installation_account_bar.php'; ?>
<!-- Main Sidebar Container -->
<section class="content">
    <div class="container-fluid">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header bg-white py-">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="">Account Management</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Account Management</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <input type="text" id="fullname_search" class="form-control"
                                                autocomplete="off" placeholder="Full Name">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-block" id="searchReqBtn"
                                                onclick="search_account()"><i class="fas fa-search"></i> Search
                                            </button>
                                        </div>
                                        <div class="col-md-2 offset-5">
                                            <button class="btn btn-info btn-block" data-toggle="modal"
                                                data-target="#add_account"><i class="fas fa-plus"></i> Add Account</button>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0" style="height: 500px;">
                                        <table class="table table-head-fixed text-nowrap table-hover">
                                            <thead style="text-align:center;">
                                                <th> # </th>
                                                <th> Username </th>
                                                <th> Full Name </th>
                                                <th> Section </th>
                                                <th> User Type </th>
                                            </thead>
                                            <tbody id="list_of_account" style="text-align:center;"></tbody>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'plugins/footer.php'; ?>
<?php
include 'plugins/javascript/account_script.php';
?>
<?php
//  include 'plugins/javascript/notification_script.php';
?>
<?php
//  include 'plugins/javascript/closed_request_history_script.php';
?>