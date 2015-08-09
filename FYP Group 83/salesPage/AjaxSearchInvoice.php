<?php

include '../database/myDb.php';

$plate_no = $_REQUEST['plateno123'];

$stmt = $conn->prepare(
        "SELECT ci.invoice_no, ci.total_amt_charged,ci.payment_status,ci.invoice_date " .
        "FROM vehicle v,customer c,vehicle_category vc, customer_invoice ci " .
        "WHERE v.customer_id=ci.customer_id AND v.plate_no= ?  AND vc.category_id=v.category_id AND ci.customer_id= c.customer_id "
);
$invoice_information = array();
$stmt->bind_param("s", $plate_no);
$stmt->execute();
$stmt->bind_result($invoiceno, $total_amt_charged, $payment_status, $date);

while($data = $stmt->fetch()){
$row_array = array();
array_push($row_array, $invoiceno);
array_push($row_array, $total_amt_charged);
array_push($row_array,$payment_status);
array_push($row_array,$date);
array_push($invoice_information,$row_array);
}



echo json_encode($invoice_information);
?>