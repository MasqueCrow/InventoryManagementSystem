<?php
include '../database/myDb.php';
$part_no=$_REQUEST['partNo'];
$service_name=$_REQUEST['serviceName'];

$stmt = $conn->prepare("Select service_name,part_no,part_name,part_descrp,retail_price,p.part_id,s.service_id,part_qty,stock_lvl_por " .
        "From part p,service s " .
        "Where p.service_id=s.service_id and service_name=? and part_no=? ");


$stmt->bind_param('ss',$service_name,$part_no);

 $sortRow_array=[];      
        //Fetch values
  if($stmt->execute()){
         $result = $stmt->get_result();
       $row_array = $result->fetch_array(MYSQLI_NUM);
       $sortRow_array[0]=$row_array[0]." ".$row_array[1]; //service name and part_no
       $sortRow_array[1]=$row_array[2]; //part name
       $sortRow_array[2]=$row_array[3]; //part dscrp
       $sortRow_array[3]=$row_array[4]; //retail price
       $sortRow_array[4]=$row_array[5]; //part id
       $sortRow_array[5]=$row_array[6];//service id
       $sortRow_array[6]=$row_array[7];//part qty
       $sortRow_array[7]=$row_array[8];//stock lvl por
     

   echo json_encode($sortRow_array);
  }  
$stmt->close();
?>