<?php
include '../database/myDb.php';
$sysErr="";
$username = str_replace("'", "''", $_POST['username']); //Closing single quote  sql injection
$salt = 'lianfuat'; //salt encryption
$password = str_replace("'", "''", $_POST['password']);
$password = crypt($_POST['password'], $salt);

$stmt = $conn->prepare("Select password,name,userid " .
        "From user " .
        "Where username=?");

$stmt->bind_param('s', $username);
if ($stmt->execute()) {     //check if the preprare statement is executed
    $stmt->bind_result($userpass,$name,$userid); //bind variables to prepared statement
    if ($stmt->fetch()&& $userpass == $password) { //Fetch values from prepare statement 
            header('Location:../homePage/Homepage.php'); //Password authentication success!
                                session_start();
                                $_SESSION['userid']=$userid;
                                $_SESSION['name']=$name;
				$_SESSION['user'] = $username;
				$_SESSION['password'] = $password;
                                
		}else{
			header('Location:../Index.php?errorCode="Username or Password Invalid"');
			
									}
	}else {

		header('Location:../Index.php?errorCode="SQL Error"');
			
              }
                       
?>