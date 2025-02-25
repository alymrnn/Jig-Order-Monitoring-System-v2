<footer class="main-footer">
  <div class="d-flex justify-content-between" style="font-size: 13px;">
    <div class="mr-auto "> <strong> Developed by: </strong> JJ Buendia
      | <strong>Co-Developers:</strong> Vince Alcantara, Raymart Vergara, Ally Maranan
    </div>
    <div> <strong>Copyright &copy; 2023 | All Rights Reserved</div>
    <div style="font-weight: normal;">&nbsp;&nbsp;Version 2.1.14</div>
  </div>
</footer>
<?php
//MODALS
include '../../modals/logout.php';
include '../../modals/import/request.php';
include '../../modals/account/add_account.php';
include '../../modals/account/update_account.php';
include '../../modals/monitor/cancel_request.php';
include '../../modals/cancel/cancel_info_modal.php';
include '../../modals/requester/add_single_item_record.php';
?>
<!-- jQuery -->
<!-- <script src="../../plugins/jquery/jquery.min.js"></script> -->
<script src="../../node_modules/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- toastr -->
<script type="text/javascript" src="../../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="../../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.js"></script>
</body>

</html>