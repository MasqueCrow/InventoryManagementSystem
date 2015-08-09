<?php


include '../database/myDb.php';

$cusID = str_replace("'", "''", $_POST['cusID']); //Closing single quote  sql injection

$stmt = $conn->prepare(
        "Select * " .
        "From customer " .
        "Where customer_id=?");
$stmt->bind_param('s', $cusID);
if ($stmt->execute()) {     //check if the preprare statement is executed
    $stmt->bind_result($col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11, $col12, $col13, $col14, $col15, $col16); //bind variables to prepared statement
    if ($stmt->fetch()) { //Fetch values from prepare statement
        $customerDetails=[];
        array_push($customerDetails,true,$col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $col11,$col15);
        echo json_encode($customerDetails);
    } else {
        $message = 'Please Update Customer Details.';
        $messageInfo2 = [false, '#14ff00', $message];
        echo json_encode($messageInfo2);
    }
}
?>