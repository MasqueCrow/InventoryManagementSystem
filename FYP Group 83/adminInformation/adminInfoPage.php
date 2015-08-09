<?php

include '../homeHeader.php';

require '../database/Mydb.php';
?>
<script src="validation.js"></script>

<script>
        $(document).ready(function() {
        $.validate({
            modules: 'security',
            onModulesLoaded: function() {
                var optionalConfig = {
                    fontSize: '12pt',
                    padding: '4px',
                    bad: 'Very bad',
                    weak: 'Weak',
                    good: 'Good',
                    strong: 'Strong'
                };

                $('input[name="pass"]').displayPasswordStrength(optionalConfig);

            }
        });

        function insertUserInformation(name, contactno, username, pass, accesslvl, jobrole) {

            $.ajax({
                type: 'POST',
                url: 'handleRegAcc.php',
                data:
                        {
                            name: name,
                            username: username,
                            password: pass,
                            contact: contactno,
                            accesslevel: accesslvl,
                            job_role: jobrole
                        },
                success: function(data)
                {
                    alert(data);

                    //Reset values in form fields
                    $(':input').val('');
                    $('#aclvl').val('');
                    $('.messageerror').html('<p></p>');
                    $('.strength-meter').hide();
                }

            });

        }

        $('#sbtBtn').on('click', function()
        {
            $('.strength-meter').show();
            
            //Input fields are validated
            if (checkselection() && checkcfmpass() && checkpass() && checkusername() && checkname() && checkcontact())
            {

                var name = $('#name').val();
                var contactno = $('#contact').val();
                var username = $('#username').val();
                var pass = $('#pass').val();
                var accesslvl = $('#aclvl').val();
                var jobrole = $('#aclvl').children(':selected').text();
                insertUserInformation(name, contactno, username, pass, accesslvl, jobrole);
            }

        });


    });
</script>

<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li class="active">User Information</li>

</ol>



<div class="adminInfo">
    <form  class="form-horizontal">
        <h2> User Information </h2>
        <div class="form-group">
            <label class="col-sm-5 control-label">Name: </label>
            <div class="col-sm-3">

                <input type="text" onkeyup="javascript:checkname();"  data-validation="server" data-validation-url="validate-input.php" id="name" name="user" class="form-control"  placeholder="Name">
                <div class='messageerror' id="nameErr"></div>

            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-5 control-label">Contact: </label>
            <div class="col-sm-3">
                <input type="text" onkeyup="javascript:checkcontact();" id="contact" class="form-control" placeholder="Contact">
                <div class='messageerror' id="contactErr"></div>

            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-5 control-label">Username: </label>
            <div class="col-sm-3">
                <input type="text" onkeyup="javascript:checkusername();" id="username" class="form-control" placeholder="Username">

                <div class='messageerror' id="usernameErr"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-5 control-label">Password: </label>
            <div class="col-sm-3">
                <input type="password" onkeypress="javascript:checkpass();" id="pass" class="form-control" placeholder="Password" name='pass' data-validation="strength" data-validation-strength="2" >
                <div class='messageerror' id="passErr"></div>
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-5 control-label">Confirm Password: </label>
            <div class="col-sm-3">
                <input type="password" onkeyup="javascript:checkcfmpass();" id="cfmpass" class="form-control" placeholder="Password">
                <div class='messageerror' id="cfmpassErr"></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-5 control-label">Job Position: </label>
            <div class="col-sm-3">
                <select onchange="javascript:checkselection();" class="form-control" id="aclvl">
                    <option value="0">---</option>
                    <option value='1'>Administrator</option>
                    <option value="2">Director</option>
                    <option value="3">Clerk</option>
                    <option value="4">Mechanic</option>
                </select>
                <div class='messageerror' id="aclvlErr"></div>

            </div>
        </div>





        <center>
            <a  onclick="javascript:registeruser();" id='sbtBtn'name="submit" class="btn btn-default" style=" padding: 5px 5px 5px 5px;">Submit </a>

        </center>
    </form>

</div>



<?php

include '../homeFooter.php';
