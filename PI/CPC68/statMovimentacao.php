<?php
session_start();

include_once 'src/Movimentacao.php';
include_once 'src/MovimentacaoRepositorio.php';
include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';

use src\Movimentacao;
use src\MovimentacaoRepositorio;
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
    if (isset($_POST['1_1'])) {
        $veioDeConsultarMovimentacao1_1 = "&1_1=" . $_POST['1_1'];
    }
    
    if (isset($_POST['OouD'])) {
        $OouD = "&OouD=" . $_POST['OouD'];
    } else {
        $OouD = "";
    }
    
    if (isset($_POST['pesquisa'])) {
        $pesquisa = "&pesquisa=" . $_POST['pesquisa'];
    } else {
        $pesquisa = "";
    }
    
    if (isset($_POST['idAmbiente'])) {
        $idAmbiente = "&idAmbiente=" . $_POST['idAmbiente'];
        $nomeAmbiente = "&nomeAmbiente=" . $_POST['nomeAmbiente'];
    }
    $idMovimentacao = $_POST['id'];
    $idAtivo = $_POST['idAtivo'];
    $idUnidade = $_POST['idUnidade'];
    $nomeUnidade = $_POST['nomeUnidade'];
    $tipoMovimentacao = $_POST['tipo'];
    $atualizar = $_POST['atualizar'];

    $Movimentacao = new Movimentacao();
    $Movimentacao->setId($idMovimentacao);
    $Movimentacao->setStatus($atualizar);
    
    $MovimentacaoRepositorio = new MovimentacaoRepositorio();
    $retornoMov = $MovimentacaoRepositorio->atualizarStatus($Movimentacao);
    
    $Ativo = new Ativo();
    $Ativo->setId($idAtivo);
    
    $AtivoRepositorio = new AtivoRepositorio();
    if ($tipoMovimentacao == 1) { // EMPRESTIMO
        $Ativo->setStatus("0");
    } else if ($tipoMovimentacao == 3) { // ASS. TECNICA
        if ($atualizar == 0) {
            $Ativo->setStatus("0");
        } else if ($atualizar == 3) {
            $Ativo->setStatus("11");
        }
    }
    $retorno = $AtivoRepositorio->atualizarStatus($Ativo);

    if ($retornoMov == TRUE && $retorno == TRUE) {
        header('Location: consultarMovimentacao2.php?id=' . $idMovimentacao . '' . $OouD . '' . $veioDeConsultarMovimentacao1_1 . '' . $pesquisa . '&idUnidade=' . $idUnidade . $idAmbiente .'&nomeUnidade=' . $nomeUnidade . $nomeAmbiente);
    } else {
        echo "Falha no bloqueio! Por favor chame o responsavel pelo programa. Fuck it, no one is gonna use this anyway...";
        echo "<a href='telaPrincipal.php'>Voltar</a>";
    }
    
?>
</body>
</html>