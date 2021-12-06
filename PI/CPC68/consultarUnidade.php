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
	<title>Consulta Unidade - CPC68</title>
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
            	<form action="consultarUnidade2.php" method="post">
            		<div class="botoes">
               				<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                   			<input type="text" name="pesquisa" size="60" placeholder="Pesquisar por nome ou sigla" required> <button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
            				<p>
            		<?php if ($_SESSION['resultado'] == 1){
            			    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
            			    echo "<label class='resultado1'>Unidade não encontrada.</label>";
            			    } else {
            			    echo "<label class='resultado1'>Unidade não encontrada ou bloqueada.</label>";
            			    }
                            $_SESSION['resultado'] = -1;
            			  }?>
                   			</p>
                   	</div>
            	</form>
           	<?php 
                $Unidade = new Unidade();
                $UnidadeRepositorio = new UnidadeRepositorio();
                
                if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                    $quantidade = $UnidadeRepositorio->contarTodoUnidade();
                    $listaUnidade = $UnidadeRepositorio->listarUnidade();
                } else {
                    $quantidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
                    $listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
                }
            ?>
               	<table>
               		<tr>
               			<td style="color: #fca235; font-weight: bold;">Nome</td>
               			<td style="color: #fca235; font-weight: bold;">Sigla</td>
               			<td style="color: #fca235; font-weight: bold;">Data de registro</td>
               			<?php 
               			$c= 0;
               			while ($c < $quantidade) {
               			    $Unidade = $listaUnidade[$c];
               			    $bloqueado = "";
                            if ($Unidade->getSituacao() != 0) {
                                $bloqueado = "class='bloqueado'";
                            }
               			    
               			    echo "<tr>";
               			    echo "<td " . $bloqueado . "><img alt='' src='img/bullet_go.png'>&nbsp;<a href='consultarUnidade2.php?pesquisa=" . $Unidade->getNome() . "'>" . $Unidade->getNome() . "&nbsp;</td>";
               			    echo "<td " . $bloqueado . ">&nbsp;" . $Unidade->getSigla() . "&nbsp;</td>";
               			    echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Unidade->getDtRegistro())) . "&nbsp;</td>";
               			    echo "</tr>";
               			    $c++;
               			}
               			?>
               		</tr>
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