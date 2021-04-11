<?php 
require_once('connection.php');
trimvarible(); //call in connection.php
if(isset($_POST['loginusername'])) //login
{
	$loginusername = strtolower($_POST['loginusername']);
	$loginpassword = $_POST['loginpassword'];
	
	if($loginpassword == '')
	{
		$_SESSION['alertmessage'] = "Wrong Username/Password";
	}
	else
	{
		$q=$con->prepare('SELECT username, password FROM userlogin where username=? and password=?');
		$q->execute([$loginusername,$loginpassword]);

		if($res = $q->fetch())
		{
			if($res[0]==$loginusername)
			{
				$_SESSION['userloginid'] = $res[0]; //to prevent blank when register username required
				$_SESSION['alertmessage'] = '';
				header('Location:hello.htm');
				$_SESSION['profilpho'] = 'images/'.$res[4];
				if($res[4] == '')
				{
					$_SESSION['profilpho'] = 'images/loginiconblack.png'; //if no profile photo
				}
			}		 
 		}
		else
		{
			echo '<script>alert("Wrong Username/Password"); location.href="login.htm";</script>';
		}
	}
}

if(isset($_POST['logoutvar']))          //Logout request
{
	//echo 'here';
	$_SESSION["userloginid"] = '';
	session_unset();
	session_destroy();

	//echo 'logout';
	//header('location:main.html');
	
}
?>