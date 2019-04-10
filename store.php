<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>eMeds Store Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo LTE;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo LTE;?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo LTE;?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo LTE;?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo LTE;?>dist/css/skins/skin-blue.css">
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>e</b>M</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>e</b>Meds</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?=gravatar($_SESSION['arr_details']['email'], 160); ?>" class="user-image">
                    <span class="hidden-xs"><?=$_SESSION['arr_details']['name']?></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                       <img src="<?=gravatar($_SESSION['arr_details']['email'], 160); ?>" class="img-circle">
                       <p>
                           <?=$_SESSION['arr_details']['name']?>
                           <small>+91 <?=$_SESSION['arr_details']['phone']?></small>
                       </p>
                    </li>
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <?=$_SESSION['arr_details']['address']?>
                            </div>
                        </div>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="index.php?logout" class="btn btn-default btn-flat">Logout</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column -->
  <aside class="main-sidebar">
      <section class="sidebar">
          <div class="user-panel">
              <div class="pull-left image">
              <img src="<?=gravatar($_SESSION['arr_details']['email'], 160); ?>" class="img-circle">
              </div>
              <div class="pull-left info">
                  <p><?=$_SESSION['arr_details']['name']?></p>
                  <a href="#">Ph. <?=$_SESSION['arr_details']['phone']?></a>
              </div>
          </div>

          <!-- side menu -->
          <ul class="sidebar-menu" data-widget="tree">
              <li class="header">Navigation</li>
              <li>
                  <a href="index.php">
                      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                  </a>
              </li>
          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
        <h1>Dashboard</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Drugs</h3>
                    </div>
                    <div class="box-body">
                        <div class="box with-border">
                            <div class="box-body">
                                <?php genMedTableStores(); ?>
                            </div>
                            <div class="box-footer">
                                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-add">Add new medicine</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12-->
        </div>
        <!-- /.row -->

    </section>

  </div>

</div>
<!-- /.wrapper -->
<div class="modal fade" id="modal-add">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add new drug to the list</h4>
                    </div>
                    <form action="" id="formAddMedicine" method="post">
                        <div class="modal-body">
                            <label for="m_name">Medicine name:</label> <input type="text" name="name" id="m_name" class="form form-control" placeholder="Medicine Name" required>
                            <label for="m_salt">Salt/Generic:</label> <input type="text" name="salt" id="m_salt" class="form form-control" placeholder="Salt" required>
                            <label for="m_price">Price <i class="fas fa-rupee-sign"></i>: </label> <input type="number" min="0" step="1" name="price" id="m_price" class="form form-control" placeholder="Price" required>
                            <label for="m_batch">Batch no:</label> <input type="text" name="batch" id="m_batch" class="form form-control" placeholder="Batch no." required>
                            <label for="m_qty">Quantity:</label> <input type="number" name="qty"  min="0" step="1" id="m_qty" class="form form-control" placeholder="Quantity" required>
                            <label for="m_exp">Expiry:</label> <input type="date" name="exp" id="m_exp" class="form form-control" placeholder="Expiry" value="2018-03-31" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            
                            <button type="submit" class="btn btn-success pull-right" name="addMedicine" value="1">Add medicine</button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>



<!-- /.wrapper -->
<!-- jQuery 3 -->
<script src="<?php echo LTE;?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo LTE;?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo LTE;?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Slimscroll -->
<script src="<?php echo LTE;?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo LTE;?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo LTE;?>dist/js/adminlte.min.js"></script>

<script src="<?php echo LTE;?>bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo LTE;?>bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>
<!-- Select2 -->
<script src="<?php echo LTE;?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $( function () {
        $( '#datatable' ).DataTable()
        $('.select2').select2()
     } );

     $("#formAddMedicine").submit(function(e) {

var url = "./ajax.php?ajaxAddMed=1"; // the script where you handle the form input.
$.ajax({
       type: "POST",
       url: url,
       data: $("#formAddMedicine").serialize(), // serializes the form's elements.
       success: function(data)
       {
           alert(data); // show response from the php script.
           location.reload(); 
       }
     });
    
e.preventDefault(); // avoid to execute the actual submit of the form.
 $('input[type="text"], textarea, input[type="number"]').val(''); //reset the form
 $('#modal-add').modal('hide'); // hide the modal
});
</script>

</body>
</html>
