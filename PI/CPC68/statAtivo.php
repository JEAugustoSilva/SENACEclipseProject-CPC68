<?php
session_start();

include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';

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
    $Ativo->setStatus($_GET['atualizar']);
    $Ativo->setCodigoBarra($_GET['codigoBarra']);
    $idUnidade = $_GET['idUnidade'];
    $nomeUnidade = $_GET['nomeUnidade'];
    $AtivoRepositorio = new AtivoRepositorio();
    $retorno = $AtivoRepositorio->atualizarStatus($Ativo);
    if ($retorno == TRUE) {
        header('Location: consultarAtivo2.php?pesquisa=' . $Ativo->getCodigoBarra() . '&idUnidade=' . $idUnidade . '&nomeUnidade=' . $nomeUnidade);
    } else {
        echo "Falha no bloqueio!";
        echo "<a href='consultarAtivo2.php?pesquisa=" . $Ativo->getCodigoBarra() . "&idUnidade=" . $idUnidade . "&nomeUnidade=" . $nomeUnidade . "'>Voltar</a>";
    }
     $AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
    // RELATORIO
        // ADD DESCRICAO NO RELATORIO $_GET['descricao'];
    
?>
</body>
</html>