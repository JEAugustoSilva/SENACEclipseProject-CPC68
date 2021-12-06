<?php 
session_start();

include_once 'src/DatabaseRepositorio.php';
use src\DatabaseRepositorio;
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Login - CPC68</title>
	<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body>
    <nav class="nav">
    	<button class="hamburger" id="btSideNav">
          <span>OS 3 TRACINHOS QUE VAO SER ANIMADOS</span>
        </button>
    	<span><a class="logo" href="telaPrincipal.php"><img width="128px" alt="" src="img/logo.png"></a></span>
    	<div class="links">
    		<a href="rel.php">Relatórios</a>
    		<a href="#">Serviços</a>
    		<a href="#">Sobre</a>
        	<div class="user">
            	<a href='index.php'>Login</a>
        	</div>
    	</div>
    </nav>
    <div id="sideMenu" class="sideMenu">
    	<div align="center" style=" font-size: 20px; margin-top: 50px;">
    	<label>Por Favor <br/><br/> Efetue o login</label>
    	</div>
    </div>
	<div id="main">
		<div class="mainContainer">
       		<div class="mainConteudo">
            	<table style="width: 350px; margin-left: auto; margin-right: auto;">
            	<tr>
            		<td>
                    	<form action="validarLogin.php" method="post">
                    		<p align="center" style="padding-right: 8px;">
                    			<label style="font-weight: bold; font-size: 20px; color: #ffb255;">Acesso ao sistema</label>
                    		</p>
                    		<br/>
                    		<p align="center" style="padding-right: 8px;">
                    			<label>Usuário:</label> <input style="background-color: transparent;" type="text" name="login" required>
                    		</p>
                    		<p align="center">
                    			<label>Senha:</label> <input style="background-color: transparent;" type="password" name="senha" required>
                    		</p>
                    		<p align="center">
                    			<a style="font-size: 14px;" href="#">Esqueci minha senha</a>
                    		</p>
                    		<div class="botoes" align="center">
                    			<button class="btPesquisar" type="submit"><img alt="" src="img/arrow_right.png">Login</button>
                    		</div>
                    	</form>
            		</td>
            	</tr>
            	</table>
            	<?php if (isset($_SESSION['resultado']) && $_SESSION['resultado'] == 1) {
                    echo "<p style='text-align:center; padding-top:40px;'>"; 
                    echo "<label class='resultado1'>Login ou senha encorretos.</label>";
                    echo "</p>";
                    $_SESSION['resultado'] = -1;
                }?>
	<?php 
// 	$DatabaseRepositorio = new DatabaseRepositorio();
// 	$retorno = $DatabaseRepositorio->existeBanco();
// 	if ($retorno != TRUE) {
// 	   @@@@@@@@@@@@@@@@@@@@@@@@@@@@ CRIAR BANCO AUTOMANTICAMENTE
// 	}
	
	$DatabaseRepositorio = new DatabaseRepositorio();
	$retorno = $DatabaseRepositorio->existeAdmin();
	if ($retorno != TRUE) {
	    echo "no admin found <br>";
	    echo "creating admin... <br>";
	    $retorno = $DatabaseRepositorio->cadastrarFuncionarioADM();
	    if ($retorno == TRUE) {
            echo "admin Ready <br> login=admin pass=admin";
	    } else {
            echo "admin creation failed";
	    }
	}
	?>
			</div>
		</div>
	</div>
	
<!-- Footer -->
<?php include_once 'includes/footer.php';?>

<!-- JavaScript -->
<script src="script.js"></script>

</body>
</html>