<?php
session_start();

include_once 'src/Grupo.php';
include_once 'src/Subgrupo.php';
include_once 'src/SubgrupoRepositorio.php';
include_once 'src/Ambiente.php';
include_once 'src/Funcionario.php';
include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';

use src\Ativo;
use src\AtivoRepositorio;
use src\SubgrupoRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Alteração Ativo - CPC68</title>
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
    	    $idUnidade = $_GET['idUnidade'];
    	    $nomeUnidade = $_GET['nomeUnidade'];
    	} else {
    	    $pesquisa = $_POST['pesquisa'];
    	    $idUnidade = $_POST['idUnidade'];
    	    $nomeUnidade = $_POST['nomeUnidade'];
    	}
    	
    	$Ativo = new Ativo();
    	$AtivoRepositorio = new AtivoRepositorio();
    	if ($pesquisa != "") {
    	    $Ativo->setCodigoBarra($pesquisa);
    	    $Ativo = $AtivoRepositorio->consultarAtivo($Ativo);
    	}
    	
    	$SubgrupoRepositorio = new SubgrupoRepositorio();
    	$listaSubgrupo = $SubgrupoRepositorio->listarSubgrupoDesbloqueado();
    	$quantidadeSubgrupo = $SubgrupoRepositorio->contarSubgrupoDesbloqueado();
    	if ($Ativo->getId() != "") {
    	?>
		<div class="mainContainer">
        	<div class="mainConteudo">
				<form action="alterarAtivo3.php" method="post">
					<table class="form">
            			<tr>
            				<td colspan="2">
        						<label style=" font-size: 12px; color: #999;">* Para alterar Ambiente de ativo, por favor faça uma transferência (Movimentação).</label>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60" value="<?php echo $Ativo->getNome();?>" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Descrição:</label>
            				</td>
            				<td>
                    			<textarea name="descricao" rows="5" cols="53"><?php echo $Ativo->getDescricao();?></textarea>
            				</td>
            			</tr>
            			<tr>
            				<td>
        						<label class="ast">*</label><label>Subgrupo:</label>
            				</td>
            				<td>
        						<select name="idSubgrupo" required>
            						<?php
                					$c = 0;
            						$selected = "";
            						while ($c < $quantidadeSubgrupo) {
            						    if ($Ativo->getSubgrupo()->getId() == $listaSubgrupo[$c]->getId()) {
                                            $selected = "selected";
            						    }
            						    echo "<option value='" . $listaSubgrupo[$c]->getId() . "' " . $selected . ">" . $listaSubgrupo[$c]->getNome() . "</option>";
                    					    $c++;
                    						$selected = "";
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
                    			<input type="text" name="codigoBarra" size="25" maxlength="10" value="<?php echo $Ativo->getCodigoBarra();?>" required>
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
                                    echo "<label class='resultado0'>Alteração efetuada com sucesso!</label>";
                                    $_SESSION['resultado'] = -1;
                                } else if ($_SESSION['resultado'] == 1) {
                                    echo "<label class='resultado1'>Falha na alteração do ativo.</label>";
                                    $_SESSION['resultado'] = -1;
                                }
                                ?>
            				</td>
            			</tr>
            		</table>
            		<input type="hidden" name="id" value="<?php echo $Ativo->getId();?>">
            		<input type="hidden" name="idUnidade" value="<?php echo $idUnidade;?>">
            		<input type="hidden" name="nomeUnidade" value="<?php echo $nomeUnidade;?>">
				</form>
			</div>
		</div>
		<?php
        } else {
            $_SESSION['resultado'] = 1;
            header('Location: alterarAtivo1-1.php?idUnidade=' . $idUnidade . '&nomeUnidade=' . $nomeUnidade);
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