<?php
error_reporting(E_ERROR);
include "class.model.common.php";
checkLoggedIn();
DBConnect();
//$Link = mysqli_connect($Host, $User, $Password, $DBName);


	$action = $_GET['action']; 
	
	if($action=="getTrip"){
	
	getTrip($Host, $User, $Password, $DBName, $table_1, $table_2, $table_3);	
	
	}
	elseif($action=="getTripSectors"){
	
	getTripSectors($Host, $User, $Password, $DBName, $table_1, $table_2, $table_3);
	
	}

	// GET TRIP FUNCTION 
	
	function getTrip($Host, $User, $Password, $DBName, $table_1, $table_2, $table_3 ){
	
		$Link = mysqli_connect($Host, $User, $Password, $DBName);
		
		
		$Query = "SELECT * FROM $table_2";
		
		if($Result = mysqli_query($Link, $Query)){
		
		//For each category	
		$array_trip = array();	
		
		$n=1;
		while($row = mysqli_fetch_array($Result)){
		
		//Get the data for the category
		$trip_id = $row['trip_id'];
		$tripTitle = $row['tripTitle'];
		$tripDesc = $row['tripDesc'];
		$createDate = $row['createDate'];
		
		//Create an array object 
		$array_trip[] = $n.': '.$tripTitle;

		
		
		$n++;	
		}//close while loop
		
		//Send data to the Controller
		
		echo json_encode(array('action'=>'success','tripData'=>$array_trip, 'console.log'=>$Query));
		 
		exit();
		
		}else{
		
		//Send Error for the first query
		echo json_encode(array('action'=>'mysql error', 'console.log'=>$Query));
		exit();
	
	}//close condition
	
	}//Close Function

	// GET SECTORS FUNCTION

	function getTripSectors($Host, $User, $DBPassword, $DBName, $table_1, $table_2, $table_3 ){

		$Link = mysqli_connect($Host, $User, $DBPassword, $DBName);
		
		
		
		$Query = "SELECT * FROM $table_3 WHERE trip_id = '1'";
		
		if($Result = mysqli_query($Link, $Query)){
		
		$array_sectors = array();
		
		while($row = mysqli_fetch_array($Result)){
		
		//Get the data for the category
		$sectors_id = $row['sectors_id'];
		$startTime = $row['startTime'];
		$startDate = $row['startDate'];
		$startAirport = $row['startAirport'];
		
		$endTime = $row['endTime'];
		$endDate = $row['endDate'];
		$endAirport = $row['endAirport'];
		
		$carrierCode = $row['carrierCode'];
		$flightNumber = $row['flightNumber'];
		
		
		
		//Create an array object 
		$array_sectors[] = 'Sector: '.$sectors_id. '
		Start Time:'.$startTime. '
		Start Date:'.$startDate.'
		Start Airport:'.$startAirport;
		
		
		
		
		}//close while loop
		
		//Send data to the Controller
		
		echo json_encode(array('action'=>'success','sectorsData'=>$array_sectors, 'console.log'=>$Query2));
		exit();
		
		}else{
		
		//Send Error for the first query
		echo json_encode(array('action'=>'mysql error', 'console.log'=>$Query));
		exit();
		
		}//close condition
		
		}//Close Function	

?>