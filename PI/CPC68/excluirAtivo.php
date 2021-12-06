<?php
session_start();

include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';
include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';

use src\Ativo;
use src\AtivoRepositorio;

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
    $Ativo = new Ativo();
    $Ativo->setId($_GET['id']);
    $Ativo->setCodigoBarra($_GET['codigoBarra']);
    $idUnidade = $_GET['idUnidade'];
    $nomeUnidade = $_GET['nomeUnidade'];
    $AtivoRepositorio = new AtivoRepositorio();
    $retorno = $AtivoRepositorio->excluirAtivo($Ativo);
    if ($retorno == TRUE) {
        header('Location: consultarAtivo1-1.php?idUnidade=' . $idUnidade . '&nomeUnidade=' . $nomeUnidade);
    } else {
        echo "Falha no bloqueio!";
        echo "<a href='consultarAtivo2.php?pesquisa=" . $Ativo->getCodigoBarra() . "'>Voltar</a>";
    }
?>
</body>
</html>