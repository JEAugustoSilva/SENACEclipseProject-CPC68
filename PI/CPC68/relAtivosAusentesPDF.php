<?php
session_start();
include_once 'src/AtivoRepositorio.php';
use src\AtivoRepositorio;

$AtivoRepositorio = new AtivoRepositorio();
$idUnidade = $_GET['idUnidade'];

$listaAtivo = $AtivoRepositorio->relListarAtivosAusentes($idUnidade);
$quantidadeAtivo = $AtivoRepositorio->relContarAtivosAusentes($idUnidade);

require('fpdf181/fpdf.php');


// FUNCTION PARA SE A STRING FOR MUITO GRANDE COLOCAR '...'.
function custom_echo($x, $length) {
    if (strlen($x) <= $length) {
        return $x;
    }
    return substr($x,0,$length) . '...';
}

class PDF extends FPDF
{
// HEADER
    function Header()
    {
        $this->Image('img/logo.png',10,6,45);
    	
    	$this->SetFont('Arial','B',15);
    
    	$this->Cell(50);
    	$this->Cell(80,10,utf8_decode('Relatório de Ativos Ausentes'),0,0,'L');
    	
    	$this->SetFont('Arial','B',12);
    	$this->Cell(0,10,utf8_decode('Data: ' . date("d/m/Y")),0,1,'R');
    	
    	$this->SetFont('Arial','B',10);
    	$this->Cell(50);
    	$this->Cell(0,5,utf8_decode('Emissor: ' . $_SESSION['nome']),0,1,'L');
    	$this->Cell(50);
    	$this->Cell(0,5,utf8_decode('Unidade: ' . $_SESSION['nomeUnidade']),0,1,'L');
    
    	$this->Ln(5);
    	
    	$this->SetFont('Arial','B',8);
    	$this->Cell(27,5,utf8_decode('Nome'),'B',0,'C');
    	$this->Cell(27,5,utf8_decode('Tombamento'),'B',0,'C');
    	$this->Cell(27,5,utf8_decode('Subgrupo'),'B',0,'C');
    	$this->Cell(27,5,utf8_decode('Ambiente'),'B',0,'C');
    	$this->Cell(27,5,utf8_decode('Data de registro'),'B',0,'C');
    	$this->Cell(27,5,utf8_decode('Cadastrante'),'B',0,'C');
    	$this->Cell(0,5,utf8_decode('Status'),'B',1,'C');
    }

    // FOOTER
    function Footer()
    {
    	// Position at 1.5 cm from bottom
    	$this->SetY(-15);
    	$this->SetFont('Arial','IB',8);
    	$this->Cell(0,5,$this->PageNo(),0,0,'R');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',6);
$c = 0;
while ($c < $quantidadeAtivo) {
	$pdf->Cell(27,7,utf8_decode(custom_echo($listaAtivo[$c]->getNome(),20)),'B',0,'C');
	$pdf->Cell(27,7,utf8_decode(custom_echo($listaAtivo[$c]->getCodigoBarra(),20)),'BL',0,'C');
	$pdf->Cell(27,7,utf8_decode(custom_echo($listaAtivo[$c]->getSubgrupo()->getNome(),20)),'BL',0,'C');
	$pdf->Cell(27,7,utf8_decode(custom_echo($listaAtivo[$c]->getAmbiente()->getNome(),20)),'BL',0,'C');
	$pdf->Cell(27,7,utf8_decode(custom_echo(date('d/m/Y - H:i',strtotime($listaAtivo[$c]->getDtRegistro())),20)),'BL',0,'C');
	$pdf->Cell(27,7,utf8_decode(custom_echo($listaAtivo[$c]->getFuncionario()->getNome(),20)),'BL',0,'C');
	if ($listaAtivo[$c]->getStatus() == 0) {
	    $status = 'OK';
	} else if ($listaAtivo[$c]->getStatus() == 1) {
	    $status = "Em empréstimo";
	} else if ($listaAtivo[$c]->getStatus() == 2) {
	    $status = "Em ass. técnica";
	} else if ($listaAtivo[$c]->getStatus() == 3) {
	    $status = "Em baixa";
	} else if ($listaAtivo[$c]->getStatus() == 10) {
	    $status = "Mal funcionamento";
	} else if ($listaAtivo[$c]->getStatus() == 11) {
	    $status = "Quebrado";
	} else if ($listaAtivo[$c]->getStatus() == 12) {
	    $status = "Sem Tombamento";
	} else if ($listaAtivo[$c]->getStatus() == 13) {
	    $status = "Ausente";
	}
	$pdf->Cell(0,7,utf8_decode(custom_echo($status,20)),'BL',1,'C');
    $c++;
}
$pdf->Output('I','RelatorioAtivoAusente'.date("d_m_Y").'.pdf',true);
?>
