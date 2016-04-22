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
		if(empty($value))
		{
			$message = "Missing data from the form";
			echo json_encode(array('success'=>false, 'message'=>$message));
			exit();
		}//close missing field condition
	}
	//close for loop
	
		$dbh = new PDO('mysql:host=localhost;dbname=k0171514', 'root',''); 
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
		//$Query = $dbh->query("select id from cvs where uid='".$ds."'");
		
		$s_query = "select id from cvs where uid=:uid and master=1";
		$Query 	 = $dbh->prepare($s_query); // for master templates
		$Query->bindParam(':uid',$ds,PDO::PARAM_INT); 
		$result = $Query->execute();
		$row = null;
		
		$lastId = false;
		if (!($row = $Query->fetch(PDO::FETCH_ASSOC)))
		{
			$sql 	= "insert into cvs(id,uid,master,title,date) values('','".$ds."','1','Master','".sysNow."')";
			$r = $dbh->exec($sql); 
			$lastId = $dbh->lastInsertId();	
		}
		else
		{
			 /*** echo number of columns ***/
			$sql 	= "insert into cvs(id,uid,master,title,date) values('','".$ds."','','newCV','".sysNow."')";
			$r = $dbh->exec($sql); 
			$lastId = $dbh->lastInsertId(); 		
		}
		
		if (!$lastId)
		{				
			$msg =  "CV id not available" ;			
			$dbh = null;
			echo json_encode(array('success'=>false,'message' => $msg));
			exit();
		}
		else
		{
			
			$sql = "insert into analysis(id,cvid,requirements,active,timestamp) values('','".$lastId."','".serialize($formValue)."','1','".sysNow."')";
			$dbh->exec($sql);
			$dbh = null;
			echo json_encode(array('success'=>true,'description'=>$sql));
			exit();							
			
		}//close num rows 0 conditional
}

?>
