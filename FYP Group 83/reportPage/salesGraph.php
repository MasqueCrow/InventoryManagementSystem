<?php
include '../homeHeader.php';
require '../database/Mydb.php';
$Label ="<h2> Please Select A Year</h2>";

if(isset($_POST['submit'])) 
{ 
$year = $_POST['Year'];

$Label ="<h2> You have selected year $year </h2>";
?>
 
 <?php



if (!$stmt = $conn->prepare("SELECT invoice_date , invoice_no,total_amt_charged FROM customer_invoice where YEAR(invoice_date) =?")) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
//
if (!$stmt->bind_param("s", $year)) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}

// Execute it /
$stmt->execute();

$stmt->bind_result($invoice_date,$invoice_no, $total_amt_charged);

while ($row = $stmt->fetch()) {
    if (!$row == 0) {
        $invoices[] = array(
            'invoice_date' =>$invoice_date,
        'invoice_number' => $invoice_no,
        'amt_charged' => $total_amt_charged
    );
   
}
}

//echo json_encode($orders);

}
echo $Label; ?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <select name="Year">

  <option value="2013">2013</option>
  <option value="2014">2014</option>
    <option value="2015">2015</option>
 </select>
    <br><br>
   <input type="submit" name="submit" value="View"><br>
</form>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<div id="morris-line-chart"></div>

<script>

                Morris.Line({
                    // ID of the element in which to draw the chart.
                    element: 'morris-line-chart',
                    // Chart data records -- each entry in this array corresponds to a point
                    // on the chart.
                    data: <?php echo json_encode($invoices); ?>,
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