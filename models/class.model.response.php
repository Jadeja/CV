<?php
session_start();
date_default_timezone_set('Europe/London'); 
if ( isset( $_GET[ 'action' ] ) )
{
	$action = $_GET['action'];
	if($action == 'me')
	datap();
}
else
{
	echo json_encode(array('success'=>false,'message'=>'not implemented'));
	exit();
}


function datap()
{
	$kk = $_SESSION['me'];

	if($kk)
	{
		 $curl = curl_init( "https://public-api.wordpress.com/rest/v1/me/" );
		 curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $kk ) );
		 curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
		 $me = json_decode(curl_exec( $curl ));
		 if($me->verified)
		 print "v";
		 else
		 print "nv";
		 
		if(is_null($me))
		print("nullllll");
		else
		$_SESSION['me'] = $me;
		echo json_encode(array('success' => true,'me2'=>$me,'kk'=>$kk));
		exit();				
	}
	else
	{
		echo json_encode(array('success'=>false,'message'=>'data is not available'));
		exit();
	}
}

?>