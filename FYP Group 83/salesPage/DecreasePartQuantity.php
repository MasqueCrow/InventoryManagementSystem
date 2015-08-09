<?php

include '../database/myDb.php';
$part_qty=$_REQUEST['part_qty'];
$part_no=$_REQUEST['part_no'];


$stmt = $conn->prepare(
        "Update part " .
        "Set part_qty=? ".
        "Where part_no=? ");


$stmt->bind_param('ss',$part_qty,$part_no);
$stmt->execute();
$stmt->close();

?>
