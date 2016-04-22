<?php
include "class.model.common.php";
//session_start();
error_reporting(E_ERROR);
DBConnect();

if(!isset($_SESSION['sUserID']) && empty($_SESSION['sUserID']))
{
	echo json_encode(array('success'=>false,'message'=>"you are not loggedIn"));
	exit();
}
else
{
	$action=strip_tags($_GET['action']);
	get($action);
}
function get($action)
{

		$uid = $_SESSION['sUserID'];

		$dbh = new PDO('mysql:host=localhost;dbname=k0171514', 'root',''); 
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
		$s_query = "SELECT c.id, u.firstN,u.lastN,pi.email,pi.addln1,pi.addln2,pi.town,pi.county,pi.postcode,pi.country,pi.mobile,pi.tel,ps.statement from users u join cvs c on c.uid =:uid and c.master='1' join personal_info pi on pi.cvid = c.id join personal_statement ps on ps.cvid = c.id where u.id =:id";
		$Query 	 = $dbh->prepare($s_query); // for master templates
		$Query->bindParam(':uid',$_SESSION['sUserID'],PDO::PARAM_INT); 
		$Query->bindParam(':id',$_SESSION['sUserID'],PDO::PARAM_INT);
		$Result1 = $Query->execute();


	if($Result1)
	{
		$row = $Query->fetch(PDO::FETCH_ASSOC);	
		$s_query2  = "select ed.institute_name,ed.start,ed.county,ed.complete,ed.town,ed.country,ed.subject,ed.degree,ed.description from education ed where ed.cvid =".$row['id'];		
		$Query2 	 = $dbh->prepare($s_query2); // for master templates
		$Result2 = $Query2->execute();
		
		
		if($Result2)
		{
			$eduRows = $Query2->fetchAll(PDO::FETCH_ASSOC);								
		}
		else
		{
			$eduNum  = 0;			
			$eduRows = 0;
		}
				
		$s_query3  = "select organisation,town,county,start,end,position,description from work_exp where cvid = ".$row['id'];
		//$Result3 = mysqli_query($Link, $Query3);
		$Query3 	 = $dbh->prepare($s_query3); // for master templates
		$Result3 	 = $Query3->execute();
		if($Result3)
		{
			$workRows = $Query3->fetchAll(PDO::FETCH_ASSOC);			
		}
		else
		{			
			$workRows = 0;
		}
		
		//echo json_encode(array('work_exp'=>$workRows,'edu' => $eduRows, 'results' => $row));
		//exit();				
	}
	else
	{
		echo json_encode(array('success'=>false,'message'=>$Query1." : ".$Result1));
		exit();
	}
	
	require('api/fpdf.php');
	switch($action)
	{
		case "download":
			$pdf = new FPDF();
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',15);
			$pdf->Cell(70);
			$pdf->Cell(40,0,$row['firstN']." ".$row['lastN'],0,1,L);
			$pdf->Ln(7);
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(-12);
			$pdf->Cell(0,0,$row['addln1']." ".$row['addln2'],0,1,'C');
			
			$pdf->Ln(5);
			$pdf->Cell(-12);
			$pdf->Cell(0,0,$row['town'],0,1,'C');
			
			$pdf->Ln(5);
			$pdf->Cell(-12);
			$pdf->Cell(0,0,$row['postcode'],0,1,'C');
			
			
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(5);
			$pdf->Cell(-12);
			$pdf->Cell(0,0,$row['mobile'].' & '.$row['tel'],0,1,'C');
			
			// profile box			
			$statement = str_replace("&nbsp;","\t",$row['statement']);			
			$count     = strlen($statement); 	
			$n = $count/100;
			$size = $n * 7.5; 
			$pdf->Ln(5);
			$pdf->Cell(-1);
			$pdf->Cell(0,$size,'',1,1,'L');
			
			//profile
			//round( 1.55, 1, PHP_ROUND_HALF_UP)
			$d = $size - 5;
			$pdf->SetFont('Arial','B',10);
			$pdf->Ln(-$d);
			$pdf->Cell(1);
			$pdf->Cell(0,0,'Profile',0,1,'L');
			
			//statement
			$pdf->SetFont('Arial','',10);
			$pdf->Ln(3);
			$pdf->Cell(1);
			$pdf->MultiCell(0,5,$statement,0,'L');
			
			//educationand qulifications title
			$pdf->SetFont('Arial','B',11);
			$pdf->Ln(10);
			$pdf->Cell(-1);
			$pdf->Cell(0,0,'Education & Qualifications',0,1,'L');
			
			
			foreach($eduRows as $r)
			{
				$start = explode("-",$r["start"]);
				$end   = explode("-",$r["complete"]);
				$pdf->SetFont('Arial','',11);
				$pdf->Ln(10);
				$pdf->Cell(1);
				$pdf->Cell(0,0,$start[0].' - '.$end[0],0,1,'L');
				
				$pdf->SetFont('Arial','U',11);					
				$pdf->Cell(66);
				$pdf->Cell(0,0,$r["institute_name"],0,1,'L');
				
				$pdf->SetFont('Arial','B',11);
				$pdf->Ln(8);
				$pdf->Cell(66);
				$pdf->Cell(0,0,$r["degree"]." ".$r["subject"],0,1,'L');
				
				$pdf->SetFont('Arial','',11);					
				$pdf->Cell(1);
				$pdf->Cell(0,0,'Predicted Grade 2.1',0,1,'R');
									
				$pdf->Ln(9);
				$pdf->Cell(1);
				$pdf->Cell(0,0,'Relevent Degree Modules',0,1,'L');
				
				// module List						
				$moduleList = str_replace("&nbsp;","\t",$r["description"]);
											
				$pdf->Ln(-2);
				$pdf->Cell(66);
				$pdf->MultiCell(0,5,$moduleList,'0','L');
			
			}
			// School Information
			/*
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(10);
			$pdf->Cell(1);
			$pdf->Cell(0,0,'2004-2009',0,1,'L');
			
			$pdf->SetFont('Arial','U',11);					
			$pdf->Cell(66);
			$pdf->Cell(0,0,'Bramhouse College',0,1,'L');
			
			$pdf->SetFont('Arial','B',11);
			$pdf->Ln(8);
			$pdf->Cell(66);
			$pdf->Cell(0,0,'A Levels:',0,1,'L');
			
			$moduleList = "Art & Design C,Information Technology D,General Studies C";
			
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(5);												
			$pdf->Cell(66);
			$pdf->MultiCell(0,5,$moduleList,'0','L');
			
			
			// School Information
			
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(10);
			$pdf->Cell(1);
			$pdf->Cell(0,0,'2009-2011',0,1,'L');
			
			$pdf->SetFont('Arial','U',11);					
			$pdf->Cell(66);
			$pdf->Cell(0,0,'Boston Community School',0,1,'L');
			
			$pdf->SetFont('Arial','B',11);
			$pdf->Ln(8);
			$pdf->Cell(66);
			$pdf->Cell(0,0,'GCSEs:',0,1,'L');
			
			$moduleList = "8 at A - C including Maths, English and Science";
			
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(5);												
			$pdf->Cell(66);
			$pdf->MultiCell(0,5,$moduleList,'0','L');
			*/
			
			$pdf->AddPage();
			//Experience 
			foreach($workRows as $w)
			{
				$pdf->SetFont('Arial','B',11);
				$pdf->Ln(10);
				$pdf->Cell(-1);
				$pdf->Cell(0,0,'Employment/ Work Experience & Volunteering in IT and Sport',0,1,'L');
				
				$end   = empty($w["end"])? 'present' : $w["end"];
				
				$pdf->SetFont('Arial','',11);
				$pdf->Ln(10);
				$pdf->Cell(1);
				$pdf->Cell(0,0,$w['start'].' - '.$end,0,1,'L');
				
				$pdf->SetFont('Arial','B',11);					
				$pdf->Cell(66);
				$pdf->Cell(0,0,$w["position"]." - ".$w["organisation"],0,1,'L');
				
				$pdf->SetFont('Arial','',11);
				$pdf->Ln(5);
				$pdf->Cell(0,0,'(freelance basis)',0,1,'L');
				
				$resp = str_replace("&nbsp;","\t",$w["description"]);				
				$pdf->SetFont('Arial','',11);
				$pdf->Ln(5);												
				$pdf->Cell(66);
				$pdf->MultiCell(0,5,$resp,'0','L');
			}
			// second exp column
			/*
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(10);
			$pdf->Cell(1);
			$pdf->Cell(0,0,'January 2011 - present',0,1,'L');
			
			$pdf->SetFont('Arial','B',11);					
			$pdf->Cell(66);
			$pdf->Cell(0,0,'Website Developer - Kidz Konneckt',0,1,'L');
			
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(5);
			$pdf->Cell(0,0,'(voluntary)',0,1,'L');
			
			
			// responsibilities in 
			$resp  = "The job spec includes working independently and part of a team to: ";
			$resp .= chr(149)."\t\t\tDevelop new web software products (websites, intranets, web applications, database systems, e-commerce etc.)\n ";
			$resp .= chr(149)."\t\t\tMaintain existing products.\n ";
			$resp .= chr(149)."\t\t\tManagement of PCs, Servers, and IT infrastructure inside the building and remotely.\n ";
			$resp .= chr(149)."\t\t\tProvide customer support for new and existing products.\n ";
			$resp .= chr(149)."\t\t\tAny other tasks that may from time to time be required by the company directors.\n ";
			
			$pdf->SetFont('Arial','',11);
			$pdf->Ln(5);												
			$pdf->Cell(66);
			$pdf->MultiCell(0,5,$resp,'0','L');
			*/
			$pdf->Output();
			exit();														
		break;
			
		default:
		echo json_encode(array('success'=>false,'action'=>$action));
		exit();
		break;
	}

}




