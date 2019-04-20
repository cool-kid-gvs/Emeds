<?php
include(__DIR__ . '/includes/functions.php');
//This file does not contain any page code itself, it just calls the required file as per the requirements.
if(!logged_in()) {
    header('Location: login.php');
    exit();
}
$type = $_SESSION['type'];
if(isset($_GET['write']) && $_GET['write'] == '1'){ //Write "Attend" button is clicked i.e. Doctor wants to write a prescription
    require_once __DIR__ . '/pres.php';
    exit();
}
if($type == 'doctor') {
    require_once __DIR__ . '/doctor.php';
} elseif($type == 'patient') {
    require_once __DIR__ . '/patient.php';
} elseif($type == 'hospital') {
    require_once __DIR__ . '/hospital.php';
} elseif($type == 'store') {
    require_once __DIR__ . '/store.php';
} else {
    echo json_encode(array(
        "status" => "ERROR",
        "msg" => "type not set",
        "fix" => "Please login again",
        "contact" => "sukhatmegaurav@gmail.com"
    ));
}