
<?php
session_start();

$quotation_no = $_SESSION["quotationNo"];//$_POST["quotationNo"]; //$_POST["quotationSelection"];
$invoice_no = "INV22021500"; //$_POST["invoiceNo"];
$plateNo = $_SESSION["plate_no"]; //$_POST["plateNo"];
$del_status=0;
$total=0;
$gst = 0;
$nostring = null;
include '../database/myDb.php';
$data = array();
$row = array();
	$stmt = $conn->prepare("SELECT quotation_item.part_id, quotation_item.price_charged, quotation_item.qty, part.part_name, part.part_descrp FROM quotation_item INNER JOIN part ON quotation_item.part_id = part.part_id WHERE quotation_item.quotation_no=?") ;
	$stmt->bind_param("i", $quotation_no);
	$stmt->execute();
	$stmt->bind_result($part_id, $price_charged, $qty, $part_name, $part_descrp);
	$price_charged = number_format((float)$price_charged, 2, '.', ''); 
	while ($stmt->fetch()) {
		$total += $price_charged * $qty;
		array_push($row, array($invoice_no, $part_id, $price_charged, $del_status));
		
		// echo $invoice_no;
		// echo "<br/>";
		// echo $part_id;
		// echo "<br/>";
		// echo $price_charged;
		// echo "<br/>";
		// echo $del_status;
		// echo "<br/>";
		// echo $total;
		// echo "<br/>";
	}
	// print "<pre>";
	// print_r($row);
	// print "</pre>";
	$stmt->close();
		for($i=0; $i<count($row); $i++){
		// echo $row[$i][0]; 
		// echo "<br/>";
		// echo $row[$i][1];
		// echo "<br/>";
		// echo $row[$i][2];
		// echo "<br/>";
		// echo $row[$i][3];
		// echo "<br/>";
		$stmt = $conn->prepare("INSERT INTO `invoice_item` (`invoice_no`, `part_id`, `price_charged`, `del_status`) VALUES (?,?,?,?)");
		$stmt->bind_param("sidi", $row[$i][0], $row[$i][1], $row[$i][2], $row[$i][3]);
		$stmt->execute();
		}
		$stmt->close();
	$customer_id = $_SESSION["customer_id"];
	
	$today = date("Y-m-d");
	$gst = $total *0.06;
	$gst = number_format((float)$gst, 2, '.', ''); 
	//echo $gst;
	$paymentstatus = "PAID";
	
	$stmt = $conn->prepare("INSERT INTO `customer_invoice`(`invoice_no`, `invoice_date`, `gst`, `total_amt_charged`, `del_status`, `payment_status`, `customer_id`, `quotation_no`) "
                      ."VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

	//discount column  datatype in database has to change from int to double
	$stmt->bind_param("isddisss", $invoice_no, $today, $gst, $total, $del_status, $paymentstatus, $customer_id, $quotation_no);
	$stmt->execute();
	$stmt->close();

?>