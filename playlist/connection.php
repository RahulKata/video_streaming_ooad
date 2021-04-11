<?php
if(!isset($_SESSION))
{
	session_start();
}
date_default_timezone_set("Asia/kolkata");
ini_set('display_errors', 1);
error_reporting(E_ALL);
error_reporting(-1);

$con = new PDO('sqlite:youtube.ty');

function trimvarible() //to trim all post varible
{
	array_walk($_POST, function(& $value){
		$value = trim($value);
	});
	array_walk($_GET, function(& $value){
		$value = trim($value);
	});
}


?>