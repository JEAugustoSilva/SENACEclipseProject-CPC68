<?php
use src\Subgrupo;
use src\SubgrupoRepositorio;

session_start();

include_once 'src/Subgrupo.php';
include_once 'src/SubgrupoRepositorio.php';

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
$Subgrupo = new Subgrupo();
$Subgrupo->setId($_GET['id']);
$Subgrupo->setNome($_GET['nome']);
$SubgrupoRepositorio = new SubgrupoRepositorio();

$retorno = $SubgrupoRepositorio->desbloquearSubgrupo($Subgrupo);

if ($retorno == TRUE) {
    header('Location: consultarSubgrupo2.php?pesquisa=' . $Subgrupo->getNome());
} else {
    echo "Falha no bloqueio!";
    echo "<a href='consultarSubgrupo2.php?pesquisa=" . $Subgrupo->getNome() . "'>Voltar</a>";
}
?>
</body>
</html>