<?php

include '../homeHeader.php';
require '../database/Mydb.php';

$plateNo = $_POST['plateNo'];
$carMake = $_POST['carMake'];
$carModel = $_POST['carModel'];
$carRemark = $_POST['carRemark'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$contact1 = $_POST['contact1'];
$contact2 = $_POST['contact2'];
$email = $_POST['email'];
$add1 = $_POST['add1'];
$add2 = $_POST['add2'];
$add3 = $_POST['add3'];
$dob = $_POST['dob'];
$cusRemark = $_POST['cusRemark'];





if (!$stmt = $conn->prepare("INSERT INTO `customer`("
        . "`first_name`, `last_name`, `contact_no1`, `contact_no2`, `email_address`,"
        . "`address_line1`,`address_line2`,`address_line3`,`date_of_birth`,`date_of_creation`,"
        . "`last_modified`,`remark`) "
        . "VALUES (?,?,?,?,?,"
        .         "?,?,?,?,?,"
        .          "?,?)")) {
    echo "1st Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$t = time();
$time = date("Y-m-d H:i:s");

$stmt->bind_param("ssiis"
        . "sssss"
        . "ss", 
        $firstname, $lastname, $contact1, $contact2, $email,
        $add1, $add2, $add3, $dob, $time,
        $time, $cusRemark);



if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {

    
    $last_id = mysqli_insert_id($conn);
	
	if (!$stmt2 = $conn->prepare("INSERT INTO vehicle_category("
                . "`model`,`make`,`remark`) VALUES (?, ?, ?)")) {
            echo "2nd Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
        
        if (!$stmt2->bind_param("sss", 
                $carModel, $carMake, $carRemark)) {
            echo "2nd Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error;
        }
        
        if (!$stmt2->execute()) {
            echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
        }
		
       $last_id2 = mysqli_insert_id($conn);
            if (!$stmt3 = $conn->prepare("INSERT INTO vehicle(`plate_no`,`customer_id`,`category_id`) VALUES (?,?, ?)")) {
            echo "3rd Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			
			if (!$stmt3->bind_param("sii", $plateNo, $last_id, $last_id2)) {
				echo "3rd Binding parameters failed: (" . $stmt3->errno . ") " . $stmt3->error;
			}
		 // echo $stmt2->bind_param;
			
			if (!$stmt3->execute()) {
				echo "Execute failed: (" . $stmt3->errno . ") " . $stmt3->error;
			}else{
                            $message='Customer Created';
                            json_encode($message);
                        }	
			
?>
<!--    <script>
        alert("Customer Created");
        window.location = "deliveryPage.php";
    </script>-->
<?php



}

$stmt->close();
$stmt2->close();
$stmt3->close();