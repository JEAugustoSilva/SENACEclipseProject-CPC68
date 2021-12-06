<?php
session_start();

include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';

use src\Ambiente;
use src\AmbienteRepositorio;
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>CPC68</title>
<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body>
<?php
$Ambiente = new Ambiente();
$Ambiente->setId($_GET['id']);
$Ambiente->setNome($_GET['nome']);
$AmbienteRepositorio = new AmbienteRepositorio();

$retorno = $AmbienteRepositorio->excluirAmbiente($Ambiente);

if ($retorno == TRUE) {
    header('Location: consultarAmbiente.php');
} else {
    echo "Falha no bloqueio!";
    echo "<a href='consultarAmbiente2.php?pesquisa=" . $Ambiente->getNome() . "'>Voltar</a>";
}
?>
</body>
</html>