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
    	<div class="mainContainer">
    		<div class="mainConteudo">
            	<form action="alterarCargo2.php" method="post">
                	<div class="botoes">
                			<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                			<input type="text" name="nome" size="60" placeholder="Pesquisar por nome" required> <button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
                		<p>
                		<?php if ($_SESSION['resultado'] == 1){
            				    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
            				    echo "<label class='resultado1'>Cargo não encontrado.</label>";
            				    } else {
            				    echo "<label class='resultado1'>Cargo não encontrado ou bloqueado.</label>";
            				    }
                                $_SESSION['resultado'] = -1;
            				  }?>
                		</p>
                	</div>
            	</form>
            <?php 
                $Cargo = new Cargo();
                $CargoRepositorio = new CargoRepositorio();
                
                if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                    $quantidade = $CargoRepositorio->contarTodoCargo();
                    $listaCargo = $CargoRepositorio->listarCargo();
                } else {
                    $quantidade = $CargoRepositorio->contarCargoDesbloqueado();
                    $listaCargo = $CargoRepositorio->listarCargoDesbloqueado();
                }
            ?>
                <table>
                	<tr>
                        <td style="color: #fca235; font-weight: bold;">Nome</td>
                        <td style="color: #fca235; font-weight: bold;">Descrição</td>
                        <td style="color: #fca235; font-weight: bold;">Data de registro</td>
                        <?php
                        $c= 0;
                        while ($c < $quantidade) {
                            $Cargo = $listaCargo[$c];
                            echo "<tr>";
                            echo "<td><img alt='' src='img/bullet_go.png'>&nbsp;<a href='alterarCargo2.php?nome=" . $Cargo->getNome() . "'>" . $Cargo->getNome() . "&nbsp;</td>";
                            echo "<td>&nbsp;" . $Cargo->getDescricao() . "&nbsp;</td>";
                            echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Cargo->getDtRegistro())) . "&nbsp;</td>";
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