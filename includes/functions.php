
<?php
/*
* Filename - functions.php
* Purpose - Contain all the core functionality of the web app
* Author - Gaurav Sukhatme
* Contact - sukhatmegaurav@gmail.com
*/
ini_set("display_errors", "1"); // Should be disabled in production, disabled in remote server
ob_start();
session_start();
//Define the include checker
define('included', 1);
//Some definitions requried for the theme 
define('LTE', 'modules/adminlte/');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emeds";
//Include Way2SMS API wrapper
// include('way2sms-api.php');
//initializing sms engine
// $sms = new WAY2SMSClient();
//fuction to send SMS via Way2SMS
function sendSMS($mobile, $msg) {
    global $sms;
    $sms->login('8224844487', 'gaurav10');
    $sms->send($mobile, $msg);
    sleep(1);
    $sms->logout();
}
 function gvsSendSMS($mobile, $msg){
    $mobile= $mobile;
    $message= $msg;
    echo "ye h ".$msg;
    $json = json_decode(file_get_contents("https://smsapi.engineeringtgr.com/send/?Mobile=9630179950&Password=999hrm90&Message=".urlencode($message)."&To=".urlencode($mobile)."&Key=hrishhVEsnp628d3FAKW0vfli4j"),true);
    // if ($json["status"]==="success") {
    //     echo $json["msg"];
    //     //your code when send success
    // }else{
    //     echo $json["msg"];
    //     //your code when not send
    // }
 }

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (mysqli_connect_errno($conn)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//function to generate random ids
function genID() {
    $id = mt_rand(1,999999);
    return $id;
}
//short function to mysqli_real_escape_string 
function escape($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

function login($user, $pass, $type) {
    global $conn;
    $user = escape($user);
    $pass = escape(md5($pass));
    if($user == '' || $pass == '' || $type == '') {
        $_SESSION['error'] = 'You cannot leave the fields empty';
    } else {
        if($type == 'doctor') {
            $query = "SELECT * FROM doctors WHERE user = '$user' AND pass = '$pass'";
            $result = mysqli_query($conn,$query);

            if(mysqli_num_rows($result) == 1) {
                $_SESSION['authorized'] = true;
                $_SESSION['type'] = 'doctor';
                $_SESSION['arr_details'] = mysqli_fetch_array($result);
                header('Location: index.php');
                exit();
            }else {
                $_SESSION['error'] = "Incorrect credentials";
            }
        } elseif($type == 'patient') {
            $query = "SELECT * FROM patients WHERE user = '$user' AND pass = '$pass'";
            $result = mysqli_query($conn,$query);

            if(mysqli_num_rows($result) == 1) {
                $_SESSION['authorized'] = true;
                $_SESSION['type'] = 'patient';
                $_SESSION['arr_details'] = mysqli_fetch_array($result);
                header('Location: index.php');
                exit();
            }else {
                $_SESSION['error'] = "Incorrect credentials";
            }
        } elseif($type == 'hospital'){
            $query = "SELECT * FROM hospital WHERE user = '$user' AND pass = '$pass'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) == 1) {
                $_SESSION['authorized'] = true;
                $_SESSION['type'] = "hospital";
                $_SESSION['arr_details'] = mysqli_fetch_array($result);
                header('Location: index.php');
                exit();
            }else {
                $_SESSION['error'] = "Incorrect credentials";
            } 
        } elseif($type == 'store') {
            $query = "SELECT * FROM stores WHERE user = '$user' AND pass = '$pass'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) == 1) {
                $_SESSION['authorized'] = true;
                $_SESSION['type'] = 'store';
                $_SESSION['arr_details'] = mysqli_fetch_array($result);
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['error'] = "Incorrect credentials";
            }
        }
    } 
}

function logged_in() {
    if(isset($_SESSION['authorized']) == true) {
        return true;
    } else {
        return false;
    }
}

function login_required() {
    if(logged_in()) {
        return true;
    } else {
        header('Location: login.php');
        exit();
    }
}

function logout(){
    unset($_SESSION['authorized']);
    unset($_SESSION['type']);
    unset($_SESSION['arr_details']);
    if(isset($_COOKIE['logged_in'])) {
		setcookie("logged_in", "", time() - 3600);
	}
	header('Location: login.php');
	exit();
}
//logout trigger
if ( isset( $_GET[ 'logout' ] ) ) {
	logout();
}

