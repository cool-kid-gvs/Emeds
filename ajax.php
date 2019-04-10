<?php
include(__DIR__ . '/includes/functions.php');
//This file will serve as the ajax execution entry point.
//trigger for addMed=1
if(isset($_GET['ajaxAddMed']) || $_GET['ajaxAddMed'] == '1') {
    $data = $_POST;
    $name = $data['name'];
    $salt = $data['salt'];
    $price = $data['price'];
    $batch = $data['batch'];
    $qty = $data['qty'];
    $exp = $data['exp'];
    ajaxAddMedicine($name, $salt, $price, $batch, $qty, $exp);
}