<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

include_once 'src/SubgrupoRepositorio.php';
include_once 'src/AmbienteRepositorio.php';

use src\SubgrupoRepositorio;
use src\AmbienteRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cadastro Ativo - CPC68</title>
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
	    $idUnidade = $_GET['idUnidade'];
	} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	   $idUnidade = $_POST['idUnidade'];
	}
	
	$SubgrupoRepositorio = new SubgrupoRepositorio();
	$listaSubgrupo = $SubgrupoRepositorio->listarSubgrupoDesbloqueado();
	$quantidadeSubgrupo = $SubgrupoRepositorio->contarSubgrupoDesbloqueado();
	
	$AmbienteRepositorio = new AmbienteRepositorio();
	$listaAmbiente = $AmbienteRepositorio->listarAmbienteDesbloqueadoPorUnidade($idUnidade);
	$quantidadeAmbiente = $AmbienteRepositorio->contarAmbienteDesbloqueadoPorUnidade($idUnidade);
	
	?>
		<div class="mainContainer">
        	<div class="mainConteudo">
				<form action="cadastrarAtivo3.php" method="post">
					<table class="form">
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60" maxlength="100" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Descrição:</label>
            				</td>
            				<td>
                    			<textarea name="descricao" rows="5" cols="53" maxlength="255"></textarea>
            				</td>
            			</tr>
            			<tr>
            				<td>
        						<label class="ast">*</label><label>Subgrupo:</label>
            				</td>
            				<td>
        						<select name="idSubgrupo" required>
        							<option value="" hidden="true" disabled selected>Selecione o subgrupo</option>
            						<?php
                					$c = 0;
            						while ($c < $quantidadeSubgrupo) {
            						    echo "<option value='" . $listaSubgrupo[$c]->getId() . "'>" . $listaSubgrupo[$c]->getNome() . "</option>";
                    					    $c++;
                    					}
            						?>
        						</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
        						<label class="ast">*</label><label>Ambiente:</label>
            				</td>
            				<td>
        						<select name="idAmbiente" required>
        							<option value="" hidden="true" disabled selected>Selecione o ambiente</option>
            						<?php
                					$c = 0;
            						while ($c < $quantidadeAmbiente) {
            						    echo "<option value='" . $listaAmbiente[$c]->getId() . "'>" . $listaAmbiente[$c]->getNome() . "</option>";
                    					    $c++;
                    					}
            						?>
        						</select>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Tombamento:</label>
            				</td>
            				<td>
                    			<input type="text" name="codigoBarra" size="25" maxlength="10" required>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2">
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
            		<input type="hidden" name="idFuncionario" value="<?php echo $_SESSION['id']; ?>">
            		<input type="hidden" name="idUnidade" value="<?php echo $idUnidade; ?>">
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