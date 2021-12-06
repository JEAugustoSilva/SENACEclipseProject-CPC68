<?php
session_start();

include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';

use src\Ativo;
use src\AtivoRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
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
        <div class="mainContainer">
        	<div class="mainConteudo">
                <form action="movimentacao2.php" method="post">
                	<div class="botoes">
                		<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
            			<input type="hidden" name="idUnidade" value="<?php echo $_GET['idUnidade'];?>">
            			<input type="text" name="pesquisa" size="60" placeholder="Pesquisar ativo por tombamento" required> <button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
                	</div>
    				<p>
        				<?php
                        if ($_SESSION['resultado'] != -1){
                            if ($_SESSION['resultado'] == 0) {
                                echo "<label class='resultado0'>Movimentação cadastrada com sucesso!</label>";
                            } else if ($_SESSION['resultado'] == 1) {
                                echo "<label class='resultado1'>Falha no cadastro.</label>";
                            } else if ($_SESSION['resultado'] == 3) {
                                echo "<label class='resultado2'>Movimentação já existente.</label>";
                            }
                            $_SESSION['resultado'] = -1;
        				}
        				?>
            		</p>
            	</form>
            	<?php
                $idAmbiente = $_GET['idAmbiente'];
                $nomeAmbiente = $_GET['nomeAmbiente'];
                $idUnidade = $_GET['idUnidade'];
                $nomeUnidade = $_GET['nomeUnidade'];
                
                $Ativo = new Ativo();
                $AtivoRepositorio = new AtivoRepositorio();
                
                $listaAtivo = $AtivoRepositorio->listarAtivoPorAmbienteDesbloqueado($idAmbiente);
                $quantidadeAtivo = $AtivoRepositorio->contarAtivoPorAmbienteDesbloqueado($idAmbiente);
            	?>
            	<table>
            		<tr>
            			<td colspan="5" style="color: #fca235; font-weight: bold; font-size:20px;"><a href="movimentacao1.php">Unidades</a> > <a href="movimentacao1-1.php?idUnidade=<?php echo $idUnidade;?>&nomeUnidade=<?php echo $nomeUnidade;?>">Ambientes</a> > Ativos em <?php echo $nomeAmbiente;?></td>
            		</tr>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Nome</td>
                        <td style="color: #fca235; font-weight: bold;">Tombamento</td>
                        <td style="color: #fca235; font-weight: bold;">Descrição</td>
                        <td style="color: #fca235; font-weight: bold;">Status</td>
                        <td style="color: #fca235; font-weight: bold;">Data de registro</td>
            		</tr>
            		<?php
            		$c = 0;
            		while ($c < $quantidadeAtivo) {
            		    $Ativo = $listaAtivo[$c];
                        echo "<tr>";
                        if ($Ativo->getStatus() == 1 || $Ativo->getStatus() == 2 || $Ativo->getStatus() == 3) {
                            echo "<td style='padding-left: 40px;'>" . $Ativo->getNome() ."</td>";
                        } else {
                            echo "<td><img alt='' src='img/bullet_go.png'>&nbsp;<a href='movimentacao2.php?pesquisa=" . $Ativo->getCodigoBarra() . "&idUnidade=" . $idUnidade . "'>" . $Ativo->getNome() ."</td>";
                        }
                        echo "<td>&nbsp;" . $Ativo->getCodigoBarra() . "&nbsp;</td>";
                        echo "<td>&nbsp;" . $Ativo->getDescricao() . "&nbsp;</td>";
                        
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
                        echo "<td><span " . $cor . ">&nbsp;" . $status . "&nbsp;</span></td>";
                        
                        echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Ativo->getDtRegistro())) . "&nbsp;</td>";
                        echo "</tr>";
                        $c++;
            		}
            		?>
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