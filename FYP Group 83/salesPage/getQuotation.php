<?php

session_start();
$plate_no = $_SESSION['plate_no'];

include '../database/myDb.php';


$plate_no = str_replace("'", "''", $plate_no); //Closing single quote  sql injection
$stmt = $conn->prepare("Select quotation_no " .
        "From quotation " .
        "Where plate_no=?");

$stmt->bind_param('s', $plate_no);
if ($stmt->execute()) {     //check if the preprare statement is executed
    $stack = array("-----");
    $stmt->bind_result($quotationpresence); //bind variables to prepared statement
    while ($stmt->fetch()) { //Fetch values from prepare statement 
        array_push($stack, $quotationpresence);
    }
    echo json_encode($stack);
} else {
    echo "<script>alert('Database Error')</script>";
}
?>