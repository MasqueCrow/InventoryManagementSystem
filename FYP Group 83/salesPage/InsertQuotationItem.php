<?php
include '../database/myDb.php';
$qty=$_REQUEST['qty'];
$price_charged=$_REQUEST['price_charged'];
$part_id=$_REQUEST['part_id'];
$part_no=$_REQUEST['part_no'];
$service_id=$_REQUEST['service_id'];
$service_name=$_REQUEST['service_name'];
$item_no=$_REQUEST['item_no'];
$del_status=0;
$quotation_no=$_REQUEST['quotation_no'];
$stmt = $conn->prepare("INSERT INTO quotation_item (service_id,service_name,part_id,part_no,price_charged,del_status,item_no,quotation_no,qty) "
                      ."VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("isisdiiii",$service_id,$service_name,$part_id,$part_no,$price_charged,$del_status,$item_no,$quotation_no,$qty);
$stmt->execute();
$stmt->close();