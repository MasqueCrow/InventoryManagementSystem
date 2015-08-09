<?php

include '../homeHeader.php';


$supplier_id = $_SESSION['supplier_id'];
$companyName = $_SESSION['companyName'];
$doc = $_SESSION['date_of_creation'];
$po_status = $_SESSION['po_status'];
$ordered_by = $_SESSION['order_by'];
$remark = $_SESSION['remark'];

//
//echo"" . $supplier_id, $doc, $po_status, $ordered_by, $remark, $companyName . "";
//echo "<Br>";

if (!$stmt = $conn->prepare("INSERT INTO `purchase_order`(`supplier_id`, `date_of_creation`, `date_of_issue`, `po_status`, `remark`,`ordered_by`) "
        . "VALUES (?, ?,?,?,?,?)")) {
    echo "1st Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

//echo"hello";

$t = time();
$time = date("Y-m-d H:i:s");

if (!$stmt->bind_param("isssss", $supplier_id, $doc, $time, $po_status, $remark, $ordered_by)) {
    echo "1st Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
//echo"hello2";

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {
//echo"hello4";
    
    $last_id = mysqli_insert_id($conn);
    $count = 1;
  foreach($_POST['part_no'] as $cnt => $qty) {

   
        if (!$stmt = $conn->prepare("SELECT  part.part_id, supplier_part.cost_price FROM part INNER JOIN supplier_part ON supplier_part.part_id =part.part_id "
                . "WHERE part.part_no=?")) {
            echo "Prepare failed: 1 (" . $mysqli->errno . ") " . $mysqli->error;
        }
     

        if (!$stmt->bind_param("s", $qty)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        // Execute it /
        $stmt->execute();
        $stmt->bind_result($part_id, $cost_price);
        $stmt->fetch();
        $stmt->close();

        //echo "count ".$count," last id ". $last_id, " part name ". $qty," part quantity ". $_POST['part_quantity'][$cnt]," cost price ". $cost_price;
        
        if (!$stmt2 = $conn->prepare("INSERT INTO po_item(`po_item_no`,`po_no`,`part_no`, `part_order_qty`, `cost_price_chrged`) VALUES (?,?, ?, ?, ?)")) {
            echo "2nd Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        
        
        if (!$stmt2->bind_param("issid", $count, $last_id,  $qty, $_POST['part_quantity'][$cnt], $cost_price)) {
            echo "2nd Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error;
        }

     // echo $stmt2->bind_param;
        
        if (!$stmt2->execute()) {
            echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
        }
        
       
        $count++;
    }
         ?>
<script>
    alert("Purchase Order Created!");
  window.location = "inventoryPO.php";
    </script>
    <?php
}

$stmt2->close();
//session_destroy();