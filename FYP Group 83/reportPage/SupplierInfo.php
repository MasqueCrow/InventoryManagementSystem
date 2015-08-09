<?php
include '../database/myDb.php';

$supplier_id=$_REQUEST['supplier_id'];

$stmt = $conn->prepare(
          "SELECT company_name,office_contact "
        . " FROM supplier "
        . "WHERE supplier_id=?"
                    );
    

$stmt->bind_param('i',$supplier_id);
/* Execute it */
$stmt->execute();
$stmt->bind_result($company_name, $office_contact);



if ($row = $stmt->fetch()) {
    
  $joinvar=$company_name . " | " . $office_contact;  

          
    }
    
 echo json_encode($joinvar);
$conn->close();
?>
