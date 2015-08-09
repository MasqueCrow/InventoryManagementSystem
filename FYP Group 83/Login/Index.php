<!DOCTYPE html>
<html>
    <head>
        <title>Inventory Management System </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../bootstrap/css/bootstrap.min.css" rel ="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.47/jquery.form-validator.min.js"></script>

        <?php
        $sysErr = "";
        $sysErr = $_GET['errorCode'];
        ?>

        <script type='text/javascript'>

            function getTime()
            {
                var now = new Date();
                var h = now.getHours();
                var m = now.getMinutes();
                var s = now.getSeconds();
                var date = now.getDate() + "-" + now.getMonth() + "-" + now.getFullYear();

                var day;

                switch (now.getDay()) {
                    case 0:
                        day = "Sunday";
                        break;
                    case 1:
                        day = "Monday";
                        break;
                    case 2:
                        day = "Tuesday";
                        break;
                    case 3:
                        day = "Wednesday";
                        break;
                    case 4:
                        day = "Thursday";
                        break;
                    case 5:
                        day = "Friday";
                        break;
                    case 6:
                        day = "Saturday";
                        break;
                }

                m = checkTime(m);
                s = checkTime(s);

                document.getElementById("clock").innerHTML = day + " | " + date + " | " + h + ":" + m + ":" + s;

                setTimeout("getTime()", 1000);
            }

            function checkTime(time)
            {
                if (time < 10)
                {
                    time = "0" + time;
                }

                return time;
            }

            function usernameerrormsg() {
                document.getElementById("usernameerrormsg").innerHTML = "";
            }

            function passworderrormsg() {
                document.getElementById("passworderrormsg").innerHTML = "";
            }

            function validateNull() {
                var value1 = document.getElementById("username").value;
                var value2 = document.getElementById("password").value;
                if (value1 == null || value1 == "") {
                    document.getElementById("usernameerrormsg").innerHTML = "<p style='color:orange'> Please Fill In All Fields </red></p>";
                    if (value2 == null || value2 == "") {
                        document.getElementById("passworderrormsg").innerHTML = "<p style='color:orange'> Please Fill In All Fields </red></p>";
                    } else {
                        passworderrormsg();
                    }
                } else {
                    usernameerrormsg();
                }
            }
        </script>

    </head>
    <body onload="getTime();">

        <div class ="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a href="Index.php" class ="navbar-brand">Lian Fuat Motors Works Sdn. Bhd | 聯發汽车修理有限公司</a>

                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse ">

                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <div class="collapse navbar-collapse navHeaderCollapse">



                    <ul class="nav navbar-nav navbar-right">
                        <li> <a href="../adminInformation/adminInfoPage.php">Register</a></li>
                        <li> <a href="#contact" data-toggle="modal">Contact Us</a></li>
                    </ul>
                </div>

            </div>
        </div>


        <div class="transBox">
            <div class="header">
                <h1> Data Management System</h1>

                <div class="loginContainer">

                    <form role="form" action="authenticate.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="username" name="username" id="username" class="form-control" placeholder="Username">
                            <div id="usernameerrormsg"></div>
                        </div>
                        <div class="form-group">
                            <label for="key" class="sr-only">Password</label>
                            <input onclick="javascript:validateNull();" type="password" name="password" id="password" class="form-control " placeholder="Password">
                            <div id="passworderrormsg"></div>

                            <span data-toggle="modal" style="color:red; margin-left:28%" > <?php echo $sysErr; ?></span></div>

                        <input name="submitBtn" type="submit" value="Submit" class="btn btn-default btn-lg btn-block" onclick="javascript:validateNull();"></input>
                        <!--                           <a href="homePage/Homepage.php" type="submit" id="btn-login" class="btn btn-default btn-lg btn-block">Log in</a>
                                              <input type="submit" id="btn-login" class="btn btn-default btn-lg btn-block" value="Log in">-->
                    </form>                                



                </div> <!--login Container-->
            </div> <!--header-->
        </div>

        <div class="modal fade" id ="contact" role ="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4> Contact Site </h4>
                    </div>

                    <div class="modal-body">
                        LIAN FUAT MOTOR WORKS SDN. BHD. <Br> 
                        PTD 3287 & 3288, TAMAN TUAH, 81500 PEKAN NENAS, JOHOR.<br>
                        TEL: 07-6991526, 012-7815665, 019-7769429<br>
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-default" data-dismiss ="modal"> close</a>

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id ="forgetpw" role ="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4> Find Password </h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-danger" data-dismiss ="modal"> Submit</a>
                        <a class="btn btn-default" data-dismiss ="modal"> Close</a>


                    </div>

                </div>
            </div>
        </div>


        <div class ="navbar navbar-inverse navbar-fixed-bottom">
            <div class="container">

                <ul class="nav navbar-nav navbar-left">
                    <p id='clock'></p>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li> <a href="#contact" data-toggle="modal">Copyrighted</a></li>
                </ul>
            </div>

        </div>


        <script src ="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src ="../bootstrap/js/bootstrap.js"></script>



    </body>
</html>
