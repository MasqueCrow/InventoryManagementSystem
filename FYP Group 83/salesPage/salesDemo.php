<?php
include '../database/myDb.php';
include './salesDbfunctions.php';
////$c1=new CustomerInfo();
//// $cusRecord=$c1->getAllCustomer($conn);
//// $date_of_birth = substr($cusRecord['date_of_birth'], 0,10);
//// echo $date_of_birth;
//// echo '<br/>';
////$append_date_of_birth=$date_of_birth." 00:00:00"; 
//// echo $append_date_of_birth;
//// 
////DateTime
//$DT = new DateTime();
//$DT->setTimezone(new DateTimeZone('Asia/Singapore'));
//$DT->format('Y-m-d H:i:s');

//$first_name=$_POST['first_name'];
//$last_name=$_POST['last_name'];
//$gender=$_POST['gender'];
//$contact_no1=$_POST['contact_no1'];
//$contact_no2=$_POST['contact_no2'];
//$email=$_POST['email'];
//$address_line1=$_POST['address_line1'];
//$address_line2=$_POST['address_line2'];
//$address_line3=$_POST['address_line3'];
//$date_of_birth=$_POST['date_of_birth'];
//$remark=$_POST['remark'];
//
//       $query = "UPDATE customer " .
//                "SET first_name='$first_name',".
//               "last_name='$last_name',".
//                 "gender='$gender',".
//                 "contact_no1='$contact_no1',".
//                 "contact_no2='$contact_no2',".
//                 "email_address='$email',".
//                 "address_line1='$address_line1',".
//               "address_line2='$address_line2',".
//               "address_line3='$address_line3',".
//               "date_of_birth='$date_of_birth',".
//               "remark='$remark' ";
//               ' WHERE customer_id=C01';
//     mysqli_query($conn, $query) ;
//     
//
//                        if (mysqli_affected_rows($conn) > 0) {
//                            echo "record Updated";
//                        } else {
//                            echo "NO record updated.";
//                            mysqli_error($conn);
//                        }
//                        mysqli_close($conn);
//                    
////Dropdown menu
//$vc=new VehicleCategory();
//$vc->disVehicleCategory($conn);
//plate no

$vc=new VehicleCategory();
$plateno='SBA123';
echo $vc->searchPlateNo($conn, $plateno);


?>
