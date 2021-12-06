<?php
session_start();

include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';
include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';
include_once 'src/SubgrupoRepositorio.php';
include_once 'src/AmbienteRepositorio.php';

use src\SubgrupoRepositorio;
use src\AmbienteRepositorio;
use src\Ativo;
use src\AtivoRepositorio;
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
	<title>Consulta Ativo - CPC68</title>
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
		$Ativo->setCodigoBarra($pesquisa);
		$AtivoRepositorio = new AtivoRepositorio();
		$Funcionario = new Funcionario();
		
		if ($pesquisa != "") {
        		$Ativo = $AtivoRepositorio->consultarAtivo($Ativo);
        		
            	$SubgrupoRepositorio = new SubgrupoRepositorio();
            	$listaSubgrupo = $SubgrupoRepositorio->listarSubgrupo();
            	$quantidadeSubgrupo = $SubgrupoRepositorio->contarSubgrupo();
            	
        		$AmbienteRepositorio = new AmbienteRepositorio();
        		$listaAmbiente = $AmbienteRepositorio->listarAmbientePorUnidade($idUnidade);
        		$quantidadeAmbiente = $AmbienteRepositorio->contarAmbientePorUnidade($idUnidade);
        		
        		$Funcionario->setId($Ativo->getFuncionario()->getId());
        		$FuncionarioRepositorio = new FuncionarioRepositorio();
        		$Funcionario = $FuncionarioRepositorio->consultarFuncionarioPorId($Funcionario);
		}
        
		if ($Ativo->getId() != "") {
		    ?>
        <div class="mainContainer">
		    <div class="mainConteudo">
		    	<table class="form">
		    		<tr>
		    			<td>
                			<label>Nome:</label>
		    			</td>
		    			<td>
                			<input type="text" readonly name="nome" size="60" value="<?php echo $Ativo->getNome();?>">
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>
                			<label>Descrição:</label>
		    			</td>
		    			<td>
                			<textarea readonly name="descricao" rows="5" cols="53"><?php echo $Ativo->getDescricao();?></textarea>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>
        					<label>Subgrupo:</label>
		    			</td>
		    			<td>
        					<select name="idSubgrupo" disabled>
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
            				<label>Ambiente:</label>
		    			</td>
		    			<td>
            				<select name="idAmbiente" disabled>
            					<?php
            					$c = 0;
            					$selected = "";
            					while ($c < $quantidadeAmbiente) {
            					    if ($Ativo->getAmbiente()->getId() == $listaAmbiente[$c]->getId()) {
            					        $selected = "selected";
            					    }
            					    echo "<option value='" . $listaAmbiente[$c]->getId() . "'>" . $listaAmbiente[$c]->getNome() . "</option>";
                					    $c++;
                					    $selected = "";
                					}
            					?>
            				</select>
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>
                			<label>Tombamento:</label>
		    			</td>
		    			<td>
                			<input type="text" readonly name="codigoBarra" size="25" maxlength="10" value="<?php echo $Ativo->getCodigoBarra();?>">
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>
                			<label>Funcionário cadastrante:</label>
		    			</td>
		    			<td>
                			<input type="text" readonly name="idFuncionario" size="25" value="<?php echo $Funcionario->getNome();?>">
		    			</td>
		    		</tr>
		    		<tr>
		    			<td>
                			<label>Data de registro:</label>
		    			</td>
		    			<td>
                			<input type="text" readonly name="dtRegistro" size="25" value="<?php echo $Ativo->getDtRegistro();?>">
		    			</td>
		    		</tr>
		    		<tr>
	    				<?php if ($Ativo->getStatus() == 0) {
                                    $status = 'OK';
                                    $cor = 'style="font-weight: bold; color: green;"';
                                } else if ($Ativo->getStatus() == 1) {
                                    $status = "Em empréstimo";
                                    $cor = 'style="font-weight: bold; color: orange;"';
                                } else if ($Ativo->getStatus() == 2) {
                                    $status = "Em ass. técnica";
                                    $cor = 'style="font-weight: bold; color: orange;"';
                                } else if ($Ativo->getStatus() == 3) {
                                    $status = "Em baixa";
                                    $cor = 'style="font-weight: bold; color: red;"';
                                } else if ($Ativo->getStatus() == 10) {
                                    $status = "Mal funcionamento";
                                    $cor = 'style="font-weight: bold; color: orange;"';
                                } else if ($Ativo->getStatus() == 11) {
                                    $status = "Quebrado";
                                    $cor = 'style="font-weight: bold; color: red;"';
                                } else if ($Ativo->getStatus() == 12) {
                                    $status = "Sem Tombamento";
                                    $cor = 'style="font-weight: bold; color: orange;"';
                                } else if ($Ativo->getStatus() == 13) {
                                    $status = "Ausente";
                                    $cor = 'style="font-weight: bold; color: red;"';
                                }?>
		    			<td>
							<label>Status:</label>
		    			</td>
		    			<td>
		    				<input type="text" readonly name="status" <?php echo $cor;?> size="17" value="<?php echo $status;?>">
		    			</td>
		    		</tr>
		    		<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 3 || $_SESSION['nivel'] == 4) {?>
		    		<tr>
		    			<td style="border: 1px solid #ccc;" colspan="2">
                    		<form  action="statAtivo.php" method="GET">
                    			<span>Atualizar status do ativo:</span><br/>
           						<textarea name="descricao" rows="5" cols="53" placeholder="Motivo/Descrição da atualização"></textarea><br/>
           						<input type="hidden" name="id" value="<?php echo $Ativo->getId();?>">
           						<input type="hidden" name="codigoBarra" value="<?php echo $Ativo->getCodigoBarra();?>">
           						<input type="hidden" name="idUnidade" value="<?php echo $idUnidade;?>">
           						<input type="hidden" name="nomeUnidade" value="<?php echo $nomeUnidade;?>">
                    			<div class="botoes">
                        			<button class="btPesquisar" type="submit" name="atualizar" value="0"><img alt="" src="img/accept.png">OK</button>
                        			<button class="btPesquisar" type="submit" name="atualizar" value="10"><img alt="" src="img/wrench.png">Mal Funcionamento</button>
                        			<button class="btPesquisar" type="submit" name="atualizar" value="11"><img alt="" src="img/wrench_orange.png">Quebrado</button>
                        			<button class="btPesquisar" type="submit" name="atualizar" value="12"><img alt="" src="img/timeline_marker.png">Sem Tombamento</button>
                        			<button class="btPesquisar" type="submit" name="atualizar" value="13"><img alt="" src="img/error.png">Ausente</button>
                    			</div>
                    		</form>
		    			</td>
		    		</tr>
                    <?php } ?>
		    		<tr>
		    			<td colspan="2">
                    		<div class="botoes">
                       			<a href="consultarAtivo.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                                <?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2 || $_SESSION['nivel'] == 3) {?>
                                	<?php if ($Ativo->getSituacao() != 0) {?>
                                		<a href="desbloquearAtivo.php?id=<?php echo $Ativo->getId();?>&codigoBarra=<?php echo $Ativo->getCodigoBarra();?>&idUnidade=<?php echo $idUnidade;?>&nomeUnidade=<?php echo $nomeUnidade;?>" class="btDesbloquear">
                                		<img src="img/report_add.png" alt="">Desbloquear
                                		</a>
                                	<?php } else {?>
                                		<a href="bloquearAtivo.php?id=<?php echo $Ativo->getId();?>&codigoBarra=<?php echo $Ativo->getCodigoBarra();?>&idUnidade=<?php echo $idUnidade;?>&nomeUnidade=<?php echo $nomeUnidade;?>" class="btBloquear">
                                		<img src="img/report_delete.png" alt="">Bloquear
                                		</a>
                                	<?php }
                                      }
                                	  if ($_SESSION['nivel'] == 1) {?>
                                		<a href="excluirAtivo.php?id=<?php echo $Ativo->getId();?>&codigoBarra=<?php echo $Ativo->getCodigoBarra();?>&idUnidade=<?php echo $idUnidade;?>&nomeUnidade=<?php echo $nomeUnidade;?>" class="btExcluir">
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
            header('Location: consultarAtivo1-1.php?idUnidade=' . $idUnidade . '&nomeUnidade=' . $nomeUnidade);
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