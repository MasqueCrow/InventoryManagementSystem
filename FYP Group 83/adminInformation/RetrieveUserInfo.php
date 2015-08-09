<?php

include '../database/myDb.php';

$username=$_REQUEST['username'];

$stmt = $conn->prepare("Select username,contact,accesslevel,name,job_role " .
        "From user " .
        "Where username=?");

$user_info_array = [];
$stmt->bind_param('s', $username);
if ($stmt->execute()) {    
    $stmt->bind_result($retrievedusername, $contact, $accesslevel, $name, $job_role); 
    $stmt->fetch();
    array_push($user_info_array, $retrievedusername, $contact, $accesslevel, $name, $job_role);

    echo json_encode($user_info_array);
}
?>