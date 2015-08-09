<?php
include '../homeHeader.php';
require '../database/Mydb.php';
?>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

    <script>
        function showSupplier(str) {
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
                xmlhttp.open("GET", "SupplierView.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>

    <script>
        function validateForm() {
          var alphaExp = /^[a-zA-Z\séåü]+$/;
            
            var numericExpression = /^[0-9 \.-]+$/;



            $first_name = document.myForm.firstName.value;
            $last_name = document.myForm.lastName.value;
            $office_contact = document.myForm.officeContact.value;
            $hp_contact = document.myForm.hpContact.value;
            $fax_contact = document.myForm.faxContact.value;
            $street_number = document.myForm.streetNumber.value;
            $block_unit_number = document.myForm.blockUnitNumber.value;
            $postal_code = document.myForm.postalCode.value;
            $company_name = document.myForm.companyName.value;

        

            if ($first_name == "") {
                alert("Please Enter First Name");
                return false;
            } else

            if (!($first_name.match(alphaExp))) {
                alert("Please do not enter number for First Name");
                return false;
            }

if ($last_name == "") {
                alert("Please Enter Last Name");
                return false;
            } else

            if (!($last_name.match(alphaExp))) {
                alert("Please do not enter number for Last Name");
                return false;
            }



            if ($office_contact == "") {
                alert("Please Enter Office Contact");
                return false;
            } else

            if (!($office_contact.match(numericExpression))) {
                alert("Please enter only number for Office Contact");
                return false;
            }

            if ($hp_contact == "") {
                alert("Please Enter HP Contact");
                return false;
            } else

            if (!($hp_contact.match(numericExpression))) {
                alert("Please enter only number for HP Contact");
                return false;
            }

            if ($fax_contact == "") {
                alert("Please Enter Fax Contact");
                return false;
            } else

            if (!($fax_contact.match(numericExpression))) {
                alert("Please enter only number for Fax Contact");
                return false;
            }

            if ($street_number == "") {
                alert("Please Enter Street Number");
                return false;
            }
            if ($block_unit_number == "") {
                alert("Please Enter Block Unit And Unit Number");
                return false;
            }
            if ($postal_code == "") {
                alert("Please Enter Postal Code");
                return false;
            }
            if ($company_name == "") {
                alert("Please Enter Company Name");
                return false;
            }
            
             
        }
            
     function validateUpdateForm() {
         var alphaExp = /^[a-zA-Z\séåü]+$/;
        
            var numericExpression = /^[0-9 \.-]+$/;
            
             $updatefirst_name = document.updateForm.update_firstName.value;
            $updatelast_name = document.updateForm.update_lastName.value;
            $updateoffice_contact = document.updateForm.update_officeContact.value;
            $updatehp_contact = document.updateForm.update_hpContact.value;
            $updatefax_contact = document.updateForm.update_faxContact.value;
            $updatestreet_number = document.updateForm.update_streetNumber.value;
            $updateblock_unit_number = document.updateForm.update_blockUnitNumber.value;
            $updatepostal_code = document.updateForm.update_postalCode.value;
            $updatecompany_name = document.updateForm.update_companyName.value;
            
            if ($updatefirst_name == "") {
                    alert("Please Enter First Name");
                    return false;
                } else

                if (!($updatefirst_name.match(alphaExp))) {
                    alert("Please do not enter number for First Name");
                    return false;
                }

                if ($updatelast_name == "") {
                    alert("Please Enter Last Name");
                    return false;
                } else

                if (!($updatelast_name.match(alphaExp))) {
                    alert("Please do not enter number for Last Name");
                    return false;
                }

                if ($updateoffice_contact == "") {
                    alert("Please Enter Office Contact");
                    return false;
                } else

                if (!($updateoffice_contact.match(numericExpression))) {
                    alert("Please enter only number for Office Contact");
                    return false;
                }


                if ($updatehp_contact == "") {
                    alert("Please Enter HP Contact");
                    return false;
                } else

                if (!($updatehp_contact.match(numericExpression))) {
                    alert("Please enter only number for HP Contact");
                    return false;
                }

                if ($updatefax_contact == "") {
                    alert("Please Enter Fax Contact");
                    return false;
                } else

                if (!($updatefax_contact.match(numericExpression))) {
                    alert("Please enter only number for Fax Contact");
                    return false;
                }

                if ($updatestreet_number == "") {
                    alert("Please Enter Street Number");
                    return false;
                }
                if ($updateblock_unit_number == "") {
                    alert("Please Enter Block Unit and Unit Number");
                    return false;
                }
                if ($updatepostal_code == "") {
                    alert("Please Enter Postal Code");
                    return false;
                }
                if ($updatecompany_name == "") {
                    alert("Please Enter Company Name");
                    return false;
                }
     }
    </script>

</head>
<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="inventoryPage.php">Inventory</a></li>
    <li class="active">Supplier Creation and View</li>

</ol>
<div class="inventoryPo">
    <div class="inventoryPo">
        <div class="poMenu">
            <h2>  Select </h2>
            <a href="inventoryNewSupplierItem.php" button type="button" class="col-sm-10 btn btn-primary" style=" padding: 10px 0 10px 0;">New Supplier Item</a>
            <a href="inventorySupplier.php" button type="button" class="col-sm-10 btn btn-default" style=" padding: 10px 0 10px 10;">Supplier creation and view</a>
            <a href="inventoryPO.php"button type="button" class="col-sm-10 btn btn-danger" style=" padding: 10px 0 10px 0;">New Purchase Order</a>
            <h2> Manage Purchase Order </h2>
            <a href="inventoryPOupdate.php"button type="button" class="col-sm-10 btn btn-info"  style=" padding: 10px 0 10px 0;">A/P Payment</a>
        </div></div></div>

<div class="poSupplier">

    <div class="poSupplierView">
        <h2> Supplier Management </h2>
  <form class="form-horizontal">
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-3 control-label">Select Supplier</label>

            
                <div class="col-sm-7"   >
           
                <form>
                    <select class="form-control" placeholder="Purchase Order Number" onchange="showSupplier(this.value)" >
                        <?php
                        if (!$stmt = $conn->prepare("SELECT supplier_id, company_name, office_contact FROM supplier")) {
                            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                        }
                        /* Execute it */
                        $stmt->execute();
                        $stmt->bind_result($supplier_id, $company_name, $office_contact);
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
                </div>
                  <div class="poButton">
                        <a href="#new" data-toggle="modal" class="btn btn-warning" style=" margin-top:-44px;padding: 5px 25px 5px 25px; ">New</a>
                    </div>
             
        </div>
         </form>
        <div id="txtHint" style="padding: 10px 0px 0px 15px; "><i>Supplier info will be listed here...</i></div>
 
    </div>


</div>



    <div class="modal fade" id ="new" role ="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4> Add Supplier </h4>
                </div>

                <div class="modal-body">

                    <form class="form-horizontal" name="myForm" onsubmit="return validateForm()" role="form" action="SupplierHandler.php"  method="POST">



                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">First Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="firstName" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Last Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="lastName" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="carMake" class="col-sm-4 control-label">Office contact </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="officeContact" placeholder="Office">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="carMake" class="col-sm-4 control-label">HP contact </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="hpContact" placeholder="Handphone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="carMake" class="col-sm-4 control-label">Fax contact </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="faxContact" placeholder="Fax contact">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="carMake" class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-6" >
                                <input type="text" class="form-control"  name="streetNumber" placeholder="Street name" style="margin-bottom: 5px">
                                <input type="text" class="form-control"  name="blockUnitNumber" placeholder="Block Number | Unit Number" style="margin-bottom: 5px"> 
                                <input type="text" class="form-control"  name="postalCode" placeholder="Postal Code">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="carMake" class="col-sm-4 control-label">Company Name</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control"  name="companyName" placeholder="Company Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Remark</label>
                            <div class = "col-sm-6">
                                <textarea class="form-control"  name="remark" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" ></a>
                            <a class="btn btn-default" data-dismiss ="modal">Close</a>

                        </div>
                    </form>    
                </div>

            </div>
        </div>
    </div>

    
    </div>
    <?php
    include '../homeFooter.php';
    