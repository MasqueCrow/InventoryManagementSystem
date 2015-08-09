<?php
include '../homeHeader.php';
include '../database/myDb.php';
//include '../salesDbfunctions.php';

$name = $_SESSION['name'];
?>

<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li class="active">Receive Payment</li>
</ol>

<style>
    .custom-combobox {
        position: relative;
        display: inline-block;
    }
    .custom-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
    }
    .custom-combobox-input {
        margin: 0;
        padding: 5px 10px;
    }
</style>
<script>
    (function ($) {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                        .addClass("custom-combobox")
                        .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("custom-combobox-input ")
                        .autocomplete({
                            delay: 0,
                            minLength: 0,
                            source: $.proxy(this, "_source")
                        })
                        .tooltip({
                            tooltipClass: "ui-state-highlight"
                        });
                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function () {
                var input = this.input,
                        wasOpen = false;
                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                            icons: {
                                primary: "ui-icon-triangle-1-s"
                            },
                            text: false
                        })
                        .removeClass("ui-corner-all")
                        .addClass("custom-combobox-toggle ui-corner-right")
                        .mousedown(function () {
                            wasOpen = input.autocomplete("widget").is(":visible");
                        })
                        .click(function () {
                            input.focus();
// Close if already visible
                            if (wasOpen) {
                                return;
                            }
// Pass empty string as value to search for, displaying all results
                            input.autocomplete("search", "");
                        });
            },
            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function (event, ui) {
// Selected an item, nothing to do
                if (ui.item) {
                    return;
                }
// Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
// Found a match, nothing to do
                if (valid) {
                    return;
                }
// Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },
            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);
    $(document).ready(function () {
        // $("#carNumber").keypress(autoCompleteSearchPlateNo);
        var invoice_no;
        function getVehicle()
        {
            $.ajax({
                async: true,
                type: "POST",
                dataType: 'json',
                url: "ajaxSearchPlateNo.php",
                success: function (data)
                {

                    var $platenos = $("#platenoComboBox").empty();
                    $platenos.append("<option value=''>      </option>");
                    $.each(data, function () {
                        $platenos.append("<option value=" + this + ">" + this + "</option>");
                    });
                    $("#carNumber").autocomplete
                            ({
                                delay: 0,
                                source: data
                            });
                } //success
            }); //ajax


        } //getVeh function

        getVehicle();
        /* Highlight keytyped search term */
        $.ui.autocomplete.prototype._renderItem = function (ul, item) {
            item.label = item.label.replace(
                    new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"),
                    "<span style='font-weight:bold;color:green;'>" + this.term + "</span>");
            return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + "</a>")
                    .appendTo(ul);
        };
        $("#platenoComboBox").combobox();
//-----------------Ajax values from car plateno textfield----------------------------


        function getInvoiceInformation(userplatenovalue)
        {
            return $.ajax({
                type: "POST",
                dataType: 'json',
                url: "AjaxSearchInvoice.php",
                data: {plateno123: userplatenovalue}
            }); //ajax
        }
        var checkInvoice = [];
        var countSearch = 0;
        var prevplatenovalue = '';

        $('#searchBtn').on('click', function ()
        {
            var userplatenovalue = $('#platenoComboBox').val();
            countSearch++;
            if (countSearch > 1)
            {

                if (userplatenovalue != prevplatenovalue)
                {
                    prevplatenovalue = userplatenovalue;
                    hiderows();
                    triggerGetInvoiceInfo(userplatenovalue);

                }

            }
            else
            {
                prevplatenovalue = userplatenovalue;
                triggerGetInvoiceInfo(userplatenovalue);

            }

        });    //click function end tag


        function hiderows()
        {
            $("#invoice-table>tbody>tr").each(function ()
            {
                // alert($(this).index());
                $(this).hide();
            });
        }



        function triggerGetInvoiceInfo(userplatenovalue)
        {
            var getInvoiceInfo = getInvoiceInformation(userplatenovalue);
            getInvoiceInfo.success(function (data)
            {
                for (var i = 0; i < data.length; i = i + 1) {
                    $("#invoice-table tbody").append(
                            "<tr>"
                            + "<td><input class='isChecked' type='checkbox' value = '" + data[i][1] + "' /></td>"
                            + "<td>" + data[i][0] + "</td>" //invoice_no
                            + "<td>" + data[i][1] + "</td>" //amt_charged
                            + "<td>" + data[i][2] + "</td>" //remarks
                            + "<td>" + data[i][3] + "</td>" //date
                            + "</tr>"
                            );

                }// for loop end


                $('input[type=checkbox]').click(function ()
                {

                    var check = $(this).prop('checked');
                    //alert (check);

                    if (check === true) {

                        //Retrieve invoice_no from selected checkbox
                        invoice_no = $(this).parent().parent().find('td:nth-child(2)').html();
                        var str_invoice_no = invoice_no.toString();

                        //When checkinvoice array is empty,insert invoice_no
                        if (checkInvoice.length == 0)
                        {
                            checkInvoice.push(str_invoice_no);
                            // console.log(checkInvoice.length);
                        } else {

                            //When invoice_no does not match invoice no in checkinvoice array
                            if (checkInvoice.indexOf(str_invoice_no) == -1)
                            {
                                checkInvoice.push(str_invoice_no);

                            }
                        }

                        //Compute grandtotal for selected checkbox rows                        
                        var p = Number(Number($('#grandtotal').val()).toFixed(2));
                        var value2 = Number($(this).val());
                        p += value2;
                        var trimtotalAmt = (Math.floor(100 * p) / 100).toFixed(2);
                        $('#grandtotal').val(trimtotalAmt);
                    } else if (check === false) {
                        var p = Number(Number($('#grandtotal').val()).toFixed(2));
                        var value2 = Number($(this).val());
                        p -= value2;
                        var trimtotalAmt = (Math.floor(100 * p) / 100).toFixed(2);
                        $('#grandtotal').val(trimtotalAmt);
                    }

                    //Calculate Discount
                    var grandtotalToString = trimtotalAmt.toString(); //convert int to string
                    var grandtotalIdx = grandtotalToString.indexOf('.');
                    var dis = grandtotalToString.charAt((grandtotalIdx + 2));
                    var discount = "0.0" + dis;
                    $('#discount').val(discount);

                    $('#amtpaid').keyup(function () {
                        var paidamt = Number($('#amtpaid').val());
                        var balance = (paidamt - $('#grandtotal').val() - $('#discount').val()).toFixed(2);
                        $('#change').val(balance);
                    });
                }); //input click end tag 


                //-----------------Update-------------------
                $('.isChecked').on('change', function ()
                {

                    if ($(this).is(':checked'))
                    {

                        $('#updateBtn').on('click', function ()
                        {
                            //Update paymt status on the no. check rows
                            for (var i = 0; i < invoice_no.length; i++)
                            {
                                UpdatePaymentStatus(invoice_no);

                            }//for tag
                            alert('Payment Status Updated!');
                        });//change tag
                    }//if tag
                }); //change tag
            }); // success end tag
        }
    }); //document ready end tag 

    function UpdatePaymentStatus(invoice_no, menu, referenceno, username)
    {
        $.ajax({
            async: false,
            type: "POST",
            url: "UpdatePaymentStatus.php",
            data: {invoiceno: invoice_no,
                paymentmode: menu,
                referenceno: referenceno,
                receivedby: username
            }
        });
    }

    $('#updateBtn').on('click', function ()
    {
        var invoice_no = $(this).parent().parent().find('td:nth-child(2)').html();
        var menu = $('#menu').val();
        var referenceno = $('#referenceno').val();
        var username = '<?php echo $name; ?>';

        UpdatePaymentStatus(invoice_no, menu, referenceno, username);

    });

    function checkOption() {
        if (document.getElementById("menu").value !== "cheque") {
            document.getElementById("referenceno").disabled = true;
        }
        else {
            document.getElementById("referenceno").disabled = false;
        }
    }
