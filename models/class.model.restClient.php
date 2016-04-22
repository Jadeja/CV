<?php
session_start();
 /**
 * class.model.restClient.php
 *
 * The purpose of the file is to connect with client site or website using API. we connect with client site using client secret information.
 *
 * PHP version 5.3
 *
 
 * @author  Kuldeepsingh Jadeja <k01715147@live.tees.ac.uk>
 
 * @version SVN:1.0
 
 */
include "class.model.common.php";
//console.log("in class");

if ( isset( $_GET[ 'code' ] ) )
{
	response();	
}
else
{
	die( 'code is not available' );
}

 

 	function response()
	{	
		if ( isset( $_GET[ 'code' ] ) ) 
		{
		  if ( false == isset( $_GET[ 'state' ] ) )
			die( 'Warning! State variable missing after authentication' );
		  
		  if ( $_GET[ 'state' ] != $_SESSION[ 'wpcc_state' ] )
			die( 'Warning! State mismatch. Authentication attempt may have been compromised.' );
		 
		  $curl = curl_init( requestTokenURL );
		  curl_setopt( $curl, CURLOPT_POST, true );
		  curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'client_id' => clientID,
			'redirect_uri' => redirectURL,
			'client_secret' => clientSecret,
			'code' => $_GET[ 'code' ], // The code from the previous request
			'grant_type' => 'authorization_code'
		  ) );
		 
		  curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1); 
		  $auth = curl_exec( $curl );
		  //var_dump($auth);
		  $secret = json_decode( $auth );
		  $_SESSION['secret']   = $secret->access_token;
		  print_r($secret);
		  
		  		   
		   //phpinfo();
		 // header( "Location: http://localhost/CVCoach/#dashboard");
		  exit();		
		}
	}
	
	function connect()
	{
		$curl = curl_init(requestTokenURL);
		curl_setopt( $curl, CURLOPT_POST, true );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
			'client_id' => clientID,
			'redirect_uri' => redirectURL,
			'client_secret' => clientSecret,
			'code' => $_GET['code'], // The code from the previous request
			'grant_type' => 'authorization_code'
		) );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1);
		$auth = curl_exec( $curl );
		$secret = json_decode($auth);
		$message = "test";
		
		console.log($secret);
		$access_key = $secret->access_token;
		echo json_encode(array('action'=>'retClient','html'=>'test', 'console.log'=>$secret));
	}
?>