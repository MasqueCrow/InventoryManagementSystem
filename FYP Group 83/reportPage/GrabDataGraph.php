<?php
#Include the connect.php file
require 'db.php';


if (!$stmt = $conn->prepare("SELECT invoice_no,invoice_date,total_amt_charged FROM customer_invoice")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
// Execute it /
$stmt->execute();
$stmt->bind_result($supplier_id,$invoice_no, $company_name);
// output data of each row
?>
<option value="inventory.PO">Select A Company</option> 
<?php
while ($row = $stmt->fetch()) {
    if (!$row == 0) {
        $orders[] = array(
            'invoice_date' =>$invoice_no,
        'invoice_number' => $supplier_id,
        'amt_charged' => $company_name
    );
   
}
}

echo json_encode($orders);
?>

    <link rel="stylesheet" type="text/css" href="morris.css">
    <script type="text/javascript" language="javascript" src="jquery-1.11.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="morris.min.js"></script>
    <script type="text/javascript" language="javascript" src="raphael-min.js"></script>
<div id="morris-line-chart"></div>

<script>
 
Morris.Line({
    // ID of the element in which to draw the chart.
    element: 'morris-line-chart',
 
    // Chart data records -- each entry in this array corresponds to a point
    // on the chart.
    data: <?php echo json_encode($orders);?>,
 
    // The name of the data record attribute that contains x-values.
    xkey: 'invoice_date',
 
    // A list of names of data record attributes that contain y-values.
    ykeys: ['amt_charged'],
 
    // Labels for the ykeys -- will be displayed when you hover over the
    // chart.
    labels: ['amt charged'],
 
    lineColors: ['#0b62a4'],
    xLabels: 'date',
 
    // Disables line smoothing
    smooth: true,
    resize: true
});
</script>