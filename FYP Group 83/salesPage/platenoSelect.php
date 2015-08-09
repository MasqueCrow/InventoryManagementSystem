<!DOCTYPE html>

        <?php
 
 class Demo{
   private $plateno='';
     
     function getPlateno($plateno){
         return $plateno;
     }
     
     
 function getModel($conn,$plateno){
   //$plateno=getPlateno[$_POST['plateno']];
   
        $query = "SELECT vh.model,v.plate_no,v.category_id,vh.category_id " .
                "FROM vehicle_category vh,vehicle v ".
                "WHERE v.plate_no='$plateno' AND v.category_id=vh.category_id ";
        $result = mysqli_query($conn, $query);
       
        while ($row = mysqli_fetch_array($result)) {
            echo'<option>';
            echo $row['model'];
            echo'</option>';
        }
        
 }
 
 function getMake($conn,$plateno){
    $query = "SELECT vh.make,v.plate_no,v.category_id,vh.category_id " .
                "FROM vehicle_category vh,vehicle v ".
                "WHERE v.plate_no='$plateno' AND v.category_id=vh.category_id ";
        $result = mysqli_query($conn, $query);
       
        while ($row = mysqli_fetch_array($result)) {
            echo'<option>';
            echo $row['make'];
            echo'</option>';
        }
        
    
 }
 function getRemark($conn,$plateno){
    $query = "SELECT vh.remark,v.plate_no,v.category_id,vh.category_id " .
                "FROM vehicle_category vh,vehicle v ".
                "WHERE v.plate_no='$plateno' AND v.category_id=vh.category_id ";
        $result = mysqli_query($conn, $query);
       
        while ($row = mysqli_fetch_array($result)) {
            echo'<option>';
            echo $row['remark'];
            echo'</option>';
        }
        
    
 }
 
 }
        ?>
  
