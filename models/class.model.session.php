<?php
class Session
{
    var $id="";
    var $bLoggedIn=false;
    var $sUserID="";
    var $sUser="";
    var $sEmail="";
    var $cUserType="";

   public function Session($sName)
    {
	
		session_name($sName);
		session_start();
		/*  
		if(CACHE_PUBLIC==true)
    	{
    		session_cache_limiter('public');
    	}
		if(CACHE_PUBLIC==true)
    	{
			header ("Cache-Control: no-store");
			header ("Pragma: public");
    	}
		limiter, and header lines needed to prevent flash / https / ie issues */
		
		$this->id=session_id();
	
		//If the user is logged in check session id and user id to ensure not spoofed or not a duplicate
		if(isset($_SESSION["bLoggedIn"]) && $_SESSION["bLoggedIn"]==true)
		{
		    $this->bLoggedIn=$_SESSION["bLoggedIn"];
		    $this->sUserID=$_SESSION["sUserID"];
		    $this->sUser=$_SESSION["sUser"];
		    $this->sEmail=$_SESSION["sEmail"];
		    $this->cUserType=$_SESSION["cUserType"];
		    //$this->CheckIfUsed($oError);
		}
    }
	
	/*
     function CheckIfUsed($oError)
     {
		$Query="select id from sessions where session_id='$this->id' and user_id!='$this->sUserID' limit 0,1";
		$Link = mysqli_connect($Host, $User, $DBPassword, $DBName);
		//Query for email And PassWord. Select 1 record, where email is equal to VAR.
		$Result = mysqli_query($Link, $Query);
		$row    = mysql_num_rows($Result);
		
		if($row != 0)
		{
			echo json_encode(array('action' => 'login', 'message' => 'test'));
		    exit;
		}
		return;
     }

    function BootOut($oError, $log)
    {
    	$this->oError->Record("T", "Session / User Mismatch", $this->id." / ".$this->sUserID, $log);
		 //Regenerate and log out
		session_regenerate_id(true);
		$this->id=session_id();
		$this->sUserID="";
		$this->sUser="";
		$this->sEmail="";
		$this->cUserType="";
		
		$this->iOldUser="";
		$this->cOldUserType="";
	
		$this->bLoggedIn=false;
		
    }
*/

    function LogOut()
    {
		 //Regenerate and log out
		session_regenerate_id(true);
		$this->id=session_id();
		$this->sUserID="";
		$this->sUser="";
		$this->sEmail="";
		$this->cUserType="";

		
		$this->bLoggedIn=false;
		setcookie(session_name(), '', time()-42000, '/');
		session_destroy();
		return 1;
    }
	
/*
     function Debug()
     {
		echo "<pre>";
		echo var_dump($this);
		echo "</pre>\n";
     }
     
     function getDebug()
     {
     	return var_export($this,true);
     }



        function session_destruct($foSession)
        {
			$_SESSION["bLoggedIn"]=$foSession->bLoggedIn;
			$_SESSION["sUserID"]=$foSession->sUserID;
			$_SESSION["sUser"]=$foSession->sUser;
			$_SESSION["sEmail"]=$foSession->sEmail;
			$_SESSION["cUserType"]=$foSession->cUserType;
			
			$_SESSION["iOldUser"]=$foSession->iOldUser;
            $_SESSION["cOldUserType"]=$foSession->cOldUserType;
			
			custom_session_destruct($foSession);
        }
	*/
 }

?>