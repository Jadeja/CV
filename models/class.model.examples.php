<?php
include "class.model.common.php";
error_reporting(E_ERROR);

if(!empty($_GET['title']) && isset($_GET['title']) && isset($_SESSION["UserID"]))
{	
	save($Host, $User, $DBPassword, $DBName);
}
else
{
	echo json_encode(array('success'=>false,'msg'=>"wrong action"));
	exit();
}

function save($Host, $User, $DBPassword, $DBName)
{
//COLLECT POST data//For loop must be closed at the top of your script before carrying on with the query
	$formValue=array();
	$ds =  $_SESSION["UserID"];

	
		$dbh = new PDO('mysql:host=localhost;dbname=k0171514', 'root',''); 
		//$Query = $dbh->exec("select id from cvs where uid=:uid and master=1");		
		$s_query = "select id from cvs where uid=:uid and master = '1'";
		$Query 	 = $dbh->prepare($s_query); // for master templates		
		$Query->bindParam(':uid',$ds,PDO::PARAM_INT); 
		$result = $Query->execute();
		
		if (!$result)
		{
			$message = "Please first analyse your job requirements";
			echo json_encode(array('success'=>false, 'message'=>$message));
			exit();	
		}
		else
		{
			
			$sql2 	= $dbh->prepare("select id,examples from samples where title = :title"); // to check if record exists or not			
			$sql2->bindParam(':title',$_GET['title'],PDO::PARAM_STR);
			$data = $sql2->execute(); 
			if(!$data)
			{
				$msg =  "Examples not available" ;			
				$dbh = null;
				echo json_encode(array('success'=>false,'message' => $msg));
				exit();
			}
			else
			{	$r = $sql2->fetch(PDO::FETCH_ASSOC);
				$msg  = "successful" ;			
				echo json_encode(array('success'=>true,'examples'=> $r['examples'],'message' =>$msg));
				$dbh  = null;
				exit();
			}
			
		}
		
}

?>
