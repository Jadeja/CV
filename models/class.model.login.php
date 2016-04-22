<?php
include "class.model.common.php";
//session_start();
error_reporting(E_ERROR);
DBConnect();
$action = $_GET['action'];

if($action=="login")
{
	login($Host, $User, $DBPassword, $DBName, $table_1);
}
else
{
	echo json_encode(array('success'=>false,'html'=>"wrong action"));
	exit();
}

function login($Host, $User, $DBPassword, $DBName, $table_1)
{
//COLLECT POST data//For loop must be closed at the top of your script before carrying on with the query
	$formValue=array();
	foreach ($_POST as $key => $value) 
	{
		$formValue[$key] = strip_tags($value);
		if(empty($value))
			{
				$message = "Please Fill In The Missing Field(s)!";
				echo json_encode(array('console.log'=>'missing data from the form', 'success'=>true, 'html'=>$message));
				exit();
			}//close missing field condition
	}
	//close for loop

	    //Make connection
		$Link = mysqli_connect($Host, $User, $DBPassword, $DBName);
		//Query for email And PassWord. Select 1 record, where email is equal to VAR.
		$Query = "SELECT * FROM $table_1 WHERE email = '".$formValue['email']."' and PassWord =encode('".secretKey."','".$formValue['PassWord']."')";
		$Result = mysqli_query($Link, $Query);

		//Check that the table contains the user name entered
		$num_rows = mysqli_num_rows($Result);
		//$PassWordMatch = mysqli_fetch_array($Result);
		$Row = mysqli_fetch_array($Result);
			
		
		if ($num_rows==0)
		{
			//Deliver String Variable For User Not Recognised
			$error = "Your Email Address was not recognised, please try again!" ;
			echo json_encode(array('success'=>true,'html'=>$error, 'console.log'=>$Query));
			exit();		
		}
		else
		{
			if (!$Row)
			{				
				$error = "Your Password was not valid, please try again!" ;				
				echo json_encode(array('success'=>true,'message' => $Result));
				exit();
			}
			else
			{							
				$fname 	 = $Row['firstN'];
				$lname   = $Row['lastN'];
				$name    = $fname.' '.$lname;
      			
				$_SESSION["UserID"]   = $Row['id'];$_SESSION["sUserID"]=$Row['id'];
    			$_SESSION["cUserType"]= $Row["user_type"];
    			$_SESSION["bLoggedIn"]= true;
    			$_SESSION["sUser"] 	  = $name ;
				$_SESSION["sFname"]   = $Row['firstN'];
				$_SESSION["sLname"]   = $Row['lastN'];
    			$_SESSION["sEmail"]   = $Row['email'];
				$sSQL="insert into sessions set session_id='".$oSession->id."', user_id='".$_SESSION["UserID"]."', timestamp='".sysNow."', ip='".sysVisitorIP."'";
				$Result = mysqli_query($Link, $sSQL);														
				//Free memory and close connection to DB				
				$cvSquery = "select id from cvs where master=1 and uid ='".$_SESSION["UserID"]."'";
				$res    = mysqli_query($Link,$cvSquery);
				$num    = mysqli_num_rows($res);
				$result = mysqli_fetch_array($res);
				
				$flag = false;	
				if ($num==0)
				{
					$flag = true;
					$_SESSION["cvid"] = 0;	
				}
				else
				$_SESSION["cvid"] = $result["id"];
				
				mysqli_close($Link);
				$message  = "You are now Logged In Successfully!";									
				echo json_encode(array('success'=>true,'name'=>$_SESSION["sUser"], 'action' => 'login','newUser'=>$flag,'num' => $num ,'res' => $res,'query' => $cvSquery));
				exit();				
			}//close password match conditional
			
		}//close num rows 0 conditional
}

?>
