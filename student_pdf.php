<?php
//include connection file 
include_once("connection.php");
include_once('lib/fpdf.php');
 
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('images/back2.jpg',10,2,50);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(90);
    // Title
    $this->Cell(100,20,'Grace Roles Library Student List',1,0,'C');
    // Line break
    $this->Ln(25);
}
 
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
$db = new dbObj();
$connString =  $db->getConnstring();
$display_heading = array('student_id'=>'ID', 'student_no'=> 'Student Number', 'firstname'=> 'First Name','middlename'=> 'Middle Name','lastname'=> 'Last Name','course'=> 'Course','section'=> 'Year Of Study',);
 
$result = mysqli_query($connString, "SELECT student_id, student_no, firstname,middlename,lastname, course,section FROM student") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM student");
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
foreach($header as $heading) {
$pdf->Cell(40,12,$display_heading[$heading['Field']],1);
}
foreach($result as $row) {
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(40,12,$column,1);
}
$pdf->Output();
?>