<?php
use src\Ativo;
use src\Subgrupo;
use src\AtivoRepositorio;

session_start();
include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';
include_once 'src/Subgrupo.php';

$Ativo = new Ativo();
$Ativo->setId($_POST['id']);

$Subgrupo = new Subgrupo();
$Subgrupo->setId($_POST['idSubgrupo']);
$Ativo->setSubgrupo($Subgrupo);

$Ativo->setNome($_POST['nome']);
$Ativo->setDescricao($_POST['descricao']);
$Ativo->setCodigoBarra($_POST['codigoBarra']);

$AtivoRepositorio = new AtivoRepositorio();
$retorno = $AtivoRepositorio->alterarAtivo($Ativo);

if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header('Location: alterarAtivo2.php?pesquisa=' . $_POST['codigoBarra'] . '&idUnidade=' . $_POST['idUnidade'] . '&nomeUnidade=' . $_POST['nomeUnidade']);
} else {
    $_SESSION['resultado'] = 1;
    header('Location: alterarAtivo2.php?pesquisa=' . $_POST['codigoBarra'] . '&idUnidade=' . $_POST['idUnidade'] . '&nomeUnidade=' . $_POST['nomeUnidade']);
}