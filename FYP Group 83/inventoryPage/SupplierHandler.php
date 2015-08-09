<?php

include '../homeHeader.php';

require '../database/Mydb.php';

$first_name = $_POST['firstName'];
$last_name = $_POST['lastName'];
$office_contact = $_POST['officeContact'];
$hp_contact = $_POST['hpContact'];
$fax_contact = $_POST['faxContact'];
$company_name = $_POST['companyName'];
$address_line1 = $_POST['streetNumber'];
$address_line2 = $_POST['blockUnitNumber'];
$address_line3 = $_POST['postalCode'];
$remark = $_POST['remark'];



if (!$stmt = $conn->prepare("INSERT INTO supplier(`first_name`, `last_name`, `office_contact`, `hp_contact`,"
        . "`fax_contact`, `company_name`, `address_line1`, `address_line2`, `address_line3`, `remark`) "
        . "VALUES (?, ?, ?, ?, ?, ?, ? , ?,  ? ,?)")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$stmt->bind_param("ssiiisssss", $first_name, $last_name, $office_contact, $hp_contact, $fax_contact, $company_name, $address_line1, $address_line2, $address_line3, $remark)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {
  
     ?>
<script>
    alert("Supplier Created!");
  window.location = "inventorySupplier.php";
    </script>
    <?php
}

$stmt->close();

