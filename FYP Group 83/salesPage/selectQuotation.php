<?php
include '../homeHeader.php';
include '../database/myDb.php';
include './salesDbfunctions.php';
?>
<?php
$plate_no = $_SESSION['plate_no'];
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
window.onload=loadquotation;

	function loadquotation(){
	$.ajax({
		type: "POST",
		url: "getQuotation.php",
		dataType: "json", // Set the data type so jQuery can parse it for you
		success: function (data) {
			
			var quotationBox = document.getElementById('quotationSelection');
			// loop through years
			for (var i = 0; i < data.length; i++) {
				// create option element
				var option = document.createElement('option');
				// add value and text name
				option.value = data[i];
				option.innerHTML = data[i];
				// add the option element to the selectbox
				quotationBox.appendChild(option);
			}
		}
	});
	}
function checkselect(){
	if (document.getElementById('quotationSelection').value == "-----" || document.getElementById('quotationSelection').value == null){
	document.getElementById("errMsg").innerHTML = "Please Select Quotation";
	return false;
	}else{
	return true;
	}
}

</script>


<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li class="active">Car Information</li>
</ol>



<!--Side Nav Bar -->
<?php include'SideNavBar.html'; ?>

<div class="poTransaction form-horizontal">
    <!-- Return the current script executed-->
   
        <h2> <?php echo $plate_no?></h2>
		
		<div class="form-group">
            <label class="col-sm-5 control-label">Select Quotation: </label>
            <div class="col-sm-3">
			<form action="salesInvoice.php" onsubmit="return checkselect()" method="post">
				 <select class="form-control" id="quotationSelection" name="quotationSelection">
				</select><span style="color:red;" id="errMsg" ></span>
				<button id="next" type="submit" class="btn btn-default " style="background-color:Black; color:white; padding: 5px 20px 5px 20px;">GO</button>
				<a  type="submit" href='salesJobSheet.php'  class="btn btn-default" id='nextBtn' style="background-color:Red; padding: 5px 10px 5px 10px;">New</a>
				<form>
			</div>
			
        </div>
		
		
		
</div>


<?php
include '../homeFooter.php';