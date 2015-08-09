<?php
require '../database/Mydb.php';

$key = $_GET['key'];
$array = array();

if (!$stmt = $conn->prepare("select `part_name`, `brand`, `part_no`, `part_descrp`  from part where part_name LIKE '%{$key}%'")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
/* Execute it */
$stmt->execute();
$stmt->bind_result($part_name, $brand, $part_no, $part_descrp);
// output data of each row
while ($row = $stmt->fetch()) {
     $array[] = $part_name;
}
echo json_encode($array);

$conn->close();
?>
