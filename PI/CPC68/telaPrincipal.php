<?php 
session_start();

include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';
include_once 'src/Movimentacao.php';
include_once 'src/MovimentacaoRepositorio.php';
include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';

use src\Movimentacao;
use src\MovimentacaoRepositorio;
use src\AmbienteRepositorio;
use src\Ambiente;



if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Home - CPC68</title>
	<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body id="body">





<!-- NAV -->
<?php include_once 'includes/nav.php';?>


<!-- Side Menu -->
<?php include_once 'includes/sideMenu.php';?>
    
    
    <!-- Main -->
    <div id="main">
    	<div class="mainContainer">
    		<div class="mainConteudo">
    			<?php
    			$MovimentacaoRepositorio = new MovimentacaoRepositorio();
    			$listaMov = $MovimentacaoRepositorio->listarUltimaMovimentacao();
    			$quantidadeMov = $MovimentacaoRepositorio->contarUltimaMovimentacao();
    			?>
    			<table class="form" style="width: auto; height: 5px;" align="left">
            		<tr style="height: 10px;">
            			<td colspan="7" style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">Início - Bem Vindo(a) <?php echo $_SESSION['nome'];?></td>
            		</tr>
    			</table>
    			<table>
            		<tr>
            			<td colspan="7" style="color: #fca235; font-weight: bold; font-size:20px;">Últimas movimentações</td>
            		</tr>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Ativo</td>
            			<td style="color: #fca235; font-weight: bold;">Tombamento</td>
            			<td style="color: #fca235; font-weight: bold;">Tipo</td>
                        <td style="color: #fca235; font-weight: bold;">Ambiente Origem</td>
                        <td style="color: #fca235; font-weight: bold;">Ambiente Destino</td>
                        <td style="color: #fca235; font-weight: bold;">Cadastrante</td>
                   <!-- <td style="color: #fca235; font-weight: bold;">Data de registro</td> -->
                        <td style="color: #fca235; font-weight: bold;">Status</td>
            		</tr>
            		<?php
            		$c = 0;
            		$AmbienteDestino = new Ambiente();
                    $AmbienteRep = new AmbienteRepositorio();
            		while ($c < $quantidadeMov) {
            		    $Movimentacao = new Movimentacao();
            		    $Movimentacao = $listaMov[$c];
                        echo "<tr>";
                        echo "<td>&nbsp;" . $Movimentacao->getAtivo()->getNome() . "</a>&nbsp;</td>";
                        echo "<td>&nbsp;" . $Movimentacao->getAtivo()->getCodigoBarra() . "&nbsp;</td>";
                        
                        
                        if ($Movimentacao->getTipo() == 1) {
                            $tipo = "Empréstimo";
                        } else if ($Movimentacao->getTipo() == 2) {
                            $tipo = "Tranferência";
                        } else if ($Movimentacao->getTipo() == 3) {
                            $tipo = "Ass. Técnica";
                        } else if ($Movimentacao->getTipo() == 4) {
                            $tipo = "Baixa";
                        }
                        echo "<td>" . $tipo ."</td>";
                        
                        
                        echo "<td>&nbsp;" . $Movimentacao->getAmbienteOrigem()->getNome() . "&nbsp;</td>";
                        
                        
                        if ($Movimentacao->getAmbienteDestino()->getId() != '') {
                            $AmbienteDestino = $AmbienteRep->consultarNomeAmbientePorId($Movimentacao->getAmbienteDestino()->getId());
                        } else {
                            $AmbienteDestino->setNome("N/A");
                        }
                        echo "<td>&nbsp;" . $AmbienteDestino->getNome() . "&nbsp;</td>";
                        echo "<td>&nbsp;" . $Movimentacao->getFuncionario()->getNome() . "&nbsp;</td>";
                        
                        
//                         echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Movimentacao->getDtRegistro())) . "&nbsp;</td>";
                        
                        if ($Movimentacao->getStatus() == 0) {
                            $status = "Concluído";
                            $statCor = 'style="font-weight: bold; color: green;"';
                        } else if ($Movimentacao->getStatus() == 1) {
                            $status = "Em andamento";
                            $statCor = 'style="font-weight: bold; color: orange;"';
                        } else if ($Movimentacao->getStatus() == 2) {
                            $status = "Atrasado";
                            $statCor = 'style="font-weight: bold; color: red;"';
                        } else if ($Movimentacao->getStatus() == 3) {
                            $status = "Cancelado";
                            $statCor = 'style="font-weight: bold; color: red;"';
                        }
                        echo "<td " . $statCor . ">&nbsp;" . $status . "&nbsp;</td>";
                        
                        echo "</tr>";
                        $c++;
            		}
            		?>
            	</table>
    		</div>
    	</div>
    </div>
	
<!-- Footer -->
<?php include_once 'includes/footer.php';?>


<!-- JavaScript -->
<script src="script.js"></script>
</body>
</html>
<?php 
}
?>