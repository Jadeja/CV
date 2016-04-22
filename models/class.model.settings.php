 <?php
 /**
 * class.model.registerUser.php
 *
 * The purpose of the file is to register users of the website using their first name, last name, email address and password. This file uses JSON to encode data back to the controller.
 *
 * PHP version 5.3
 *
 
 * @author  Original Author <you@live.tees.ac.uk>
 
 * @version SVN:1.0
 
 */ 
 
 include "class.model.common.php";
 DBConnect();
	error_reporting(E_ERROR);
	
	$action = $_GET['action'];

if($action=="write")
{	
	 createRecord($Host, $User, $DBPassword, $DBName, $table_3);
}
else
{
	$message = "wrong path";
	echo json_encode(array('success' => false,'action'=>'write','html'=>$message));
	exit;
}

function createRecord($Host, $User, $DBPassword, $DBName, $table_3)
{
	$Link = mysqli_connect($Host, $User, $DBPassword, $DBName);
	//COLLECT POST data
	$formValue=array();							
	foreach ($_POST as $key => $value) 
	{
		$formValue[$key] = strip_tags($value);//remove html tags
		$formValue[$key] = str_replace("'", "&#39;", $value);//remove single quotes
		if(empty($value))
		{
			$message = "Please Fill In The Missing Field(s)!";
			echo json_encode(array('action'=>'error','html'=>$message));
			exit();
		}
	}

		
		if($formValue['web']!="")
		{					
		//Match not found so carry on with the registration process		
				
			$web = $formValue['web'];			
			//Remove All Whitespace from the string
			//$PassWord = preg_replace('/\s/', '', $PassWord);
			$Query = "INSERT INTO $table_3 VALUES ('0','".$oSession->sUserID."','".$web."')";											
									
			//Has the query executed?							
			if(mysqli_query($Link, $Query))
			{
				$message = "You Have Successfully Created The Account!".$Query;	 
				//Send Back to the Controller
				echo json_encode(array('success' => true,'action'=>'write','html'=>$message));
				exit();
				
			}//close insert query conditional 
				//echo json_encode(array('action'=>mysql_error(),'q' => $Query));
				
	   }//close email check conditional
	   exit();

 //close for each
}
?>