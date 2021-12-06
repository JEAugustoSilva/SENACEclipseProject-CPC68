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
	<title>Alteração Ambiente - CPC68</title>
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
        
        $Ambiente = new Ambiente();
        $Ambiente->setNome($pesquisa);
        $AmbienteRepositorio = new AmbienteRepositorio();
        if ($pesquisa != "") {
            $Ambiente = $AmbienteRepositorio->consultarAmbientePorNome($Ambiente);
        }
        
        $UnidadeRepositorio = new UnidadeRepositorio();
        $listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
        $quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
        
        if ($Ambiente->getId() != "") {
    ?>
    	<div class="mainContainer">
       		<div class="mainConteudo">
            	<form action="alterarAmbiente3.php" method="post">
                	<table class="form">
            			<tr>
            				<td>
                    			<label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60px" value="<?php echo $Ambiente->getNome(); ?>">
            				</td>
            			</tr>
            			<tr>
            				<td>
                           		<label>Descrição:</label><br/>
            				</td>
            				<td>
                           		<textarea name="descricao" rows="5" cols="53"><?php echo $Ambiente->getDescricao(); ?></textarea>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Unidade:</label>
            				</td>
            				<td>
                    			<select name="idUnidade" required>
                    				<?php
                    				$c = 0;
                                    while ($c < $quantidadeUnidade) {
                        				$selected = "";
                                        if ($Ambiente->getUnidade()->getId() == $listaUnidade[$c]->getId()) {
                                            $selected = "selected";
                                        }
                                        echo "<option value='" . $listaUnidade[$c]->getId() . "' " . $selected . ">" . $listaUnidade[$c]->getNome() . "</option>";
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
                            		<input type="hidden" name="id" value="<?php echo $Ambiente->getId(); ?>">
                            		<a href="alterarAmbiente.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                            		<button class="btSalvar" type="submit"><img alt="" src="img/tick.png">Alterar</button>  
                        		</div>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2">
                        		<?php 
                        		if ($_SESSION['resultado'] == 0) {
                        	        echo "<label class='resultado0'>Ambiente alterado com sucesso!</label>";
                        	        $_SESSION['resultado'] = -1;
                        	    } else if ($_SESSION['resultado'] == 1) {
                        	        echo "<label class='resultado1'>Falha na alteração do ambiente.</label>"; 
                        	        $_SESSION['resultado'] = -1;
                        	    }?>
            				</td>
            			</tr>
            		</table>
            	</form>
    		</div>
		</div>
    	<?php
        } else {
            $_SESSION['resultado'] = 1;
            header('Location: alterarAmbiente.php');
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