function usernamechecktaken() {
    var username = $('#username').val();
    $.ajax({
        
        type: 'POST',
        url: 'serversidevalidation.php',
        dataType: 'json',
        data:
                {
                    username: username
                },
        success: function(data) {

            $('#usernameErr').html('<p style="color:' + data[1] + '">' + data[0] + '</p>');
        }

    });

    $('#usernameErr').html("<p style='color:orange'>Processing...</p>");

}

function checkname() {
    var str = $('#name').val();
    if (str.length < 5) {
        $('#nameErr').html("<p style='color:red'>Name too short.</p>");
        return false;

    } else {
        if (/^[A-Za-z\s]{1,}[\.]{0,1}[A-Za-z\s]{0,}$/.test(str) == false) {
            $('#nameErr').html("<p style='color:red'>No Special Characters Allowed</p>");
            return false;

        } else {
            $('#nameErr').html("<p style='color:#14ff00'>Name is Valid.</p>");
            return true;
        }
    }
}

function checkusername() {
    var username = $('#username').val();
    if (username.length < 8) {
        $('#usernameErr').html("<p style='color:red'>Min 8 Characters Alphanumeric</p>");
        return false;
    } else {
        if (/^[a-zA-Z0-9-]*$/.test(username) == false && /^\s+$/.test(username == true)) {
            $('#usernamedErr').html("<p style='color:red'>No Special Characters or Spaces Allowed</p>");
            return false;
        } else {

            usernamechecktaken();
            return true;
        }
    }

}

function checkpass() {
    var str = $('#pass').val();
    if (str.length < 8) {
        $('#passErr').html("<p style='color:red'>Min 8 Characters Alphanumeric</p>");
        return false;
    } else {
        if (/^[a-zA-Z0-9-]*$/.test(str) == false || /^\s+$/.test(username == true)) {
            $('#passErr').html("<p style='color:red'>No Special Characters or Spaces Allowed.</p>");
            return false;
        } else {
            $('#passErr').html("<p style='color:#14ff00'>Password is Valid.</p>");
            return true;
        }
    }
}

function checkcfmpass() {
    var value1 = $('#pass').val();
    var value2 = $('#cfmpass').val();
    if (value1 == value2) {
        $('#cfmpassErr').html("<p style='color:#14ff00'>Password Confirmed.</p>");
        return true;
    } else {
        $('#cfmpassErr').html("<p style='color:red'>Re-type Password.</p>");
        return false;
    }
}

function checkselection() {
    var value1 = $('#aclvl').val();
    if (value1 > 0) {
        $('#aclvlErr').html("<p style='color:#14ff00'>Level Selected</p>");
        return true;
    } else {
        $('#aclvlErr').html("<p style='color:red'>Please Select Access Level.</p>");
        return false;
    }
}

function checkcontact() {
    var contact = $('#contact').val();
    if (contact.length < 8) {
        $('#contactErr').html("<p style='color:red'>Min 8 numbers.</p>");
        return false;
    } else {
        if (/^[a-zA-Z0-9-]*$/.test(contact) == false || /^\s+$/.test(contact == true)) {
            $('#contactErr').html("<p style='color:red'>No Special Characters or Spaces Allowed.</p>");
            return false;
        } else {
            $('#contactErr').html("<p style='color:#14ff00'>Number is Valid.</p>");
            return true;
        }
    }
}

