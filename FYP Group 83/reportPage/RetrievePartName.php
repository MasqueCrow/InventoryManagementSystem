<?php

include '../database/myDb.php';

$stmt = $conn->prepare
        (
        "SELECT DISTINCT part_name " .
        "FROM part "
);

$part_name_array=array();

if ($stmt->execute() == true ) {
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        array_push($part_name_array, $myrow);
    }

    $stmt->close();
}
echo json_encode($part_name_array);

