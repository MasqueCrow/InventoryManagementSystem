<?php
require '../database/Mydb.php';
?>
<?php
if (!$stmt = $conn->prepare("SELECT `supplier_id`, `first_name`, `last_name`, `office_contact`, "
        . "`hp_contact`, `fax_contact`, `company_name`, `address_line1`, `address_line2`, "
        . "`address_line3`, `remark` FROM `supplier` WHERE `company_name` =?")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

$q = ($_GET['q']);
if (!$stmt->bind_param("s", $q)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

/* Execute it */
$stmt->execute();

$stmt->bind_result($supplier_id, $first_name, $last_name, $office_contact, $hp_contact, $fax_contact, $company_name, $address_line1, $address_line2, $address_line3, $remark);
$stmt->fetch();
?>

<h2> Supplier Information </h2>  

<form class="form-horizontal" name="updateForm" onsubmit="return validateUpdateForm()" role="form" action="SupplierUpdateHandler.php"  method="POST">


    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">Supplier ID</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="supplierID" value="<?php echo $supplier_id; ?>" readOnly="true">
        </div></div>


    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">First Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" name="update_firstName" value="<?php echo $first_name; ?>" placeholder="First Name">
        </div>
    </div>



    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">Last Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control"  name="update_lastName" value="<?php echo $last_name; ?>" placeholder="Last Name">
        </div>
    </div>

    <div class="form-group">
        <label for="carMake" class="col-sm-3 control-label">Office contact </label>
        <div class="col-sm-7">
            <input type="text" class="form-control"  name="update_officeContact" value="<?php echo $office_contact; ?>" placeholder="Office">
        </div>
    </div>

    <div class="form-group">
        <label for="carMake" class="col-sm-3 control-label">Hp contact </label>
        <div class="col-sm-7">
            <input type="text" class="form-control"  name="update_hpContact" value="<?php echo $hp_contact; ?>" placeholder="Handphone">
        </div>
    </div>
    <div class="form-group">
        <label for="carMake" class="col-sm-3 control-label">Fax contact </label>
        <div class="col-sm-7">
            <input type="text" class="form-control"  name="update_faxContact" value="<?php echo $fax_contact; ?>" placeholder="Fax contact">

        </div>
    </div>
    <div class="form-group">
        <label for="carMake" class="col-sm-3 control-label">Address</label>
        <div class="col-sm-7" >
            <input type="text" class="form-control"  name="update_streetNumber" value="<?php echo $address_line1; ?>" placeholder="Street name" style="margin-bottom: 5px">
            <input type="text" class="form-control"  name="update_blockUnitNumber" value="<?php echo $address_line2; ?>" placeholder="Block Number | Unit Number" style="margin-bottom: 5px"> 
            <input type="text" class="form-control"  name="update_postalCode" value="<?php echo $address_line3; ?>" placeholder="Postal Code" style="margin-bottom: 5px"> 

        </div>
    </div>
    <div class="form-group">
        <label for="carMake" class="col-sm-3 control-label">Company Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control"  name="update_companyName" value="<?php echo $company_name; ?>" placeholder="Company Name">
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-3 control-label">Remark</label>
        <div class = "col-sm-7">
            <textarea class="form-control"  name="update_remark" rows="3"><?php echo $remark; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" name="update"value="Update"class="btn btn-success" style=" margin:0 0 10px 80px ; padding: 5px 25px 5px 25px; "></a>


            <input type="submit" name="delete"value="Delete" class="btn btn-danger" style="margin:0 0 10px  ; padding: 5px 25px 5px 25px; ">


        </div>
    </div>

</form>









</div>

<?php
$stmt->close();
