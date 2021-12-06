<?php
session_start();

include_once 'src/Unidade.php';
include_once 'src/UnidadeRepositorio.php';

use src\Unidade;
use src\UnidadeRepositorio;

$Unidade = new Unidade();
$Unidade->setId($_POST['id']);
$Unidade->setNome($_POST['nome']);
$Unidade->setSigla($_POST['sigla']);
$Unidade->setEndereco($_POST['endereco']);

$UnidadeRepositorio = new UnidadeRepositorio();
$retorno = $UnidadeRepositorio->alterarUnidade($Unidade);

if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header("Location: alterarUnidade2.php?pesquisa=" . $Unidade->getNome());
} else {
    $_SESSION['resultado'] = 1;
    header("Location: alterarUnidade2.php?pesquisa=" . $Unidade->getNome());
}