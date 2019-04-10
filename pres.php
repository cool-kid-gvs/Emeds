<?php
//Check for Illegal Entries
if(!isset($_GET['w_id']) && !isset($_GET['p_id']) && $_GET['w_id']=='' && $_GET['p_id']=='') {
    //Illegal entry
    header('Location: index.php');
    exit();
}
//This page is only available to doctors
if($_SESSION['type'] != "doctor") {
    //Illegal entry
    header('Location: index.php');
    exit();
}
$p_id = $_GET['p_id'];
$w_id = $_GET['w_id'];
$today = date("Y-m-d H:i:s");// 2001-03-10 17:16:18 (the MySQL DATETIME format)
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>eMeds Prescription Pad</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo LTE;?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo LTE;?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo LTE;?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo LTE;?>bower_components/select2/dist/css/select2.min.css">
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
                           <small><?=$_SESSION['arr_details']['venue']?></small>
                       </p>
                    </li>
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <?=$_SESSION['arr_details']['qualification']?>
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
                  <a href="#"><?=$_SESSION['arr_details']['speciality']?></a>
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
          <h1>Write a Prescription</h1>
      </section>

      <!-- Main Content -->
      <section class="content">

          <!-- main row -->
          <div class="row">
              <section class="col-lg-12 connectedSortable">
                  <div class="box box-success">
                    <div class="box-header">
                    <h3 class="box-title">Prescription</h3>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="w_id" value="<?=$w_id?>">
                        <div class="box with-border">
                            <div class="box-body">
                                <!--FORM GOES HERE -->
                                <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="p_id">Patient ID</label>
                                           <input type="text" name="p_id" id="p_id" value="<?=$p_id?>" readonly="readonly" >
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                           <label for="doc_id">Doctor ID</label>
                                           <input type="text" name="doc_id" id="doc_id" value="<?=$_SESSION['arr_details']['doc_id']?>" readonly="readonly" >
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_created">DateTime</label>
                                            <input id="date_created" type="text" name="date_created" value="<?=$today?>" readonly="readonly" >
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                               <div class="row col-lg-12">
                                   <div class="box box-primary">
                                       <div class="box-body with-border">
                                            <div class="field_wrapper1">
                                                <div class="row">
                                                    <div class="form-group col-md-3">
                                                        <label for="medicines">Medicines</label>
                                                        <?php genMedicineList() ?>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="dosage">Dosage</label>
                                                        <?php genDosageList() ?>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="consumption">Consumption</label>
                                                        <?php genConsumptionList() ?>
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        <label for="number">Number</label>
                                                        <input type="number" name="number[]" min="1" id="number" step="1" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="duration">Duration</label>
                                                        <?php genConsumptionDuration() ?>
                                                    </div>
                                                </div>
                                                <!-- /.row -->
                                            </div>
                                            <!-- /.field_wrapper -->
                                            <div>
                                                        <a href="javascript:void(0);" class="add_button1" title="Add field">
                                                            <i class="ion ion-plus"></i>
                                                            Add more fields
                                                        </a>
                                            </div>
                                        </div>
                                        <!-- /.box-body with-border -->
                                    </div>
                                    <!-- /.box box-primary -->
                               </div>
                               <!-- /.row col-lg-12 -->
                               <div class="row col-lg-12">
                                   <div class="box box-primary">
                                       <div class="box-body with-border">
                                           <div class="field_wrapper2">
                                               <div class="row">
                                                   <div class="form-group col-md-7">
                                                       <label for="Tests">Tests</label>
                                                       <input type="text" name="tests[]" id="Tests" class="form-control">
                                                   </div>
                                               </div>
                                           </div>
                                           <!-- /.field_wrapper2 -->
                                           <div>
                                                        <a href="javascript:void(0);" class="add_button2" title="Add field">
                                                            <i class="ion ion-plus"></i>
                                                            Add more fields
                                                        </a>
                                            </div>
                                       </div>
                                       <!-- /.box-body -->
                                   </div>
                                   <!-- /.box box-primary-->
                               </div>
                               <!-- /.row col-lg-12 -->
                               <div class="row col-md-12">
                                   <div class="box box-primary">
                                       <div class="box-body with-border">
                                           <div class="row">
                                               <div class="form-group col-md-12">
                                                   <label for="diagnosis">Diagnosis</label>
                                                   <textarea class="form-control" rows="3" placeholder="Diagnonis...." name="diagnosis"></textarea>
                                                </div>
                                           </div>
                                       </div>                                       
                                   </div>
                               </div>
                            </div>
                            <!-- /.box-body  -->
                            <div class="box-footer">
                                <input type="reset" value="Reset" class="btn btn-default">
                                <button type="submit" class="btn btn-success pull-right" name="writePres" value="1">Finalize</button>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </form>
                  </div>
                  <!-- /.box box-success -->
              </section>
          </div>
      </section>
  </div>
  <!-- /.content-wrapper -->

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
    $(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton1 = $('.add_button1'); //Add button selector
    var wrapper1 = $('.field_wrapper1'); //Input field wrapper
    var fieldHTML1 = ' <div class="row">\
                                           <div class="form-group col-md-3">\
                                               <label for="medicines">Medicines</label>\
                                               <?php genMedicineList() ?>
                                           </div>\
                                           <div class="form-group col-md-3">\
                                               <label for="dosage">Dosage</label>\
                                               <?php genDosageList() ?>
                                           </div>\
                                           <div class="form-group col-md-3">\
                                               <label for="consumption">Consumption</label>\
                                               <?php genConsumptionList() ?>
                                           </div>\
                                           <div class="form-group col-md-1">\
                                                        <label for="number">Number</label>\
                                                        <input type="number" name="number[]" min="1" id="number" step="1" class="form-control">\
                                                    </div>\
                                                    <div class="form-group col-md-2">\
                                                        <label for="duration">Duration</label>\
                                                        <?php genConsumptionDuration() ?>
                                                    </div>\
                                           <a href="javascript:void(0);" class="remove_button1 pull-right" title="Remove Field">\
                                                <i class="ion ion-minus"></i>\
                                                Remove\
                                            </a>\
                                       </div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton1).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper1).append(fieldHTML1); // Add field html
            //Initialize Select2 Elements
            $('.select2').select2();
        }
    });
    $(wrapper1).on('click', '.remove_button1', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    var addButton2 = $('.add_button2'); //Add button selector
    var wrapper2 = $('.field_wrapper2'); //Input field wrapper
    var fieldHTML2 = '<div class="row">\
                                                   <div class="form-group col-md-7">\
                                                       <label for="Tests">Tests</label>\
                                                       <input type="text" name="tests[]" id="Tests" class="form-control">\
                                                   </div>\
                                                <a href="javascript:void(0);" class="remove_button2" title="Remove Field">\
                                                <i class="ion ion-minus"></i>\
                                                Remove\
                                            </a>\
                                               </div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(addButton2).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper2).append(fieldHTML2); // Add field html
            //Initialize Select2 Elements
            $('.select2').select2();
        }
    });
    $(wrapper2).on('click', '.remove_button2', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
$(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>

</body>
</html>
