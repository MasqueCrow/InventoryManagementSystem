<?php


include '../database/myDb.php';

$plateNo = str_replace("'", "''", $_POST['plateNo']); //Closing single quote  sql injection

$stmt = $conn->prepare(
        "Select vehicle.plate_no, vehicle.customer_id, vehicle_category.make, vehicle_category.model, vehicle_category.remark " .
        "From vehicle INNER JOIN vehicle_category ON vehicle.category_id = vehicle_category.category_id " .
        "Where vehicle.plate_no=?");
$stmt->bind_param('s', $plateNo);
if ($stmt->execute()) {     //check if the preprare statement is executed
    $stmt->bind_result($retrievePlateNo, $retrieveCustomer, $retrieveMake, $retrieveModel, $retrieveRemark); //bind variables to prepared statement
    if ($stmt->fetch()) { //Fetch values from prepare statement 
        $message = $retrievePlateNo . ' is already registered.';
        $messageInfo1 = [true,'red', $message, $retrievePlateNo, $retrieveMake, $retrieveModel, $retrieveRemark, $retrieveCustomer];
        echo json_encode($messageInfo1);
    } else {
        $message = 'New Customer';
        $messageInfo2 = [false,'green', $message];
        echo json_encode($messageInfo2);
    }
}
?>