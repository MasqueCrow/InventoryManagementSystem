<?php
include '../database/myDb.php';

 $service_id=$_REQUEST['service_id'];
 $stmt = $conn->prepare("Select part_no " .
        "From part p,service s " .
        "Where p.service_id=s.service_id and s.service_id=? ");
 $partnoArray=[];
$stmt->bind_param('s',$service_id);
$stmt->execute();
        $stmt->bind_result($part_no);
        
         //Fetch values
        while($stmt->fetch()){
            
            array_push($partnoArray, $part_no);
           
        }  
        
         echo json_encode($partnoArray);
  $stmt->close();

?>
