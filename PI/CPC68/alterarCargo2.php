<?php 
session_start();

include_once 'src/Cargo.php';
include_once 'src/CargoRepositorio.php';

use src\Cargo;
use src\CargoRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Alteração Cargo - CPC68</title>
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
                $nome = $_GET['nome'];
            } else {
                $nome = $_POST['nome'];
            }
            
            $Cargo = new Cargo();
            $Cargo->setNome($nome);
            
            $CargoRepositorio = new CargoRepositorio();
            
            if ($nome != ""){
                if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                    $Cargo = $CargoRepositorio->consultarCargo($Cargo);
                } else {
                    $Cargo = $CargoRepositorio->consultarCargoPorNome($Cargo);
                }
            }
            if ($Cargo->getId() != "") {
        ?>
        	<div class="mainContainer">
        		<div class="mainConteudo">
                	<form action="alterarCargo3.php" method="post">
                		<table class="form">
                			<tr>
                				<td>
                               		<label>Nome:</label>
                				</td>
                				<td>
                               		<input type="text" name="nome" size="60px" value="<?php echo $Cargo->getNome();?>">
                				</td>
                			</tr>
                			<tr>
                				<td>
                               		<label>Descrição:</label>
                				</td>
                				<td>
                               		<textarea name="descricao" rows="5" cols="53"><?php echo $Cargo->getDescricao();?></textarea>
                				</td>
                			</tr>
                			<tr>
                				<td colspan="2">
                                   	<div class="botoes">
                                   		<input type="hidden" type="text" name="id" value="<?php echo $Cargo->getId();?>">
                            			<a href="alterarCargo.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                            			<button class="btSalvar" type="submit"><img alt="" src="img/tick.png">Alterar</button>
                            		</div>
                				</td>
                			</tr>
                			<tr>
                				<td colspan="2">
                            		<?php if ($_SESSION['resultado'] == 0) {
                            	        echo "<label class='resultado0'>Cargo alterado com sucesso!</label>";
                            	        $_SESSION['resultado'] = -1;
                            		} else if ($_SESSION['resultado'] == 1) {
                            	        echo "<label class='resultado1'>Falha na alteração do cargo.</label>";
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
                header('Location: alterarCargo.php');
        	}?>
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