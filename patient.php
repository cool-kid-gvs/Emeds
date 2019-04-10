<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>eMeds Patients Dashboard</title>
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
                  <a href="#">#<?=$_SESSION['arr_details']['p_id']?></a>
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

      <!-- Main Content -->
      <section class="content">
          <div class="row">
             <div class="col-lg-3 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?=getPresCount()?></h3>
                  <p>Prescriptions</p>
                </div>
             <div class="icon">
                  <i class="ion ion-document-text"></i>
             </div>
             <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
             </div>
             <!-- ./col -->
          </div>
          <!-- /.row -->

          <!-- main row -->
          <div class="row">
              <section class="col-lg-12 connectedSortable">
                  <div class="box box-success">
                      <div class="box-header">
                          <h3 class="box-title">Prescriptions</h3>
                          <div class="box-tools pull-right">
                            <!-- Collapse Button -->
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            </div>
                            <!-- /.box-tools -->
                      </div>
                      <div class="box-body">
                          <div class="box with-border">
                            <div class="box-body">
                                <?php genPresListPatient($_SESSION['arr_details']['p_id']); ?>
                            </div>
                          </div>
                      </div>
                  </div>
              </section>
          </div>
      </section>
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
</script>

</body>
</html>
