<?php
include_once __DIR__ .'/includes/functions.php';
if(!isset($_GET['pr_id']) || $_GET['pr_id'] == '') {
    //Illegal entry
    header('Location: index.php');
}
$pr_id = $_GET['pr_id'];
//Get all the details from pr_id
$query = "SELECT * FROM Prescriptions WHERE pr_id='$pr_id'";
$result = mysqli_query($conn,$query);
$pres = mysqli_fetch_array($result);
//get the p_id
$p_id = $pres['p_id'];
//get the patient details
$query = "SELECT * FROM patients WHERE p_id='$p_id'";
$result = mysqli_query($conn, $query);
$patient = mysqli_fetch_array($result);
//get the doc_id
$doc_id = $pres['doc_id'];
//get the doctor details
$query = "SELECT * FROM doctors WHERE doc_id='$doc_id'";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Prescription ID - <?=$pr_id?></title>
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="assets/js/qrious/dist/qrious.js"></script>
  <script>
  const qr = new QRious({
      value: '<?=$pres["qrcode"]?>'
  });
  var base64 = qr.toDataURL();
  //console.log(base64);
  </script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="">
<div class="wrapper">
  <!-- Main content -->

    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-plus"></i> <?=$doctor['venue']?><small class="pull-right"><?=$pres['date_created']?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?=$doctor['name']?></strong><br><?=$doctor['venue_add']?><br>India<br>Phone: <?=$doctor['phone']?><br>Email: <?=$doctor['email']?></address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><?=$patient['name']?></strong><br><?=$patient['address']?><br>India<br>Phone: <?=$patient['phone']?><br>Email: <?=$patient['email']?></address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Patient ID: #<?=$p_id?></b><br>
          <br>
            <div style=" 5px solid black;">&nbsp;
              <a href="emeds://<?=$pres["qrcode"]?>">
                <img src="" alt="QRCODE" width="100px" class="qrcode">
              </a>
            </div>
            <br>

           
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <?php $tests=genPresTable($pres['arr_name']) ?>
        </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-sm-3">
        <strong>Tests : </strong>
        </div>
        <div class="col-sm-3">
            <?php genTestsList($tests) ?>
        </div>
        <div class="col-sm-3">
            <strong>Diagnosis : </strong>
        </div>
        <div class="col-sm-3">
            <?php genDiag($pres['arr_name']);?>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
      <div class="col-xs-12">
      <i>Note : This is a system generated prescription, signature is optional.</i> 
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="<?php echo LTE;?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo LTE;?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
$('.qrcode').attr('src', base64);
</script>
</body>
</html>
