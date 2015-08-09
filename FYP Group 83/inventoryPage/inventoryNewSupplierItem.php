<?php
include '../homeHeader.php';
require '../database/Mydb.php'
?>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <script>
        function showNewItem(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "newItemView.php?q=" + str, true);
                xmlhttp.send();
            }
        }



    </script>
       <script>
        function validateForm() {

          var alphaExp = /^[a-zA-Z\séåü]+$/;
        
            var numericExpression = /^[0-9 \.-]+$/;
            var decExp =/^\d+(\.\d{1,2})?$/;

            $part_name = document.myForm.partName.value;
            $part_number = document.myForm.partNumber.value;
            $brand = document.myForm.brand.value;
            $part_description = document.myForm.partDescription.value;
            $cost_price = document.myForm.costPrice.value;
            $retail_price = document.myForm.retailPrice.value;


            if ($part_name == "") {
                alert("Please Enter Part Name");
                return false;
            } else

            if (!($part_name.match(alphaExp))) {
                alert("Please do not enter number for Part Name");
                return false;
            }

            if ($part_number == "") {
                alert("Please Enter Part Number");
                return false;
            }
            if ($brand == "") {
                alert("Please Enter Brand Name");
                return false;
            }
            if ($part_description == "") {
                alert("Please Enter Part Description");
                return false;
            }
            if ($cost_price == "") {
                alert("Please Enter Cost Price");
                return false;
            } else

            if (!($cost_price.match(decExp))) {
                alert("Please Enter Only Number for Cost Price");
                return false;
            }
            if ($retail_price == "") {
                alert("Please Enter Retail Price");
                return false;
            } else

            if (!($retail_price.match(decExp))) {
                alert("Please Enter Only Number for Retail Price");
                return false;
            }

        }
    </script>
</head>
<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="inventoryPO.php">Inventory</a></li>
    <li class="active">New Supplier Item</li>
</ol>

 <div class="inventoryPo">
    <div class="inventoryPo">
        <div class="poMenu">
            <h2>  Select </h2>
            <a href="inventoryNewSupplierItem.php" button type="button" class="col-sm-10 btn btn-default" style=" padding: 10px 0 10px 0;">New Supplier Item</a>
            <a href="inventorySupplier.php" button type="button" class="col-sm-10 btn btn-warning" style=" padding: 10px 0 10px 10;">Supplier creation and view</a>
            <a href="inventoryPO.php"button type="button" class="col-sm-10 btn btn-danger" style=" padding: 10px 0 10px 0;">New Purchase Order</a>
            <h2> Manage Purchase Order </h2>
            <a href="inventoryPOupdate.php"button type="button" class="col-sm-10 btn btn-info"  style=" padding: 10px 0 10px 0;">A/P Payment</a>
        </div></div></div>


<div class="poTransaction">

    <h2> New Supplier Item </h2>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-4 control-label" style="margin-left: 1.2%">Company Name and Contact</label>
        <div class="col-sm-6"   >
            <form>
                <select class="form-control" placeholder="Purchase Order Number" onchange="showNewItem(this.value)" >
                    <?php
                    if (!$stmt = $conn->prepare("SELECT company_name, office_contact FROM supplier")) {
                        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                    }
                    /* Execute it */
                    $stmt->execute();
                    $stmt->bind_result($company_name, $office_contact);
                    // output data of each row
                    ?>
                    <option value="inventory.PO">Select A Company</option> 
                    <?php
                    while ($row = $stmt->fetch()) {
                        if (!$row == 0) {
                            ?>
                            <option value="<?php echo $company_name; ?> ">
                                <?php echo " Company Name: " . $company_name . " Contact: " . $office_contact . ""; ?>
                            </option>  
                            <?php
                        } else {
                            echo "<option>Add New Supplier</option>";
                        }
                    }
                    $conn->close();
                    ?>

                </select>
            </form>
           
        </div>
         
    </div>
    <div id="txtHint" style="padding: 10px 0px 0px 15px; "></div>



<?php include '../homeFooter.php'; ?>
