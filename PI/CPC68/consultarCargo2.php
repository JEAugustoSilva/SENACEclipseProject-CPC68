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
	<title>Consulta Cargo - CPC68</title>
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
        
        if ($nome != "") {
            $Cargo = $CargoRepositorio->consultarCargo($Cargo);
        }
        
        if ($Cargo->getId() != "") {
        ?>
        <div class="mainContainer">
        	<div class="mainConteudo">
        		<table class="form">
        			<tr>
        				<td>
                    		<label>Nome:</label>
        				</td>
        				<td>
                    		<input readonly type="text" name="nome" size="60" value="<?php echo $Cargo->getNome();?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                    		<label>Descrição:</label>
        				</td>
        				<td>
                    		<textarea readonly name="descricao" rows="5" cols="52"><?php echo $Cargo->getDescricao();?></textarea>
        				</td>
        			</tr>
        			<tr>
        				<td>
                    		<label>Data de registro:</label>
        				</td>
        				<td>
                    		<input readonly type="text" name="dtRegistro" value="<?php echo date('d/m/Y - H:i',strtotime($Cargo->getDtRegistro()));?>">
        				</td>
        			</tr>
        			<tr>
        				<td colspan="2">
                        	<div class="botoes">
                       			<a href="consultarCargo.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                       				<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {?>
                       					<?php if ($Cargo->getSituacao() != 0) {?>
                       						<a href="desbloquearCargo.php?id=<?php echo $Cargo->getId();?>&nome=<?php echo $Cargo->getNome();?>" class="btDesbloquear">
                       						<img src="img/report_add.png" alt="">Desbloquear
                       						</a>
                       					<?php } else {?>
                       						<a href="bloquearCargo.php?id=<?php echo $Cargo->getId();?>&nome=<?php echo $Cargo->getNome();?>" class="btBloquear">
                							<img src="img/report_delete.png" alt="">Bloquear
                							</a>
                       					<?php }
                                          }
                       					  if ($_SESSION['nivel'] == 1) {?>
                       						<a href="excluirCargo.php?id=<?php echo $Cargo->getId();?>&nome=<?php echo $Cargo->getNome();?>" class="btExcluir">
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
        header('Location: consultarCargo.php');
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