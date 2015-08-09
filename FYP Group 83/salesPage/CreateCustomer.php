<?php
include '../homeHeader.php';
?>
<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li class="active">Car Information</li>
</ol
>
<!--Side Nav Bar -->
<?php include'SideNavBar.html';
?>
<script>

    $(document).ready(function() {


        function createCustomer(plateNo, carMake, carModel, carRemarks, firstname, lastname,
                contact1, contact2, email, add1, add2, add3, dob, cusRemark) {
                 
            $.ajax({type: "POST",
                url: 'registerCustomer.php',
                data:
                        {
                            plateNo: plateNo,
                            carMake: carMake,
                            carModel: carModel,
                            carRemark: carRemarks,
                            firstname: firstname,
                            lastname: lastname,
                            contact1: contact1,
                            contact2: contact2,
                            email: email,
                            add1: add1,
                            add2: add2,
                            add3: add3,
                            dob: dob,
                            cusRemark: cusRemark
                        },
                        success:function(){
                alert('Customer Created!');        
                }

            });

        }

        $('#createCus').on('click', function() {

            //initialise empty string fields
            var plateNo = '',
                    carMake = '',
                    carModel = '',
                    carRemarks = '',
                    firstname = '',
                    lastname = '',
                    contact1 = '',
                    contact2 = '',
                    email = '',
                    add1 = '',
                    add2 = '',
                    add3 = '',
                    dob = '',
                    cusRemark = '';

            plateNo = $('#plateNo').val();
            carMake = $('#carMake').val();
            carModel = $('#carModel').val();
            carRemarks = $('#carRemarks').val();
            firstname = $('#firstname').val();
            lastname = $('#lastname').val();
            contact1 = $('#contact1').val();
            contact2 = $('#contact2').val();
            email = $('#email').val();
            add1 = $('#add1').val();
            add2 = $('#add2').val();
            add3 = $('#add3').val();
            dob = $('#dob').val();
            cusRemark = $('#cusRemark').val();
 
            if (firstname != '' && lastname != '' && plateNo != '' && contact1 != '')
            {

                createCustomer(plateNo, carMake, carModel, carRemarks, firstname, lastname,
                        contact1, contact2, email, add1, add2, add3, dob, cusRemark);
            } else
            {
                alert('Please fill in the required fields!');
            }
        });
        $(':input').on('change', function() {



        });
        function retrievecustomerdetails(cus_id) {
            $.ajax({
                type: 'POST',
                url: 'getCustomer.php',
                dataType: 'json',
                data:
                        {
                            cusID: cus_id
                        },
                success: function(data) {
                    if (data[0]) {
                        alert("Getting Customer Information");
                        $('#firstname').val(data[1]);
                        $('#lastname').val(data[2]);
                        $('#contact1').val(data[3]);
                        $('#contact2').val(data[4]);
                        $('#email').val(data[5]);
                        $('#add1').val(data[6]);
                        $('#add2').val(data[7]);
                        $('#add3').val(data[8]);
                        $('#dob').val(data[9]);
                        $('#cusRemarks').val(data[10]);
                    } else {
                        alert(data[1]);
                    }
                }
            });
        }
        function carplatechecktaken() {
            var plateNo = $('#plateNo').val();
            alert(plateNo);
            $.ajax({
                type: 'POST',
                url: 'serversidevalidation.php',
                dataType: 'json',
                data:
                        {
                            plateNo: plateNo
                        },
                success: function(data) {
                    if (data[0]) {
                        $('#plateNoErr').html('<p style="color:' + data[1] + '">' + data[2] + '</p>');
                        $('#plateNo').val(data[3]);
                        $('#carMake').val(data[4]);
                        $('#carModel').val(data[5]);
                        $('#carRemarks').val(data[6]);
                        retrievecustomerdetails(data[7]);
                    }
                    else {
                        $('#plateNoErr').html('<p style="color:' + data[1] + '">' + data[2] + '</p>');
                        $('#createCus').on('click', function()
                        {

                        });

                    }
                }
            });
        }

        $('#plateNo').change(function() {
            carplatechecktaken();



        });


        //datepicker
        $(function() {
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0"

            });
            $("#dob").datepicker("option", "dateFormat", "yy-mm-dd ");
        });

    });

</script>


<div class="salesNewcustomer">  
    <form class="form-horizontal" role="form">

        <h2>New Vehicle Information</h2>
        <p style="margin-left:70%;margin-top:-3%"><i>* refers to required fields</i></p>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Car Plate No*</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="plateNo" name="plateNo" placeholder="Car Plate No">
                <div class='plateNoErr' id="plateNoErr"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Car Make*</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="carMake" name="carMake" placeholder="Car Make">
                <div class='carMakeErr' id="carMakeErr"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Car Model*</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="carModel" name="carModel" placeholder="Car Model">
                <div class='carModelErr' id="carModelErr"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Remarks</label>
            <div class = "col-sm-6">
                <textarea class="form-control" id="carRemarks" name="carRemarks" rows="3"></textarea>
            </div>
        </div>



        <h2> New Customer Information </h2>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">First Name*</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                <div class='carModelErr' id="firstnameErr"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Last Name*</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name">
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Contact Number 1*</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="contact1" name="contact1"  placeholder="Handphone">
                <div class='carModelErr' id="contact1Err"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Contact Number 2 </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="contact2" name="contact2" placeholder="House phone">
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Email </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Address</label>
            <div class="col-sm-6" >
                <input type="text" class="form-control" id="add1" name="add1" placeholder="Street name" style="margin-bottom: 5px">
                <input type="text" class="form-control" id="add2" name="add2" placeholder="Block Number | Unit Number" style="margin-bottom: 5px"> 
                <input type="text" class="form-control" id="add3" name="add3" placeholder="Postal Code">
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">D.O.B</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="dob" name="dob" placeholder="DDMMYY">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Remark</label>
            <div class = "col-sm-6">
                <textarea class="form-control" id="cusRemark" name="cusRemark" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">

                <a type="submit" class="btn btn-default" id='createCus'  style="margin-left:32%; padding: 5px 20px 5px 20px;">Create</a>

            </div>
        </div>
    </form>
</div>

<?php
include '../homeFooter.php';
