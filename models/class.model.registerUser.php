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

if($action=="register")
{	
	registerUser($Host, $User, $DBPassword, $DBName, $table_1,$specialKey);
}


function registerUser($Host, $User, $DBPassword, $DBName, $table_1,$sKey)
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
			echo json_encode(array('success' => false,'action'=>'error','html'=>$message));
			exit();
		}
	}

		
		if($formValue['email']!="")
		{
			$email = $formValue['email'];
			//Check if the owner has an email in the table - 
			$Query = "SELECT email FROM $table_1 WHERE email = '".$email."'";
			$Result = mysqli_query($Link, $Query);
			$Row = mysqli_fetch_array($Result);
			$email_check = $Row['email'] ;
			
		//If the owner already has data, do not allow them to add more!
		if( $email == $email_check)
		{
			$message = "Sorry, you have already created an account under this email address!";	 
			//Send Back to the Controller
			echo json_encode(array('action'=>'error','success' => false,'html'=>$message));
			exit();								
		}
 		else
		{					
		//Match not found so carry on with the registration process		
				
			$PassWord = $formValue['PassWord'];			
			//Remove All Whitespace from the string
			$PassWord = preg_replace('/\s/', '', $PassWord);
			$Query = "INSERT INTO $table_1 VALUES ('0', '".$formValue['firstN']."', '".$formValue['lastN']."', '".$email."',ENCODE('".secretKey."','".$PassWord."'),'1')";											
									
			//Has the query executed?							
			if(mysqli_query($Link, $Query))
			{
				$message = "You Have Successfully Created The Account!";	 
				//Send Back to the Controller
				echo json_encode(array('action'=>'login','success' => true, 'html'=>$message));
				exit();
				
			}//close insert query conditional 
				echo json_encode(array('action'=>mysql_error(), 'success' => false));
				
	   }//close email check conditional
	   exit();
 	}//close missing field condition

	
 //close for each


}
?>