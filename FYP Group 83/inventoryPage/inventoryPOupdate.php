<?php
include '../homeHeader.php';
require '../database/Mydb.php';
?>


 <ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="inventoryPO.php">Inventory</a></li>
    <li class="active">A/P Payment</li>
</ol>

 
<div class="inventoryPo">
    <div class="inventoryPo">
        <div class="poMenu">
            <h2>  Select </h2>
            <a href="inventoryNewSupplierItem.php" button type="button" class="col-sm-10 btn btn-primary" style=" padding: 10px 0 10px 0;">New Supplier Item</a>
            <a href="inventorySupplier.php" button type="button" class="col-sm-10 btn btn-warning" style=" padding: 10px 0 10px 10;">Supplier creation and view</a>
            <a href="inventoryPO.php"button type="button" class="col-sm-10 btn btn-danger" style=" padding: 10px 0 10px 0;">New Purchase Order</a>
            <h2> Manage Purchase Order </h2>
            <a href="inventoryPOupdate.php"button type="button" class="col-sm-10 btn btn-default"  style=" padding: 10px 0 10px 0;">A/P Payment</a>
        </div></div></div>


    <div class="poTransaction">
        <form class="form-horizontal"  role="form" action="POUpdateHandler.php" method="POST">

            <h2>  Update Purchase Order </h2>




            <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">PO No. | D.O.C | Order By</label>
                <div class="col-sm-6"   >

                    <select class="form-control" name="po_no" placeholder="Purchase Order Number" >
                        <?php
                        if (!$stmt = $conn->prepare("SELECT po_no, date_of_creation, ordered_by FROM purchase_order WHERE po_status='Sent'
OR po_status='Paid';")) {
                            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                        }
                        /* Execute it */
                        $stmt->execute();
                        $stmt->bind_result($po_no, $date_of_creation, $ordered_by);
                        // output data of each row
                         ?>
                         <option value="inventory.PO">Select A PO</option> 
                         <?php
                        while ($row = $stmt->fetch()) {
                            if (!$row == 0) {
                                ?>
                                <option value="<?php echo $po_no; ?> ">
                                    <?php echo "".$po_no . "|" . $date_of_creation . " | " . $ordered_by . ""; ?>
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
                <label for="carMake" class="col-sm-4 control-label">PO Status</label>
                <div class="col-sm-6">
                    <select class="form-control" name="po_status" placeholder="Purchase Order Number">
                        <option>Goods Received</option>
                        <option>Paid</option>
                    </select>
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
                <input type="submit" value="Update"class="col-sm-11 btn btn-success pull-left" style="margin-left:7%" >
            </div> 
        </div>


        </form>
    </div>



<?php include '../homeFooter.php'; ?>







