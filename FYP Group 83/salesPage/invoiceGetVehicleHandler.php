<?php
include '../homeHeader.php';
include '../database/myDb.php';
include './salesDbfunctions.php';
?>

<!--Create a new class -->
<?php 
$vc = new VehicleCategory(); 

?>

<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li class="active">Car Information</li>
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
(function( $ ) {
$.widget( "custom.combobox", {
_create: function() {
this.wrapper = $( "<span>" )
.addClass( "custom-combobox" )
.insertAfter( this.element );
this.element.hide();
this._createAutocomplete();
this._createShowAllButton();
},
_createAutocomplete: function() {
var selected = this.element.children( ":selected" ),
value = selected.val() ? selected.text() : "";
this.input = $( "<input>" )
.appendTo( this.wrapper )
.val( value )
.attr( "title", "" )
.addClass( "custom-combobox-input " )
.autocomplete({
delay: 0,
minLength: 0,
source: $.proxy( this, "_source" )
})
.tooltip({
tooltipClass: "ui-state-highlight"
});
this._on( this.input, {
autocompleteselect: function( event, ui ) {
ui.item.option.selected = true;
this._trigger( "select", event, {
item: ui.item.option
});
},
autocompletechange: "_removeIfInvalid"
});
},
_createShowAllButton: function() {
var input = this.input,
wasOpen = false;
$( "<a>" )
.attr( "tabIndex", -1 )
.attr( "title", "Show All Items" )
.tooltip()
.appendTo( this.wrapper )
.button({
icons: {
primary: "ui-icon-triangle-1-s"
},
text: false
})
.removeClass( "ui-corner-all" )
.addClass( "custom-combobox-toggle ui-corner-right" )
.mousedown(function() {
wasOpen = input.autocomplete( "widget" ).is( ":visible" );
})
.click(function() {
input.focus();
// Close if already visible
if ( wasOpen ) {
return;
}
// Pass empty string as value to search for, displaying all results
input.autocomplete( "search", "" );
});
},
_source: function( request, response ) {
var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
response( this.element.children( "option" ).map(function() {
var text = $( this ).text();
if ( this.value && ( !request.term || matcher.test(text) ) )
return {
label: text,
value: text,
option: this
};
}) );
},
_removeIfInvalid: function( event, ui ) {
// Selected an item, nothing to do
if ( ui.item ) {
return;
}
// Search for a match (case-insensitive)
var value = this.input.val(),
valueLowerCase = value.toLowerCase(),
valid = false;
this.element.children( "option" ).each(function() {
if ( $( this ).text().toLowerCase() === valueLowerCase ) {
this.selected = valid = true;
return false;
}
});
// Found a match, nothing to do
if ( valid ) {
return;
}
// Remove invalid value
this.input
.val( "" )
.attr( "title", value + " didn't match any item" )
.tooltip( "open" );
this.element.val( "" );
this._delay(function() {
this.input.tooltip( "close" ).attr( "title", "" );
}, 2500 );
this.input.autocomplete( "instance" ).term = "";
},
_destroy: function() {
this.wrapper.remove();
this.element.show();
}
});
})( jQuery );



    $(document).ready(function() {
       
        function getVehicle()
        {
                $.ajax({
                    async:true,
                    type: "POST",
                    dataType: 'json',
                    url: "ajaxSearchPlateNo.php",
                    success: function(data)
                    {
                        
                       var $platenos = $("#platenoComboBox").empty();
                       $platenos.append("<option value=''>      </option>");
                        $.each(data, function() {
                            $platenos.append("<option value="+this+">" + this+ "</option>");
                            
                          });
                          
                        $("#carNumber").autocomplete
                            ({
                              delay:0,
                              source: data
                             });
                            

                    } //success
                }); //ajax
            

        } //getVeh function
        
        getVehicle();
        $("#nextBtn").click(function() {

            var carNumber = $('#carNumber').val();
            var carMake = $('#carMake').val();
            var carModel = $('#carModel').val();
            var remark = $('#remark').val();
            if ((carNumber !='') && (carMake!='') && (carModel !='') && (remark !='')) {
                $('#nextBtn').attr('disabled', false);
                window.location.href = 'selectQuotationInvoice.php';
            } else {
                $('#nextBtn').attr('disabled', true);
                alert("Please search for car plate number before proceeding.");
            }
        });

        /* Highlight keytyped search term */
        $.ui.autocomplete.prototype._renderItem = function(ul, item) {
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
 
 function getCarInformation(userplatenovalue)
    {
     $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "AjaxCarInformation.php" ,
                    data:{plateno:userplatenovalue},
                     success: function(data)
                    {
                       $('#platenoComboBox').val(data[0]);
                       $('#carModel').val(data[1]);
                       $('#carMake').val(data[2]);
                       $('#remark').val(data[3]);
                    
                    }   
                    
                          });
                          
    }
 
$('#searchBtn').on('click',function(){
    var userplatenovalue=$('#platenoComboBox').val();
    getCarInformation(userplatenovalue);
$('#nextBtn').attr('disabled', false);
    
    
    }); //click function end tag
        
        
        
        
    });//document ready end tag 




</script>
<!--Side Nav Bar -->
<?php include'SideNavBar.html'; ?>

<div class="poTransaction form-horizontal">
    <!-- Return the current script executed-->
   
        <h2> Car Information </h2>

        <div class="form-group">
            <label class="col-sm-5 control-label">Car Plate Number</label>
            <div class="col-sm-5" >
                <div class="ui-widget">
                    <select id="platenoComboBox" name='plateno'>  
                        
                    </select>
                  
                </div>
                <button class="btn btn-default" id='searchBtn' style="margin-top:5%;">Search</button>

            </div>

        </div>


        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Car Make</label>
            <div class="col-sm-6">
        <input class="form-control" id='carMake' style='font-size:14px;' type='text' value="" readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Car Model</label>
            <div class="col-sm-6">
                <input class="form-control" id='carModel' style='font-size:14px;' type='text' value=""  readonly>               
            </div>
        </div>  

        <div class="form-group">
            <label for="inputPassword3"  class="col-sm-5 control-label">Remark</label>
            <div class = "col-sm-6">
                <textarea  id='remark' class="form-control" rows="3" readonly >

                </textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">

                <a  type="submit" class="btn btn-default" id='nextBtn' style="margin-left:32.5%; padding: 5px 20px 5px 20px;">Next</a>

            </div>
        </div>
    
</div>


<?php
include '../homeFooter.php';
