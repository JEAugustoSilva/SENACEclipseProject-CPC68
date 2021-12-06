<?php
session_start();

include_once 'src/CargoRepositorio.php';
include_once 'src/UnidadeRepositorio.php';
include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';

use src\Funcionario;
use src\FuncionarioRepositorio;
use src\CargoRepositorio;
use src\UnidadeRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Alteração Funcionário - CPC68</title>
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
		
		$Funcionario = new Funcionario();
		$Funcionario->setNome($pesquisa);
		$FuncionarioRepositorio = new FuncionarioRepositorio();
		if ($pesquisa != "") {
		    $Funcionario = $FuncionarioRepositorio->consultarFuncionarioPorNome($Funcionario);
		}
		
		$CargoRepositorio = new CargoRepositorio();
		$listaCargo = $CargoRepositorio->listarCargoDesbloqueado();
		$quantidadeCargo = $CargoRepositorio->contarCargoDesbloqueado();
        
		$UnidadeRepositorio = new UnidadeRepositorio();
		$listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
		$quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
		
		if ($Funcionario->getId() != "") {
		?>
		<div class="mainContainer">
       		<div class="mainConteudo">
           		<form action="alterarFuncionario3.php" method="post">
           			<table class="form">
            			<tr>
            				<td>
                    			<label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60" maxlength="100" value="<?php echo $Funcionario->getNome(); ?>"  required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Email:</label>
            				</td>
            				<td>
                    			<input type="text" name="email" size="60" maxlength="50" value="<?php echo $Funcionario->getEmail(); ?>"  required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Telefone:</label>
            				</td>
            				<td>
                    			<input type="text" name="telefone" id="telefone" size="13" maxlength="15" value="<?php echo $Funcionario->getTelefone(); ?>"  required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Turno:</label>
            				</td>
            				<td>
                       			<select name="turno">
                       				<option value="" hidden="true" disabled>Selecione o turno</option>
                       				<option value="manha" <?php if ($Funcionario->getTurno() == "manha"){echo "selected";}?>>Manhã</option>
                       				<option value="tarde" <?php if ($Funcionario->getTurno() == "tarde"){echo "selected";}?>>Tarde</option>
                       				<option value="noite" <?php if ($Funcionario->getTurno() == "noite"){echo "selected";}?>>Noite</option>
                       				<option value="manha-tarde" <?php if ($Funcionario->getTurno() == "manha-tarde"){echo "selected";}?>>Manhã e Tarde</option>
                       				<option value="tarde-noite" <?php if ($Funcionario->getTurno() == "tarde-noite"){echo "selected";}?>>Tarde e Noite</option>
                       				<option value="noite-manha" <?php if ($Funcionario->getTurno() == "noite-manha"){echo "selected";}?>>Noite e Manhã</option>
                       			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                       			<label>Nível:</label>
            				</td>
            				<td>
                       			<select name="nivel">
                       				<option value="" hidden="true" disabled>Selecione o nível</option>
                       				<option value="1" <?php if ($Funcionario->getNivel() == 1){echo "selected";}?>>Administrador</option>
                       				<option value="2" <?php if ($Funcionario->getNivel() == 2){echo "selected";}?>>Supervisor</option>
                       				<option value="3" <?php if ($Funcionario->getNivel() == 3){echo "selected";}?>>Aux. de Administração</option>
                       				<option value="4" <?php if ($Funcionario->getNivel() == 4){echo "selected";}?>>Técnico</option>
                       				<option value="5" <?php if ($Funcionario->getNivel() == 5){echo "selected";}?>>Operador</option>
                       			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Cargo:</label>
            				</td>
            				<td>
                    			<select name="idCargo" required>
                    				<option value="" hidden="true" disabled>Selecione o cargo</option>
                    					<?php
                                        $c = 0;
                                        $selected = "";
                                        while ($c < $quantidadeCargo) {
                                            if ($Funcionario->getCargo()->getId() == $listaCargo[$c]->getId()) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $listaCargo[$c]->getId() . "' " . $selected . ">" . $listaCargo[$c]->getNome() . "</option>";
                                            $selected = "";
                                            $c++;
                                        }
                    				    ?>
                    			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Cargo superior:</label>
            				</td>
            				<td>
                    			<select name="idCargoSuperior" required>
                    					<?php
                                        $c = 0;
                                        while ($c < $quantidadeCargo) {
                                            if ($Funcionario->getCargoSuperior()->getId() == $listaCargo[$c]->getId()) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $listaCargo[$c]->getId() . "' " . $selected . ">" . $listaCargo[$c]->getNome() . "</option>";
                                            $c++;
                                        }
                    				    ?>
                    			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Unidade:</label>
            				</td>
            				<td>
                    			<select name="idUnidade" required>
                    				<option value="" hidden="true" disabled selected>Selecione a unidade</option>
                    					<?php
                                        $c = 0;
                                        $selected = "";
                                        while ($c < $quantidadeUnidade) {
                                            if ($Funcionario->getUnidade()->getId() == $listaUnidade[$c]->getId()) {
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
                            		<a href="alterarFuncionario.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                            		<button class="btSalvar" type="submit"><img alt="" src="img/tick.png">Alterar</button>
                        		</div>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2">
                        		<?php if ($_SESSION['resultado'] == 0) {
                        	        echo "<label class='resultado0'>Funcionário alterado com sucesso!</label>";
                        	        $_SESSION['resultado'] = -1;
                        	    } else if ($_SESSION['resultado'] == 1) {
                        	        echo "<label class='resultado1'>Falha na alteração do funcionário.</label>";
                        	        $_SESSION['resultado'] = -1;
                        	    }?>
            				</td>
            			</tr>
            		</table>
            		<input type="hidden" name="idAtorCadastro" value="<?php echo $_SESSION['id']; ?>">
            		<input type="hidden" name="id" value="<?php echo $Funcionario->getId(); ?>">
           		</form>
			</div>
		</div>
		<?php
        } else {
            $_SESSION['resultado'] = 1;
            header('Location: alterarFuncionario.php');
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