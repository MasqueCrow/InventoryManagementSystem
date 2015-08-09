<?php 
include '../homeHeader.php'; 
include '../database/myDb.php';
 include './salesDbfunctions.php';
?>
<?php //session_start(); ?>
<?php
$c1=new CustomerInfo();
$plate_no= $_SESSION['plate_no']; 
$cusRecord=$c1->getAllExistingCustomerDetail($conn,$plate_no);
$first_name=$cusRecord['first_name'];
$last_name=$cusRecord['last_name'];
$gender=$cusRecord['gender'];
$contact_no1=$cusRecord['contact_no1'];
$contact_no2=$cusRecord['contact_no2'];
$email=$cusRecord['email_address'];
$address_line1=$cusRecord['address_line1'];
$address_line2=$cusRecord['address_line2'];
$address_line3=$cusRecord['address_line3'];
$date_of_birth = substr($cusRecord['date_of_birth'], 0,10);
$remark=$cusRecord['remark'];
?>
<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css"> 

<ol class="breadcrumb">
     <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="#">Sales</a></li>
    <li><a href="salesPage.php">Car Information</a></li>
    <li class="active">Existing Customer</li>
</ol>

<div class="salesInvoice">

    <div class="salesExistCus">
        <form class="form-horizontal" role="form" method='post' action='salesCallObject.php'>
        <h2>  Customer Information </h2>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name='first_name' value="<?php echo $first_name?>">
            </div>
        </div>
         <div class="form-group">
             <label for="inputPassword3" class="col-sm-4 control-label" >Last Name</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name='last_name'  value="<?php echo $last_name ?> ">
            </div>
        </div>
            <div class="form-group">
            <label for="gender" class="col-sm-4 control-label">Gender</label> 
            <div class="col-sm-7" style='margin-top:7px;'>
                <?php
                if($gender=='M'){
                 echo "<input type='radio' name='gender' value='M' checked>Male"; 
                  echo"<input type='radio' name='gender' value='F'>Female";
                }else{
                     echo"<input type='radio' name='gender' value='M'>Male";
                    echo" <input type='radio' name='gender' value='F checked'>Female";
                   
                }
                ?>
               
            </div>
        </div>
       
        <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Contact No. 1 </label>
            <div class="col-sm-7">
                 <input type="text" class="form-control" value="<?php echo $contact_no1?>"name='contact_no1' placeholder="contact number 1">
            </div>
        </div>
            <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Contact No. 2 </label>
            <div class="col-sm-7">
                 <input type="text" class="form-control" id="carNumber" value="<?php echo $contact_no2?>"  name='contact_no2' placeholder="contact number 2">
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Email </label>
            <div class="col-sm-7">
                 <input type="text" class="form-control"   value="<?php echo $email?>" name='email' id="carNumber" placeholder="Email">
            </div>
        </div>
         <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Address</label>
            <div class="col-sm-7" >
                 <input type="text" class="form-control"  value="<?php echo $address_line1?>" name='address_line1' placeholder="Street name" style="margin-bottom: 5px">
                  <input type="text" class="form-control" value="<?php echo $address_line2?>" name='address_line2' placeholder="Block Number | Unit Number" style="margin-bottom: 5px"> 
                   <input type="text" class="form-control" value="<?php echo $address_line3?>" name='address_line3' placeholder="Postal Code">
            </div>
        </div>
      <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">D.O.B</label>
            <div class="col-sm-7">
                 <input type="text" class="form-control"value="<?php echo $date_of_birth?>" name='date_of_birth' placeholder="YYYY-MM-DD">
                 
            </div>
        </div>
    
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-4 control-label">Remark</label>
            <div class = "col-sm-7">
                <textarea class="form-control" name='remark'rows="3" cols="50"><?php echo $remark ?></textarea>
            </div>
        </div>
            <div class="form-group">
                <div class="col-sm-2 control-label">
                    <button type="submit" class="btn btn-default" style="margin-left: 140px;margin-top:10px; padding: 5px 75px 5px 75px;">Update</button>
                </div>
            </div>
        </form> 
    </div>

    <div class="salesTransaction">

        <div class="quotation">
        
        <h2> Quotation </h2>


 <div class="col-sm-7"  style=" margin:18px 0px 0px 0px; padding: 0px; ">
                <select class="form-control" placeholder="Select a past transaction">
                    <option> Qn147890</option>
                    <option> Qn165490</option>
                </select>
            </div>
                

          
            <div class="salesButton" style="float:right; position:relative; margin-right: 19.5%; margin-top:18px;">
                <button type="submit" class="btn btn-default" style="background-color:Black; color:white; padding: 5px 20px 5px 20px;">GO</button>
<!--                <button type="submit" class="btn btn-danger" style=" padding: 5px 30px 5px 30px; margin-top: 23px; margin-left:15px;">NEW</button>-->
                <a href="salesJobSheet.php" type="submit" class="btn btn-danger"  style=" padding: 5px 20px 5px 20px;  margin-left:10px;">NEW</a>
            </div>

        </div>
        
    
         <h2 class="col-sm-8" style=" padding:0px;   "> Past Invoice </h2>
 <div class="col-sm-7"  style=" margin:13px 0px 0px 0px; padding: 0px; ">
                <select class="form-control" placeholder="Select a past transaction">
<!--                    <option>27-03-2014 | Qn147890</option>
                    <option>24-02-2014 | Qn154890</option>-->
                </select>
            </div>

            <div class="salesButton" style="float:right; position:relative; margin-right: 19.5%;margin-top:15px;">
                <button type="submit" class="btn btn-default" style="background-color:Black; color:white; padding: 5px 20px 5px 20px;">GO</button>
<!--                <button type="submit" class="btn btn-danger" style=" padding: 5px 30px 5px 30px; margin-top: 23px; margin-left:15px;">NEW</button>-->
                <a href="salesJobSheet.php" type="submit" class="btn btn-danger"  style=" padding: 5px 20px 5px 20px;  margin-left:10px;">NEW</a>
            </div>

        </div>
        </div>



    </div>

</div> 


<?php

include '../homeFooter.php';