// Render error messages

function messages() {
    $message = '';
    if(isset($_SESSION['success']) != '') {
        $message = '<div class="row">
					<div class="box">
					<div class="box-body"><div class="alert alert-success">'.$_SESSION['success'].'</div></div></div></div>';
        $_SESSION['success'] = '';
    }
    if(isset($_SESSION['error']) != '') {
        $message = '<div class="row">
					<div class="box">
					<div class="box-body"><div class="alert alert-danger">'.$_SESSION['error'].'</div></div></div></div>';
        $_SESSION['error'] = '';
    }
    echo "$message";
}
function errors($error){
	if (!empty($error))
	{
		$i = 0;
		while ($i < count($error)){
		$showError.= "<div class=\"row\">
					<div class=\"box\">
					<div class=\"box-body\"><div class=\"alert alert-danger\">".$error[$i]."</div></div></div></div>";
            $i ++;
        }
		echo $showError;
	}// close if empty errors
} // close function
/**
  Load a gravatar.
*/
function gravatar($email = '', $size = 60, $rating = 'pg' ) {
    $email = md5(strtolower(trim($email)));
    $gravurl = "http://www.gravatar.com/avatar/$email?s=$size&r=$rating";
    return $gravurl;
}

//function to get the waitlist in hospital.php
function getWaitlist($hid) {
    global $conn;
    $query = "SELECT w_id, doctors.name 'd_name', patients.name 'p_name', doctors.room 'd_room' FROM `waitlist`,`doctors`,`patients` WHERE waitlist.h_id = '$hid' AND waitlist.doc_id = doctors.doc_id ANd waitlist.p_id = patients.p_id";
    $result = mysqli_query($conn, $query);
    //$row = mysqli_fetch_array($result);
    echo '<table class="table table-hover" id="datatable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Room No.</strong></th>';
    echo '</tr>';
    echo '</thead>';
    while($r = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>';
        echo $r['w_id'];
        echo '</td>';
        echo '<td>';
        echo $r['d_name'];
        echo '</td>';
        echo '<td>';
        echo $r['p_name'];
        echo '</td>';
        echo '<td>';
        echo $r['d_room'];
        echo '</td>';
        echo '</tr>';
    }
    echo '<tfoot>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Room No.</strong></th>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
}

//Function to add a new patient in hospital.php
function addPatient($user, $pass, $name, $email, $address, $phone, $age, $wt, $sex, $aadhar) {
    global $conn;
    $user = escape($user);
    $r_pass = escape($pass);
    $pass = escape(md5($pass));
    $name = escape($name);
    $email = escape($email);
    $address = escape($address);
    $phone = escape($phone);
    $age=escape($age);
    // $wt=escape($wt);
    // $sex = escape($sex);
    // $adhaar = escape($adhaar); 
    $p_id = genID();
    // $query = "INSERT INTO 'patients' ('user', 'pass', 'name', 'email', 'address', 'phone', 'age', 'wt', 'sex', 'adhaar', 'p_id') VALUES ('$user', '$pass', '$name', '$email', '$address', '$phone', '$age', '$wt', $sex, '$adhaar', '$p_id')";
    // echo '<script>alert("if k phle");</script>';
    $query = "INSERT INTO `patients` (`p_id`, `user`, `pass`, `name`, `email`, `address`, `phone`, `age`, `wt`, `sex`, `aadhar`) VALUES ($p_id, '$user', '$pass', '$name', '$email', '$address', '$phone', $age, $wt, 1, $aadhar);";
    // $check = mysqli_query($conn, $query);
    // echo '<script>alert("send sms k phle");</script>';
    if (mysqli_query($conn, $query)) {
        $msg = "Welcome to eMeds! Your username - " . $user . "  pass - " . $r_pass;
        // echo '<script>alert("send sms k phle");</script>';
        // sendSMS($phone, $msg);
        gvsSendSMS($phone, $msg);
        echo '<script>alert("New record created successfully");</script>';
    } else {
        echo '<script>alert("ERROR: " '.mysqli_error($conn) .' ");</script>';
    }
}
//addPatient trigger - hospital.php
if(isset($_POST['addPatient']) && $_POST['addPatient'] == '1') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $wt = $_POST['wt'];
    $sex = $_POST['sex'];
    // $adhaar = $_POST['adhaar'];
    // addPatient($user, $pass, $name, $email, $address, $phone, $age, $wt, $sex, $adhaar);
    $aadhar = $_POST['aadhar'];
    addPatient($user, $pass, $name, $email, $address, $phone, $age, $wt, $sex, $aadhar);
}

