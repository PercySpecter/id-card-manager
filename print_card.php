<?php

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$add1 = $_POST['add1'];
$add2 = $_POST['add2'];
$city = $_POST['city'];
$pin = $_POST['pin'];
$state = $_POST['state'];
$year = $_POST['year'];
$prog = $_POST['prog'];
$id = $_POST['id'];
$dept = $_POST['dept'];
$mode = $_POST['mode'];

$uploaddir = 'uploads';
$uploadfile = 'dp.jpg';

require('../fpdf181/fpdf.php');

class PDF extends FPDF
{
	// Page header
	function __construct($orientation , $units , $dims)
	{
		parent::__construct($orientation , $units , $dims);
	}
	
	function Header()
	{
	    // Logo
	    $this->Image('res/logo.png',2,2,12);
	    // Arial bold 15
	    $this->SetFont('Arial','B',20);
	    // Move to the right
	    $this->Cell(9);
	    // Title
	    $this->Cell(0 , 0 , 'COENSOBEC');
	
	    $this->Image('uploads/dp.jpg',70,2,14);
	}
	
	function body($fname,$lname,$add1,$add2,$city,$pin,$state,$year,$prog,$id,$dept)
	{
		$this->setFont('Arial','',8);
		$this->Ln(10);
		$this->Cell(1,1,'NAME : '.$fname.' '.$lname);
		$this->Ln(4);
		$this->Cell(1,1,'ADDRESS : '.$add1);
		$this->Ln(4);
		$this->Cell(15);
		$this->Cell(1,1,$add2);
		$this->Ln(4);
		$this->Cell(15);
		$this->Cell(1,1,$city.'-'.$pin.' '.$state);
		$this->Ln(4);
		$this->Cell(1,1,'YEAR OF JOINING : '.$year);
		$this->Ln(4);
		$this->Cell(1,1,'PROGRAM : '.$prog);
		$this->Ln(4);
		$this->Cell(1,1,'ID : '.$id);
		$this->Ln(4);
		$this->Cell(1,1,'DEPARTMENT : '.$dept);
	}
}

$servername = "localhost";
$username = "btech2017";
$password = "btech2017";
$dbname = "btech2017";

  // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
      // Check connection
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM AnindyaKinjal WHERE id='" . $id . "';";
$result = $conn->query($sql);

if($result->num_rows > 0)
{
	//echo "block 1";
	$row = $result->fetch_assoc();
	$fname = $row['fname'];
	$lname = $row['lname'];
	$add1 = $row['add1'];
	$add2 = $row['add2'];
	$city = $row['city'];
	$pin = $row['pin'];
	$state = $row['state'];
	$year = $row['year'];
	$prog = $row['prog'];
	$id = $row['id'];
	$dept = $row['dept'];
	rename($uploaddir . '/id_' . $id . '.jpg' , $uploaddir . '/' . $uploadfile);
}
else
{
	//echo "block 2";
	if($mode == "old")
	{
		include 'idnotfound.html';
		return;
	}
	if (!move_uploaded_file($_FILES['pic']['tmp_name'], $uploaddir . '/' . $uploadfile))
	{
		echo "File Upload Failed!!\n";
	}
	$sql = "INSERT INTO AnindyaKinjal VALUES ( \"" . $fname . " \", \"" . $lname . " \", \"" . $add1 . " \", \"" . $add2 . " \", \"" . $city . " \", \"" . $pin .  " \", \"" . $state . " \", " . $year . " , \"" . $prog . "\" , \"" . $dept . "\" , \"" . $id . "\" );";

	if ($conn->query($sql)=== FALSE ) 
	{
		echo "Error saving values: " . $conn->error;
	}
}

//$conn-close();

$pdf = new PDF('L' , 'mm' , array(85 , 54));
$pdf->SetAutoPageBreak(false, 1);
$pdf->AddPage();
$pdf->Header();
$pdf->body($fname,$lname,$add1,$add2,$city,$pin,$state,$year,$prog,$id,$dept);
 
rename($uploaddir . '/' . $uploadfile , 'uploads/id_' . $id . '.jpg');

$pdf->Output('I' , 'id_' . $id . '.pdf');
?>




























