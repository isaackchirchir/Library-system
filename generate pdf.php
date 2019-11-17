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
    $this->Image('images/back.jpg',10,2,50);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(90);
    // Title
    $this->Cell(100,20,'Grace Roles Library Book List',1,0,'C');
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
$display_heading = array('book_id'=>'ID', 'book_title'=> 'Book Title', 'book_description'=> 'Book Description','book_category'=> 'Book Category','book_author'=> 'Book Author','date_publish'=> 'Date Published','qty'=> 'Quantity',);
 
$result = mysqli_query($connString, "SELECT book_id, book_title, book_description,book_category,book_author, date_publish,qty FROM book") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM book");
 
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