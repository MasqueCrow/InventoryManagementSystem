<?php
include '../homeHeader.php';
$username = $_SESSION['user'];
$userid = $_SESSION['userid'];
?>
<style>
    table.sortable thead {
        background-color:#eee;
        color:#666666;
        font-weight: bold;
        cursor: default;
    }
</style>
<script src="validation.js"></script>
<script>
    $(document).ready(function() {
        function retrieveUserInfo(username)
        {

            $.ajax
                    ({
                        type: "POST",
                        url: 'RetrieveUserInfo.php',
                        data: {username: username},
                        dataType: 'json',
                        success: function(data) {

                            $('#name').val(data[3]);
                            $('#contact_no').val(data[1]);
                            $('#username').val(data[0]);
                            $('#job_role').val(data[4]);
                        }
                    });
        }

        function  updateUserInfo(userid, name, contact_no, username, prevpassword, currentpass)
        {
            $.ajax
                    ({
                        type: 'POST',
                        url: 'UpdateUserInfo.php',
                        data:
                                {
                                    name: name,
                                    contact_no: contact_no,
                                    username: username,
                                    prevpassword: prevpassword,
                                    currentpass: currentpass,
                                    userid: userid,
                                    success: function(data) {
                                        alert(data);
                                    }

                                }
                    });
        }

        var username = '<?php echo $username; ?>';
        retrieveUserInfo(username);

        $('#updateBtn').on('click', function()
        {
            var userid = '<?php echo $userid; ?>';
            var name = $('#name').val();
            var contact_no = $('#contact_no').val();
            var username = $('#username').val();
            var prevpassword = $('#prevpassword').val();
            var currentpass = $('#pass').val();
            alert(userid + " " + name + " " + contact_no + " " + username + " " + prevpassword + " " + currentpass);
            if (currentpass != '')
                updateUserInfo(userid, name, contact_no, username, prevpassword, currentpass);
            else
                alert('Password cannot be empty');

        });
    });

</script>

<ol class="breadcrumb">
    <li><a href="../homePage/Homepage.php">Home</a></li>
    <li class="active">User Information</li>

</ol>

<div class="adminInfo">
    <form class="form-horizontal" role="form">
        <h2> User Information </h2>

        <div class="form-group">
            <label  class="col-sm-5 control-label">Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id='name'  name='name' >
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-5 control-label">Contact No.</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id='contact_no'  name='contact_no'>
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Username</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id='username' name='username' >
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">Previous Password </label>
            <div class="col-sm-3">
                <input type="password" class="form-control" id='prevpassword' name='password'>
            </div>
        </div>
        <div class="form-group">
            <label for="carMake" class="col-sm-5 control-label">New Password </label>
            <div class="col-sm-3">
                <input type="password" class="form-control" onkeypress="javascript:checkpass();"  id='pass' name='password'>

                <div class='messageerror' id="passErr"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="jobrole" class="col-sm-5 control-label">Job Role</label>
            <div class="col-sm-3">
                <input disabled type="text" class="form-control" id='job_role' name='job_role'>
            </div>
        </div>
        <a   id='updateBtn' name="submit" class="btn btn-default" style=" margin-left:50.5%; padding: 5px 20px 5px 20px;">Update </a>

    </form>


</div>

<?php
include '../homeFooter.php';
