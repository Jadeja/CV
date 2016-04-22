<?php
include "class.model.common.php";
error_reporting(E_ERROR);
DBConnect();
$action = $_GET['action'];

if(!empty($_GET['action']) && isset($_GET['action']) && $action == "save" && isset($_SESSION["UserID"]))
{
	save($Host, $User, $DBPassword, $DBName);
}
else
{
	echo json_encode(array('success'=>false,'message'=>"wrong action"));
	exit();
}

function save($Host, $User, $DBPassword, $DBName)
{
//COLLECT POST data//For loop must be closed at the top of your script before carrying on with the query
	$formValue=array();
	$ds =  $_SESSION["UserID"];
	foreach ($_POST as $key => $value) 
	{
		$formValue[$key] = strip_tags($value);
		if(empty($value) && $key != 'end')
		{
			$message = "Missing data from the form";
			echo json_encode(array('success'=>false, 'msg'=>$message));
			exit();
		}//close missing field condition
	}
	//close for loop
	
		$dbh = new PDO('mysql:host=localhost;dbname=k0171514', 'root',''); 
		$s_query = "select id from cvs where uid=:uid and master = '1'";
		$Query 	 = $dbh->prepare($s_query); // for master templates
		$Query->bindParam(':uid',$ds,PDO::PARAM_INT); 
		$result = $Query->execute();
		
		if (!($row = $Query->fetch(PDO::FETCH_ASSOC)))
		{
			$message = "Please first analyse your job requirements";
			echo json_encode(array('success'=>false, 'message'=>$message));
			exit();	
		}
		else
		{
			 /*** echo number of columns ***/
			$sql 	 = "insert into work_exp(id,cvid,organisation,town,county,position,start,end,description) ";
			$sql    .= "values('','".$row["id"]."','".$formValue['organisation']."','".$formValue['town']."','".$formValue['county']."',";
			$sql    .= "'".$formValue['position']."','".$formValue['start']."','".$formValue['end']."','".$formValue['desc']."')";
			$r = $dbh->exec($sql); 
			$lastId = $dbh->lastInsertId(); 
			$dbh = null;
			echo json_encode(array('success'=>true));
			exit();					
		}
}

?>
