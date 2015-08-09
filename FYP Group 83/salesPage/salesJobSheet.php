<?php
// 
include '../homeHeader.php';
include '../database/myDb.php';
include './salesDbfunctions.php';
?>
<?php
$plate_no = $_SESSION['plate_no'];
$car_model = $_SESSION['model'];
$remark = $_SESSION['remark'];
$service = new Service();
?>

<link rel="stylesheet" type="text/css" href="salesJobSheetStyleSheet.css">

<script>
    $(document).ready(function() {
        var rowIndex = $('#mytable tbody>tr:last').index(); //retrieve index of last row 
        //Delete specific row in the table by id
        $('#del').click(function() {
            jQuery('input:checkbox:checked').map(function()
            {
                if (this.value) {
                    countIdx--; //reduce countIdx when rows are deleted 
                }
                return this.value;

            }).get();
            jQuery('input:checkbox:checked').parents("tr").remove();
            rowIndex = $('#mytable tbody>tr:last').index();  //update last index of row

        });

//--------------------------------------------------------

        //Insert new rows in the table
        $("#add").click(function()
        {
            var numRows = $('#getnumRows').val();
            var selectlastRow = $('tbody>tr').eq(rowIndex);
            for (i = 0; i < numRows; i++)
            {
                $(selectlastRow).clone(true, true).insertAfter(selectlastRow); //copy last row to new row
                $('tbody>tr').eq((rowIndex + 1)).find('select,input,textarea').val(''); //clear fields after cloning

            }
            rowIndex = $('#mytable tbody>tr:last').index(); //update last row index after adding in new rows 
        });//end click tag
        //----------------------------------------------------------

        function ajaxNewRowInfo(ServiceName, partNo) {
            return $.ajax({
                type: "POST",
                dataType: 'json',
                url: "ajaxServicePart.php",
                data: {serviceName: ServiceName,
                    partNo: partNo},
            }); //ajax
        }

//Add a new Row of service and part
        var countIdx = 0;//counter to add new row to table rows
        var service_id = []; //store service_id
        var part_id = []; //store part_id
        $('#addBtn').click(function()
        {

            var servicePartCode = $('#dropDownService').val();//retrieve the servicePartCode from the drowndown menu
            if (servicePartCode != '') { //ensures that the first option is not selected
                var n = servicePartCode.indexOf('Service'); //retrieve the starting index of the occurence of 'Service'
                var serviceName = servicePartCode.substr(0, n + 7).trim(); //retrieve service name ending from the first occurance of whitespace
                var partNo = servicePartCode.substr(n + 7).trim(); //retrieve partNo
                var addNewRow = ajaxNewRowInfo(serviceName, partNo);  //call ajaxNewRowInfo function 
                addNewRow.success(function(data)
                {

                    if (countIdx <= rowIndex)
                    {
                        var arrayElement = ['input', 'input', 'textarea', 'input'];
                        part_id.push(data[4]);
                        service_id.push(data[5]);
                        for (var i = 0; i < (data.length - 4); i++) //omit displaying of part_qty,stock_lvl_por,service_id,part_id
                        {
                            var selectCell = $('#mytable tbody>tr').eq(countIdx).children('td:nth-child(' + (i + 2) + ')');
                            $(selectCell).children(arrayElement[i]).val(data[i]);

                        } //for    
                        countIdx++;



                    }

                });//addNewRow tag
            }//if end tag
        });//click function tag    

//---------------------------------------------------------------------------------------

//line total for each row is calculated when there are changes to unit price and qty
        $('tbody>tr>td>input').on('change', function() {
            $('tbody  > tr').each(function()
            {
                var qty = $(this).find('.qty').val();
                var unitprice = $(this).find('.unitprice').val();
                if (qty !== '' && unitprice !== '')
                {
                    var total = qty * unitprice;
                    var total2 = parseInt('' + (total * 100)) / 100;
                    $(this).find('.linetotal').val(total2);
                }
            }); //end of each tag
        });//end of on change tag

//---------------------------------------------
//----Caculate subtotal amount from line totals in all rows

        $('tbody > tr').find('.qty').on('change', function() {
            var totalAmt = 0;
            $('tbody > tr').each(function()
            {
                totalAmt = Number(totalAmt);
                var linetotal = $(this).find('.linetotal').val();

                if (linetotal !== '')
                {
                    totalAmt += Number(linetotal); //raw total amt
                    var totalAmtToString = totalAmt.toString(); //convert int to string
                    var subtotalDeciIndx = totalAmtToString.indexOf('.');
                    var subtotal2 = totalAmtToString.substring(0, (subtotalDeciIndx + 3)); //retrieve the subtotal up to 2 dp without rounding up
                    $('#totAmt').val(subtotal2); //display subtotal

                    //------------Calculate Grand total and discount
                    var grandtotal = totalAmt * 1.06; //raw grandtotal
                    var grandtotal2 = parseInt('' + (grandtotal * 100)) / 100;
                    var grandtotalToString = grandtotal.toString(); //convert int to string
                    var grandtotalIdx = grandtotalToString.indexOf('.');
                    var dis = grandtotalToString.charAt((grandtotalIdx + 3));
                    var discount = "0.0" + dis;

                    $('#grandtotal').val(grandtotal2);
                    $('#discount').val(discount);

                }//if tag
            });//each tag

        });//on change tag
//------------------------------------------------------
//check stock for all rows

        $('tbody>tr>td').find('span').hide();
        $('tbody>tr>td>input.qty ').on('change', function() {
            var trSelector = $(this).parents('tr'); //find its tr parent
            var userqty = trSelector.find('.qty').val();
            var servicePartcode = trSelector.find('.servicePartCode').val();
            var n = servicePartcode.indexOf('Service'); //retrieve the starting index of the occurence of 'Service'
            var serviceName = servicePartcode.substr(0, n + 7).trim(); //retrieve service name ending from the first occurance of whitespace
            var partNo = servicePartcode.substr(n + 7).trim(); //retrieve partNo
            var retrieveQty = ajaxNewRowInfo(serviceName, partNo);  //call ajaxNewRowInfo function
            retrieveQty.success(function(data)
            {
                var partQty = data[6];
                if (partQty >= Number(userqty)) //sufficient stock
                {
                    trSelector.find('span').switchClass('glyphicon-remove', 'glyphicon-ok');
                    trSelector.find('span').show();
                }
                else //insufficent stock
                {
                    trSelector.find('span').switchClass('glyphicon-ok', 'glyphicon-remove');
                    trSelector.find('span').show();
                }

            });//success function

        });//onchange tag

        //-------Insert values from table rows into database tables---------------
        function ajaxInsertQuotationItem(qty, line_total, part_no, service_name, service_id, part_id, item_no, quotation_no)
        {
            $.ajax({
                async:false,
                type: "POST",
                dataType: 'json',
                url: "InsertQuotationItem.php",
                data: {qty: qty,
                    price_charged: line_total,
                    part_id: part_id,
                    part_no: part_no,
                    service_id: service_id,
                    service_name: service_name,
                    item_no: item_no,
                    quotation_no: quotation_no

                }
            }); //ajax
        }//ajax function end tag

        function ajaxInsertQuotation(grandtotal, gst)
        {

            $.ajax({
                async: false,
                type: "POST",
                dataType: 'json',
                url: "InsertQuotation.php",
                data: {
                    total_amt_charged: grandtotal,
                    gst: gst,
                }
            }); //ajax
            return true;
        }//ajax end tag

        function ajaxDecresePartQuantity(partNo, newQty) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "DecreasePartQuantity.php",
                data: {
                    part_no: partNo,
                    part_qty: newQty
                }
            }); //ajax
        }

        $('#submit').on('click', function()
        {
            var grandtotal = $('#grandtotal').val();
            var gst = $('#gst').val();
            var hasInsertQuotation = false;
            var item_no = 0;


            if (grandtotal && grandtotal != 0)
                hasInsertQuotation = ajaxInsertQuotation(grandtotal, gst);
            else
                hasInsertQuotation = false;


            $("#submit").attr("disabled", true);
          

            $('tbody>tr').each(function() {
                var rowIndex = $(this).index();

                var servicePartcode = $.trim($(this).find('.servicePartCode').val());
                if (servicePartcode.length > 0) { //when values exist in rows
                    item_no++; //for quotation_item table
                    var n = servicePartcode.indexOf('Service'); //retrieve the starting index of the occurence of 'Service'
                    var serviceName = servicePartcode.substr(0, n + 7).trim(); //retrieve service name ending from the first occurance of whitespace
                    var partNo = servicePartcode.substr(n + 8).trim(); //retrieve partNo
                    var linetotal = $(this).find('.linetotal').val();
                    var qty = $(this).find('.qty').val();
                    var retrieveUserQty = ajaxNewRowInfo(serviceName, partNo);  //call ajaxNewRowInfo function
                    retrieveUserQty.success(function(data)
                    {
                        var partQty = data[6];
                        var newQty = partQty - qty;
                        ajaxDecresePartQuantity(partNo, newQty); //decrease part quantity
                    });

                    if (hasInsertQuotation) { //when values have been inserted into quotation table 

                        //--Retrieve recent quotation number    
                        $.ajax({
                            async: false,
                            type: "POST",
                            dataType: 'json',
                            url: "GetQuotationNumber.php",
                            success: function(data)
                            {

                                ajaxInsertQuotationItem(qty, linetotal, partNo, serviceName, service_id[rowIndex], part_id[rowIndex], item_no, data); //Insert values into quotation_item table   

                            }//success end tag



                        }); //ajax end tag


                    }//if tag

                } else {

                    return false; //break out of each function //if there is empty row values
                }

            });//each tag


        });//onclick tag


        //Validate empty fields
        $('#submit').on('click', function()
        {


            var isCheck = false;
            $('tbody > tr').each(function()
            {
                var servicePartCode = $(this).find('.servicePartCode').val();
                var unitPrice = $(this).find('.unitprice').val();
                var qty = $(this).find('.qty').val();


                var resetStyle = {
                    'outline': '',
                    'border-color': '',
                    'box-shadow': ''
                };
                $(this).find('.unitprice').css(resetStyle);
                $(this).find('.qty').css(resetStyle);
                $(this).find('.servicePartCode').css(resetStyle);
                $(this).find('.itemName').css(resetStyle);
                $(this).find('.dscrp').css(resetStyle);
                $(this).find('.unitprice').css(resetStyle);
                $(this).find('.linetotal').css(resetStyle);
                var styles =
                        {
                            'outline': 'none',
                            'border-color': 'red',
                            'box-shadow': '0 0 1px red'

                        };

                if (servicePartCode != "" && unitPrice == "" && qty == '') //unitprice and qty empty
                {
                    $(this).find('.unitprice').css(styles);
                    $(this).find('.qty').css(styles);


                } //if
                else if (servicePartCode != "" && qty == "" && unitPrice != '')//qty empty
                {
                    $(this).find('.linetotal').css(styles);
                    $(this).find('.qty').css(styles);
                }
                else if (servicePartCode != "" && unitPrice == "" && qty != '')//unitprice empty
                {
                    $(this).find('.linetotal').css(styles);
                    $(this).find('.unitprice').css(styles);
                }

                else if (servicePartCode == '' && qty != "" && unitPrice != '')//servicePart empty
                {
                    $(this).find('.servicePartCode').css(styles);
                    $(this).find('.itemName').css(styles);
                    $(this).find('.dscrp').css(styles);
                }
                else if (servicePartCode == '' && unitPrice != "" && qty == '')//servicePart and qty empty
                {
                    $(this).find('.servicePartCode').css(styles);
                    $(this).find('.itemName').css(styles);
                    $(this).find('.dscrp').css(styles);
                    $(this).find('.qty').css(styles);
                    $(this).find('.linetotal').css(styles);

                }
                else if (servicePartCode == '' && unitPrice == "" && qty != '')//servicePart and price empty
                {
                    $(this).find('.servicePartCode').css(styles);
                    $(this).find('.itemName').css(styles);
                    $(this).find('.dscrp').css(styles);
                    $(this).find('.unitprice').css(styles);
                    $(this).find('.linetotal').css(styles);

                }


                else if (servicePartCode == '' && unitPrice == "" && qty == '') {//servicepart,qty,price empty
                    isCheck = false;

                } else {

                    isCheck = true;
                    alert('Customer Quotation Submitted!');

                }

            }); //each function
         
        }); //click function



        //Reset fields
        $('#resetBtn').on('click', function() {

            var resetStyle = {
                'outline': '',
                'border-color': '',
                'box-shadow': ''
            };

            $('#totAmt').val('');
            $('#grandtotal').val('');
            $('#totAmt').val('');

            $('tbody > tr').each(function()
            {
                $(this).find('.unitprice').css(resetStyle);
                $(this).find('.qty').css(resetStyle);
                $(this).find('.servicePartCode').css(resetStyle);
                $(this).find('.itemName').css(resetStyle);
                $(this).find('.dscrp').css(resetStyle);
                $(this).find('.unitprice').css(resetStyle);
                $(this).find('.linetotal').css(resetStyle);

            });

            countIdx = 0;//reset counter for inserting service row
            var attr = $('#submit').attr('disabled');
            if (typeof attr !== typeof undefined && attr !== false)
            {
                $("#submit").removeAttr("disabled");
            }


            $('tbody > tr').each(function()
            {
                var chkbox = $(this).find('.chkbox').is(":checked");
                var servicePartCode = $(this).find('.servicePartCode').val();
                var itemName = $(this).find('.itemName').val();
                var dscrp = $(this).find('.dscrp').val();
                var unitPrice = $(this).find('.unitprice').val();
                var qty = $(this).find('.qty').val();
                var lineTotal = $(this).find('.linetotal').val();

                if (servicePartCode != "" || chkbox != false || itemName != "" || dscrp != "" ||
                        unitPrice != "" || qty != "" || lineTotal != "")
                {
                    $(this).find('.chkbox').attr('checked', false);
                    $(this).find('.servicePartCode').val('');
                    $(this).find('.itemName').val('');
                    $(this).find('.dscrp').val('');
                    $(this).find('.unitprice').val('');
                    $(this).find('.qty').val('');
                    $(this).find('.linetotal').val('');
                    $(this).find('span').hide();

                }
            });


        });//onclick tag


    });//document end tag



