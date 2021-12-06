<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/GrupoRepositorio.php';
use src\GrupoRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
$GrupoRepositorio = new GrupoRepositorio();
$listaGrupo = $GrupoRepositorio->listarGrupoDesbloqueado();
$quantidadeGrupo = $GrupoRepositorio->contarGrupoDesbloqueado();
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Cadastro Subgrupo - CPC68</title>
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
        		<form action="cadastrarSubgrupo2.php" method="post">
        			<table class="form">
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Nome:</label>
            				</td>
            				<td>
                    			<input type="text" name="nome" size="60" required>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label>Descrição:</label>
            				</td>
            				<td>
                				<textarea name="descricao" rows="5" cols="53"></textarea>
            				</td>
            			</tr>
            			<tr>
            				<td>
                    			<label class="ast">*</label><label>Grupo:</label>
            				</td>
            				<td>
                    			<select name="idGrupo" required>
                    				<option value="0" hidden="true" disabled selected>Selecione um grupo</option>
                    					<?php
                                        $c = 0;
                                        while ($c < $quantidadeGrupo) {
                                            echo "<option value='" . $listaGrupo[$c]->getId() . "'>" . $listaGrupo[$c]->getNome() . "</option>";
                                            $c++;
                                        }
                    				    ?>
                    			</select>
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