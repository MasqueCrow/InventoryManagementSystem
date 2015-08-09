<?php

include './salesDbfunctions.php';
include '../database/myDb.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$gender = $_POST['gender'];
$contact_no1 = $_POST['contact_no1'];
$contact_no2 = $_POST['contact_no2'];
$email = $_POST['email'];
$address_line1 = $_POST['address_line1'];
$address_line2 = $_POST['address_line2'];
$address_line3 = $_POST['address_line3'];
$date_of_birth = $_POST['date_of_birth']." 00:00:00";
$remark = $_POST['remark'];
 $DT=new DateTime();
$DT->setTimezone(new DateTimeZone('Asia/Singapore'));
$result=$DT->format('Y-m-d H:i:s');
$last_modified=$result;
$c1 = new CustomerInfo();
$c1->updateAllCustomerDetail($conn, $first_name, $last_name, $gender, $contact_no1, $contact_no2, $email, $address_line1, $address_line2, $address_line3, $date_of_birth, $remark,$last_modified);
?>