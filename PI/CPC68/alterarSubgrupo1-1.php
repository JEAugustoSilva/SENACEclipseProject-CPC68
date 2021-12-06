<?php
session_start();
include_once 'src/Subgrupo.php';
include_once 'src/SubgrupoRepositorio.php';
use src\Subgrupo;
use src\SubgrupoRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Alteração Subgrupo - CPC68</title>
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
				<form action="alterarSubgrupo2.php" method="post">
					<div class="botoes">
                		<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
            			<input type="text" name="pesquisa" size="60" placeholder="Pesquisar o subgrupo por nome" required> <button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
                	</div>
					<p>
            			<?php if ($_SESSION['resultado'] == 1){
        				    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
        				    echo "<label class='resultado1'>Subgrupo não encontrado.</label>";
        				    } else {
        				    echo "<label class='resultado1'>Subgrupo não encontrado ou bloqueado.</label>";
        				    }
                            $_SESSION['resultado'] = -1;
        				}?>
            		</p>
				</form>
				<?php
				$idGrupo = $_GET['idGrupo'];
				$nomeGrupo = $_GET['nomeGrupo'];
				
				$Subgrupo = new Subgrupo();
				$SubgrupoRepositorio = new SubgrupoRepositorio();
				
			    $listaSubgrupo = $SubgrupoRepositorio->listarSubgrupoPorGrupo($idGrupo);
			    $quantidadeSubgrupo = $SubgrupoRepositorio->contarSubgrupoPorGrupo($idGrupo);
				?>
				<table>
            		<tr>
            			<td colspan="3" style="color: #fca235; font-weight: bold; font-size:20px;"><a href="alterarSubgrupo.php">Grupos</a> > Subgrupos de <?php echo $nomeGrupo;?></td>
            		</tr>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Nome</td>
                        <td style="color: #fca235; font-weight: bold;">Descrição</td>
                        <td style="color: #fca235; font-weight: bold;">Data de registro</td>
            		</tr>
            		<?php
            		$c = 0;
            		while ($c < $quantidadeSubgrupo) {
            		    $Subgrupo = $listaSubgrupo[$c];
            		  echo "<tr>";
            		  echo "<td><img alt='' src='img/bullet_go.png'>&nbsp;<a href='alterarSubgrupo2.php?pesquisa=" . $Subgrupo->getNome() . "'>" . $Subgrupo->getNome() ."</td>";
            		  echo "<td>&nbsp;" . $Subgrupo->getDescricao() . "&nbsp;</td>";
            		  echo "<td>&nbsp;" . date('d/m/Y - H:i',strtotime($Subgrupo->getDtRegistro())) . "&nbsp;</td>";
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