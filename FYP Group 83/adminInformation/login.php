<?php
include '../database/myDb.php';
$response = array(
    'valid' => false,
    'message' => 'Post argument "user" is missing.'
);
//echo $_POST['user'];
if (isset($_POST['user'])) {
  
    $query = 'Select userid ' .
            'From user ';

    $result = mysqli_query($conn, $query);
    if($result == false){
        echo "ERROR IN MYSQL";
        die(mysql_error());
    }
    while ($row = mysqli_fetch_array($result)) {
        if ($row['userid'] == $_POST['user']) {
            // User name is registered on another account
            $response = array('valid' => false, 'message' => 'This user name is already registered.');
        } else {
            // User name is available
            $response = array('valid' => true);
        }
    }
}
echo json_encode($response);
?>

