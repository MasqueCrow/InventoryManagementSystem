<?php
include '../database/myDb.php';
//$company_nameandcontact=explode('|',$_REQUEST['company_name']);
//$company_name=$company_nameandcontact[0];
$supplier_id=$_REQUEST['supplier_id'];
//Format:YYYY-MM-DD
$date_creation=explode('/',$_REQUEST['date_creation']);

//Format:HH:MM:SS
$time=date("H:i:s");

//FORMAT:YYYY:MM:DD:HH:MM:SS
$date_creation_format=$date_creation[0].'-'.$date_creation[1].'-'.$date_creation[2]." :".$time;
//echo $date_creation_format;
$po_status=$_REQUEST['po_status'];
$remark=$_REQUEST['remark'];
$order_by=$_REQUEST['order_by'];
$del_status=0;

$stmt = $conn->prepare("INSERT INTO purchase_order "
                    . "(date_of_creation,po_status,remark,del_status,"
                    . "ordered_by,supplier_id) "
                    ."VALUES (?, ?, ?, ?, ?, ?)");

//discount column  datatype in database has to change from int to double
$stmt->bind_param("sssisi",$date_creation_format,$po_status,$remark,$del_status,$order_by,$supplier_id);
$stmt->execute();
$stmt->close();
