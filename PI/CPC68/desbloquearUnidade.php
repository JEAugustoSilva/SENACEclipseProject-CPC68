<?php
session_start();

include_once 'src/Unidade.php';
include_once 'src/UnidadeRepositorio.php';

use src\Unidade;
use src\UnidadeRepositorio;
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
    $Unidade = new Unidade();
    $Unidade->setId($_GET['id']);
    $Unidade->setNome($_GET['nome']);
    
    $UnidadeRepositorio = new UnidadeRepositorio();
    $retorno = $UnidadeRepositorio->desbloquearUnidade($Unidade);
    
    if ($retorno == TRUE) {
        header('Location: consultarUnidade2.php?pesquisa=' . $Unidade->getNome());
    } else {
        echo "Falha no bloqueio!";
        echo "<a href='consultarUnidade2.php?pesquisa=" . $Unidade->getNome() . "'>Voltar</a>";
    }

?>
</body>
</html>