</script>

<style>

    #calculationlabel
    {
        margin-top:10%;
    }
    #noncalculationlabel
    {
        float:left;
        margin-top:-22%
    }

</style>
<!--Side Nav Bar -->
<?php include'SideNavBar.html'; ?>

<div class="poTransaction form-horizontal" >
    <h2 style="margin-left: 250px"> Receive Payment </h2>
    <div class="form-group">
        <label class="col-sm-5 control-label">Car Plate Number</label>
        <div class="col-sm-5" >
            <div class="ui-widget">
                <select id="platenoComboBox" name='plateno'>  
                </select>
            </div>
            <button type="submit" value="Submit" class="btn btn-default" id='searchBtn' style="margin-top:10px;">Search</button>
        </div>

    </div>

    <table class="table table-bordered" style="margin-left: -10px;" id="invoice-table">
        <thead>
        <th></th>
        <th class="col-sm-3">Invoice No.</th>
        <th class="col-sm-3">Amt. Charged</th>
        <th class="col-sm-3">Payment Status</th>      
        <th class="col-sm-2">Date</th>   
        </thead>

        <tbody>
        </tbody> 
    </table>

    <div class="form-group">
<!--        <form class="form-horizontal" role="form" method="POST">-->
            <div id="calculationlabel">
                <div class="form-group">
                    <label class="col-sm-7 control-label" >Grand total: </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="grandtotal" placeholder="0" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-7 control-label"  >Discount: </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="discount"  placeholder="0" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-7 control-label">Amount Paid: </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="amtpaid"  placeholder="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-7 control-label"  >Change: </label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="change" placeholder="0" disabled>
                    </div>
                </div>
            </div>
            <div id='noncalculationlabel'>

                <div class="form-group">
                    <label for="paymentmode" style='margin-left:-8%;' name="payment_mode" class="col-sm-6 control-label" >Payment Mode:</label>
                    <div class="col-sm-3" >
                        <select id='menu' name="paymentmode" onChange="checkOption()" >
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="card">Master/Visa</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reference"  name="referenceno" class="col-sm-4 control-label" >Cheq Ref No: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id='referenceno' name="refno" placeholder="Reference No." disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recievedby"  name="recievedby" class="col-sm-4 control-label" >Received by:</label>
                    <div class="col-sm-6" >
                        <input type="text" class="form-control" id='username' name="order_by" placeholder="<?php echo $name; ?>" readOnly="true">

                    </div>
                </div>
            </div>

            <div class="paymentBtn">
                <button id='updateBtn' type="submit" class="btn btn-success" style="margin-left: 370px;">Update</button>
            </div>
<!--        </form>-->
    </div>

    <!--</div>-->

    <?php
    include '../homeFooter.php';
    