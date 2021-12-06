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
		<?php
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $pesquisa = $_GET['pesquisa'];
        } else {
            $pesquisa = $_POST['pesquisa'];
        }

        $Subgrupo = new Subgrupo();
        $Subgrupo->setNome($pesquisa);
        $SubgrupoRepositorio = new SubgrupoRepositorio();

        $GrupoRepositorio = new GrupoRepositorio();
        $listaGrupo = $GrupoRepositorio->listarGrupoDesbloqueado();
        $quantidadeGrupo = $GrupoRepositorio->contarGrupoDesbloqueado();

        if ($pesquisa != "") {
          $Subgrupo = $SubgrupoRepositorio->consultarSubgrupoPorNome($Subgrupo);
        }
        
        if ($Subgrupo->getId() != "") {
        ?>
        <div class="mainContainer">
       		<div class="mainConteudo">
    			<form action="alterarSubgrupo3.php" method="post">
    				<table class="form">
            			<tr>
            				<td>
                    			<label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60px" value="<?php echo $Subgrupo->getNome(); ?>">
            				</td>
            			</tr>
            			<tr>
            				<td>
                           		<label>Descrição:</label>
            				</td>
            				<td>
                           		<textarea name="descricao" rows="5" cols="53"><?php echo $Subgrupo->getDescricao(); ?></textarea>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Grupo:</label>
            				</td>
            				<td>
                    			<select name="idGrupo" required>
                    				<?php
                    				$c = 0;
                    				while ($c < $quantidadeGrupo) {
                        				$selected = "";
                        				if ($Subgrupo->getGrupo()->getId() == $listaGrupo[$c]->getId()) {
                                            $selected = "selected";
                                        }
                                        echo "<option value='" . $listaGrupo[$c]->getId() . "' " . $selected . ">" . $listaGrupo[$c]->getNome() . "</option>";
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
                            		<input type="hidden" name="id" value="<?php echo $Subgrupo->getId(); ?>">
                            		<a href="alterarSubgrupo.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
                            		<button class="btSalvar" type="submit"><img alt="" src="img/tick.png">Alterar</button>
                        		</div>
            				</td>
            			</tr>
            			<tr>
            				<td colspan="2">
                        		<?php if ($_SESSION['resultado'] == 0) {
                        	        echo "<label class='resultado0'>Subgrupo alterado com sucesso!</label>";
                        	        $_SESSION['resultado'] = -1;
                        	    } else if ($_SESSION['resultado'] == 1) {
                        	        echo "<label class='resultado1'>Falha na alteração do subgrupo.</label>";
                        	        $_SESSION['resultado'] = -1;
                        	    }?>
            				</td>
            			</tr>
            		</table>
    			</form>
    		</div>
		</div>
    	<?php
        } else {
            $_SESSION['resultado'] = 1;
            header('Location: alterarSubgrupo.php');
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