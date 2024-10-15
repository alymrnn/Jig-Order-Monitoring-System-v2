<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="../../dist/img/logo.png" alt="Logo" class="brand-image">
    <span class="brand-text font-weight-light"><b>JOMS |
        <?= htmlspecialchars($_SESSION['section']); ?>
      </b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../dist/img/user.png" class="img-circle elevation-2" alt="User Image">

      </div>
      <div class="info">
        <a href="#" class="d-block"><b>
            <?= htmlspecialchars($_SESSION['fullname']); ?>
          </b></a>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">

      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link active bg-success">
            <i class="nav-icon fas fa-wrench"></i>
            <p style="font-size:14px;">
              Set Installation
            </p>
          </a>
        </li>
        <li class="nav-item" id="accounts_bar">
          <a href="installation_account.php" class="nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
            <p style="font-size:14px;">
              Account Management
            </p>
          </a>
        </li>
        <?php include 'logout.php'; ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>