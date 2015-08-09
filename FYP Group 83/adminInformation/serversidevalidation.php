<?php

//$username = $_POST['username'];
include '../database/myDb.php';

$username = str_replace("'", "''", $_POST['username']); //Closing single quote  sql injection

$stmt = $conn->prepare(
        "Select username " .
        "From user " .
        "Where username=?");
$stmt->bind_param('s', $username);
if ($stmt->execute()) {     //check if the preprare statement is executed
    $stmt->bind_result($retrievedusername); //bind variables to prepared statement
    if ($stmt->fetch()) { //Fetch values from prepare statement 
        $message = $retrievedusername . ' is not available.';
        $messageInfo1 = [$message, 'red'];
        echo json_encode($messageInfo1);
    } else {
        $message = 'Username is available.';
        $messageInfo2 = [$message, '#14ff00'];
        echo json_encode($messageInfo2);
    }
}
?>