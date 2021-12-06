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
        if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
            $Unidade = $UnidadeRepositorio->consultarUnidade($Unidade);
        } else {
            $Unidade = $UnidadeRepositorio->consultarUnidadePorNome($Unidade);
        }
        if ($Unidade->getId() == "") {
            if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                $Unidade = $UnidadeRepositorio->consultarUnidade($Unidade);
            } else {
            $Unidade = $UnidadeRepositorio->consultarUnidadePorSigla($Unidade);
            }
        }
    }
    
    if ($Unidade->getId() != "") {
?>
	<div class="mainContainer">
        <div class="mainConteudo">
        	<table class="form">
        		<tr>
        			<td>
                		<label>Nome:</label>
        			</td>
        			<td>
                		<input readonly type="text" name="nome" size="60" value="<?php echo $Unidade->getNome();?>">
        			</td>
        		</tr>
        		<tr>
        			<td>
                		<label>Sigla:</label>
        			</td>
        			<td>
                		<input readonly type="text" name="nome" size="10" value="<?php echo $Unidade->getSigla();?>">
        			</td>
        		</tr>
        		<tr>
        			<td>
                		<label>Endereço:</label>
        			</td>
        			<td>
                		<input readonly type="text" name="nome" size="60" value="<?php echo $Unidade->getEndereco();?>">
        			</td>
        		</tr>
        		<tr>
        			<td>
                		<label>Data de registro:</label>
        			</td>
        			<td>
                		<input readonly type="text" name="dtRegistro" value="<?php echo date('d/m/Y - H:i',strtotime($Unidade->getDtRegistro()));?>">
        			</td>
        		</tr>
        		<tr>
        			<td colspan="2">
            			<div class="botoes">
                   			<a href="consultarUnidade.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                   				<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {?>
                   					<?php if ($Unidade->getSituacao() != 0) {?>
                   						<a href="desbloquearUnidade.php?id=<?php echo $Unidade->getId();?>&nome=<?php echo $Unidade->getNome();?>" class="btDesbloquear">
                   						<img src="img/report_add.png" alt="">Desbloquear
                   						</a>
                   					<?php } else {?>
                   						<a href="bloquearUnidade.php?id=<?php echo $Unidade->getId();?>&nome=<?php echo $Unidade->getNome();?>" class="btBloquear">
            							<img src="img/report_delete.png" alt="">Bloquear
            							</a>
                   					<?php }
                                      }
                   					  if ($_SESSION['nivel'] == 1) {?>
                   						<a href="excluirUnidade.php?id=<?php echo $Unidade->getId();?>&nome=<?php echo $Unidade->getNome();?>" class="btExcluir">
            							<img src="img/delete.png" alt="">Excluir
            							</a>
            					<?php }?>
                   		</div>
        			</td>
        		</tr>
        	</table>
   		</div>
   	</div>
<?php } else {
    $_SESSION['resultado'] = 1;
    header('Location: consultarUnidade.php');
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