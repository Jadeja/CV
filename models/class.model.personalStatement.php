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
	 $value = $_POST["personalStatement"];
	
		$formValue["personalStatement"] = strip_tags($value);
		if(empty($value))
		{
			$message = "Missing data from the form";
			echo json_encode(array('success'=>false, 'message'=>$message));
			exit();
		}//close missing field condition
	
	//close for loop
	
		$dbh = new PDO('mysql:host=localhost;dbname=k0171514', 'root',''); 
		$s_query = "select id from cvs where uid=:uid and master = '1'";
		$Query 	 = $dbh->prepare($s_query); // for master templates
		$Query->bindParam(':uid',$ds,PDO::PARAM_INT); 
		$result = $Query->execute();
		$row = null;
		
		if (!($row = $Query->fetch(PDO::FETCH_ASSOC)))
		{
			$message = "Please first analyse your job requirements";
			echo json_encode(array('success'=>false, 'message'=>$message));
			exit();	
		}
		else
		{
			 /*** echo number of columns ***/
			$sql 	= "insert into personal_statement(id,cvid,statement) values('','".$row["id"]."','".$formValue['personalStatement']."')";
			$r = $dbh->exec($sql); 
			$lastId = $dbh->lastInsertId(); 
			$dbh = null;
			echo json_encode(array('success'=>true,'id'=>$lastId,'sql' => $sql));
			exit();					
		}
}

?>
