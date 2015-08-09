<?php
include '../database/myDb.php';

$stmt = $conn->prepare
        (
        "SELECT s.supplier_id,s.first_name,s.last_name,p.part_name,p.part_no,p.part_qty,cps.cost_price,p.stock_lvl_por,vc.make,vc.model ".     
        "FROM part p,vehicle_category vc,supplier s,category_part_supplier cps ".
        "WHERE p.part_id=cps.part_id AND vc.category_id=cps.category_id AND s.supplier_id=cps.supplier_id  "
        );

    $stmt->execute();
    //Initialize an empty array
    $supplier_part_info=array();
    /* instead of bind_result: */
    $result = $stmt->get_result();
    
    /* now you can fetch the results into an array  */
    while ($myrow = $result->fetch_assoc()) 
    {
        array_push($supplier_part_info, $myrow);
    }
echo json_encode($supplier_part_info);
 $stmt->close();



 ?>