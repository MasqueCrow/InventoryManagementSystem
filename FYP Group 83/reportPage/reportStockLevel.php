<?php
// 
include '../homeHeader.php';

$name = $_SESSION['name'];
?>

<link rel="stylesheet" type="text/css" href="reportStockStyleSheet.css">

<script>
    $(document).ready(function()
    {
        var num_supplier_id;
        var po_item_no = 1;
        var checked_supplier_id;
        var otable = $("#example").dataTable();    //Select datatable
        var successretrievePartSupplierCategoryInfo;
//---------------------------------------------------

        function retrievePartSupplierCategoryInfo() {
            return  $.ajax({
                url: "RetrievePartSupplierCategoryInfo.php",
                dataType: 'json',
                type: "POST"
            });//ajax end tag
        }
        function retrieveMake() {
            return  $.ajax({
                url: "RetrieveMake.php",
                dataType: 'json',
                type: "POST"
            });//ajax end tag


        }
        function retrieveModel() {
            return  $.ajax({
                url: "RetrieveModel.php",
                dataType: 'json',
                type: "POST"
            });//ajax end tag


        }

        function retrievePartName() {
            return  $.ajax({
                url: "RetrievePartName.php",
                dataType: 'json',
                type: "POST"
            });//ajax end tag

        }
//-------------------------------

//Populate Dropdown Menu

        var successRetrieveMake = retrieveMake();
        successRetrieveMake.success(function(data) {
            $.each(data, function() {

                $('#car_make').append('<option>' + this['make'] + '</option>');

            });
        });

        var successRetrieveModel = retrieveModel();
        successRetrieveModel.success(function(data) {
            $.each(data, function() {

                $('#car_model').append('<option>' + this['model'] + '</option>');
            });
        });





        var successRetrievePartName = retrievePartName();
        successRetrievePartName.success(function(data) {
            $.each(data, function() {
                $('#part_name').append('<option>' + this['part_name'] + '</option>');

            });
        });



//--Dropdown menu to show bar graph 
        $('.drop_down_graph').change(function()
        {

            // Reset input object values
            inputs = {
                part_no: '',
                part_name: '',
                make: '',
                model: ''
            };

            //Retrieve values from dropdown menus
            var carmake = $('#car_make').val();
            var carmodel = $('#car_model').val();
            var partname = $('#part_name').val();
            var partcategory = $('#part_category').val();
            var prev = [];

            //Define a record object
            inputs = {
                'part_no': partcategory,
                'part_name': partname,
                'make': carmake,
                'model': carmodel
            };


            //Query PartSupplierCategoryInfo and assign success callback function
            successretrievePartSupplierCategoryInfo = retrievePartSupplierCategoryInfo();


            //Retrieve data after successful callback function        
            successretrievePartSupplierCategoryInfo.success(function(data)
            {

                //initalise an empty array for storing data for displaying bargraph
                var arrayOfDataMulti = [];


                //Iterate through data index-associative array
                for (var i = 0; i < data.length; i++)
                {
                    //initialise a boolean check variable
                    var ismatch = true;

                    //iterate through all input values
                    $.each(inputs, function(prop, value) {

                        //match input values with data values                          
                        if (value !== '' && data[i][prop].indexOf(value) == -1) {

                            ismatch = false;


                        }//end if tag

                    });// end each tag

                    if (ismatch)
                    {

                        var qtyarray2 = [];
                        if (prev != data[i]['part_no'] && prev != '') {

                            qtyarray2.push(data[i]['part_qty'], data[i]['stock_lvl_por']);
                            arrayOfDataMulti[i] = [qtyarray2, data[i]['part_no']];
                        }
                        prev = data[i]['part_no'];

                    }

                }//end of for tag


                var tempo = new Array();
                var j = 0;
                for (var i = 0; i < arrayOfDataMulti.length; i++)
                {
                    if (arrayOfDataMulti[i]) {

                        tempo[j] = arrayOfDataMulti[i];
                        j++;
                    }

                }


                $('#DivforGraph').html(''); //reset graph during dynamic change    
                $('#DivforGraph').jqBarGraph
                        ({
                            sort:'asc',
                            data: tempo,
                            colors: ['#437346', '#b20000'],
                            legends: ['Item stock', 'Reorder point'],
                            legend: true,
                            legendWidth: 130,
                            width: 1000,
                            speed: 2,
                            type: 'multi'


                        });//jqBarGraph tag 

            });//  successretrievePartSupplierCategoryInfo end tag
            
            
            //Hide graph for empty dropdown menu values selected
            if (!$('#part_category').val() && !$('#part_name').val() && !$('#car_make').val() && !$('#car_model').val()) {
                
                $('#DivforGraph').hide();
            } else {
                $('#DivforGraph').show();
            }

        });//onchange tag


//------------------------------Populate DataTable--------------------------------

        //Query PartSupplierCategoryInfo and assign success callback function
        successretrievePartSupplierCategoryInfo = retrievePartSupplierCategoryInfo();

        //Retrieve data after successful callback function       
        successretrievePartSupplierCategoryInfo.success(function(data)
        {


            $('#example').DataTable({
                destroy: true,
                bDeferRender: false,
                "createdRow": function(row) {
                    $('td:eq(7)', row).html('<input type="text" style="margin-left:30px;width:90px;" class="form-control purchaseQty">');
                    $('td:eq(8)', row).html('<input type="text" style="width:80px;" value="0.06" disabled class="form-control gst">');
                    $('td:eq(9)', row).html('<input type="text"  style="width:100px;" disabled class="form-control linetotal">');
                    $('td:eq(10)', row).html('<input type="checkbox"  class="setChecked form-control">');
                },
                'data': data,
                "columns":
                        [
                            {"data": ['supplier_id']},
                            {"data": function(data) {

                                    return data['first_name'] + ' ' + data['last_name'];
                                }},
                            {"data": ['part_no']},
                            {"data": ['part_name']},
                            {"data": ['part_qty']},
                            {"data": ['stock_lvl_por']},
                            {"data": ['cost_price']},
                            //Purchase Quantity
                            {"data": function() {
                                    return '';
                                }},
                            //GST S                                 
                            {"data": function() {
                                    return '';
                                }},
                            //Line Total
                            {"data": function() {
                                    return '';
                                }},
                            //Checkbox
                            {"data": function() {
                                    return '';
                                }}

                        ]
            }).draw();//datatable end tag

            //------------Compute linetotal-----------------------
                      
            //Retrieve all TR node
             var rows = otable.fnGetNodes();
             
             //Iterate thru all tr nodes including invisible nodes
            for (var i = 0; i < rows.length; i++) {  
            var totalAmt = 0;
            $(rows[i]).find('.purchaseQty').on('change', function() {


                var costprice = Number($(this).parent().parent().children('td:eq(6)').html());
                var gst = $(this).parent().parent().find('.gst').val();
                var purchasequantity = $(this).val();

                totalAmt = (costprice * purchasequantity) * gst + (costprice * purchasequantity);
                //Remove leading decimals
                var trimtotalAmt = (Math.floor(100 * totalAmt) / 100).toFixed(2);

                $(this).parent().parent().find('.linetotal').val(trimtotalAmt);


            });//onchange tag
                }
                
            //------------------User checkox----------------------------


            //Iterate thru all tr nodes including invisible nodes
            for (var i = 0; i < rows.length; i++) {

                $(rows[i]).find('.setChecked').on('change', function()
                {

                    if ($(this).is(':checked'))
                    {
                        //Get supplier_id from current checked row              
                        var current_supplier_id = $(this).parent().parent().children().eq(0).html();

                        //assign supplier_id to globalevariable
                        checked_supplier_id = current_supplier_id;

                        //Iterate thru table rows
                        for (var i = 0; i < rows.length; i++)
                        {
                            var pos = otable.fnGetPosition(rows[i]);
                            //Get supplier_id from table row 
                            var supplier_id = otable.fnGetData(pos)['supplier_id'];

                            //Hide row when checked supplier_id not equal to supplier_id in rows
                            if (supplier_id != current_supplier_id)
                            {
                                $(rows[i]).hide();
                            }//if tag
                        }//for tag


                    }//if tag
                    else
                    {
                        //Show all unchecked rows    
                        for (var i = 0; i < rows.length; i++)
                        {
                            $(rows[i]).show();
                        }//for tag

                    }//else tag

//---------Display Company Name in Modal dialog-----------------------------

                    //Convert retrieved string supplier_id to integer
                    num_supplier_id = parseInt(checked_supplier_id);
                    var successgetSupplierInfo = getSupplierInfo(num_supplier_id);
                    successgetSupplierInfo.success(function(data)
                    {


                        $('#companyName').val(data);

                    });//success end tag          


                });//onchange tag
            }//for tag



        });//success end tag



        //-----------Show modal dialog------------------------

        function getSupplierInfo(num_supplier_id)
        {
            return  $.ajax({
                data: {
                    supplier_id: num_supplier_id
                },
                url: "SupplierInfo.php",
                dataType: 'json',
                type: "POST"
            });//ajax end tag

        }



        function getCurrentDate()
        {
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            var outputDate = d.getFullYear() + '/' +
                    (month < 10 ? '0' : '') + month + '/' +
                    (day < 10 ? '0' : '') + day;
            return outputDate;
        }

        $('#exampleModal').on('show.bs.modal', function()
        {
            //Set name
            var username = '<?php echo $name; ?>';
            $('#name').val(username);

            //Set Current Date   
            var todayDate = getCurrentDate();
            $('#dateCreation').val(todayDate);

        });


        //-----------Ajax function for Quotation---------------       
        function insertPurchaseOrder(supplier_id, date_creation, po_status, remark, name)
        {

            $.ajax({
                async: false,
                type: "POST",
                dataType: 'json',
                url: "InsertPurchaseOrder.php",
                data: {
                    supplier_id: supplier_id,
                    date_creation: date_creation,
                    po_status: po_status,
                    remark: remark,
                    order_by: name

                }

            }); //ajax

        }




        function retrievePurchaseOrderNo()
        {
            var purchase_no;
            $.ajax({
                async: false,
                type: "POST",
                dataType: 'json',
                url: "RetrievePurchaseOrderNo.php",
                success: function(data) {
                    purchase_no = data;
                }
            }); //ajax
            return purchase_no;

        }




        function  insertPoItem(purchase_order_no, part_no, purchase_qty, line_total)
        {

            if (!isNaN(line_total) && !isNaN(purchase_qty))
            {

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "insertPoItem.php",
                    data: {
                        purchase_order_no: purchase_order_no,
                        part_no: part_no,
                        line_total: line_total,
                        purchase_qty: purchase_qty,
                        po_item_no: po_item_no

                    }
                }); //ajax
                po_item_no++;
            }


        }