//Function to construct the Add to waitlist form in hospital.php
function genAddToWaitlist($hid) {
    global $conn;
    $sql1 = "SELECT * FROM patients";
    $sql2 = "SELECT * FROM doctors WHERE h_id = '$hid'";
    $result1 = mysqli_query($conn,$sql1);
    $result2 = mysqli_query($conn, $sql2);
    //Let's contruct the form
    echo '
        <form action="" method="POST" class="form-horizontal">
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <select name="doc_id" id="doc_id" class="form-control select2" placeholder="Select a doctor">
                        ';
                        while($r2 = mysqli_fetch_array($result2)) {
                            echo '<option value="';
                            echo $r2['doc_id'];
                            echo '">';
                            echo $r2['name'];
                            echo '</option>';
                        }
    echo '
                        </select>
                    </div><br>
                    <div class="form-group">
                        <select name="p_id" id="p_id" class="form-control select2" placeholder="Select a patient">
                        ';
                        while($r1 = mysqli_fetch_array($result1)) {
                            echo '<option value="';
                            echo $r1['p_id'];
                            echo '">';
                            echo $r1['name'];
                            echo '</option>';
                        }
    echo '
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                <input type="reset" value="Cancel" class="btn btn-default">
                <button type="submit" class="btn btn-info pull-right" name="addToWaitlist" value="1">Add</button>
                </div>
            </div>
        </form>
    ';
}

//function to add to waitlist - hospital.php
function addToWaitlist($hid,$doc_id,$p_id) {
    global $conn;
    $hid = escape($hid);
    $doc_id = escape($doc_id);
    $p_id = escape($p_id);
    $query = "INSERT INTO `waitlist`(`h_id`, `doc_id`, `p_id`) VALUES ('$hid', '$doc_id', '$p_id')";
    if (mysqli_query($conn, $query)) {
        echo '<script>alert("Added to waitlist");</script>';
    } else {
        echo '<script>alert("ERROR: " '.mysqli_error($conn) .' ");</script>';
    }
}
//trigger for addToWaitlist() in hospital.php
if(isset($_POST['addToWaitlist']) && $_POST['addToWaitlist'] == '1') {
    $hid = $_SESSION['arr_details']['h_id'];
    $doc_id = $_POST['doc_id'];
    $p_id = $_POST['p_id'];
    addToWaitlist($hid,$doc_id,$p_id);
}

