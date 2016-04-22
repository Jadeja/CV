<?php
include "class.model.common.php";
//session_start();
error_reporting(E_ERROR);
DBConnect();


if(!empty($_GET['stream']) && isset($_GET['stream']))
{
	streamInfo($Host, $User, $DBPassword, $DBName);
}
else if(!empty($_GET['get']) && isset($_GET['get']) && isset($_SESSION["UserID"]))
{
	get($Host, $User, $DBPassword, $DBName);
}
else
{
	echo json_encode(array('success'=>false,'message'=>"wrong action"));
	exit();
}

function streamInfo($Host, $User, $DBPassword, $DBName)
{
//COLLECT POST data//For loop must be closed at the top of your script before carrying on with the query
	$formValue=array();
	foreach ($_POST as $key => $value) 
	{
		$formValue[$key] = strip_tags($value);
		if(empty($value))
			{
				$message = "Please select the option";
				echo json_encode(array('console.log'=>'missing data from the form', 'success'=>false, 'message'=>$message));
				exit();
			}//close missing field condition
	}
	//close for loop

	    //Make connection
		$Link = mysqli_connect($Host, $User, $DBPassword, $DBName);
		//Query for email And PassWord. Select 1 record, where email is equal to VAR.
		$Query = "SELECT a.description FROM advises a join template t on t.id = a.templateId and t.stream = '".$formValue['stream']."' WHERE a.title = 'analysesStep1'";
		$Result = mysqli_query($Link,$Query);

		//Check that the table contains the user name entered
		$num_rows = mysqli_num_rows($Result);
		//$PassWordMatch = mysqli_fetch_array($Result);
		$Row = mysqli_fetch_array($Result);
		
		if ($num_rows==0)
		{
			//Deliver String Variable For User Not Recognised
			$error = "information not available" ;
			echo json_encode(array('success'=>false,'message'=>$error, 'console.log'=>$Query));
			exit();		
		}
		else
		{
			if (!$Row)
			{				
				$error =  "information not available" ;				
				echo json_encode(array('success'=>false,'message' => $Result));
				exit();
			}
			else
			{
				$_SESSION['stream'] = $formValue['stream'];
				$desc = $Row['description'];
				echo json_encode(array('success'=>true,'description'=>$desc));
				exit();				
			}//close password match conditional
			
		}//close num rows 0 conditional
}




function get($Host, $User, $DBPassword, $DBName)
{
//COLLECT POST data//For loop must be closed at the top of your script before carrying on with the query
	
	    //Make connection
		$Link = mysqli_connect($Host, $User, $DBPassword, $DBName);
		//Query for email And PassWord. Select 1 record, where email is equal to VAR.
		$Query = "select a.requirements from cvs c join analysis a on c.id = a.cvid where uid='".$_SESSION["UserID"]."' and master = '1'";
		
		$Result = mysqli_query($Link,$Query);

		//Check that the table contains the user name entered
		$num_rows = mysqli_num_rows($Result);
		
		$Row = mysqli_fetch_array($Result);
		
		if ($num_rows==0)
		{
			//Deliver String Variable For User Not Recognised
			$error = "information not available" ;
			echo json_encode(array('success'=>false,'message'=>$error, 'console.log'=>$Query));
			exit();		
		}
		else
		{
			if (!$Row)
			{				
				$error =  "information not available" ;				
				echo json_encode(array('success'=>false,'message' => $Result));
				exit();
			}
			else
			{				
				$requirements = unserialize($Row['requirements']);
				echo json_encode(array('success'=>true,'requirements'=>$requirements));
				exit();				
			}//close password match conditional
			
		}//close num rows 0 conditional
}
?>