//-------------Submit Purchase Order--------------------------
        $('#sbtBtn').on('click', function()
        {
            //values from Purchase Order form
            //var companyName = $('#companyName').val();
            var date_creation = $('#dateCreation').val();
            var po_status = $('#poStatus').val();
            var remark = $('#remark').val();
            var name = $('#name').val();
            var supplier_id = num_supplier_id;


            if (supplier_id != '' && date_creation != '' && po_status != '' && remark != '' && name != '') {


                //Insert values into Purchase Order
                insertPurchaseOrder(supplier_id, date_creation, po_status, remark, name);

                //Get PurchaseOrderNo
                var purchase_order_no = parseInt(retrievePurchaseOrderNo());

                //Get array of TR nodes
                var rows = otable.fnGetNodes();
                var showSubmitAlert = false;
                var showNotSubmitAlert = false;
                for (var i = 0; i < rows.length; i++)
                {

                    //Find checkedrows
                    if ($(rows[i]).find('.setChecked').prop('checked'))
                    {
                        var pos = otable.fnGetPosition(rows[i]);
                        //Retrieve part_no,cost_price,purchase,linetotl for Purchase_Line_Item
                        var part_no = otable.fnGetData(pos)['part_no'];
                        var purchase_qty = parseInt($(rows[i]).find('.purchaseQty').val());
                        var line_total = parseFloat($(rows[i]).find('.linetotal').val());
                        if (!isNaN(purchase_qty) && !isNaN(line_total))
                        {

                            //Insert Po item
                            insertPoItem(purchase_order_no, part_no, purchase_qty, line_total);

                            if (showSubmitAlert == false)
                            {
                                alert(purchase_qty + " " + line_total);
                                alert('Purchase Order Submitted!');
                                showSubmitAlert = true;
                            }
                        }
                        else
                        {
                            if (showNotSubmitAlert == false)
                            {
                                alert(purchase_qty + " " + line_total);
                                alert('Purchase Order Not Submitted!');
                                showNotSubmitAlert = true;
                            }
                        }




                    }//if tag

                }//for tag


            }//if tag 
            else
            {
                alert('Purchase Order Not Submitted!');
            }


        });//onclick tag

