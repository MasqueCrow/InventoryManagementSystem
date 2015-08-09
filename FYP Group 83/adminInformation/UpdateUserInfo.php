<?php

require '../database/Mydb.php';

$name = $_POST['name'];
$contact_no = $_POST['contact_no'];
$username = $_POST['username'];
$salt = 'lianfuat';
$prevpassword = crypt($_POST['prevpassword'], $salt);
$currentpass = crypt($_POST['currentpass'], $salt);
$userid = $_POST['userid'];

$stmt = $conn->prepare('SELECT password FROM user WHERE userid=?');
$stmt->bind_param('i', $userid);
$stmt->execute();
$stmt->bind_result($retrievedpassword);
$stmt->fetch();
$stmt->close();
if ($retrievedpassword == $prevpassword) {

    $stmt = $conn->prepare(
            "UPDATE user "
            . "SET username = ?,name = ?,password = ?,contact = ? "
            . "WHERE userid= ? ");
    $stmt->bind_param('ssssi', $username, $name, $currentpass, $contact_no, $userid);
    $stmt->execute();
    $stmt->close();
} else {
    echo'password does  not match.';
}

?>
