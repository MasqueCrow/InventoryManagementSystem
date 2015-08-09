
<?php
require '../database/myDb.php';
$paymentunpaid = "unpaid";
$payment_status = "paid";
$paymentmode = $_POST['paymentmode'];
$referenceno = $_POST['referenceno'];
$receivedby = $_POST['recievedby'];

if (!$stmt = $conn->prepare("UPDATE customer_invoice SET `payment_status` = ?,`payment_mode` = ?,`reference_no` = ?,`received_by` = ?  WHERE `payment_status` = ?")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("ssiss", $payment_status, $paymentmode, $referenceno, $receivedby, $paymentunpaid)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {
    echo'success';
}

//echo $paymentmode, $referenceno, $receivedby;
//if (!$stmt = $conn->prepare(")) {
//    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
//}
//
//if (!$stmt->bind_param("ssiss", $payment_status,$paymentmode,$referenceno,$receivedby,$paymentunpaid)) {
//    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
//}
//
//if (!$stmt->execute()) {
//    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
//}
//echo $paymentmode, $referenceno, $receivedby;
?> 
<!--<script>
    alert("Status Updated");
</script>-->


