<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/CargoRepositorio.php';
include_once 'src/UnidadeRepositorio.php';

use src\CargoRepositorio;
use src\UnidadeRepositorio;

$CargoRepositorio = new CargoRepositorio();
$listaCargo = $CargoRepositorio->listarCargoDesbloqueado();
$quantidadeCargo = $CargoRepositorio->contarCargoDesbloqueado();

$UnidadeRepositorio = new UnidadeRepositorio();
$listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
$quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();


if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cadastro Funcionário - CPC68</title>
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
            	<form action="cadastrarFuncionario2.php" method="post">
            		<table class="form">
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60" maxlength="100" placeholder="Max: 100 caracteres" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Email:</label>
            				</td>
            				<td>
                    			<input type="text" name="email" size="60" maxlength="50" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Telefone:</label>
            				</td>
            				<td>
                    			<input type="text" name="telefone" id="telefone" size="13" maxlength="15" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Turno:</label>
            				</td>
            				<td>
                       			<select name="turno" required>
                       				<option value="" hidden="true" disabled selected>Selecione o turno</option>
                       				<option value="manha">Manhã</option>
                       				<option value="tarde">Tarde</option>
                       				<option value="noite">Noite</option>
                       				<option value="manha-tarde">Manhã e Tarde</option>
                       				<option value="tarde-noite">Tarde e Noite</option>
                       				<option value="noite-manha">Noite e Manhã</option>
                       			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                       			<label class="ast">*</label><label>Nível:</label>
            				</td>
            				<td>
                       			<select name="nivel" required>
                       				<option value="" hidden="true" disabled selected>Selecione o nível</option>
                       				<option value="1">Administrador</option>
                       				<option value="2">Supervisor</option>
                       				<option value="3">Aux. de Administração</option>
                       				<option value="4">Técnico</option>
                       				<option value="5">Operador</option>
                       			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Cargo:</label>
            				</td>
            				<td>
                    			<select name="idCargo" required>
                    				<option value="" hidden="true" disabled selected>Selecione o cargo</option>
                    					<?php
                                        $c = 0;
                                        while ($c < $quantidadeCargo) {
                                            echo "<option value='" . $listaCargo[$c]->getId() . "'>" . $listaCargo[$c]->getNome() . "</option>";
                                            $c++;
                                        }
                    				    ?>
                    			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Cargo superior:</label>
            				</td>
            				<td>
                    			<select name="idCargoSuperior" required>
                    				<option value="" hidden="true" disabled selected>Selecione o cargo superior</option>
                    					<?php
                                        $c = 0;
                                        while ($c < $quantidadeCargo) {
                                            echo "<option value='" . $listaCargo[$c]->getId() . "'>" . $listaCargo[$c]->getNome() . "</option>";
                                            $c++;
                                        }
                    				    ?>
                    			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Unidade:</label>
            				</td>
            				<td>
                    			<select name="idUnidade" required>
                    				<option value="" hidden="true" disabled selected>Selecione a unidade</option>
                    					<?php
                                        $c = 0;
                                        while ($c < $quantidadeUnidade) {
                                            echo "<option value='" . $listaUnidade[$c]->getId() . "'>" . $listaUnidade[$c]->getNome() . "</option>";
                                            $c++;
                                        }
                    				    ?>
                    			</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					&nbsp;
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2">
                    			<label class="ast">*</label><label>Login:</label>
                    			<input type="text" name="login" size="25" maxlength="25" placeholder="Max: 25 caracteres" required>
            					&nbsp;
            					&nbsp;
                    			<label class="ast">*</label><label>Senha:</label>
                    			<input type="password" name="senha" size="25" maxlength="15" placeholder="Max: 15 caracteres" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					&nbsp;
            				</td>
            			</tr>
            			<tr>
            				<td colspan="4">
                    			<div class="botoes">
                    				<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                    				<button class="btSalvar" type="submit"><img alt="" src="img/disk.png">Salvar</button>
                				</div>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2">
                                <?php
                                if ($_SESSION['resultado'] == 0) {
                                        echo "<label class='resultado0'>Cadastro efetuado com sucesso!</label>";
                                        $_SESSION['resultado'] = -1;
                                    } else if ($_SESSION['resultado'] == 1) {
                                        echo "<label class='resultado1'>Falha no cadastro.</label>";
                                        $_SESSION['resultado'] = -1;
                                    } else if ($_SESSION['resultado'] == 3) {
                                        echo "<label class='resultado1'>Cadastro já existente.</label>";
                                        $_SESSION['resultado'] = -1;
                                    }
                                ?>
            				</td>
            			</tr>
            		</table>
            		<input type="hidden" name="idAtorCadastro" value="<?php echo $_SESSION['id']; ?>">
            	</form>
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