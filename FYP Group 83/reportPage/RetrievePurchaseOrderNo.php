<?php

include '../database/myDb.php';


 $stmt = $conn->prepare("Select po_no " .
        "From purchase_order " .
        "Order by po_no DESC ".
        "Limit 1");
 
 $stmt->execute();
 $stmt->bind_result($po_no);
 $stmt->fetch();

 echo json_encode($po_no);
 $stmt->close();
        