<?php
session_start();

include_once 'src/AtivoRepositorio.php';
include_once 'src/FuncionarioRepositorio.php';
include_once 'src/AmbienteRepositorio.php';
include_once 'src/UnidadeRepositorio.php';

use src\Ativo;
use src\AtivoRepositorio;
use src\AmbienteRepositorio;
use src\UnidadeRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Movimentação - CPC68</title>
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
		} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
		    $pesquisa = $_POST['pesquisa'];
		    $idUnidade = $_POST['idUnidade'];
		}
		
		$Ativo = new Ativo();
		$AtivoRepositorio = new AtivoRepositorio();
		
		if ($pesquisa != "") {
    		$Ativo->setCodigoBarra($pesquisa);
    		$Ativo = $AtivoRepositorio->consultarAtivo($Ativo);
		}
		
		if ($idUnidade != "") {
    		$AmbienteRepositorio = new AmbienteRepositorio();
    		$listaAmbiente = $AmbienteRepositorio->listarAmbienteDesbloqueadoPorUnidade($idUnidade);
    		$quantidadeAmbiente = $AmbienteRepositorio->contarAmbienteDesbloqueadoPorUnidade($idUnidade);
		}
		
		if ($Ativo->getId() != "" && $Ativo->getStatus() != 1 && $Ativo->getStatus() != 2 && $Ativo->getStatus() != 3) {
        ?>
		<div class="mainContainer">
       		<div class="mainConteudo">
       			<table class="form" style="width: 100%;">
       				<tr>
       					<td colspan="3" style="color: #fca235; font-weight: bold; font-size:20px; border: none; border-bottom: 1px solid #9b9b9b; padding-bottom: 10px;">Informações do ativo</td>
       				</tr>
       				<tr>
       					<td>
       						<label>Nome: <?php echo $Ativo->getNome();?></label>
       					</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Unidade: <?php echo $Ativo->getAmbiente()->getUnidade()->getNome();?></label>
	       				</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Grupo: <?php echo $Ativo->getSubgrupo()->getGrupo()->getNome();?></label>
       					</td>
       				</tr>
       				<tr>
       					<td>
       						<label>Descrição: <?php echo $Ativo->getDescricao();?></label>
       					</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Ambiente de origem: <?php echo $Ativo->getAmbiente()->getNome();?></label>
	       				</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Subgrupo: <?php echo $Ativo->getSubgrupo()->getNome();?></label>
       					</td>
       				</tr>
       				<tr>
       					<td>
       						<label>Tombamento: <?php echo $Ativo->getCodigoBarra();?></label>
       					</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Ambiente tombamento: <?php echo $Ativo->getAmbiente()->getCodigoBarra();?></label>
	       				</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Subgrupo descrição: <?php echo $Ativo->getSubgrupo()->getDescricao();?></label>
	       				</td>
       				</tr>
       				<tr>
       					<td>
       						<label>Cadastrante: <?php echo $Ativo->getFuncionario()->getNome();?></label>
       					</td>
       					<td style="border-left: 1px solid #9b9b9b;">
       						<label>Ambiente descrição: <?php echo $Ativo->getAmbiente()->getDescricao();?></label>
	       				</td>
       				</tr>
       				<tr>
       					<td>
       						<label>Data de registro: <?php echo $Ativo->getDtRegistro();?></label>
       					</td>
       				</tr>
       					<?php
       					if ($Ativo->getStatus() == 0) {
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
                        }
                        ?>
       				<tr>
       					<td>
       						<label>Status: <span <?php echo $cor;?>><?php echo $status;?></span></label>
       					</td>
       				</tr>
       			</table>
				<br/>

			    <!-- ------PARA OUTRA UNIDADE------ -->
				<form action="movimentacaoUni.php" method="post">
					<?php
					$UnidadeRepositorio = new UnidadeRepositorio();
                    $listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
                    $quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
                    ?>
					<div class="botoes" style="float: right; margin: 0; padding: 0; padding-top: 17px;">
					<label>Enviar para outra Unidade:</label>
        			<select name="idUnidadeDestino">
        				<option value="" hidden="true" disabled selected>Selecione a unidade</option>
        					<?php
                            $c = 0;
                            while ($c < $quantidadeUnidade) {
                                if ($listaUnidade[$c]->getId() != $idUnidade) {
                                    echo "<option value='" . $listaUnidade[$c]->getId() . "'>" . $listaUnidade[$c]->getNome() . "</option>";
                                }
                                $c++;
                            }
        				    ?>
        			</select>
        			<input type="hidden" name="idUnidade" value="<?php echo $idUnidade;?>">
        			<input type="hidden" name="pesquisa" value="<?php echo $pesquisa;?>">
        			<button class="btPesquisar" type="submit"><img alt="" src="img/arrow_right.png">Continuar</button>
					</div>
				</form>
			    <!-- ------PARA OUTRA UNIDADE------ -->
				
				<form action="movimentacao3.php" method="post">
           			<p>
           				<?php if ($Ativo->getStatus() != 1 && $Ativo->getStatus() != 2 && $Ativo->getStatus() != 3) {?>
            				<label class="radio"><input type="radio" name="tipo" value="1" required><span>Empréstimo</span></label>
            				&nbsp;&nbsp;
            				<label class="radio"><input type="radio" name="tipo" value="2" required><span>Transferência</span></label>
            				&nbsp;&nbsp;
            			<?php }?>
        				<label class="radio"><input type="radio" name="tipo" value="3" required><span>Ass. Técnica</span></label>
        				&nbsp;&nbsp;
        				<label class="radio"><input type="radio" name="tipo" value="4" required><span>Baixa</span></label>
    				</p>
    				<br/>
    				<p>
    					<label>Ambiente de origem:</label>
            			<select name="idAmbienteOrigem" disabled>
            					<?php
                                $c = 0;
                                $selected = "";
                                while ($c < $quantidadeAmbiente) {
                                    if ($Ativo->getAmbiente()->getId() == $listaAmbiente[$c]->getId()) {
                                        $selected = "selected";
                                    }
                                    echo "<option value='" . $listaAmbiente[$c]->getId() . "' " . $selected . ">" . $listaAmbiente[$c]->getNome() . "</option>";
                                    $selected = "";
                                    $c++;
                                }
            				    ?>
            			</select>
            			<input type="hidden" name="idAmbienteOrigem" value="<?php echo $Ativo->getAmbiente()->getId();?>">
            			
<!--     					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
    					
<!--             			<label>Ambiente atual:</label> -->
<!--             			<select name="idAmbienteAtual" disabled> -->
<!--             			<option value="0" hidden="true" disabled selected>N/A</option> -->
            					<?php
//                                 $c = 0;
//                                 $selected = "";
//                                 while ($c < $quantidadeAmbiente) {
//                                     if ($Ativo->getAmbiente()->getId() == $listaAmbiente[$c]->getId()) {
//                                         $selected = "selected";
//                                     }
//                                     echo "<option value='" . $listaAmbiente[$c]->getId() . "' " . $selected . ">" . $listaAmbiente[$c]->getNome() . "</option>";
//                                     $selected = "";
//                                     $c++;
//                                 }
//             				    ?>
<!--             			</select> -->
            			
            			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            			
            			<label>Ambiente destino:</label>
            			<select name="idAmbienteDestino">
            				<option value="" hidden="true" disabled selected>Selecione o ambiente</option>
            					<?php
                                $c = 0;
                                while ($c < $quantidadeAmbiente) {
                                    echo "<option value='" . $listaAmbiente[$c]->getId() . "'>" . $listaAmbiente[$c]->getNome() . "</option>";
                                    $c++;
                                }
            				    ?>
            			</select>
            		</p>
    				<p>
    					<label>Data de retorno:</label><input type="date" name="dtRetornoDate" value="<?php echo date('Y-m-d');?>">
    					&nbsp;&nbsp;
    					<select name="dtRetornoTime">
    						<option value="<?php echo date('H:i') .':00';?>"><?php echo date('H:i');?></option>
    						<option value="00:00:00">00:00</option>
    						<option value="00:30:00">00:30</option>
    						<option value="01:00:00">01:00</option>
    						<option value="01:30:00">01:30</option>
    						<option value="02:00:00">02:00</option>
    						<option value="02:30:00">02:30</option>
    						<option value="03:00:00">03:00</option>
    						<option value="03:30:00">03:30</option>
    						<option value="04:00:00">04:00</option>
    						<option value="04:30:00">04:30</option>
    						<option value="05:00:00">05:00</option>
    						<option value="05:30:00">05:30</option>
    						<option value="06:00:00">06:00</option>
    						<option value="06:30:00">06:30</option>
    						<option value="07:00:00">07:00</option>
    						<option value="07:30:00">07:30</option>
    						<option value="08:00:00">08:00</option>
    						<option value="08:30:00">08:30</option>
    						<option value="09:00:00">09:00</option>
    						<option value="09:30:00">09:30</option>
    						<option value="10:00:00">10:00</option>
    						<option value="10:30:00">10:30</option>
    						<option value="11:00:00">11:00</option>
    						<option value="11:30:00">11:30</option>
    						<option value="12:00:00">12:00</option>
    						<option value="12:30:00">12:30</option>
    						<option value="13:00:00">13:00</option>
    						<option value="13:30:00">13:30</option>
    						<option value="14:00:00">14:00</option>
    						<option value="14:30:00">14:30</option>
    						<option value="15:00:00">15:00</option>
    						<option value="15:30:00">15:30</option>
    						<option value="16:00:00">16:00</option>
    						<option value="16:30:00">16:30</option>
    						<option value="17:00:00">17:00</option>
    						<option value="17:30:00">17:30</option>
    						<option value="18:00:00">18:00</option>
    						<option value="18:30:00">18:30</option>
    						<option value="19:00:00">19:00</option>
    						<option value="19:30:00">19:30</option>
    						<option value="20:00:00">20:00</option>
    						<option value="20:30:00">20:30</option>
    						<option value="21:00:00">21:00</option>
    						<option value="21:30:00">21:30</option>
    						<option value="22:00:00">22:00</option>
    						<option value="22:30:00">22:30</option>
    						<option value="23:00:00">23:00</option>
    						<option value="23:30:00">23:30</option>
    					</select>
    				</p>
    				<p>
    					<label>Data de saída:</label><input type="date" name="dtSaidaDate" value="<?php echo date('Y-m-d');?>">
    					&nbsp;&nbsp;
    					<select name="dtSaidaTime">
    						<option value="<?php echo date('H:i') .':00';?>"><?php echo date('H:i');?></option>
    						<option value="00:00:00">00:00</option>
    						<option value="00:30:00">00:30</option>
    						<option value="01:00:00">01:00</option>
    						<option value="01:30:00">01:30</option>
    						<option value="02:00:00">02:00</option>
    						<option value="02:30:00">02:30</option>
    						<option value="03:00:00">03:00</option>
    						<option value="03:30:00">03:30</option>
    						<option value="04:00:00">04:00</option>
    						<option value="04:30:00">04:30</option>
    						<option value="05:00:00">05:00</option>
    						<option value="05:30:00">05:30</option>
    						<option value="06:00:00">06:00</option>
    						<option value="06:30:00">06:30</option>
    						<option value="07:00:00">07:00</option>
    						<option value="07:30:00">07:30</option>
    						<option value="08:00:00">08:00</option>
    						<option value="08:30:00">08:30</option>
    						<option value="09:00:00">09:00</option>
    						<option value="09:30:00">09:30</option>
    						<option value="10:00:00">10:00</option>
    						<option value="10:30:00">10:30</option>
    						<option value="11:00:00">11:00</option>
    						<option value="11:30:00">11:30</option>
    						<option value="12:00:00">12:00</option>
    						<option value="12:30:00">12:30</option>
    						<option value="13:00:00">13:00</option>
    						<option value="13:30:00">13:30</option>
    						<option value="14:00:00">14:00</option>
    						<option value="14:30:00">14:30</option>
    						<option value="15:00:00">15:00</option>
    						<option value="15:30:00">15:30</option>
    						<option value="16:00:00">16:00</option>
    						<option value="16:30:00">16:30</option>
    						<option value="17:00:00">17:00</option>
    						<option value="17:30:00">17:30</option>
    						<option value="18:00:00">18:00</option>
    						<option value="18:30:00">18:30</option>
    						<option value="19:00:00">19:00</option>
    						<option value="19:30:00">19:30</option>
    						<option value="20:00:00">20:00</option>
    						<option value="20:30:00">20:30</option>
    						<option value="21:00:00">21:00</option>
    						<option value="21:30:00">21:30</option>
    						<option value="22:00:00">22:00</option>
    						<option value="22:30:00">22:30</option>
    						<option value="23:00:00">23:00</option>
    						<option value="23:30:00">23:30</option>
    					</select>
    				</p>
    				<p>
    				<label>Descreva a movimentação:</label><br/>
						<textarea name="descricao" rows="5" cols="53" placeholder="Ex:
Motivo da movimentação...
Se o destino é Ass. Técnica, descreva o que está quebrado..."></textarea>
					</p>
					<input type="hidden" name="idAtivo" value="<?php echo $Ativo->getId();?>">
					<input type="hidden" name="nomeAmbienteOrigem" value="<?php echo $Ativo->getAmbiente()->getNome();?>">
					<input type="hidden" name="nomeUnidadeOrigem" value="<?php echo $Ativo->getAmbiente()->getUnidade()->getNome();?>">
					<input type="hidden" name="idUnidade" value="<?php echo $idUnidade;?>">
					<input type="hidden" name="idAtorCadastro" value="<?php echo $_SESSION['id'];?>">
					<div class="botoes">
        				<a href="movimentacao1-2.php?idUnidade=<?php echo $idUnidade;?>&idAmbiente=<?php echo $Ativo->getAmbiente()->getId();?>&nomeUnidade=<?php echo $Ativo->getAmbiente()->getUnidade()->getNome();?>&nomeAmbiente=<?php echo $Ativo->getAmbiente()->getNome();0?>" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
        				<button class="btSalvar" type="submit"><img alt="" src="img/disk.png">Salvar</button>
        				<a href="telaPrincipal.php" class="btVoltar"><img src="img/cross.png" alt="">Cancelar</a>
    				</div>
    				<p>
                        <?php
                        if ($_SESSION['resultado'] == 0) {
                                echo "<label class='resultado0'>Movimentação cadastrada com sucesso!</label>";
                                $_SESSION['resultado'] = -1;
                            } else if ($_SESSION['resultado'] == 1) {
                                echo "<label class='resultado1'>Falha no cadastro.</label>";
                                $_SESSION['resultado'] = -1;
                            }
                        ?>
        			</p>
				</form>
			</div>
		</div>
    	<?php
    	} else {
    	    if ($Ativo->getId() != "" && $Ativo->getStatus() != 0) {
    	        if ($Ativo->getStatus() == 1) {
        	       $_SESSION['resultado'] = 11; // EM EMPRESTIMO
    	        } else if ($Ativo->getStatus() == 2) {
            	    $_SESSION['resultado'] = 12; // EM ASS. TECNICA
    	        } else if ($Ativo->getStatus() == 3) {
            	    $_SESSION['resultado'] = 13; // EM BAIXA
    	        }
        	    header('Location: movimentacao1-1.php?idUnidade=' . $idUnidade .'&nomeUnidade=' . $listaAmbiente[0]->getUnidade()->getNome() . '');
    	    } else {
        	    $_SESSION['resultado'] = 1;
        	    header('Location: movimentacao1-1.php?idUnidade=' . $idUnidade .'&nomeUnidade=' . $listaAmbiente[0]->getUnidade()->getNome() . '');
    	    }
    
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