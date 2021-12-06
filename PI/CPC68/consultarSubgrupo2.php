<?php
session_start();

include_once 'src/GrupoRepositorio.php';
include_once 'src/Subgrupo.php';
include_once 'src/SubgrupoRepositorio.php';

use src\GrupoRepositorio;
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
	<title>Consulta Subgrupo - CPC68</title>
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
		$GrupoRepositorio = new GrupoRepositorio();
		$Subgrupo = new Subgrupo();
		$Subgrupo->setNome($pesquisa);
		$SubgrupoRepositorio = new SubgrupoRepositorio();
        
        if ($pesquisa != "") {
            if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                $Subgrupo = $SubgrupoRepositorio->consultarSubgrupo($Subgrupo);
                $listaGrupo = $GrupoRepositorio->listarTodoGrupo();
                $quantidadeGrupo = $GrupoRepositorio->contarTodoGrupo();
            } else {
                $Subgrupo = $SubgrupoRepositorio->consultarSubgrupoPorNome($Subgrupo);
                $listaGrupo = $GrupoRepositorio->listarTodoGrupo();
                $quantidadeGrupo = $GrupoRepositorio->contarGrupoDesbloqueado();
            }
        }
        
        if ($Subgrupo->getId() != "") {
        ?>
        <div class="mainContainer">
            <div class="mainConteudo">
            	<table class="form">
        			<tr>
        				<td>
                			<label>Nome:</label>
        				</td>
        				<td>
                			<input readonly type="text" name="nome" size="60px" value="<?php echo $Subgrupo->getNome(); ?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                       		<label>Descrição:</label>
        				</td>
        				<td>
                       		<textarea readonly name="descricao" rows="5" cols="53"><?php echo $Subgrupo->getDescricao(); ?></textarea>
        				</td>
        			</tr>
        			<tr>
        				<td>
                			<label>Data de Registro:</label>
        				</td>
        				<td>
                			<input readonly type="text" name="dtRegistro" value="<?php echo date('d/m/Y - H:i',strtotime($Subgrupo->getDtRegistro())); ?>">
        				</td>
        			</tr>
        			<tr>
        				<td>
                			<label>Unidade:</label>
        				</td>
        				<td>
                			<select disabled name="idUnidade" required>
                				<?php
                				$c = 0;
                				while ($c < $quantidadeGrupo) {
                    				$selected = "";
                    				if ($Subgrupo->getGrupo()->getId() == $listaGrupo[$c]->getId()) {
                                        $selected = "selected";
                                    }
                                    echo "<option readonly value='" . $listaGrupo[$c]->getId() . "' " . $selected . ">" . $listaGrupo[$c]->getNome() . "</option>";
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
                       			<a href="consultarSubgrupo.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
               				<?php if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {?>
               					<?php if ($Subgrupo->getSituacao() != 0) {?>
               						<a href="desbloquearSubgrupo.php?id=<?php echo $Subgrupo->getId();?>&nome=<?php echo $Subgrupo->getNome();?>" class="btDesbloquear">
               						<img src="img/report_add.png" alt="">Desbloquear
               						</a>
               					<?php } else {?>
               						<a href="bloquearSubgrupo.php?id=<?php echo $Subgrupo->getId();?>&nome=<?php echo $Subgrupo->getNome();?>" class="btBloquear">
            						<img src="img/report_delete.png" alt="">Bloquear
            						</a>
               					<?php }
                                  }
               					  if ($_SESSION['nivel'] == 1) {?>
               						<a href="excluirSubgrupo.php?id=<?php echo $Subgrupo->getId();?>&nome=<?php echo $Subgrupo->getNome();?>" class="btExcluir">
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
            header('Location: consultarSubgrupo.php');
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