</script>

<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li><a href="#">Sales</a></li>
    <li><a href="salesPage.php">Car Information</a></li>
    <li><a href="salesExistingCus.php">Existing Customer</a></li>
    <li class="active">Quotation</li>
</ol>
<?php
echo '<div class="headerJobSheet">';

echo '<div class="col-sm-3">';
echo '<div class="well well-sm">Car Plate Number: ' . $plate_no . "</div>";
echo '</div>';

echo '<div class="col-sm-2">';
echo '<div class="well well-sm">Model: ' . $car_model . '</div>';
echo '</div>';

echo '<div class="col-sm-6" >';
echo '<div class="well well-sm remarkHeaderJobSheet" style="margin-right:30px;">Remark: ' . $remark . '</div>';
echo '</div>';
echo '</div>';
?>
<div class="inputJobsheet">

    <h1><u>Quotation </u></h1>
    <div class="quotationSearch">
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-1 control-label">Services</label>
            <div class="col-sm-4">

                <select id='dropDownService' class="form-control">
                    <option></option>
                    <?php $service->getServicewithPartCode($conn); ?>
                </select>
            </div>
        </div>

        <div class="invoiceBtn">
            <button type="submit" id="addBtn" class="btn btn-success" >Add</button>
        </div>

        <!--Add rows -->
        <div class="form-group">
            <label  class="col-sm-1 control-label" id='rowlabel' >Rows</label>
            <input class="form-control"  type='text' id='getnumRows' placeholder='No.of Rows'>
            <button type="submit" id="add" class="btn btn-success" >Add rows</button>
        </div>
        <!------------->

        <!-- Delete specific rows-->
        <div class="form-group">
            <button type="submit" id="del" class="btn btn-success" >Delete rows</button>
            <p id='delrownote'><i ><Strong>Note: </strong>Check on the box to delete specific rows </i></p>
        </div>
        <!-------------------------->

    </div>


    <table class="table table-bordered" id="mytable">
        <thead>
            <tr>
                <th></th>
                <th class="col-sm-3">Item</th>
                <th class="col-sm-2">Item Name</th>
                <th class="col-sm-3">Description</th>
                <th class="col-sm-1">Unit Price</th>
                <th class="col-sm-1">Qty</th>
                <th class="col-sm-3">Line Total</th>
                <th class="col-sm-2">Stock Level</th>
            </tr>
        </thead>

        <tbody>
            <tr  class='rows'>
                <td><input type="checkbox" class='chkbox'/></td>  
                <td><input class="form-control servicePartCode"  disabled/></td>
                <td> <input type="text" class="form-control itemName"  disabled></td>
                <td><textarea type='text' rows="4" cols="40" class="form-control dscrp" disabled /></textarea></td>
                <td> <input type="text" class="form-control unitprice" ></td>
                <td> <input  class="form-control qty" ></td>               
                <td> <input  class="form-control linetotal" disabled ></td>
                <td class="stock">  <span class="glyphicon glyphicon-remove icon " aria-hidden="true" class='stockicon' ></span></td>
            </tr>

            <tr  class='rows'>
                <td><input type="checkbox" class='chkbox'/></td>  
                <td><input class="form-control servicePartCode"  disabled/></td>
                <td> <input type="text" class="form-control itemName"  disabled></td>
                <td><textarea type='text' rows="4" cols="40" class="form-control dscrp" disabled /></textarea></td>
                <td> <input type="text" class="form-control unitprice" ></td>
                <td> <input  class="form-control qty" ></td>               
                <td> <input  class="form-control linetotal" disabled ></td>
                <td class="stock">  <span class="glyphicon glyphicon-remove icon " aria-hidden="true" class='stockicon'></span></td>
            </tr>

            <tr  class='rows'>
                <td><input type="checkbox" class='chkbox'/></td>  
                <td><input class="form-control servicePartCode"  disabled/></td>
                <td> <input type="text" class="form-control itemName"  disabled></td>
                <td><textarea type='text' rows="4" cols="40" class="form-control dscrp" disabled /></textarea></td>
                <td> <input type="text" class="form-control unitprice" ></td>
                <td> <input  class="form-control qty" ></td>               
                <td> <input  class="form-control linetotal" disabled ></td>
                <td class="stock">  <span class="glyphicon glyphicon-remove icon " aria-hidden="true" class='stockicon'></span></td>
            </tr>

            <tr  class='rows'>
                <td><input type="checkbox" class='chkbox'/></td>  
                <td><input class="form-control servicePartCode"  disabled/></td>
                <td> <input type="text" class="form-control itemName"  disabled></td>
                <td><textarea type='text' rows="4" cols="40" class="form-control dscrp" disabled /></textarea></td>
                <td> <input type="text" class="form-control unitprice" ></td>
                <td> <input  class="form-control qty" ></td>               
                <td> <input  class="form-control linetotal" disabled ></td>
                <td class="stock">  <span class="glyphicon glyphicon-remove icon " aria-hidden="true" class='stockicon'></span></td>
            </tr>

            <tr  class='rows'>
                <td><input type="checkbox" class='chkbox'/></td>  
                <td><input class="form-control servicePartCode"  disabled/></td>
                <td> <input type="text" class="form-control itemName"  disabled></td>
                <td><textarea type='text' rows="4" cols="40" class="form-control dscrp" disabled /></textarea></td>
                <td> <input type="text" class="form-control unitprice" ></td>
                <td> <input  class="form-control qty" ></td>               
                <td> <input  class="form-control linetotal" disabled ></td>
                <td class="stock">  <span class="glyphicon glyphicon-remove icon " aria-hidden="true" class='stockicon'></span></td>
            </tr>



        </tbody>

    </table>

    <label for="inputPassword3" class="col-xs-1" id='subTotal' >Subtotal:</label>
    <div class="col-sm-2">
        <input type="text" id='totAmt' class="form-control" value='0'  placeholder="$0" disabled>
    </div>

    <label class="col-xs-1" id='gstlabel' >GST : </label>

    <div class="col-sm-1">
        <input type="text" id='gst' class="form-control" value='0.06'  disabled>
    </div>
    <label class="col-xs-1" id='grandtot' >Grand total : </label>
    <div class="col-sm-2">
        <input type="text" class="form-control" id="grandtotal" value='0'disabled>
    </div>

    <div class=quoteBtn">
        <a type="submit" href='../inventoryPage/inventoryPO.php' class="btn btn-default" id='creatPurchaseOrder'> Create Purchase Order </a>
        <a type="submit"  id='resetBtn' class="btn btn-default" >Reset</a>
        <a type="submit"  id='submit' class="btn btn-success" >Submit</a>
        <a type="submit" href='deliveryPage.php' id='nextBtn' class="btn btn btn-default" >Done</a>
    </div>

</div>

</div>

<?php
include '../homeFooter.php';
