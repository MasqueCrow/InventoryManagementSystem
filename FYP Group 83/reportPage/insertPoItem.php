<?php
include '../database/myDb.php';

$purchase_order_no=$_REQUEST['purchase_order_no'];
$part_no=$_REQUEST['part_no'];
$line_total=$_REQUEST['line_total'];
$purchase_qty=$_REQUEST['purchase_qty'];
$po_item_no=$_REQUEST['po_item_no'];
$del_status=0;

//$purchase_order_no=1;
//        $part_no='abc';
//        $line_total=30.21;
//        $purchase_qty=12;
//        $po_item_no=2;
//        $del_status=0;

$stmt = $conn->prepare("INSERT INTO po_item (po_no,po_item_no,part_order_qty,"
                       . "cost_price_chrged,part_no,del_status) "
                      ."VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("iiidsi",$purchase_order_no,$po_item_no,$purchase_qty,
                   $line_total,$part_no,$del_status);
$stmt->execute();
$stmt->close();