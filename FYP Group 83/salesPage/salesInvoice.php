<?php include '../homeHeader.php'; ?>
<?php

$_SESSION['quotationNo']= $_POST['quotationSelection'];
?>

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<link rel='stylesheet' type='text/css' href='../cssInvoice/style.css' />
	<link rel='stylesheet' type='text/css' href='../cssInvoice/print.css' media="print" />
	<script type='text/javascript' src='../jsInvoice/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='../jsInvoice/example.js'></script>
	
<script>
function printDiv() {
     
    var originalContents = document.body.innerHTML;
	var printContents = originalContents //document.getElementById("page-wrap").innerHTML;
	
	// Get the <ul> element with id="myList"
	var list = document.getElementById("myList");

	// As long as <ul> has a child node, remove it
	while (list.hasChildNodes()) {   
		list.removeChild(list.firstChild);
	}


     window.print();

     document.body.innerHTML = originalContents;
}

</script>	
	
<script>

var rowitems=[];
$(document).ready(function() {
	
		$.ajax({
			type: "POST",
			url: "populateInvoiceItems.php",
			dataType: "json",
			data: {quotationNo:"<?php echo $_POST['quotationSelection'];?>"}, //<?php echo $_POST['quotationSelection'];?> },
			success: function (data) {
			//alert(data);
			rowitems = data;
				$("#invoiceNo").val(data[1][0]);	
				$("#address").val("Car Plate No: "+data[1][2]+"\n"+"Car Model: "+data[1][3]+"\n"+"Car Owner: "+data[1][4]+"\n"+"Contact No: "+data[1][5]);
				var total=0;
				var count = data[0].length
				for(var i= count-1; i>=0; i--){
				var linetotal=0;
				var rowNo = i+1;
				linetotal= (data[0][i][2] * data[0][i][3]);
				//alert(data);
				$(".table-header:last").after('<tr class="item-row"><td><div class="delete-wpr">'+ rowNo +'<a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="item-name"><textarea>'+data[0][i][0]+'</textarea></td><td class="description"><textarea>'+data[0][i][1]+'</textarea></td><td><textarea class="cost">'+data[0][i][2]+'</textarea></td><td><textarea class="qty">'+data[0][i][3]+'</textarea></td><td><span class="price">'+linetotal+'</span></td></tr>');                            
				 total+=linetotal;
				}
                                var rndtotal=total.toFixed(2);
				$("#subtotal").val(rndtotal);
				$("#total").val(rndtotal);
				var paid = $("#paid").val();
				$("#due").val(rndtotal-paid);                               
				$("#amtDue").val((rndtotal-paid));
			},
			 error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert("Retrieve Error");
			  }
		});
	});

	function createInvoice(){
	alert(rowitems);
	
	$.ajax({
			type: "POST",
			url: "CreateInvoice.php",
			dataType: "json",
			data: {
				invoiceNo: rowitems[1][0]
			}, //<?php echo $_POST['quotationSelection'];?> },
			success: function (data) {
			
			},
			 error: function(XMLHttpRequest, textStatus, errorThrown) {
				 alert("create Error");
			  }
		});
	}
</script>
	
	
	
</head>

<body>
    
<ol class="breadcrumb" id="myList">
      <li><a href="../homePage/Homepage.php">Home</a></li>
      <li><a href="#">Sales</a></li>
      <li><a href="salesPage.php.php">Car Information</a></li>
      <li><a href="salesExistingCus.php">Existing Customer</a></li>
      <li><a href="salesJobSheet.php">Quotation</a></li>
    <li class="active">Invoice</li>
</ol>

	<div id="page-wrap">

            <textarea id="header">INVOICE</textarea>
		
		<div id="identity">
		
                    
                             <textarea id="customer-title">
LIAN FUAT MOTOR WORKS SDN. BHD. 

PTD 3287 & 3288, TAMAN TUAH, 
81500 PEKAN NENAS, JOHOR. 
TEL: 07-6991526, 012-7815665, 019-7769429

</textarea>
    

          
		
		<div style="clear:both"></div>
		
		<div id="customer">
        <textarea id="address"></textarea>
   

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea id="invoiceNo"></textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date"></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due"><textarea id="amtDue"></textarea></div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr class="table-header">
              <th>No.</th>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		  
		  <tr id="hiderow">
		    <td colspan="6"><a id="addrow" href="javascript:;" title="Add a row"></a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><textarea id="subtotal"></textarea></td>
		  </tr>
		  <tr>

		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><textarea id="total"></textarea></td>
		  </tr>
		  <tr>
		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>
		      <td class="total-value"><textarea id="paid"></textarea></td>
		  </tr>
		  <tr>
		      <td colspan="3" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><textarea id="due"></textarea></td>
		  </tr>
		
		</table>
		
		  <button type="submit" class="btn btn-success" onclick="printDiv()" style=" padding: 5px 20px 5px 20px; margin-left: 81%;margin-top: 20px; margin-bottom: 80px;">Print</button>
                    <button type="submit" class="btn btn-danger" onclick="createInvoice()" style=" padding: 5px 20px 5px 20px;margin-top: 20px; margin-bottom: 80px;">Done</button>
	
	</div>
        </div>
	
</body>

</html>


<?php

include '../homeFooter.php';