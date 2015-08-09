<?php
include '../homeHeader.php';

require '../database/Mydb.php';
?>
<div align style="margin-left: 3.5%">
<form class="form-horizontal" name="myForm" onsubmit="return validateForm()" action="newItemHandler.php" method="POST" >

         <div class="form-group">
        <label for="inputPassword3" class="col-sm-4 control-label">Supplier ID</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="supplierID2" value="<?php
if (!$stmt = $conn->prepare("SELECT `supplier_id` FROM `supplier` WHERE `company_name` =?")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
$q = ($_GET['q']);
if (!$stmt->bind_param("s", $q)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
/* Execute it */
$stmt->execute();
$stmt->bind_result($supplier_id);
$stmt->fetch();
echo $supplier_id;
?>" readOnly="true">
        </div>
         </div>

            <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Part Name</label>
                <div class = "col-sm-6">
                    <input type="text" class="form-control" name="partName" placeholder="Enter Part Name">
                </div>
            </div>  <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Part Number</label>
                <div class = "col-sm-6">
                    <input type="text" class="form-control" name="partNumber" placeholder="Enter Part Number">
                </div>
            </div>  <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Brand</label>
                <div class = "col-sm-6">
                    <input type="text" class="form-control" name="brand" placeholder="Enter Brand Name">
                </div>
            </div>  <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Part Description</label>
                <div class = "col-sm-6">
                      <textarea class="form-control" name="partDescription"  rows="3"></textarea>
               
                </div>
                
            </div> 
            
            <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Part Quantity </label>
            <div class="col-sm-6">
                <input type="text" class="form-control"  name="partQuantity" value ="0" placeholder="Enter Part Quantity"  readOnly="true">
            </div>
        </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Cost Price</label>
                <div class = "col-sm-6">
                    <input type="text" class="form-control" name="costPrice" placeholder="Enter Cost Price">
                </div>
            </div>  <div class="form-group">
                <label for="inputPassword3" class="col-sm-4 control-label">Retail Price</label>
                <div class = "col-sm-6">
                    <input type="text" class="form-control" name="retailPrice" placeholder="Enter Retail Price">
                </div>
            </div>
            
            <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Stock Level</label>
            <div class="col-sm-6">
                <input type="text" class="form-control"  name="stockLevel" value="0"  placeholder="Enter Stock Level" readOnly="true" >
            </div>
        </div>

       <div class="form-group">
            <label for="carMake" class="col-sm-4 control-label">Stock Status</label>
            <div class="col-sm-6">
                <input type="text" class="form-control"  name="stockStatus" value="Re-order" placeholder="Enter Stock Status" readOnly="true" >
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
                <input type="submit" value="Submit"class="col-sm-11 btn btn-success pull-left" style="margin-left:7%" >
            </div> 
        </div>

        </form>
    </div>


