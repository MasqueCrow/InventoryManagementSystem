<?php

include '../database/myDb.php';


 $stmt = $conn->prepare("Select quotation_no " .
        "From quotation " .
        "Order by quotation_no DESC ".
        "Limit 1");
 
 $stmt->execute();
 $stmt->bind_result($quotation_no);
 $stmt->fetch();
 $_SESSION['quotation_no']=$quotation_no; //store quotation_no in session
 echo json_encode($quotation_no);
 $stmt->close();
        