<?php

include '../database/myDb.php';

$stmt = $conn->prepare
        (
        "SELECT DISTINCT  model " .
        "FROM vehicle_category vc "
);

$model_make_info = array();

if ($stmt->execute() == true ) {
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        array_push($model_make_info, $myrow);
    }

    $stmt->close();
}

echo json_encode($model_make_info);



