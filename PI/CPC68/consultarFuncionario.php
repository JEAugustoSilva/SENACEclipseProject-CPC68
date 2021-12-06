<?php
session_start();

include_once 'src/FuncionarioRepositorio.php';

use src\FuncionarioRepositorio;

if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Consulta Funcionário - CPC68</title>
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
        		<form action="consultarFuncionario2.php" method="post">
        			<div class="botoes">
                		<a href="telaPrincipal.php" class="btVoltar"><img src="img/arrow_left.png" alt="">Voltar</a>
            			<input type="text" name="pesquisa" size="60" placeholder="Pesquisar o funcionário por nome" required> <button class="btPesquisar" type="submit" value="Pesquisar"><img alt="" src="img/magnifier.png"></button>
                		<p>
                			<?php if ($_SESSION['resultado'] == 1){
            				    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
            				    echo "<label class='resultado1'>Funcionário não encontrado.</label>";
            				    } else {
            				    echo "<label class='resultado1'>Funcionário não encontrado ou bloqueado.</label>";
            				    }
                                $_SESSION['resultado'] = -1;
            				}?>
                		</p>
            		</div>
        		</form>
    			<?php
                    $FuncionarioRepositorio = new FuncionarioRepositorio();
                    
                    if ($_SESSION['nivel'] == 1 || $_SESSION['nivel'] == 2) {
                        $listaFuncionario = $FuncionarioRepositorio->listarFuncionario();
                        $quantidadeFuncionario = $FuncionarioRepositorio->contarFuncionario();
                    } else {
                        $listaFuncionario = $FuncionarioRepositorio->listarFuncionarioDesbloqueado();
                        $quantidadeFuncionario = $FuncionarioRepositorio->contarFuncionarioDesbloqueado();
                    }
    			?>
				<table>
            		<tr>
            			<td style="color: #fca235; font-weight: bold;">Nome</td>
            			<td style="color: #fca235; font-weight: bold;">Cargo</td>
                        <td style="color: #fca235; font-weight: bold;">Turno</td>
                        <td style="color: #fca235; font-weight: bold;">Nível</td>
            		</tr>
            		<?php
            		$c = 0;
            		while ($c < $quantidadeFuncionario) {
            		  echo "<tr>";
            		  echo "<td><img alt='' src='img/bullet_go.png'>&nbsp;<a href='consultarFuncionario2.php?pesquisa=" . $listaFuncionario[$c]->getNome() . "'>" . $listaFuncionario[$c]->getNome() ."</td>";
            		  echo "<td>&nbsp;" . $listaFuncionario[$c]->getCargo()->getNome() . "&nbsp;</td>";
            		  
            		  if ($listaFuncionario[$c]->getTurno() == "manha") {
            		      $turno = "Manhã";
            		  } else if ($listaFuncionario[$c]->getTurno() == "tarde") {
            		      $turno = "Tarde";
            		  } else if ($listaFuncionario[$c]->getTurno() == "noite") {
            		      $turno = "Noite";
            		  } else if ($listaFuncionario[$c]->getTurno() == "manha-tarde") {
            		      $turno = "Manhã e Tarde";
            		  } else if ($listaFuncionario[$c]->getTurno() == "tarde-noite") {
            		      $turno = "Tarde e Noite";
            		  } else if ($listaFuncionario[$c]->getTurno() == "noite-manha") {
            		      $turno = "Manhã e Noite";
            		  } else {
            		      $turno = "N/A";
            		  }
            		  echo "<td>&nbsp;" . $turno . "&nbsp;</td>";
            		  
            		  if ($listaFuncionario[$c]->getNivel() == 1) {
            		      $nivel = "Coordenador";
            		  } else if ($listaFuncionario[$c]->getNivel() == 2) {
            		      $nivel = "Supervisor";
            		  } else if ($listaFuncionario[$c]->getNivel() == 3) {
            		      $nivel = "Aux. de Coordenação";
            		  } else if ($listaFuncionario[$c]->getNivel() == 4) {
            		      $nivel = "Professor";
            		  } else if ($listaFuncionario[$c]->getNivel() == 5) {
            		      $nivel = "Operador";
            		  }
            		  echo "<td>&nbsp;" . $nivel . "&nbsp;</td>";
            		  
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