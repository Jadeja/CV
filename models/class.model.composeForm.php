<?php

/**
 * class.model.registerUser.php
 *
 * The purpose of the file is to register users of the website using their first name, last name, email address and password. This file uses JSON to encode data back to the view.
 *
 * PHP version 5.3
 *
 
 * @author  Original Author <you@live.tees.ac.uk>
 
 * @version SVN:1.0
 
 */
 
/*error_reporting(E_ERROR);*/




include "class.model.common.php";
DBConnect();

$action = $_GET['action'];

if($action=="save"){



composeForm($Host, $User, $Password, $DBName, $table_2);	

}


function composeForm($Host, $User, $Password, $DBName, $table_2){

$Link = mysqli_connect($Host, $User, $Password, $DBName);

//COLLECT POST data
$formValue=array();
foreach ($_POST as $key => $value) {
$formValue[$key] = strip_tags($value);//remove html tags
$formValue[$key] = str_replace("'", "&#39;", $value);//remove single quotes
	
	if($formValue[$key]==""){
	$message = "Please Fill In The Missing Field(s)!";
	echo json_encode(array('console.log'=>'missing data from the form','error'=>$message));
	exit();
	}
}

$testOutput = $testOutput.$key.": ".$formValue[$key].", ";
$Query = "INSERT INTO $table_2 VALUES ('0', '1' ,'".$formValue['tripTitle']."', '".$formValue['tripDesc']."', CURDATE(), '1')";			
						

if(mysqli_query($Link, $Query)){	

echo json_encode(array('action'=>'save','html'=>$message, 'console.log'=>$testOutput));


} else {

echo json_encode(array('action'=>'error','html'=>$message, 'console.log'=>$Query));

	
	
}

	
}






?>
