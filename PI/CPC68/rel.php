<?php
session_start();

include_once 'src/UnidadeRepositorio.php';

use src\UnidadeRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Relatórios - CPC68</title>
	<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<style>
.form td{
    padding: 0px 30px 0px 30px;
}
.botoes .rel{
    width: 100%;
}
</style>
<body>
<?php
$UnidadeRepositorio = new UnidadeRepositorio();
$listaUnidade = $UnidadeRepositorio->listarUnidadeDesbloqueado();
$quantidadeUnidade = $UnidadeRepositorio->contarUnidadeDesbloqueado();
?>



<!-- NAV -->
<?php include_once 'includes/nav.php';?>


<!-- Side Menu -->
<?php include_once 'includes/sideMenu.php';?>
    
    
    <!-- Main -->
    <div id="main">
    	<div class="mainContainer">
        	<div class="mainConteudo">
    			<form method="GET">
            		<table class="form">
            			<tr>
                			<td style="border-bottom: 1px solid #ccc; padding:10px 30px 25px 30px;">
                				<label>Relatórios da unidade:</label>
                    			<select name="idUnidade" required>
                    					<?php
                                        $c = 0;
                                        while ($c < $quantidadeUnidade) {
                                            if ($listaUnidade[$c]->getId() == $_SESSION['unidade']) {
                                                echo "<option value='" . $listaUnidade[$c]->getId() . "' selected>" . $listaUnidade[$c]->getNome() . "</option>";
                                            } else {
                                                echo "<option value='" . $listaUnidade[$c]->getId() . "'>" . $listaUnidade[$c]->getNome() . "</option>";
                                            }
                                            $c++;
                                        }
                    				    ?>
                    			</select>
            				</td>
            			</tr>
            			<tr>
            				<td style="border-bottom: 1px solid #ccc; padding-bottom: 20px; padding-top: 20px;">
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosDaUnidade.php" type="submit"><img alt="" src="img/report.png">Ativos da unidade</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td style="padding-top: 20px;">
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosOutraUnidade.php" type="submit"><img alt="" src="img/building_go.png">Ativos em outra unidade</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosOutroAmbiente.php" type="submit"><img alt="" src="img/tab_go.png">Ativos em outro ambiente</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosAssTec.php" type="submit"><img alt="" src="img/error_go.png">Ativos em ass. técnica</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td style="border-bottom: 1px solid #ccc; padding-bottom: 20px;">
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosBaixa.php" type="submit"><img alt="" src="img/report_delete.png">Ativos em baixa</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td style="padding-top: 20px;">
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosMalFunc.php" type="submit"><img alt="" src="img/wrench.png">Ativos com mal funcionamento</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosQuebrados.php" type="submit"><img alt="" src="img/wrench_orange.png">Ativos quebrados</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosSemTomb.php" type="submit"><img alt="" src="img/timeline_marker.png">Ativos sem tombamento</button>
            					</div>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<div class="botoes">
            						<button class="btPesquisar rel" formaction="relAtivosAusentes.php" type="submit"><img alt="" src="img/error.png">Ativos ausentes</button>
            					</div>
            				</td>
            			</tr>
            		</table>
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