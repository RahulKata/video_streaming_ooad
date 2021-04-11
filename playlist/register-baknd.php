<?php 
require_once('connection.php');
trimvarible(); //call in connection.php
//check email not repeat when anytype of login it may gmail, facebook, normallogin 

if(isset($_POST['signupusername'])) //login
{
	$signupusername = $_POST['signupusername'];
	 
	$signuppassword = $_POST['signuppassword'];
	  
	
	$q2= $con->prepare("SELECT username, password FROM userlogin WHERE username=?");
	$q2->execute([$signupusername]);
	
	if($res = $q2->fetch())
	{
		$_SESSION['alertmessage'] = 'Already Register';
		header('location: hello.htm');
	}
	else
	{
		$q=$con->prepare('INSERT INTO userlogin(username, password)VALUES(?,?)');
		$q->execute([$signupusername, $signuppassword]);

		if($q)
		{
			$_SESSION['alertmessage'] = 'Register Successfully';
				
		}
		else
		{
			$_SESSION['alertmessage'] = "Not register ! Check again";
		}
		header('location: hello.htm');
	}	
}
 
?>