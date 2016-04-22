<?php
include "class.model.common.php";
error_reporting(E_ERROR);
DBConnect();
$action = $_GET['action'];

if(!empty($_GET['action']) && isset($_GET['action']) && $action == "save")
{
	save();
}
else if(!empty($_GET['action']) && isset($_GET['action']) && $action == "onload")
{
	get();
}
else
{
	echo json_encode(array('success'=>false,'message'=>"wrong action"));
	exit();
}

function save()
{
//COLLECT POST data//For loop must be closed at the top of your script before carrying on with the query
	$formValue=array();
	$ds = $_SESSION["UserID"];
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
		$s_query = "select id from cvs where uid=:uid and master='1' ";
		$Query 	 = $dbh->prepare($s_query); // for master templates
		$Query->bindParam(':uid',$ds,PDO::PARAM_INT); 
		$result = $Query->execute();		
		$result2 = null;

		if (!($result2 = $Query->fetch(PDO::FETCH_ASSOC)))
		{				
			$msg =  "CV id not available" ;			
			$dbh = null;
			echo json_encode(array('success'=>false,'message' => $msg,'id'=>$ds));
			exit();
		}
		else
		{				
			$sql1 	= $dbh->prepare("select id from personal_info where cvid =:cvid"); // to check if record exists or not
			$sql1->bindParam(':cvid',$result2["id"],PDO::PARAM_INT);
			$ouput = $sql1->execute();
			$row = $sql1->fetch(PDO::FETCH_ASSOC);	


			if(!$row)
			{
	$sql2  = "insert into personal_info(id,cvid,email,addln1,addln2,town,county,postcode,country,mobile,tel) values('','".$result2['id']."','".$formValue['email']."','".$formValue['addln1']."',";
				$sql2 .= "'".$formValue['addln2']."','".$formValue['town']."','".$formValue['county']."','".$formValue['postcode']."','".$formValue['country']."',";
				$sql2 .= "'".$formValue['mobile']."','".$formValue['tel']."')";
				$dbh->exec($sql2);
				$msg = "Created";
			}
			else
			{
				$sql2 = "update personlInfo set email = '".$formValue['email']."',addln1='".$formValue['addln1']."',addln2='".$formValue['addln2']."',town='".$formValue['town']."',
				county='".$formValue['county']."',postcode='".$formValue['postcode']."',country='".$formValue['country']."',mobile='".$formValue['mobile']."',tel='".$formValue['tel']."' where cvid = ".$result['id'];				
				$dbh->exec($sql2);
				$msg = "Updated";
			}
			$dbh = null;
			echo json_encode(array('success'=>true,'msg'=>'Successfully '.$msg));
			exit();							
			
		}//close num rows 0 conditional
}

function get()
{
	$dbh = new PDO('mysql:host=localhost;dbname=k0171514', 'root',''); 
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
	$sql1 	= $dbh->prepare("select * from personal_info where cvid =:cvid"); // to check if record exists or not
	$sql1->bindParam(':cvid',$_SESSION["cvid"],PDO::PARAM_INT);
	$ouput = $sql1->execute();
	$row = $sql1->fetch(PDO::FETCH_ASSOC);
	if($row)
	{		
		$dbh = null;
		echo json_encode(array('success'=>true,'row'=>$row,'fname' => $_SESSION["sFname"],'lname' => $_SESSION["sLname"], 'email' => $_SESSION["sEmail"]));
		exit();
	}
	else
	{
		$dbh = null;		
		echo json_encode(array('success'=>false,'fname' => $_SESSION["sFname"],'lname' => $_SESSION["sLname"], 'email' => $_SESSION["sEmail"]));
		exit();
	}
}

?>
