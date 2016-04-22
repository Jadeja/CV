<?php

if($_REQUEST['action']=='check')
{
	if(!isset($_SESSION["bLoggedIn"]))
	{		
		$message = "Unauthorised";
	    echo json_encode(array('logged' => false, 'message' => $message));
	    exit;
	}
	else if($_SESSION["bLoggedIn"]!=true)
	{
		$message = "Not LoggedIn";
	    echo json_encode(array('logged' => false, 'message' => $message));
	    exit;
	}
	else
	{
		$message = "LoggedIn";
		echo json_encode(array('logged' => true, 'message' => $message));
	    exit;
	}
	return;
}

function checkSysAdminLoggedIn()
{
	global $oError, $oSession;
	if($oSession->cUserType < 5)
	{
	    $message = "Access SysAdmin - Insufficient Usertype";
	    echo json_encode(array('action' => false, 'message' => $message));
	    exit;
	}
}

function checkAdminLoggedIn()
{
	global $oError, $oSession;
	if($oSession->cUserType < 4 )
	{
	    $message = "Access Admin - Insufficient Usertype" ;
	    echo json_encode(array('action' => false, 'message' => $message));
	    exit;
	}
}

function checkLoggedIn()			//General Use for Client Users *NOT* External users
{
	global $oSession;
	if($oSession->cUserType < 1)
	{
	    $message = "Access Client System - Insufficient Usertype";
	    $oSession->LogOut();		//Just in case half logged in - zap
	    echo json_encode(array('action' => false, 'message' => $message));
		exit;	  
	}
}


?>