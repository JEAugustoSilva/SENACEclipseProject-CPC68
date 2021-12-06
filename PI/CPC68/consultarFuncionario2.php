<?php
session_start();

include_once 'src/CargoRepositorio.php';
include_once 'src/UnidadeRepositorio.php';
include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';

use src\CargoRepositorio;
use src\UnidadeRepositorio;
use src\Funcionario;
use src\FuncionarioRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Consulta Funcionário - CPC68</title>
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
        $CargoRepositorio = new CargoRepositorio();
        $UnidadeRepositorio = new UnidadeRepositorio();
        $Funcionario = new Funcionario();
        $Funcionario->setNome($pesquisa);
        $FuncionarioRepositorio = new FuncionarioRepositorio();
        
        if ($pesquisa != "") {
            if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                $Funcionario = $FuncionarioRepositorio->consultarFuncionario($Funcionario);
                $listaCargo = $CargoRepositorio->listarCargo();
                $quantidadeCargo = $CargoRepositorio->contarTodoCargo();
                $listaUnidade = $UnidadeRepositorio->listarUnidade();
                $quantidadeUnidade = $UnidadeRepositorio->contarTodoUnidade();
            } else {
                $Funcionario = $FuncionarioRepositorio->consultarFuncionarioPorNome($Funcionario);
                $listaCargo = $CargoRepositorio->listarCargoDesbloqueado();
                $quantidadeCargo = $CargoRepositorio->contarCargoDesbloqueado();
                $listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
                $quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
            }
        }
		
        if ($Funcionario->getId() != "") {
		?>
		<div class="mainContainer">
            <div class="mainConteudo">
            	<table class="form">
        			<tr>
        				<td>
                			<label>Nome:</label>
        				</td>
        				<td>
                			<input readonly type="text" name="nome" size="60" value="<?php echo $Funcionario->getNome(); ?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                			<label>Turno:</label>
        				</td>
        				<td>
                   			<select name="turno" disabled>
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
                   			<select name="nivel" disabled>
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
                			<select name="idCargo" disabled>
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
                			<label>Data de Registro:</label>
        				</td>
        				<td>
                			<input readonly type="text" name="dtRegistro" value="<?php echo date('d/m/Y - H:i',strtotime($Funcionario->getDtRegistro())); ?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                			<label>Unidade:</label>
        				</td>
        				<td>
                			<select name="idUnidade" disabled>
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
        			<?php $Cadastrante = $FuncionarioRepositorio->consultarFuncionarioPorIdAtorCadastro($Funcionario->getIdAtorCadastro()) ?>
        			<tr>
        				<td>
        					<label>Cadastrante:</label>
        				</td>
        				<td>
        					<input readonly type="text" name="cadastrante" value="<?php echo $Cadastrante->getNome(); ?>">
        				</td>
        			</tr>
        			<tr>
        				<td colspan="2">
                    		<div class="botoes">
                       			<a href="consultarFuncionario.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
               				<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {?>
               					<?php if ($Funcionario->getSituacao() != 0) {?>
               						<a href="desbloquearFuncionario.php?id=<?php echo $Funcionario->getId();?>&nome=<?php echo $Funcionario->getNome();?>" class="btDesbloquear">
               						<img src="img/report_add.png" alt="">Desbloquear
               						</a>
               					<?php } else {?>
               						<a href="bloquearFuncionario.php?id=<?php echo $Funcionario->getId();?>&nome=<?php echo $Funcionario->getNome();?>" class="btBloquear">
            						<img src="img/report_delete.png" alt="">Bloquear
            						</a>
               					<?php }
                                  }
               					  if ($_SESSION['nivel'] == 1) {?>
               						<a href="excluirFuncionario.php?id=<?php echo $Funcionario->getId();?>&nome=<?php echo $Funcionario->getNome();?>" class="btExcluir">
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
            header('Location: consultarFuncionario.php');
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