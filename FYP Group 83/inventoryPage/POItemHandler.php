<?php
include '../homeHeader.php';

?>
<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="inventoryPage.php">Inventory</a></li>
    <li><a href="">New Purchase Order</a></li>
    <li><a href="">Select Item To Order</a></li>
    <li class="active">Enter Item Quantity To Order</li>

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
    <form class="form-inline" name="myForm" role="form" action="POSubmitHandler.php" method="POST">

        <?php
        if (!empty($_POST["check_list"])) {
            echo "<h2>You have selected the part,  Enter the part quantity to order</h2>";
            ?>
            <div align style="margin-left: 3%">
            <?php
            foreach ($_POST['check_list'] as $check) {
                ?>

                    <div class="form-group">
                        <label for="inputPassword3" >Part name:</label>

                        <input type="text" class="form-control"  name="part_no[]"  value="<?php echo "" . $check . ""; ?>" readOnly="true">

                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" >  Part Quantity:</label>

                        <input type="text" class="form-control" name="part_quantity[]" value="1">

                    </div>
                    <br><br>
        <?php
    }
    ?>
                <div class="form-group">
                    <input type="submit" value="Submit"class="col-sm-12 btn btn-success " >
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



</form>

<?php include '../homeFooter.php'; ?>