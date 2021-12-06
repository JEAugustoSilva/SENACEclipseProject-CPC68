<?php
session_start();
include_once 'src/Unidade.php';
include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';

use src\Ambiente;
use src\AmbienteRepositorio;
use src\Unidade;

$Ambiente = new Ambiente();
$Ambiente->setId($_POST['id']);
$Ambiente->setNome($_POST['nome']);
$Ambiente->setDescricao($_POST['descricao']);

$Unidade = new Unidade();
$Unidade->setId($_POST['idUnidade']);
$Ambiente->setUnidade($Unidade);

$AmbienteRepositorio = new AmbienteRepositorio();
$retorno = $AmbienteRepositorio->alterarAmbiente($Ambiente);
if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header('Location: alterarAmbiente2.php?pesquisa=' . $_POST['nome']);
} else {
    $_SESSION['resultado'] = 1;
    header('Location: alterarAmbiente2.php?pesquisa=' . $_POST['nome']);
}