<?php
include '../database/myDb.php';
session_start();
$customer_id=$_SESSION['customer_id'];
$total_amt_charged=$_REQUEST['total_amt_charged'];
$gst=$_REQUEST['gst'];
$plate_no=$_SESSION['plate_no'];
$del_status=0;
//set default timezone
date_default_timezone_set('Asia/Singapore');
//Date creation format
$currentDate = date("Y-m-d H:i:s");

$stmt = $conn->prepare("INSERT INTO quotation (quotation_date,total_amt_charged,gst, del_status,customer_id,plate_no) "
                      ."VALUES (?, ?, ?, ?, ?, ?)");

//discount column  datatype in database has to change from int to double
$stmt->bind_param("sddiis",$currentDate,$total_amt_charged,$gst,$del_status,$customer_id,$plate_no);
$stmt->execute();
$stmt->close();
