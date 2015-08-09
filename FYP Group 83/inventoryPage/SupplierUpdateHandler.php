<?php

include '../homeHeader.php';
require '../database/Mydb.php';


$supplier_id = $_POST['supplierID'];
$first_name = $_POST['update_firstName'];
$last_name = $_POST['update_lastName'];
$office_contact = $_POST['update_officeContact'];
$hp_contact = $_POST['update_hpContact'];
$fax_contact = $_POST['update_faxContact'];
$company_name = $_POST['update_companyName'];
$address_line1 = $_POST['update_streetNumber'];
$address_line2 = $_POST['update_blockUnitNumber'];
$address_line3 = $_POST['update_postalCode'];
$remark = $_POST['update_remark'];

if (isset($_POST['update'])) {
    if (!$stmt = $conn->prepare("UPDATE `supplier` SET `first_name` = ?, `last_name` = ?, "
            . "`office_contact` = ?, `hp_contact` = ?, `fax_contact` = ?, "
            . "`company_name` = ?, `address_line1` = ?, `address_line2` = ?,"
            . "`address_line3` = ?,`remark` =? WHERE `supplier_id` = ?")) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("ssiiisssssi", $first_name, $last_name, $office_contact, $hp_contact, $fax_contact, $company_name, $address_line1, $address_line2, $address_line3, $remark, $supplier_id)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    } else {
        ?>
        <script>
            alert("Update Success!");
            window.location = "inventorySupplier.php";
        </script>
        <?php

    }
} else if (isset($_POST['delete'])) {
    if (!$stmt = $conn->prepare("DELETE FROM supplier WHERE supplier_id = ?")) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
    if (!$stmt->bind_param("i", $supplier_id)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
    }
    ?>
    <script>
        alert("Delete Success!");
        window.location = "inventorySupplier.php";
    </script>
    <?php

}



$stmt->close();
