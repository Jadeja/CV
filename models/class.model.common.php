<?php
error_reporting(E_ERROR);
require "class.model.session.php";
require "class.model.security_fun.php";
$oSession=new Session("CVBuilder");

define('sysNow',date('Y-m-d H:i:s'));
define('sysVisitorIP',$_SERVER['REMOTE_ADDR']);
//Connection To MYSQL DataBase
define('secretKey','gwdf34jw4fs43jf943f438ampqlnfgeshgfdfdshf3e3012');
function DBConnect()
{
	//add further global vars at the end of the line below once you have created them in the database admin tool
	global $Host, $User, $DBPassword, $DBName, $table_1,$table_2,$table_3,$table_4;
	$table_1 = "users";
	$table_2 = "sessions";
	$table_3 = "cvs";
	$table_4 = "analysis";
	$table_5 = "personal_statement";

	$Host 	    = "localhost"; 
	$User 	    = "root";
	$DBPassword = "";
	$DBName     = "k0171514"; 
	//IMPORTANT!Comment out this block when connection is successful!
}//close function
?>
