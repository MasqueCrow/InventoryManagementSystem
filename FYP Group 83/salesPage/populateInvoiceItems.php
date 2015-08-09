
<?php
session_start();

$quotation_no = $_POST["quotationNo"]; //$_POST["quotationSelection"];

include '../database/myDb.php';

//initialise empty array
$data = array();
$row = array();

        // Select part information(part_id, part_name, price_charged,qty) from quotation_item table 
        // that exists(subset) in part table
	if (!$stmt = $conn->prepare("SELECT quotation_item.part_id, quotation_item.price_charged, quotation_item.qty, part.part_name, part.part_descrp "
                                    . "FROM quotation_item "
                                    . "INNER JOIN part "
                                    . "ON quotation_item.part_id = part.part_id "
                                    . "WHERE quotation_item.quotation_no=?")) {
				echo "Prepare failed: 1 (" . $mysqli->errno . ") " . $mysqli->error;
	}
		 
	if (!$stmt->bind_param("i", $quotation_no)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	/* Execute it */
	$stmt->execute();
	$stmt->bind_result($part_id, $price_charged, $qty, $part_name, $part_descrp);
	while ($stmt->fetch()) {
               //store part info into $row array
		array_push($row, array($part_name, $part_descrp, $price_charged, $qty));
	}
        //store $row array in $data array i.e 2 dimensional array
	array_push($data, $row);
	$stmt->close();

 //Display day,month,year i.e 010495
$today = date("dmy");
$cusInfo=array();
	if (!$stmt = $conn->prepare("Select COUNT(invoice_no) " //count no. of invoice for that invoice_no
                                   ."From customer_invoice "
                                   . "Where invoice_date=?")) {
					echo "Prepare failed: 1 (" . $mysqli->errno . ") " . $mysqli->error;
		}
                
		if (!$stmt->bind_param("s", $today)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		/* Execute it */
		$stmt->execute();
		$stmt->bind_result($count);
		if ($stmt->fetch()) { //Fetch values from prepare statement 
					$cusInfo[0] = "INV";
					$cusInfo[0] .=  $today;
					$count = sprintf("%02s", $count);
					$cusInfo[0] .= $count;
				}else{echo "<script>alert('Fetch Values Error')</script>";}
		$stmt->close();

$cusInfo[1] = date("d/m/y");

$cusInfo[2] = $_SESSION['plate_no'];
$cusInfo[3] = $_SESSION['model'];
$custID = $_SESSION['customer_id'];


if (!$stmt = $conn->prepare("Select first_name, contact_no1 From customer Where customer_id=?")) {
					echo "Prepare failed: 1 (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if (!$stmt->bind_param('i', $custID)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		/* Execute it */
		$stmt->execute();
		$stmt->bind_result($name, $contact_no1);
		if ($stmt->fetch()) { //Fetch values from prepare statement 
				$cusInfo[4] = $name;
				$cusInfo[5] = $contact_no1;
				
				
			}else{echo "<script>alert('Fetch Values Error')</script>";}
		$stmt->close();
		array_push($data, $cusInfo);
	
	echo json_encode($data);

?>