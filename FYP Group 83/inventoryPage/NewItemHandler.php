<?php

include '../homeHeader.php';
require '../database/Mydb.php';


$supplier_id = $_POST['supplierID2'];
$part_name = $_POST['partName'];
$part_no = $_POST['partNumber'];
$brand = $_POST['brand'];
$part_descrp = $_POST['partDescription'];
$part_quantity = $_POST['partQuantity'];
$cost_price = $_POST['costPrice'];
$retail_price = $_POST['retailPrice'];
$stock_level = $_POST['stockLevel'];
$stock_status = $_POST['stockStatus'];
$remark = $_POST['remark'];

//echo"".$supplier_id, $part_name,$brand,$part_descrp,$part_quantity,$cost_price,$retail_price,$stock_level,$stock_status,$remark."";




if (!$stmt = $conn->prepare("INSERT INTO part(`part_no`, `part_name`, `brand`, `part_descrp`, `part_qty`, "
            . " `retail_price`, `remark`, `stock_lvl_por`, `stock_status` ) "
            . "VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
    echo "1st Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$stmt->bind_param("ssssidsis", $part_no, $part_name, $brand, $part_descrp, $part_quantity, $retail_price, $remark, $stock_level, $stock_status)) {
        echo "" . $last_id . "2nd Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error;
    }


if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {
    $last_id = mysqli_insert_id($conn);

    if (!$stmt2 = $conn->prepare("INSERT INTO `supplier_part`(`supplier_id`,`part_id`, `cost_price`) "
        . "VALUES (?,? ,?)")) {
        echo "2nd Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
  if (!$stmt2->bind_param("isi", $supplier_id, $last_id, $cost_price)) {
    echo "1st Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

    if (!$stmt2->execute()) {
        echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
    }

     ?>
<script>
    alert("Item Created!");
  window.location = "inventoryNewSupplierItem.php";
    </script>
    <?php
}

$stmt->close();