//function to generate waitlist for the doctor's dashboard - doctor.php
function genWaitlistDoc($doc_id) {
    global $conn;
    $query = "SELECT w_id, patients.p_id, doctors.name 'd_name', patients.name 'p_name', doctors.room 'd_room' FROM `waitlist`,`doctors`,`patients`,`hospital` WHERE waitlist.doc_id = '$doc_id' AND waitlist.h_id = hospital.h_id AND waitlist.p_id = patients.p_id AND waitlist.doc_id = doctors.doc_id";
    $result = mysqli_query($conn, $query);
    echo '<table class="table table-hover" id="datatable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Room No.</strong></th><th><strong>Actions</strong></th>';
    echo '</tr>';
    echo '</thead>';
    while($r = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>';
        echo $r['w_id'];
        echo '</td>';
        echo '<td>';
        echo $r['d_name'];
        echo '</td>';
        echo '<td>';
        echo $r['p_name'];
        echo '</td>';
        echo '<td>';
        echo $r['d_room'];
        echo '</td>';
        echo '<td>';
        echo '<a href="index.php?write=1&w_id='.$r['w_id'].'&p_id='.$r['p_id'].'"><span class="label label-success">Attend</span> </a> | <a href="?discardWL='.$r['w_id'].'"><span class="label label-danger">Discard</span></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '<tfoot>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Room No.</strong></th><th><strong>Actions</strong></th>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
}

//function to remove a name from waitlist
function discardWL($w_id) {
    global $conn;
    $w_id = escape($w_id);
    $query = "DELETE FROM `waitlist` WHERE `w_id` = '$w_id'";
    if (mysqli_query($conn, $query)) {
        echo '<script>alert("Deleted from waitlist");location.href = "index.php"</script>';
    } else {
        echo '<script>alert("ERROR: " '.mysqli_error($conn) .' ");</script>';
    }
}
//Trigger for discardWL function 
if(isset($_GET['discardWL']) && $_GET['discardWL'] != '') {
    $w_id = $_GET['discardWL'];
    discardWL($w_id);
}

//function to generate number cards like patient registrations etc
function getPatientCount() {
    global $conn;
    $query = "SELECT * FROM patients";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}
function getDoctorCount() {
    global $conn;
    $query = "SELECT * FROM doctors";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}
function getPresCount() {
    global $conn;
    $query = "SELECT * FROM prescriptions";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
}

//function to generate prescription list via doc_id - doctor.php
function genPresListDoc($doc_id){
    global $conn;
    $query = "SELECT pr_id, patients.name 'p_name', doctors.name 'd_name', date_created FROM `prescriptions`,`doctors`,`patients` WHERE prescriptions.p_id = patients.p_id AND prescriptions.doc_id = doctors.doc_id AND prescriptions.doc_id = '$doc_id'";
    $result = mysqli_query($conn, $query);
    echo '<table class="table table-hover" id="datatable2">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Date created</strong></th><th><strong>Actions</strong></th>';
    echo '</tr>';
    echo '</thead>';
    while($r = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>';
        echo $r['pr_id'];
        echo '</td>';
        echo '<td>';
        echo $r['d_name'];
        echo '</td>';
        echo '<td>';
        echo $r['p_name'];
        echo '</td>';
        echo '<td>';
        echo $r['date_created'];
        echo '</td>';
        echo '<td>';
        echo '<a href="viewpres.php?pr_id='.$r['pr_id'].'"><span class="label label-info">View</span> </a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '<tfoot>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Date created</strong></th><th><strong>Actions</strong></th>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
}

//function to generate prescription list via p_id - patient.php
function genPresListPatient($p_id) {
    global $conn;
    $query = "SELECT pr_id, patients.name 'p_name', doctors.name 'd_name', date_created FROM `prescriptions`,`doctors`,`patients` WHERE prescriptions.p_id = patients.p_id AND prescriptions.doc_id = doctors.doc_id AND prescriptions.p_id = '$p_id'";
    $result = mysqli_query($conn, $query);
    echo '<table class="table table-hover" id="datatable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Date created</strong></th><th><strong>Actions</strong></th>';
    echo '</tr>';
    echo '</thead>';
    while($r = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>';
        echo $r['pr_id'];
        echo '</td>';
        echo '<td>';
        echo $r['d_name'];
        echo '</td>';
        echo '<td>';
        echo $r['p_name'];
        echo '</td>';
        echo '<td>';
        echo $r['date_created'];
        echo '</td>';
        echo '<td>';
        echo '<a href="viewpres.php?pr_id='.$r['pr_id'].'"><span class="label label-info">View</span> </a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '<tfoot>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th> <th><strong> Doctor\'s name </strong></th> <th><strong>Patient\'s name </strong></th><th><strong>Date created</strong></th><th><strong>Actions</strong></th>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
}

//function to generate medicine list for pres.php
function genMedicineList() {
    global $conn;
    $query = "SELECT * FROM medicines";
    $result = mysqli_query($conn, $query);
    echo '<select class="form-control select2" name="medicines[]" tabindex="-1" aria-hidden="true" id="medicines">';
    while($r=mysqli_fetch_array($result)) {
        echo '<option value="'.$r['name'].'">';
        echo $r['name']; //change this to $r['name'] if you wanna show the brand names and just store the salts
        echo '</option>';
    }
    echo '</select>';
}

//function to generate dosage list for pres.php
function genDosageList() {
    $dossage = array("50mg", "100mg", "200mg","250mg", "300mg", "400mg", "625mg", "5ml", "10ml", "15ml", "20ml", "1drop", "2drop", "3drop");
    echo '<select class="form-control select2" name="dosage[]" tabindex="-1" aria-hidden="true" id="dosage">';
    foreach($dossage as $d) {
        echo '<option value="'.$d.'">';
        echo $d;
        echo '</option>';
    }
    echo '</select>';
}

//function to generate consumption list for pres.php
function genConsumptionList() {
    $cons = array(
        "Once in a day",
        "Empty stomach",
        "After breakfast",
        "After lunch",
        "Before lunch",
        "After dinner",
        "Before dinner",
        "Twice daily after meal",
        "Twice daily before meal",
        "Thrice daily after meal",
        "Thrice daily before meal",
        "Four times daily after meal",
        "Four times daily before meal",
        "Once in a week"
    );
    echo '<select class="form-control select2" name="consumption[]" tabindex="-1" aria-hidden="true" id="consumption">';
    foreach($cons as $c){
        echo '<option value="'.$c.'">';
        echo $c;
        echo '</option>';
    }
    echo '</select>';
}

//function to generate consumption duration
function genConsumptionDuration() {
    $cons = array(
        "Days",
        "Weeks",
        "Months"
    );
    echo '<select class="form-control select2" name="duration[]" tabindex="-1" aria-hidden="true" id="duration">';
    foreach($cons as $c){
        echo '<option value="'.$c.'">';
        echo $c;
        echo '</option>';
    }
    echo '</select>';
}

//function to add prescription
function addPres($p_id, $doc_id, $date_created, $json, $w_id) {
    $pr_id = genID();
    $qrcode = md5($pr_id);
    $arr_name = $pr_id.'.json';
    global $conn;
    $query = "INSERT INTO `prescriptions`(`pr_id`, `p_id`, `doc_id`, `qrcode`, `arr_name`, `date_created`) VALUES ('$pr_id', '$p_id', '$doc_id', '$qrcode', '$arr_name', '$date_created')";
    if(mysqli_query($conn,$query)) {
        //INSERT query returns true
        //Write the prescription file
        file_put_contents('data/prescriptions/'.$arr_name, $json);
        $q = "SELECT phone FROM patients WHERE p_id='$p_id'";
        $re = mysqli_query($conn, $q);
        $r = mysqli_fetch_array($re);
        $phone = $r['phone'];
        $msg = "Prescription created ID ".$pr_id.". View at 192.168.1.5/gvstryphp/web/viewpres.php?pr_id=".$pr_id;
        // $msg=urlencode('prescription '.$pr_id.' View at 192.168.1.5/gvstryphp/web/viewpres.php?pr_id= '.$pr_id);
        // $msg="tumaddhogye";
        gvsSendSMS($phone, $msg);
        echo '<script>window.open("viewpres.php?pr_id='.$pr_id.'", "_blank");alert("Prescription Created");</script>';
        discardWL($w_id);
    } else {
        echo '<script>alert("INSERT FAILED");</script>';
    }
}
//Trigger for addPres
if(isset($_POST['writePres']) && $_POST['writePres'] == '1') {
    $p_id = $_POST['p_id'];
    $doc_id = $_POST['doc_id'];
    $date_created = $_POST['date_created'];
    $json = json_encode($_POST);
    $w_id = $_POST['w_id'];
    addPres($p_id, $doc_id, $date_created, $json, $w_id);
}
//function to calculate quantity
function calcQTY($consumption, $number, $duration) {
    $cons = array(
        "Once in a day" => 1,
        "Empty stomach" => 1,
        "After breakfast" => 1,
        "After lunch" => 1,
        "Before lunch" => 1,
        "After dinner" => 1,
        "Before dinner" => 1,
        "Twice daily after meal" => 2,
        "Twice daily before meal" => 2,
        "Thrice daily after meal" => 3,
        "Thrice daily before meal" => 3,
        "Four times daily after meal" => 4,
        "Four times daily before meal" => 4,
        "Once in a week" => 1
    );
    $dur = array(
        "Days" => 1,
        "Weeks" => 7,
        "Months" => 30
    );
    $dailyNo = $cons[$consumption];
    $qty = $dailyNo * $number * $dur[$duration];
    return $qty;
}
//function to generate the prescription table in viewpres.php
function genPresTable($arr_name) {
    $file = './data/prescriptions/'.$arr_name;
    $json = file_get_contents($file);
    $arr = json_decode($json, true);
    $medicines = $arr['medicines'];
    $dosage = $arr['dosage'];
    $consumption = $arr['consumption'];
    $number = $arr['number'];
    $duration = $arr['duration'];
    $tests = $arr['tests'];
    $countM = sizeof($medicines);
    $countT = sizeof($tests);
    echo '<table class="table table-stripped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>#</th><th>Medicine</th><th>Dosage</th><th>Consumption</th><th>Duration</th><th>Quantity</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for($i = 0; $i<$countM; $i++) {
        echo '<tr>';
        echo '<td>'.($i+1).'</td>';
        echo '<td>'.$medicines[$i].'</td>';
        echo '<td>'.$dosage[$i].'</td>';
        echo '<td>'.$consumption[$i].'</td>';
        echo '<td>'.$number[$i].' '.$duration[$i].'</td>';
        echo '<td>'. calcQTY($consumption[$i], $number[$i], $duration[$i]) . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    return $tests;
}

//function to generate TESTs list if any - viewpres.php
function genTestsList($tests) {
    if(sizeof($tests) == '0') {
        echo '<b>0</b>';
    } else {
        for($i = 0; $i < sizeof($tests); $i++){
            echo $tests[$i];
            echo '<br>';
        }
    }

}

//function to print diagnosis from json array - viewpres.php
function genDiag($arr_name) {
    $file = './data/prescriptions/'.$arr_name;
    $json = file_get_contents($file);
    $arr = json_decode($json, true);
    $diag = $arr['diagnosis'];
    echo $diag;
}

//function to generate medicine list
function genMedTableStores() {
    global $conn;
    $query = "SELECT * FROM medicines";
    $result = mysqli_query($conn, $query);
    echo '<table class="table table-hover" id="datatable">';
    echo '<thead>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th><th><strong>Name</strong></th><th><strong>Salt</strong></th><th><strong>Price</strong></th><th><strong>Batch</strong></th><th><strong>Quantity</strong></th><th><strong>Expiry</strong></th>';
    echo '</tr>';
    echo '</thead>';
    while($r = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td>';
        echo $r['m_id'];
        echo '</td>';
        echo '<td>';
        echo $r['name'];
        echo '</td>';
        echo '<td>';
        echo $r['salt'];
        echo '</td>';
        echo '<td>';
        echo $r['price'];
        echo '</td>';
        echo '<td>';
        echo $r['batch'];
        echo '</td>';
        echo '<td>';
        echo $r['qty'];
        echo '</td>';
        echo '<td>';
        echo $r['exp'];
        echo '</td>';
        echo '</tr>';
    }
    echo '<tfoot>';
    echo '<tr>';
    echo '<th><strong>ID</strong></th><th><strong>Name</strong></th><th><strong>Salt</strong></th><th><strong>Price</strong></th><th><strong>Batch</strong></th><th><strong>Quantity</strong></th><th><strong>Expiry</strong></th>';
    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
}

//function to add more medicines
function ajaxAddMedicine($name, $salt, $price, $batch, $qty, $exp) {
    global $conn;
    $query = "INSERT INTO `medicines`(`name`, `salt`, `price`, `batch`, `qty`, `exp`) VALUES ('$name', '$salt', '$price', '$batch', '$qty', '$exp')";
    if(mysqli_query($conn, $query)) {
        $query = "SELECT m_id FROM medicines WHERE name = '$name'";
        $result = mysqli_query($conn, $query);
        $r = mysqli_fetch_array($result);
        $m_id = $r['m_id'];
        $file_inv = './data/inventory/inventory.json';
        $json_inv = file_get_contents($file_inv);
        $arr_inv = json_decode($json_inv, true);
        $arr_inv[$m_id] = array(
            "1","2"
        ); //Currently the new medicine is available in both stores by default
        $json_inv = json_encode($arr_inv);
        file_put_contents($file_inv, $json_inv);
        echo "Medicine added successfully";
    } else {
        echo 'ajaxAddMedicine failure';
    }
}