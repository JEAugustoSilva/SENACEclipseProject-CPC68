<?php
session_start();

include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';
include_once 'src/Movimentacao.php';
include_once 'src/MovimentacaoRepositorio.php';
include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';

use src\Movimentacao;
use src\MovimentacaoRepositorio;
use src\AmbienteRepositorio;
use src\Ambiente;



if (! isset($_SESSION['logou']) || $_SESSION['logou'] != TRUE) {
    header('Location: index.php');
} else {
    ?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Home - CPC68</title>
	<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body id="body">





<!-- NAV -->
<?php include_once 'includes/nav.php';?>


<!-- Side Menu -->
<?php include_once 'includes/sideMenu.php';?>
    
    
    <!-- Main -->
    <div id="main">
    	<div class="mainContainer">
    		<div class="mainConteudo">
    			<table class="form">
    				<tr>
						<td style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">For the people that can speak the only TRUE language.</td>
    				</tr>
    			</table>
    			<table class="form">
    				<tr>
						<td style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">About Page.</td>
    				</tr>
    				<tr>
						<td>
							<span>I can write whatever i want here, because no one will click this link and if they do, its gonna be really awkward.</span>
						</td>
    				</tr>
    			</table>
    			<table class="form">
    				<tr>
						<td style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">What? hell no.</td>
    				</tr>
    				<tr>
						<td>
							<span>It's almost 2AM and i want to shove my head in the sand, because i cant stop thinking about friday (Project presentation day).</span>
						</td>
    				</tr>
    			</table>
    			<table class="form">
    				<tr>
						<td style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">What am I going to do now?</td>
    				</tr>
    				<tr>
						<td>
							<span>Start freaking out and dont present de project? Maybe... What if i just freeze up there and cant say anything?</span>
						</td>
    				</tr>
    			</table>
    			<table class="form">
    				<tr>
						<td style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">FUCK NO!</td>
    				</tr>
    				<tr>
						<td>
							<span>I'm gonna present this shit and its gonna be FUCKING AWESOME!</span>
						</td>
    				</tr>
    			</table>
    			<table class="form">
    				<tr>
						<td style="height:10px; text-align: center; color: #fca235; font-weight: bold; font-size:20px;">If you speak english and you read this, im sorry.</td>
    				</tr>
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