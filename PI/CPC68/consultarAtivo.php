<?php
session_start();

include_once 'src/Unidade.php';
include_once 'src/UnidadeRepositorio.php';

use src\Unidade;
use src\UnidadeRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Consulta Ativo - CPC68</title>
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
    			<?php
    			$Unidade = new Unidade();
    			$UnidadeRepositorio = new UnidadeRepositorio();
    			$listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
    			$quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
    			?>
    			<table>
    				<tr>
            			<td colspan="4" style="color: #fca235; font-weight: bold; font-size:20px;">Escolha uma das unidades</td>
            		</tr>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Nome</td>
						<td style="color: #fca235; font-weight: bold;">Sigla</td>
						<td style="color: #fca235; font-weight: bold;">Endereço</td>
						<td style="color: #fca235; font-weight: bold;">Data de registro</td>
            		</tr>
            		<?php
            		$c = 0;
            		while ($c < $quantidadeUnidade) {
            		  $Unidade = $listaUnidade[$c];
            		  echo "<tr>";
            		  echo "<td><img alt='' src='img/bullet_go.png'>&nbsp;<a href='consultarAtivo1-1.php?idUnidade=" . $Unidade->getId() . "&nomeUnidade=" . $Unidade->getNome() . "'>" . $Unidade->getNome() ."</td>";
            		  echo "<td>&nbsp;" . $Unidade->getSigla() . "&nbsp;</td>";
            		  echo "<td>&nbsp;" . $Unidade->getEndereco() . "&nbsp;</td>";
            		  echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Unidade->getDtRegistro())) . "&nbsp;</td>";
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