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
	<title>Consulta Ambiente - CPC68</title>
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
            	<form action="consultarAmbiente2.php" method="post">
            		<div class="botoes">
                		<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
            			<input type="text" name="pesquisa" size="60" placeholder="Pesquisar o ambiente por nome" required> <button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
                		<p>
                			<?php if ($_SESSION['resultado'] == 1){
            				    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
            				    echo "<label class='resultado1'>Ambiente não encontrado.</label>";
            				    } else {
            				    echo "<label class='resultado1'>Ambiente não encontrado ou bloqueado.</label>";
            				    }
                                $_SESSION['resultado'] = -1;
            				}?>
                		</p>
                	</div>
            	</form>
                <?php 
                
                $idUnidade = $_GET['idUnidade'];
                $nomeUnidade = $_GET['nomeUnidade'];
                
                $Ambiente = new Ambiente();
                $AmbienteRepositorio = new AmbienteRepositorio();
                
                if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                    $listaAmbiente = $AmbienteRepositorio->listarAmbientePorUnidade($idUnidade);
                    $quantidadeAmbiente = $AmbienteRepositorio->contarAmbientePorUnidade($idUnidade);
                } else {
                    $listaAmbiente = $AmbienteRepositorio->listarAmbienteDesbloqueado();
                    $quantidadeAmbiente = $AmbienteRepositorio->contarAmbienteDesbloqueado();
                }
                ?>
            	<table>
            		<tr>
            			<td colspan="3" style="color: #fca235; font-weight: bold; font-size:20px;"><a href="consultarAmbiente.php">Unidades</a> > Ambientes de <?php echo $nomeUnidade;?></td>
            		</tr>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Nome</td>
                        <td style="color: #fca235; font-weight: bold;">Descrição</td>
                        <td style="color: #fca235; font-weight: bold;">Data de registro</td>
            		</tr>
            		<?php
            		$c = 0;
            		while ($c < $quantidadeAmbiente) {
                        $Ambiente = $listaAmbiente[$c];
                        echo "<tr>";
                        echo "<td><img alt='' src='img/bullet_go.png'>&nbsp;<a href='consultarAmbiente2.php?pesquisa=" . $Ambiente->getNome() . "'>" . $Ambiente->getNome() ."</td>";
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