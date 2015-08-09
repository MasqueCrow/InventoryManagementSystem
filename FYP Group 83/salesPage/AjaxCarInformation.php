<?php

include '../database/myDb.php';

$plate_no = $_REQUEST['plateno'];

$stmt = $conn->prepare(
        "SELECT v.plate_no, vc.model,vc.make,vc.remark,c.customer_id " .
        "FROM vehicle v,customer c,vehicle_category vc " .
        "WHERE v.customer_id=c.customer_id AND v.plate_no= ?  AND vc.category_id=v.category_id "
);

$car_information = array();
$stmt->bind_param("s", $plate_no);
$stmt->execute();
$stmt->bind_result($car_plateno, $car_model, $car_make, $car_remark,$customer_id);
$stmt->fetch();

array_push($car_information, $car_plateno);
array_push($car_information, $car_model);
array_push($car_information, $car_make);
array_push($car_information, $car_remark);
session_start();
$_SESSION['customer_id']=$customer_id;
$_SESSION['plate_no']=$car_plateno;
$_SESSION['model']=$car_model;
$_SESSION['remark']=$car_remark;
echo json_encode($car_information);
?>