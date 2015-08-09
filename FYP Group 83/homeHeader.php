    <?php 
    include '../session/checksession.php';
    include '../database/myDB.php';
    ?> 

<html>
    <head>
        <title>Inventory Management System </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../bootstrap/css/bootstrap.min.css" rel ="stylesheet">
        <link href="../css/styleHome.css" rel="stylesheet">
        <!--<script src="jquery/jq.js" type="text/javascript"></script>-->
        <script src="../jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- Need the two lines of code below for auto-complete widget-->
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <!--Jquery Validation script link below -->
        <script src="../Validation/jQuery-Form-Validator-master/form-validator/jquery.form-validator.js"></script>
       
        <!--Jquery Bar graph plugin -->
        <script src="jqBarGraph.js"></script>
        <!--Datatable plugin -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.css">
        <script src='//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js'></script>   
        <script src='//cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js'></script>
        

       
      <script>
                    $(function() {
                        $(document).tooltip({
                            track: true
                        });
                    });

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
                if (time < 10) {
                    time = "0" + time;
                }

                return time;
            }


        </script>

    </head>
    <body onload="getTime();">
        <div class ="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <a href="../homePage/Homepage.php" class ="navbar-brand"> 聯發汽车修理有限公司 <Br>Lian Fuat Motors Works Sdn. Bhd    </a>
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse ">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>   
                <div class="collapse navbar-collapse navHeaderCollapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li> <a href="../adminInformation/DisplayUserInfo.php" data-toggle="modal"> <span class="glyphicon glyphicon-user" aria-hidden="true" style="margin-right:5px;"></span>User Information</a></li>
                        <li>  <a href="../adminInformation/adminInfoPage.php  " data-toggle="modal"> <span class="glyphicon glyphicon-plus" aria-hidden="true" style="margin-right:5px;"></span>Register User </a></li>
                        <li> <a href="../session/destroysession.php" ><span class="glyphicon glyphicon-off" aria-hidden="true" style="margin-right:5px;"></span>Log Out</a></li>
                    </ul>
                </div>
            </div>

        </div>