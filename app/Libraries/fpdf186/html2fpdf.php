<?php
//HTML2PDF by Cl�ment Lavoillotte
//ac.lavoillotte@noos.fr
//webmaster@streetpc.tk
//http://www.streetpc.tk

require('fpdf.php');

//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
	$R = substr($couleur, 1, 2);
	$rouge = hexdec($R);
	$V = substr($couleur, 3, 2);
	$vert = hexdec($V);
	$B = substr($couleur, 5, 2);
	$bleu = hexdec($B);
	$tbl_couleur = array();
	$tbl_couleur['R']=$rouge;
	$tbl_couleur['V']=$vert;
	$tbl_couleur['B']=$bleu;
	return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
	return $px*25.4/72;
}

function txtentities($html){
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}
////////////////////////////////////

class PDF_HTML extends FPDF
{
function Header()
{
    // Logo
    // $this->Image(url('/ICONS-07.png'),10,6,20);
    // $this->Image(url('/abu_naif_sign.jpg'),50,185,30);

    // // Arial bold 15
    // $this->SetFont('Arial','B',15);
    // // Move to the right
    // $this->Cell(70);
    // // Title
    // $this->Cell(60,10,'BANDER TRADING CO',0,1);
    // // Line break
    // $this->Ln(20);
    // // Move to the right
    // $this->Cell(80);
    // $this->Cell(40,10,'UNDERTAKING',0,1);
    // $this->Ln(20);
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

}//end of class
?>
