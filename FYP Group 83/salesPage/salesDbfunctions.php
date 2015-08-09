<?php

class CustomerInfo {

    function setFirstName() {
        
    }

    function setLastName() {
        
    }

    function setContactNo1() {
        
    }

    function setContactNo2() {
        
    }

    function setEmailAddress() {
        
    }

    function setDateOfBirth() {
        
    }

    function setAddressLine1() {
        
    }

    function setAddressLine2() {
        
    }

    function setAddressLine3() {
        
    }

    function setGender() {
        
    }

    function setRemark() {
        
    }

    function delCustomer() {
        
    }

    function insertCustomer() {
        
    }

    function getAllExistingCustomerDetail($conn,$plateno) {
        $stmt = $conn->prepare(
                "Select first_name,last_name,contact_no1,contact_no2,email_address,gender,address_line1," .
                        "address_line2,address_line3,date_of_birth,date_of_creation,last_modified,remark ".
                "From customer c,vehicle v " .
                "Where plate_no=? AND c.customer_id=v.customer_id");
        
        $stmt->bind_param('s',$plateno);       
        if($stmt->execute()){
         $result = $stmt->get_result();
       $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
        }
 
    }

//rmb to update last_modified
    function updateAllCustomerDetail($conn, $first_name, $last_name, $gender, $contact_no1, $contact_no2, $email, $address_line1, $address_line2, $address_line3, $date_of_birth, $remark, $last_modified) {
        $query ="UPDATE customer " .
                "SET first_name='$first_name'," .
                    "last_name='$last_name'," .
                    "gender='$gender'," .
                    "contact_no1='$contact_no1'," .
                    "contact_no2='$contact_no2'," .
                    "email_address='$email'," .
                    "address_line1='$address_line1'," .
                    "address_line2='$address_line2'," .
                    "address_line3='$address_line3'," .
                    "date_of_birth='$date_of_birth'," .
                    "remark='$remark', " .
                    "last_modified='$last_modified' ";
               "WHERE customer_id=C01";
        mysqli_query($conn, $query);


        if (mysqli_affected_rows($conn) > 0) {
            echo "record Updated";
            header("Location:salesExistingCus.php");
        } else {
            echo "NO record updated.";
            mysqli_error($conn);
        }
        mysqli_close($conn);
    }

}

class VehicleCategory {

    //private $plateno='';



    function setModel() {
        
    }

    function setMake() {
        
    }
    function getPlateNo2($conn){
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
          //  $stmt->close();
         return $platenoArray;   
        
        
    }
    function getPlateNo($conn, $plateno) {
         $plateno = str_replace(' ', '', $plateno); //remove spaces
        $stmt = $conn->prepare(
        "Select plate_no " .
        "From vehicle_category vh,vehicle v " .
        "Where v.plate_no=? ".
        "AND v.category_id=vh.category_id ");
        
        $stmt->bind_param('s', $plateno);
        $stmt->execute();
        $stmt->bind_result($userPlateno);
        $stmt->fetch();
        return $userPlateno;
    }

    function disModel($conn, $plateno) {
        $plateno = str_replace(' ', '', $plateno); //remove spaces
        $stmt = $conn->prepare(
        "Select  vh.model " .
        "From vehicle_category vh,vehicle v " .
        "Where v.plate_no=? ".
        "AND v.category_id=vh.category_id ");
         
        $stmt->bind_param('s',$plateno);
        $stmt->execute();
        $stmt->bind_result($car_model);
        $stmt->fetch();
        return $car_model;
    }

    function disMake($conn, $plateno) {
        $plateno = str_replace(' ', '', $plateno); //remove spaces
        $stmt = $conn->prepare(
        "Select  vh.make " .
        "From vehicle_category vh,vehicle v " .
        "Where v.plate_no=? ".
        "AND v.category_id=vh.category_id ");
        
         $stmt->bind_param('s',$plateno);
         $stmt->execute();
         $stmt->bind_result($car_make);
         $stmt->fetch();
         return $car_make;
          
    
    }

    function disRemark($conn, $plateno) {
        $plateno = str_replace(' ', '', $plateno); //remove spaces
        $stmt = $conn->prepare(
        "Select  vh.remark " .
        "From vehicle_category vh,vehicle v " .
        "Where v.plate_no=? ".
        "AND v.category_id=vh.category_id ");
        
        $stmt->bind_param('s',$plateno);
        $stmt->execute();
        $stmt->bind_result($car_remark);
        $stmt->fetch();
        return $car_remark;
        
    }
    function delVehicleCategory() {
        
    }

}

class Service{
    
    function getService($conn)
    {
         $stmt = $conn->prepare("Select service_name,service_id " .
        "From service");
        $stmt->execute();
        $stmt->bind_result($servicename,$service_id);
        
        //Fetch values
        while($stmt->fetch())
        {
            echo '<option value="'.$service_id.'">' .$servicename.'</option>';
        }
       
    }
    function getServicewithPartCode($conn)
    {
        $stmt = $conn->prepare("Select s.service_name,p.part_no " .
        "From part p,service s " .
        "Where p.service_id=s.service_id");
         $stmt->execute();
        $stmt->bind_result($servicename,$part_no);
        
        //Fetch values
        while($stmt->fetch())
        {
            echo '<option>' .$servicename." ".$part_no.'</option>';
           
        }
    }
    
    
}
