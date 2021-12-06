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
	<title>Alteração Unidade - CPC68</title>
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
    
        $Unidade = new Unidade();
        $Unidade->setNome($pesquisa);
        $Unidade->setSigla($pesquisa);
        
        $UnidadeRepositorio = new UnidadeRepositorio();
        
        if ($pesquisa != "") {
            $Unidade = $UnidadeRepositorio->consultarUnidadePorNome($Unidade);
            if ($Unidade->getId() == "") {
            $Unidade = $UnidadeRepositorio->consultarUnidadePorSigla($Unidade);
            }
        }
        
        if ($Unidade->getId() != "") {
    ?>
    	<div class="mainContainer">
       		<div class="mainConteudo">
            	<form action="alterarUnidade3.php" method="post">
           			<table class="form">
           				<tr>
           					<td>
                    			<label>Nome:</label>
           					</td>
           					<td>
                    			<input type="text" name="nome" size="60px" value="<?php echo $Unidade->getNome(); ?>">
           					</td>
           				</tr>
           				<tr>
           					<td>
                    			<label>Sigla:</label>
           					</td>
           					<td>
                    			<input type="text" name="sigla" size="10px" value="<?php echo $Unidade->getSigla() ?>">
           					</td>
           				</tr>
           				<tr>
           					<td>
                    			<label>Endereço:</label>
           					</td>
           					<td>
                    			<input type="text" name="endereco" size="80px" value="<?php echo $Unidade->getEndereco(); ?>">
           					</td>
           				</tr>
           				<tr>
           					<td colspan="2">
                        		<div class="botoes">
                           			<input type="hidden" name="id" value="<?php echo $Unidade->getId(); ?>">
                           			<a href="alterarUnidade.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                           			<button class="btSalvar" type="submit"><img alt="" src="img/tick.png">Alterar</button>
                            	</div>
           					</td>
           				</tr>
           				<tr>
           					<td colspan="2">
                        		<?php if ($_SESSION['resultado'] == 0) {
                        		    echo "<label class='resultado0'>Unidade alterada com sucesso!</label>";
                        		    $_SESSION['resultado'] = -1;
                        		} else if ($_SESSION['resultado'] == 1) {
                        		    echo "<label class='resultado1'>Falha na alteração da unidade.</label>";
                        		    $_SESSION['resultado'] = -1;
                        		}?>
           					</td>
           				</tr>
           			</table>
            	</form>
            <?php } else {
                    $_SESSION['resultado'] = 1;
                    header('Location: alterarUnidade.php');
                  }?>
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