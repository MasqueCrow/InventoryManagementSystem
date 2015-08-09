<?php
include '../database/myDb.php';
        $stmt = $conn->prepare("Select v.plate_no " .
        "From vehicle v,customer c " .
        "Where v.customer_id=c.customer_id ");
        
        $platenoArray=[];
        $stmt->execute();

        $stmt->bind_result($userPlateno);
        //Fetch values
        while($stmt->fetch())
            {
            array_push($platenoArray, $userPlateno);  
            }           
        echo json_encode($platenoArray);
       // $stmt->close();

?>
