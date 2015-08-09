<?php

include '../database/myDb.php';


$username = $_POST['username'];
$salt = 'lianfuat';
$password = crypt($_POST['password'], $salt);
$name = $_POST['name'];
$contact = $_POST['contact'];
$accesslevel = $_POST['accesslevel'];
$job_role=$_POST['job_role'];


//set default timezone
date_default_timezone_set('Asia/Singapore');
//Date creation format
$currentDate = date("Y-m-d H:i:s");
$stmt = $conn->prepare("INSERT INTO user " .
        "(username, password, name, contact, accesslevel, dateofcreation,job_role) " .
        "VALUES" .
        "(?,?,?,?,?,?,? )");
$stmt->bind_param("sssssss", $username, $password, $name, $contact, $accesslevel, $currentDate,$job_role);
if ($stmt->execute()) {
   $message='User Account Created!';
    echo json_encode($message);
} else {
    return "<script>alert('Database Error')</script>";
}

?>

