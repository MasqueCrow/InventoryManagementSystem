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
            $response = array('valid' => false, 'message' => '<p style="color:red;"> This user name is already registered. </p>');
        } else {
            // User name is available
            $response = array('valid' => true, 'message' => '<p style="color:#14ff00;"> This user name is available. </p>');
        }
    }
}
echo json_encode($response);
?>