//----------------Reset fields-------------------
$('#resetBtn').on('click',function()
{  
    //Retrieve all TR nodes
    var rows = otable.fnGetNodes();
    //iterate rows in table
   for(var i=0;i<rows.length;i++)
   {
       
       //Get supplier_id from table row 
       var linetotal = $(rows[i]).find('.linetotal');
       var purchaseQty = $(rows[i]).find('.purchaseQty');
       var checkbox=$(rows[i]).find('.setChecked');

       if(checkbox.is(':checked') || linetotal.val()!='' || purchaseQty.val()!='')
       {
        linetotal.val('');
        purchaseQty.val('');
        checkbox.attr('checked',false);
       }//if tag
          
       
   
   }//for tag
});



    });//document ready tag
</script>



<!-------------------------------Modal Dialog--------------------------------->

<div class="modal fade bs-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-bigmenu ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Create Purchase Order</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="control-label">Company Name and Contact:</label>
                        <input type="text" id='companyName'  class="form-control col-sm-2" >


                    </div>
                    <div >
                        <label for="Date_Of_Creation" class="control-label">Date of Creation:</label>
                        <input type='text'  class="col-sm-2 form-control" id='dateCreation'  placeholder='YYY/MM/DD' />

                    </div>

                    <div>
                        <label for="PO Status"  class="control-label">PO Status</label>
                        <input type="text" id="poStatus" value='sent' name="po_status" class="form-control col-sm-2" >                       
                    </div>

                    <div>
                        <label for="Order_By" class="control-label">Order By</label>
                        <input type="text" id='name'  class="form-control col-sm-2" name="order_by" placeholder="Enter Your Name">
                    </div>

                    <div >
                        <label for="Remark" class="control-label">Remark</label>
                        <textarea id='remark' class="form-control col-sm-2" name="remark"rows="3"></textarea>

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id='sbtBtn' class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
<!----------------------------------------------------------------------------->
<div id='dropdownMenus'>

    <label id="part_no_label">Part No Category:</label>
    <select  id='part_category' class="drop_down_graph" >
        <option></option>
        <?php
        $alphabet_array = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        echo $alphabet_array;
        for ($i = 1; $i <= count($alphabet_array); $i++) {

            echo'<option value="' . $alphabet_array[($i - 1)] . '">' . $alphabet_array[($i - 1)] . '</option>';
        }
        ?>       
    </select>

    <label id='part_name_label'>Part Name</label>
    <select   style='margin-top:5%' id="part_name" class='drop_down_graph'>
        <option ></option>

    </select>


    <label id='car_make_label'>Car Make</label>

    <select  id="car_make" class='drop_down_graph ' >
        <option ></option>
    </select>


    <label id='car_model_label'>Car Model</label>
    <select id="car_model" class='drop_down_graph'>
        <option ></option>

    </select>
</div>
<div id="DivforGraph" > </div>

<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Supplier id</th>
            <th>Supplier Name</th>
            <th>Part No</th>
            <th>Part Name</th>
            <th>Part Quantity</th>
            <th>Reorder Point</th>
            <th>Cost Price</th>
            <th>Purchase Quantity</th>
            <th>GST</th>
            <th>Line Total</th>
            <th>Checkbox</th>
        </tr>
    </thead>


</tbody>
</table>



<a  type="submit" id='purchaseOrder' href="#myModal"  data-toggle="modal" data-target="#exampleModal"  class="btn btn-default" >Make Purchase Order</a>
<a  type="submit" id='resetBtn' class="btn btn-default" >Reset</a>
<a  type="submit" href="../homePage/Homepage.php" id='exitBtn' class="btn btn-default" >Exit</a>

<?php
include '../homeFooter.php';
