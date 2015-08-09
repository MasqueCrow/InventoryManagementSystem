<?php
include '../homeHeader.php';
require '../database/Mydb.php';
?>

<script>
    function validateForm() {

        $company_name = document.myForm.companyName.value;
        $order_by = document.myForm.order_by.value;
        var alphaExp = /^[a-zA-Z\séåü]+$/;

        if ($company_name == "-1")
        {
            alert("Please select a company");
            return false;
        }
        if ($order_by == "") {
            alert("Please Enter First Name");
            return false;
        } else

        if (!($order_by.match(alphaExp))) {
            alert("Please do not enter number for Name");
            return false;
        }

    }
</script>
<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="inventoryPO.php">Inventory</a></li>
    <li class="active">New Purchase Order</li>
</ol>


<div class="inventoryPo">
    <div class="inventoryPo">
        <div class="poMenu">
            <h2>  Select </h2>
            <a href="inventoryNewSupplierItem.php" button type="button" class="col-sm-10 btn btn-primary" style=" padding: 10px 0 10px 0;">New Supplier Item</a>
            <a href="inventorySupplier.php" button type="button" class="col-sm-10 btn btn-warning" style=" padding: 10px 0 10px 10;">Supplier creation and view</a>
            <a href="inventoryPO.php"button type="button" class="col-sm-10 btn btn-default" style=" padding: 10px 0 10px 0;">New Purchase Order</a>
            <h2> Manage Purchase Order </h2>
            <a href="inventoryPOupdate.php"button type="button" class="col-sm-10 btn btn-info"  style=" padding: 10px 0 10px 0;">A/P Payment</a>
        </div></div></div>


<div class="poTransaction">
    <form class="form-horizontal" name="myForm" role="form" action="POHandler.php" onsubmit="return validateForm()" method="POST">

        <h2>  New Purchase Order </h2>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-4 control-label">Company Name | Contact</label>
            <div class="col-sm-6"   >

                <select class="form-control" name="companyName" placeholder="Purchase Order Number" >
                    <?php
                    if (!$stmt = $conn->prepare("SELECT supplier_id, company_name, office_contact FROM supplier")) {
                        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                    }
                    /* Execute it */
                    $stmt->execute();
                    $stmt->bind_result($supplier_id, $company_name, $office_contact);
                    // output data of each row
                    ?>
                    <option value="-1">Select A Company</option> 
                    <?php
                    while ($row = $stmt->fetch()) {
                        if (!$row == 0) {
                            ?>

                            <option value="<?php echo $company_name; ?> ">
                                <?php echo "" . $company_name . " | " . $office_contact . ""; ?>
                            </option>  
                            <?php
                        }
                    }
                    $conn->close();
                    ?>

                </select>
            </div>
        </div>

        <div class="form-group">


            <label for="carMake" id="disabledInput" class="col-sm-4 control-label">Date Of Creation </label>
            <div class="col-sm-6">
                <?php date_default_timezone_set('Asia/Singapore'); ?>
                <input type="text" class="form-control" name="date_of_creation" id="disabledInput" placeholder="Date Of Creation" value="<?php echo "" . date("Y-m-d H:i:s") . ""; ?>" readOnly="true">
            </div>
        </div>

        <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">PO Status</label>
            <div class="col-sm-6">
                <select class="form-control" name="po_status" placeholder="Purchase Order Number">
                    <option>Sent</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-4 control-label">Order By</label>
            <div class = "col-sm-6">
                <input type="text" class="form-control" name="order_by" placeholder="Enter Your Name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-4 control-label">Remark</label>
            <div class = "col-sm-6">
                <textarea class="form-control" name="remark"rows="3"></textarea>
            </div>
        </div>

        <div class="form-group">
            
            <div class = "col-sm-10">
                <input type="submit" value="Next"class="col-sm-11 btn btn-success pull-left" style="margin-left:7%" >
            </div> 
        </div>

    </form>
</div>


<?php include '../homeFooter.php'; ?>






