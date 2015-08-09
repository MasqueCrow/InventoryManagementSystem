<?php

include '../homeHeader.php';
require '../database/Mydb.php';


$po_no = $_POST['po_no'];
$po_status = $_POST['po_status'];
$remark = $_POST['remark'];

if ($po_status == "Paid") {
    if (!$stmt = $conn->prepare("UPDATE `purchase_order` SET `po_status` = ?, `remark` = ? WHERE `po_no` = ?")) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("ssi", $po_status,$remark, $po_no)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {

        $stmt->close();
        ?>
        <script>
            alert("Update Status Success!");
            window.location = "inventoryPOupdate.php";
        </script>
        <?php

    }
} else {
     if (!$stmt = $conn->prepare("UPDATE `purchase_order` SET `po_status` = ?, `remark` = ? WHERE `po_no` = ?")) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    if (!$stmt->bind_param("ssi", $po_status,$remark, $po_no)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {

        $stmt->close();
    } if (!$stmt = $conn->prepare("SELECT po_item.part_order_qty, po_item.part_no, part.part_qty FROM po_item INNER JOIN part ON po_item.part_no=part.part_no WHERE po_item.po_no=?")) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
//      
    if (!$stmt->bind_param("i", $po_no)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    $stmt->execute();
    $stmt->bind_result($part_order_qty, $part_no, $part_qty);

    while ($row = $stmt->fetch()) {

        $part_order[] = $part_order_qty;
        $exisit_part_qtyp[] = $part_qty;
        $partno[] = $part_no;
        //echo " " . $part_order_qty . " " . $part_no . " " . $part_qty . "";
    }
    $stmt->close();
    for ($i = 0; $i < count($part_order); $i++) {
//  echo " ".$part_order[$i] + $exisit_part_qtyp[$i] . " ";
//  
        $sums[$i] = $part_order[$i] + $exisit_part_qtyp[$i];
        // echo $sums[$i] . " ";

        if (!$stmt = $conn->prepare("UPDATE `part` SET `part_qty` = ?, `stock_status` = 'Sufficient' WHERE `part_no` = ?")) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        if (!$stmt->bind_param("is", $sums[$i], $partno[$i])) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 
    }
     ?>
            <script>
                alert("Good Recieve and Update Success!");
                window.location = "inventoryPOupdate.php";
            </script>
            <?php
}