<?php
session_start();

include_once 'src/UnidadeRepositorio.php';
include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';

use src\UnidadeRepositorio;
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
    	<?php
    	if ($_SERVER['REQUEST_METHOD'] == "GET") {
    	    $pesquisa = $_GET['pesquisa'];
    	} else {
    	    $pesquisa = $_POST['pesquisa'];
    	}
        $UnidadeRepositorio = new UnidadeRepositorio();
    	$Ambiente = new Ambiente();
    	$Ambiente->setNome($pesquisa);
    	$AmbienteRepositorio = new AmbienteRepositorio();
    	
    	if ($pesquisa != "") {
    	    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
    	       $Ambiente = $AmbienteRepositorio->consultarAmbiente($Ambiente);
    	       $listaUnidade = $UnidadeRepositorio->listarUnidade();
    	       $quantidadeUnidade = $UnidadeRepositorio->contarTodoUnidade();
    	    } else {
                $Ambiente = $AmbienteRepositorio->consultarAmbientePorNome($Ambiente);
    	        $listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
    	        $quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
    	    }
    	}
	    
    	if ($Ambiente->getId() != "") {
    	?>
    	<div class="mainContainer">
            <div class="mainConteudo">
            	<table class="form">
        			<tr>
        				<td>
                			<label>Nome:</label>
        				</td>
        				<td>
                			<input readonly type="text" name="nome" size="60px" value="<?php echo $Ambiente->getNome(); ?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                       		<label>Descrição:</label>
        				</td>
        				<td>
                       		<textarea readonly name="descricao" rows="5" cols="53"><?php echo $Ambiente->getDescricao(); ?></textarea>
        				</td>
        			</tr>
        			<tr>
        				<td>
                			<label>Data de Registro:</label>
        				</td>
        				<td>
                			<input readonly type="text" name="dtRegistro" value="<?php echo date('d/m/Y - H:i',strtotime($Ambiente->getDtRegistro())) ?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                			<label>Unidade:</label>
        				</td>
        				<td>
                			<select disabled name="idUnidade" required>
                				<?php
                				$c = 0;
                                while ($c < $quantidadeUnidade) {
                    				$selected = "";
                                    if ($Ambiente->getUnidade()->getId() == $listaUnidade[$c]->getId()) {
                                        $selected = "selected";
                                    }
                                    echo "<option readonly value='" . $listaUnidade[$c]->getId() . "' " . $selected . ">" . $listaUnidade[$c]->getNome() . "</option>";
                                    $selected = "";
                                    $c++;
                                }
                			    ?>
                			</select>
        				</td>
        			</tr>
        			<tr>
        				<td colspan="2">
            				<div class="botoes">
                       			<a href="consultarAmbiente.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
               				<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {?>
               					<?php if ($Ambiente->getSituacao() != 0) {?>
               						<a href="desbloquearAmbiente.php?id=<?php echo $Ambiente->getId();?>&nome=<?php echo $Ambiente->getNome();?>" class="btDesbloquear">
               						<img src="img/report_add.png" alt="">Desbloquear
               						</a>
               					<?php } else {?>
               						<a href="bloquearAmbiente.php?id=<?php echo $Ambiente->getId();?>&nome=<?php echo $Ambiente->getNome();?>" class="btBloquear">
            						<img src="img/report_delete.png" alt="">Bloquear
            						</a>
               					<?php }
                                  }
               					  if ($_SESSION['nivel'] == 1) {?>
               						<a href="excluirAmbiente.php?id=<?php echo $Ambiente->getId();?>&nome=<?php echo $Ambiente->getNome();?>" class="btExcluir">
            						<img src="img/delete.png" alt="">Excluir
            						</a>
            				<?php }?>
                   			</div>
        				</td>
        			</tr>
        		</table>
			</div>
		</div>
		<?php
		} else {
            $_SESSION['resultado'] = 1;
            header('Location: consultarAmbiente.php');
        }
        ?>
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