<?php
include '../homeHeader.php';
require '../database/Mydb.php';



//finally, let's store our posted values in the session variables
$companyName = $_SESSION['companyName'] = $_POST['companyName'];
$doc = $_SESSION['date_of_creation'] = $_POST['date_of_creation'];
$po_status = $_SESSION['po_status'] = $_POST['po_status'];
$ordered_by = $_SESSION['order_by'] = $_POST['order_by'];
$remark = $_SESSION['remark'] = $_POST['remark'];
?>
<html>
    <head>

        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>

        <script>
            function validate() {
                var chk = document.getElementsByName('check_list[]')
                var len = chk.length

                for (i = 0; i < len; i++)
                {
                    if (chk[i].checked) {
                        return true;
                    }
                }
                alert("Please Select An Item To Order");
                return false;
            }

        </script>

    <ol class="breadcrumb">
        <li><a href="../homePage/Homepage.php">Home</a></li>
        <li><a href="inventoryPO.php">Inventory</a></li>
        <li><a href="">New Purchase Order</a></li>
        <li class="active">Select Item To Order</li>

    </ol>

    <style>
        table {
            border-collapse: collapse;
            margin-top:10px;
            margin-left: 30px;
            border-color: black;
        }

        table, td, th {
            border: 1px solid black;
            //font-weight: bold;
            font-size: 14px;
            padding:5px 5px;
        }
    </style>
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

        <h2>Select Item To Order</h2>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label" style="margin-left: 14px">Company Name</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="companyName" id="disabledInput"  value="<?php echo "" . $companyName . ""; ?>" readOnly="true">
            </div>
        </div>

        <?php
        if (!$stmt = $conn->prepare("SELECT `supplier_id` FROM `supplier` WHERE `company_name` =?")) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("s", $companyName)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        /* Execute it */
        $stmt->execute();
        $stmt->bind_result($supplier_id);
        $stmt->fetch();
        $_SESSION['supplier_id'] = $supplier_id;
        // print_r($_SESSION);
        // echo "Session variables are set.";

        $stmt->close();
        if (!$stmt = $conn->prepare("SELECT part.part_id, part.part_no, part.part_name, part.brand, part.part_descrp, supplier_part.cost_price FROM part INNER JOIN supplier_part ON supplier_part.part_id =part.part_id "
                . "WHERE supplier_part.supplier_id =?")) {
            echo "1st Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("s", $supplier_id)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* Execute it */
        $stmt->execute();
        $stmt->bind_result($part_id, $part_no, $part_name, $brand, $part_descrp, $cost_price);
        $stmt->store_result();
        ?>

        <?php
        if ($stmt->num_rows > 0) {
            ?>  
            <form action="POItemHandler.php"  onclick="return validate()" method="post">

                <label for="carMake"  class="col-sm-4 control-label" style="margin:15px 0 0 14px">Select Item To Order </label>
                <div class="form-group">
                    <table class="col-sm-9" >
                        <?php
                        echo "
<tr>
<th>Part Id</th>
<th>Part No</th>
<th>Part Name</th>
<th>Brand</th>
<th>Part Description</th>
<th>CostPrice</th>
<th>Select</th>
</tr>";
                        while ($row = $stmt->fetch()) {
                            ?>

                            <div id="itemRows">
                                <?php
                                echo "<tr>";
                                echo "<td>" . $part_id . " </td>";
                                echo "<td>" . $part_no . "</td>";
                                echo "<td>" . $part_name . "</td>";
                                echo "<td>" . $brand . "</td>";
                                echo "<td>" . $part_descrp . "</td>";
                                echo "<td> $" . $cost_price . "</td>";
                                echo '<td>   <input type="checkbox" name="check_list[]" value="' . $part_no . '" id="' . $part_no . '"  /> </td>';
                                echo "</tr>";
                            }
                            ?>
                    </table>
                </div>
                <div class="form-group">

                    <div class = "col-sm-10">
                        <input type="submit" value="Next"class="col-sm-12 btn btn-success " style="margin:3% 0 0 2%;" >
                    </div> 
                </div>
                <?php
            } else {
                echo"<Br><BR>";
                echo " <h2>No item available to purchase </h2><br>";
                $stmt->close();
                ?>

                <div class="form-group">

                    <div class = "col-sm-10">
                        <a href="inventoryPO.php" button type="button" class="col-sm-12 btn btn-danger" style="margin-left:2%">Back</a>
                    </div> 
                </div>


        </div>
        <?php
    }
    ?>


    <?php include '../homeFooter.php'; ?>


