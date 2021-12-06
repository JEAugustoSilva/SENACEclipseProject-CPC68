<?php
session_start();

include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';
use src\Ambiente;
use src\AmbienteRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Consulta Movimentação - CPC68</title>
	<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body>





<!-- NAV -->
<?php include_once 'includes/nav.php';?>


<!-- Side Menu -->
<?php include_once 'includes/sideMenu.php';?>
    
    
    <!-- Main -->
	<div id="main">
		<div class="mainContainer">
        	<div class="mainConteudo">
				<form action="consultarMovimentacao2.php" method="post">
            		<div class="botoes">
                		<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
            			<input type="text" name="pesquisa" size="70" placeholder="Pesquisar movimentação (em andamento) pelo tombamento do ativo" required>
                		<input type="hidden" name="idUnidade" value="<?php echo $_GET['idUnidade'];?>">
                		<input type="hidden" name="nomeUnidade" value="<?php echo $_GET['nomeUnidade'];?>">
                		<input type="hidden" name="1_1" value="0">
            			<button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
                	</div>
            		<p>
            			<?php
            			if ($_SESSION['resultado'] == 1){
        				    echo "<label class='resultado1'>Nenhuma movimentação em andamento encontrada.</label>";
                            $_SESSION['resultado'] = -1;
            			}
        				?>
            		</p>
            	</form>
            	<?php
            	$idUnidade = $_GET['idUnidade'];
            	$nomeUnidade = $_GET['nomeUnidade'];
            	
            	$Ambiente = new Ambiente();
            	$AmbienteRepositorio = new AmbienteRepositorio();
                $listaAmbiente = $AmbienteRepositorio->listarAmbientePorUnidadeDesbloqueado($idUnidade);
                $quantidadeAmbiente = $AmbienteRepositorio->contarAmbienteDesbloqueadoPorUnidade($idUnidade);
                ?>
                <div>
                    <img style="padding:none; margin:none; width: 19px;" alt="" src="img/tooltip.png"> <span style="font-size: 12px; position: absolute; padding-top: 3px;">*Passar mouse para ver dica.</span>
                </div>
            	<table>
            		<tr>
            			<td colspan="5" style="color: #fca235; font-weight: bold; font-size:20px;"><a href="consultarMovimentacao.php">Unidades</a> > Ambientes de <?php echo $nomeUnidade;?></td>
            		</tr>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Nome</td>
            			<td style="color: #fca235; font-weight: bold;">Ambiente Origem&nbsp;<img style="padding:none; margin:none; position:absolute; width: 19px;" src="img/tooltip.png" alt="" title="*Ambiente origem: Ambiente original do ativo antes da movimentação.&#013;Mostrar movimentações do ambiente como Ambiente Origem."/></td>
            			<td style="color: #fca235; font-weight: bold;">Ambiente Destino&nbsp;<img style="padding:none; margin:none; position:absolute; width: 19px;" src="img/tooltip.png" alt="" title="*Ambiente destino: Ambiente para onde o ativo é movimentado. (Dependendo do tipo de movimentação)&#013;Mostrar movimentações do ambiente como Ambiente Destino."/></td>
                        <td style="color: #fca235; font-weight: bold;">Descrição</td>
                        <td style="color: #fca235; font-weight: bold;">Data de registro</td>
            		</tr>
            		<?php
            		$c = 0;
            		while ($c < $quantidadeAmbiente) {
                        $Ambiente = $listaAmbiente[$c];
                        echo "<tr>";
                        echo "<td>&nbsp;" . $Ambiente->getNome() ."</td>";
                        echo "<td> " .
                             "<a href='consultarMovimentacao1Origem.php?idUnidade=" . $idUnidade . "&idAmbiente=" . $Ambiente->getId() . "&nomeUnidade=" . $nomeUnidade . "&nomeAmbiente=" . $Ambiente->getNome() . "'><img alt='' src='img/arrow_up.png'>Origem</a>" .
                             "</td>";
                        echo "<td> " .
                             "<a href='consultarMovimentacao1Destino.php?idUnidade=" . $idUnidade . "&idAmbiente=" . $Ambiente->getId() . "&nomeUnidade=" . $nomeUnidade . "&nomeAmbiente=" . $Ambiente->getNome() . "'><img alt='' src='img/arrow_down.png'>Destino</a>" .
                             "</td>";
                        echo "<td>&nbsp;" . $Ambiente->getDescricao() . "&nbsp;</td>";
                        echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Ambiente->getDtRegistro())) . "&nbsp;</td>";
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